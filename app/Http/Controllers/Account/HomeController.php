<?php

namespace App\Http\Controllers\Account;

use App\Ctic\AddressBook\Contracts\AddressBook;
use App\Ctic\AddressBook\Models\AddressBookProxy;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Konekt\User\Models\UserProxy;
use Vanilo\Order\Contracts\Order;
use Vanilo\Order\Models\OrderProxy;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account.home', array_merge(
            $this->getCommonParameters(),
            [
                'orders' => OrderProxy::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->paginate(100)
            ]
        ));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function showOrder(Order $order)
    {
        return view('account.show_order', array_merge(
            $this->getCommonParameters(),
            [
                'order' => $order
            ]
        ));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        return view('account.data', $this->getCommonParameters());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editData()
    {
        return view('account.edit-data', $this->getCommonParameters());
    }

    protected function getUserDataFromRequest(Request $request)
    {
        $user = auth()->user();

        return $request->validate([
            'name'              => 'required|max:255',
            'surname'           => 'nullable|max:255',
            'email'             => 'required|email|unique:users,email,' . $user->id,
            'phone'             => 'nullable|digits:9',
            'newsletter'        => 'boolean',
            'current_password'  => 'password',
            'password'          => 'nullable|confirmed|min:6',
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveData(Request $request)
    {
        $userData = $this->getUserDataFromRequest($request);
        $dataToModify = collect($userData)->only(['name', 'surname', 'email', 'phone', 'newsletter'])->toArray();

        if (empty($dataToModify['newsletter'])) {
            $dataToModify['newsletter'] = false;
        }

        $userToUpdate = UserProxy::find(auth()->user()->id);
        if (!empty($userData['password'])) {
            $dataToModify = array_merge(['password'=> Hash::make($userData['password'])], $dataToModify);
        }

        $userToUpdate->update($dataToModify);

        return redirect(route('account.edit-data'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function addAddressBook()
    {
        return view('account.address_book.create', $this->getCommonParameters());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editAddressBook(AddressBook $addressBook)
    {
        return view('account.address_book.edit', array_merge(
            $this->getCommonParameters(),
            [
                'addressBook' => $addressBook
            ]
        ));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeAddressBook(Request $request)
    {
        try {
            $addressBook = AddressBookProxy::create(array_merge(['user_id' => auth()->user()->id], $request->all()));
            flash()->success(__(':name has been created', ['name' => $addressBook->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('account.edit-address-book', $addressBook));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateAddressBook(AddressBook $addressBook, Request $request)
    {
        try {
            $addressBook->update($request->all());

            flash()->success(__(':name has been updated', ['name' => $addressBook->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('account.data'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashAddressBook(AddressBook $addressBook)
    {
        try {
            $name = $addressBook->name;
            $addressBook->delete();

            flash()->warning(__(':name has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('account.data'));
    }
}
