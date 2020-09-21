<div id="shipping-address">

    <div class="form-group row">
        <label class="col-form-label col-md-2">{{ __('ctic_shop.name') }}</label>
        <div class="col-md-10">
            {{ Form::text('name', null, [
                    'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : '')
                ])
            }}
            @if ($errors->has('name'))
                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label class="col-form-label col-md-2">{{ __('ctic_shop.addressee_name') }}</label>
        <div class="col-md-4">
            {{ Form::text('addressee_name', null, [
                    'class' => 'form-control' . ($errors->has('addressee_name') ? ' is-invalid' : '')
                ])
            }}
            @if ($errors->has('addressee_name'))
                <div class="invalid-feedback">{{ $errors->first('addressee_name') }}</div>
            @endif
        </div>

        <label class="col-form-label col-md-2">{{ __('ctic_shop.addressee_surname') }}</label>
        <div class="col-md-4">
            {{ Form::text('addressee_surname', null, [
                    'class' => 'form-control' . ($errors->has('addressee_surname') ? ' is-invalid' : '')
                ])
            }}
            @if ($errors->has('addressee_surname'))
                <div class="invalid-feedback">{{ $errors->first('addressee_surname') }}</div>
            @endif
        </div>
    </div>

    <div class="form-group row">

        <label class="col-form-label col-md-2">{{ __('ctic_shop.address') }}</label>
        <div class="col-md-10">
            {{ Form::text('address', null, [
                    'class' => 'form-control' . ($errors->has('address') ? ' is-invalid' : '')
                ])
            }}
            @if ($errors->has('address'))
                <div class="invalid-feedback">{{ $errors->first('address') }}</div>
            @endif
        </div>
    </div>

    <div class="form-group row">

        <label class="col-form-label col-md-2">{{ __('ctic_shop.address') }} 2</label>
        <div class="col-md-10">
            {{ Form::text('address2', null, [
                    'class' => 'form-control' . ($errors->has('address2') ? ' is-invalid' : '')
                ])
            }}
            @if ($errors->has('address2'))
                <div class="invalid-feedback">{{ $errors->first('address2') }}</div>
            @endif
        </div>
    </div>

    <div class="form-group row">

        <label class="col-form-label col-md-2">{{ __('ctic_shop.postal_code') }}</label>
        <div class="col-md-4">
            {{ Form::text('postal_code', null, [
                    'class' => 'form-control' . ($errors->has('postal_code') ? ' is-invalid' : '')
                ])
            }}
            @if ($errors->has('postal_code'))
                <div class="invalid-feedback">{{ $errors->first('postal_code') }}</div>
            @endif
        </div>

        <label class="col-form-label col-md-2">{{ __('ctic_shop.city') }}</label>
        <div class="col-md-4">
            {{ Form::text('town', null, [
                    'class' => 'form-control' . ($errors->has('town') ? ' is-invalid' : '')
                ])
            }}
            @if ($errors->has('town'))
                <div class="invalid-feedback">{{ $errors->first('town') }}</div>
            @endif
        </div>

    </div>
</div>
