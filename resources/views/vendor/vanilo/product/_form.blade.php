<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon">
            <i class="zmdi zmdi-layers"></i>
        </span>
        {{ Form::text('name', null, [
                'class' => 'form-control form-control-lg' . ($errors->has('name') ? ' is-invalid' : ''),
                'placeholder' => __('Product name')
            ])
        }}
        @if ($errors->has('name'))
            <div class="invalid-tooltip">{{ $errors->first('name') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="form-row">
    <div class="form-group col-12 col-md-6 col-xl-4">
        <div class="input-group">
            <span class="input-group-addon">
                <i class="zmdi zmdi-code-setting"></i>
            </span>
            {{ Form::text('sku', null, [
                    'class' => 'form-control' . ($errors->has('sku') ? ' is-invalid' : ''),
                    'placeholder' => __('SKU (product code)')
                ])
            }}
        </div>
        @if ($errors->has('sku'))
            <input hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('sku') }}</div>
        @endif
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 col-md-6 col-xl-4">
        <label class="switch switch-icon switch-pill switch-primary">
            {{ Form::checkbox("manage_stock", 1, $product->manage_stock, ['class' => 'switch-input']) }}
            <span class="switch-label" data-on="&#xf26b;" data-off="&#xf136;"></span>
            <span class="switch-handle"></span>
        </label>
        {{ __('ctic_admin.manage_stock') }}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 col-md-6 col-xl-4">
        <div class="input-group">
            <span class="input-group-addon">
                <i class="zmdi zmdi-code-setting"></i>
            </span>
            {{ Form::number('stock', null, [
                    'class' => 'form-control' . ($errors->has('stock') ? ' is-invalid' : ''),
                    'placeholder' => __('Product Stock Count')
                ])
            }}
        </div>
        @if ($errors->has('stock'))
            <input hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('stock') }}</div>
        @endif
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 col-md-6 col-xl-4">
        <div class="input-group">
            {{ Form::text('cost', null, [
                    'class' => 'form-control' . ($errors->has('cost') ? ' is-invalid' : ''),
                    'placeholder' => __('ctic_admin.cost')
                ])
            }}
            <span class="input-group-addon">
                {{ config('vanilo.framework.currency.code') }}
            </span>
        </div>
        @if ($errors->has('cost'))
            <input hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('cost') }}</div>
        @endif
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 col-md-6 col-xl-4">
        <div class="input-group">
            {{ Form::text('price', null, [
                    'class' => 'form-control' . ($errors->has('price') ? ' is-invalid' : ''),
                    'placeholder' => __('Price')
                ])
            }}
            <span class="input-group-addon">
                {{ config('vanilo.framework.currency.code') }}
            </span>
        </div>
        @if ($errors->has('price'))
            <input hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('price') }}</div>
        @endif
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 col-md-6 col-xl-4">
        <div class="input-group">
            {{ Form::text('price_2', null, [
                    'class' => 'form-control' . ($errors->has('price_2') ? ' is-invalid' : ''),
                    'placeholder' => __('ctic_admin.price_2')
                ])
            }}
            <span class="input-group-addon">
                {{ config('vanilo.framework.currency.code') }}
            </span>
        </div>
        @if ($errors->has('price_2'))
            <input hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('price_2') }}</div>
        @endif
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 col-md-6 col-xl-4">
        <div class="input-group">
            {{ Form::text('price_3', null, [
                    'class' => 'form-control' . ($errors->has('price_3') ? ' is-invalid' : ''),
                    'placeholder' => __('ctic_admin.price_3')
                ])
            }}
            <span class="input-group-addon">
                {{ config('vanilo.framework.currency.code') }}
            </span>
        </div>
        @if ($errors->has('price_3'))
            <input hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('price_3') }}</div>
        @endif
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 col-md-6 col-xl-4">
        <div class="input-group">
            {{ Form::text('price_4', null, [
                    'class' => 'form-control' . ($errors->has('price_4') ? ' is-invalid' : ''),
                    'placeholder' => __('ctic_admin.price_4')
                ])
            }}
            <span class="input-group-addon">
                {{ config('vanilo.framework.currency.code') }}
            </span>
        </div>
        @if ($errors->has('price_4'))
            <input hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('price_4') }}</div>
        @endif
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 col-md-6 col-xl-4">
        <div class="input-group">
            {{ Form::text('price_5', null, [
                    'class' => 'form-control' . ($errors->has('price_5') ? ' is-invalid' : ''),
                    'placeholder' => __('ctic_admin.price_5')
                ])
            }}
            <span class="input-group-addon">
                {{ config('vanilo.framework.currency.code') }}
            </span>
        </div>
        @if ($errors->has('price_5'))
            <input hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('price_5') }}</div>
        @endif
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 col-md-6 col-xl-4">
        <div class="input-group">
            {{ Form::text('iva', null, [
                    'class' => 'form-control' . ($errors->has('iva') ? ' is-invalid' : ''),
                    'placeholder' => __('ctic_admin.iva')
                ])
            }}
        </div>
        @if ($errors->has('iva'))
            <input hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('iva') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="form-group row">
    <label class="form-control-label col-md-2">{{ __('State') }}</label>
    <div class="col-md-10">
        <?php /*$errors->has('state') ? ' is-invalid' : ''; */ ?>

        @foreach($states as $key => $value)
            <label class="radio-inline" for="state_{{ $key }}">
                {{ Form::radio('state', $key, $product->state == $value, ['id' => "state_$key"]) }}
                {{ $value }}
                &nbsp;
            </label>
        @endforeach

        @if ($errors->has('state'))
            <input hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('state') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="form-group row">
    <label class="form-control-label col-md-2">{{ __('ctic_admin.archetype') }}</label>
    <div class="col-md-10">
        @foreach($product::ARCHETYPES as $key => $value)
            <label class="radio-inline" for="type_{{ $key }}">
                {{ Form::radio('archetype', $key, ($product->archetype) ? $product->archetype == $key : 0 == $key, ['id' => "archetype_$key"]) }}
                {{ __('ctic_admin.' . $value) }}
                &nbsp;
            </label>
        @endforeach

        @if ($errors->has('archetype'))
            <input hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('archetype') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="form-group">
    <label>{{ __('Description') }}</label>

    {{ Form::textarea('description', null,
            [
                'class' => 'form-control' . ($errors->has('description') ? ' is-invalid' : ''),
                'placeholder' => __('Type or copy/paste product description here')
            ]
    ) }}

    @if ($errors->has('description'))
        <div class="invalid-feedback">{{ $errors->first('description') }}</div>
    @endif
</div>

<div class="form-group">
    <label>{{ __('ctic_admin.observation') }}</label>

    {{ Form::textarea('observation', null,
            [
                'class' => 'form-control' . ($errors->has('observation') ? ' is-invalid' : ''),
                'placeholder' => __('ctic_admin.observation_placeholder')
            ]
    ) }}

    @if ($errors->has('observation'))
        <div class="invalid-feedback">{{ $errors->first('observation') }}</div>
    @endif
</div>

<hr>

<div class="form-row">
    <div class="form-group col-12 col-md-6 col-xl-4">
        <div class="input-group">
            {{ Form::text('order', null, [
                    'class' => 'form-control' . ($errors->has('order') ? ' is-invalid' : ''),
                    'placeholder' => __('ctic_admin.order')
                ])
            }}
        </div>
        @if ($errors->has('order'))
            <input hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('order') }}</div>
        @endif
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 col-md-6 col-xl-4">
        <div class="input-group">
            {{ Form::text('barcode', null, [
                    'class' => 'form-control' . ($errors->has('barcode') ? ' is-invalid' : ''),
                    'placeholder' => __('ctic_admin.barcode')
                ])
            }}
        </div>
        @if ($errors->has('barcode'))
            <input hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('barcode') }}</div>
        @endif
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 col-md-6 col-xl-4">
        <div class="input-group">
            {{ Form::text('send', null, [
                    'class' => 'form-control' . ($errors->has('send') ? ' is-invalid' : ''),
                    'placeholder' => __('ctic_admin.send')
                ])
            }}
        </div>
        @if ($errors->has('send'))
            <input hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('send') }}</div>
        @endif
    </div>
</div>

<div class="form-group">
    <?php $seoHasErrors = any_key_exists($errors->toArray(), ['ext_title', 'meta_description', 'meta_keywords']) ?>
    <h5><a data-toggle="collapse" href="#product-form-seo" class="collapse-toggler-heading"
           @if ($seoHasErrors)
               aria-expanded="true"
           @endif
        ><i class="zmdi zmdi-chevron-right"></i> {{ __('SEO') }}</a></h5>

    <div id="product-form-seo" class="collapse{{ $seoHasErrors ? ' show' : '' }}">
        <div class="callout">

            @include('vanilo::product._form_seo')

        </div>
    </div>
</div>

<div class="form-group">
    <?php $extraHasErrors = any_key_exists($errors->toArray(), ['slug', 'excerpt']) ?>
    <h5><a data-toggle="collapse" href="#product-form-extra" class="collapse-toggler-heading"
           @if ($extraHasErrors)
           aria-expanded="true"
                @endif
        ><i class="zmdi zmdi-chevron-right"></i> {{ __('Extra Settings') }}</a></h5>

    <div id="product-form-extra" class="collapse{{ $extraHasErrors ? ' show' : '' }}">
        <div class="callout">

            @include('vanilo::product._form_extra')

        </div>
    </div>
</div>
