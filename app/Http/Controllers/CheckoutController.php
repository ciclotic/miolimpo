<?php

namespace App\Http\Controllers;

use App\Ctic\AddressBook\Models\AddressBookProxy;
use App\Ctic\PaymentMethod\Models\PaymentMethodProxy;
use App\Ctic\PaymentMethod\Redsys\RedsysAPI;
use App\Ctic\ShippingMethod\Models\ShippingMethodProxy;
use App\Http\Requests\CheckoutRequest;
use App\Mail\OrderCompleted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Konekt\Address\Models\CountryProxy;
use Vanilo\Cart\Contracts\CartManager;
use Vanilo\Checkout\Contracts\Checkout;
use Vanilo\Order\Contracts\OrderFactory;
use Vanilo\Order\Models\OrderProxy;
use Vanilo\Order\Models\OrderStatus;
use Vanilo\Product\Models\ProductProxy;

class CheckoutController extends Controller
{
    /** @var Checkout */
    private $checkout;

    /** @var Cart */
    private $cart;

    public function __construct(Checkout $checkout, CartManager $cart)
    {
        $this->checkout = $checkout;
        $this->cart     = $cart;
    }

    public function show()
    {
        $checkout = false;

        if ($this->cart->isNotEmpty()) {
            $checkout = $this->checkout;
            if ($old = old()) {
                $checkout->update($old);
            }

            $checkout->setCart($this->cart);
        }

        $user = auth()->user();
        if ($user) {
            $addressBooks = AddressBookProxy::where('user_id', $user->id)->get();
        } else {
            $addressBooks = [];
        }

        return view('checkout.show', array_merge(
            [
                'checkout'              => $checkout,
                'countries'             => CountryProxy::all(),
                'address_books'         => $addressBooks,
                'payment_methods'       => PaymentMethodProxy::all(),
                'shipping_methods'      => ShippingMethodProxy::all(),
            ],
            $this->getCommonParameters()
        ));
    }

    public function payRedsys(Request $request)
    {
        $fromAddress = setting('ctic.mail.smtp.from_address');
        $merchantName = setting('appshell.ui.name');
        if (!empty( $request->all() )) {
            $kc = setting('ctic.payment.redsys.secret');

            $redsysObject = new RedsysAPI();

            $datos = $request->get('Ds_MerchantParameters');
            $signatureReceibt = $request->get('Ds_Signature');

            $decodec = $redsysObject->decodeMerchantParameters($datos);
            $firma = $redsysObject->createMerchantSignatureNotif($kc,$datos);

            $dataJson = json_decode($decodec);
            $dataPost = (array) $dataJson;

            if ($firma === $signatureReceibt) {
                $message = $merchantName . " cobro VISA FIRMA OK\r\n";
                $order = OrderProxy::find($dataPost['Ds_Order']);
                if (is_numeric($dataPost['Ds_AuthorisationCode'])) {
                    $message .= $dataPost['Ds_Order'].": SI AUTORIZADA\r\n";
                    if ($order) {
                        $message = "Importe cobrado: ".number_format($order->total(),2,",",".")."\r\n";

                        $order->status = new OrderStatus(OrderStatus::COMPLETED);
                        $order->save();

                    } else {
                        $message .= "NO ENCUENTRA EL PEDIDO\r\n";
                    }
                } else {
                    $message .= $dataPost['Ds_Order'].": NO AUTORIZADA\r\n";
                    if ($order)
                    {
                        $order->status = new OrderStatus(OrderStatus::CANCELLED);
                        $order->save();
                    } else {
                        $message .= "NO ENCUENTRA EL PEDIDO\r\n";
                    }
                }
            } else {
                $message = $merchantName . " cobro VISA FIRMA ERROR\r\n";
            }
            $cabeceras = 'From: ' . $fromAddress;
            mail($fromAddress,"Datos cobro VISA",$message,$cabeceras);
        }else
        {
            $cabeceras = 'From: ' . $fromAddress;
            mail($fromAddress,"Acceso " . $merchantName . " cobro VISA ERROR","Acceso al sistema de cobros sin datos",$cabeceras);
        }

        return redirect(route('product.index'));
    }

    public function payPaypal(Request $request)
    {
        $fromAddress = setting('ctic.mail.smtp.from_address');
        $merchantName = setting('appshell.ui.name');

        $order = OrderProxy::find($request->get('invoice'));

        if ($order)
        {
            $order->status = new OrderStatus(OrderStatus::COMPLETED);
            $order->save();

            $missatge = "Mandragora cobro PayPal OK\r\n";
            $missatge .= "Importe cobrado: ".number_format($order->total(),2,",",".")."\r\n";
        } else {
            $missatge = $merchantName . " cobro PayPal ERROR";
        }

        $cabeceras = 'From: ' . $fromAddress;
        mail($fromAddress,"Datos cobro PayPal",$missatge,$cabeceras);

        return redirect(route('product.index'));
    }

    public function payStripe(Request $request)
    {
        $fromAddress = setting('ctic.mail.smtp.from_address');
        $merchantName = setting('appshell.ui.name');

        $order = OrderProxy::find($request->get('invoice'));

        if ($order)
        {
            $order->status = new OrderStatus(OrderStatus::COMPLETED);
            $order->save();

            $missatge = "Mandragora cobro Stripe OK\r\n";
            $missatge .= "Importe cobrado: ".number_format($order->total(),2,",",".")."\r\n";
        } else {
            $missatge = $merchantName . " cobro Stripe ERROR";
        }

        $cabeceras = 'From: ' . $fromAddress;
        mail($fromAddress,"Datos cobro Stripe",$missatge,$cabeceras);

        return redirect(route('product.index'));
    }

    public function submit(CheckoutRequest $request, OrderFactory $orderFactory)
    {
        // Add shipping to cart.
        $shippingMethod = ShippingMethodProxy::find($request->get('shipping_method_id'));
        $this->cart->addItem($shippingMethod);

        // Add order
        $this->checkout->update($request->all());
        $this->checkout->setCustomAttribute('notes', $request->get('notes'));
        $this->checkout->setCart($this->cart);

        $order = $orderFactory->createFromCheckout($this->checkout);
        $order->shipping_method_id = $request->get('shipping_method_id', null);
        $order->payment_method_id = $request->get('payment_method_id', null);
        $order->notes = $request->get('notes');
        $order->save();
        $this->cart->destroy();

        if ($order->paymentMethod && $order->paymentMethod->gateway === 'redsys') {
            $redsysObject = new RedsysAPI();

            $urlOKKO = route('product.index');
            $urlMerchant = route('checkout.pay-redsys');
            $redsysObject->setParameter("DS_MERCHANT_AMOUNT", $order->total());
            $redsysObject->setParameter("DS_MERCHANT_ORDER", $order->id);
            $redsysObject->setParameter("DS_MERCHANT_MERCHANTCODE", setting('ctic.payment.redsys.merchantcode'));
            $redsysObject->setParameter("DS_MERCHANT_CURRENCY", setting('ctic.payment.redsys.currency'));
            $redsysObject->setParameter("DS_MERCHANT_TRANSACTIONTYPE", '0');
            $redsysObject->setParameter("DS_MERCHANT_TERMINAL", setting('ctic.payment.redsys.terminal'));
            $redsysObject->setParameter("DS_MERCHANT_MERCHANTURL", $urlMerchant);
            $redsysObject->setParameter("DS_MERCHANT_URLOK", $urlOKKO);
            $redsysObject->setParameter("DS_MERCHANT_URLKO", $urlOKKO);
            $redsysObject->setParameter("Ds_Merchant_ConsumerLanguage", setting('ctic.payment.redsys.language'));
            $kc = setting('ctic.payment.redsys.secret');

            $redsysVersion = "HMAC_SHA256_V1";
            $redsysParams = $redsysObject->createMerchantParameters();
            $redsysSignature = $redsysObject->createMerchantSignature($kc);
        } else {
            $redsysVersion = null;
            $redsysParams = null;
            $redsysSignature = null;
        }
        if ($order->paymentMethod && $order->paymentMethod->gateway === 'paypal') {
            $paypalBussinessEmail = setting('ctic.payment.paypal.business_email');
        } else {
            $paypalBussinessEmail = null;
        }
        if ($order->paymentMethod && $order->paymentMethod->gateway === 'stripe') {
            $stripeSecretKey = setting('ctic.payment.stripe.secret_key');
            \Stripe\Stripe::setApiKey($stripeSecretKey);
            $checkout_session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                "locale" => 'es',
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'unit_amount' => str_replace('.', '', number_format($order->total(), 2, '.', '')),
                        'product_data' => [
                            'name' => __('ctic_shop.ordered_in') . ' ' . setting('appshell.ui.name'),
                            'images' => [setting('ctic.general.defaults.logo_url_dark')],
                        ],
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('checkout.pay-stripe'),
                'cancel_url' => route('product.index'),
            ]);
            $stripeSessionId = $checkout_session->id;
            $stripePublicKey = setting('ctic.payment.stripe.public_key');
        } else {
            $stripeSessionId = null;
            $stripePublicKey = null;
        }

        $authUser = auth()->user();
        if ($authUser) {
            Mail::to($authUser)->send(new OrderCompleted($order));
        }
        Mail::to(setting('ctic.mail.smtp.from_address'))->send(new OrderCompleted($order));

        return view('checkout.thankyou', array_merge(
            [
                'order'                 => $order,

                'redsysVersion'         => $redsysVersion,
                'redsysParams'          => $redsysParams,
                'redsysSignature'       => $redsysSignature,

                'paypalBussinessEmail'  => $paypalBussinessEmail,

                'stripeSessionId'       => $stripeSessionId,
                'stripePublicKey'       => $stripePublicKey,
            ],
            $this->getCommonParameters()
        ));
    }

}
