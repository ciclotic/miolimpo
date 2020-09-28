<div class="form-payment_method">
    <div class="input-payment_method">
        <span class="input-payment_method-addon">
            <i class="zmdi zmdi-folder"></i>
        </span>
        {{ __('ctic_admin.name_of_payment_method') }}
        {{ Form::text('name', null, [
                'class' => 'form-control form-control-lg' . ($errors->has('name') ? ' is-invalid' : ''),
                'placeholder' => __('ctic_admin.name_of_payment_method')
            ])
        }}
    </div>
    @if ($errors->has('name'))
        <input hidden class="form-control is-invalid" />
        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
    @endif
</div>

<div class="form-payment_method">
    <div class="input-payment_method">
        <span class="input-payment_method-addon">
            <i class="zmdi zmdi-folder"></i>
        </span>
        {{ __('ctic_admin.observation') }}
        {{ Form::textarea('observation', null, [
                'class' => 'form-control form-control-lg' . ($errors->has('observation') ? ' is-invalid' : ''),
                'placeholder' => __('ctic_admin.observation')
            ])
        }}
    </div>
    @if ($errors->has('observation'))
        <input hidden class="form-control is-invalid" />
        <div class="invalid-feedback">{{ $errors->first('observation') }}</div>
    @endif
</div>

<div class="form-group">
    <span class="input-payment_method-addon">
            <i class="zmdi zmdi-folder"></i>
        </span>
    {{ __('ctic_admin.gateway') }}
    {{ Form::select('gateway', ['offline' => __('ctic_admin.gateway_offline'), 'redsys' => __('ctic_admin.gateway_redsys'), 'paypal' => __('ctic_admin.gateway_paypal'), 'stripe' => __('ctic_admin.gateway_stripe')], null, [
            'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),
            'placeholder' => __('ctic_admin.gateway')
        ])
    }}
    @if ($errors->has('product_id'))
        <input hidden class="form-control is-invalid" />
        <div class="invalid-feedback">{{ $errors->first('product_id') }}</div>
    @endif
</div>

<div class="form-payment_method">
    <div class="input-payment_method">
        <span class="input-payment_method-addon">
            <i class="zmdi zmdi-folder"></i>
        </span>
        {{ __('ctic_admin.order') }}
        {{ Form::text('order', null, [
                'class' => 'form-control form-control-lg' . ($errors->has('order') ? ' is-invalid' : ''),
                'placeholder' => __('ctic_admin.order')
            ])
        }}
    </div>
    @if ($errors->has('order'))
        <input hidden class="form-control is-invalid" />
        <div class="invalid-feedback">{{ $errors->first('order') }}</div>
    @endif
</div>
