<div class="form-group">
    {{ Form::select('product_id', $products->pluck('name', 'id'), ($group->product)? $group->product->id : null, [
            'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),
            'placeholder' => __('ctic_admin.product')
        ])
    }}
    @if ($errors->has('product_id'))
        <input hidden class="form-control is-invalid" />
        <div class="invalid-feedback">{{ $errors->first('product_id') }}</div>
    @endif
</div>

<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon">
            <i class="zmdi zmdi-folder"></i>
        </span>
        {{ Form::text('name', null, [
                'class' => 'form-control form-control-lg' . ($errors->has('name') ? ' is-invalid' : ''),
                'placeholder' => __('ctic_admin.name_of_group')
            ])
        }}
    </div>
    @if ($errors->has('name'))
        <input hidden class="form-control is-invalid" />
        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
    @endif
</div>

<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon">
            <i class="zmdi zmdi-folder"></i>
        </span>
        {{ Form::text('observation', null, [
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
    <div class="input-group">
        <span class="input-group-addon">
            <i class="zmdi zmdi-folder"></i>
        </span>
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

<div class="form-row">
    <div class="form-group col-12 col-md-6 col-xl-4">
        <label class="switch switch-icon switch-pill switch-primary">
            {{ Form::checkbox("mandatory", 1, $group->manage_stock, ['class' => 'switch-input']) }}
            <span class="switch-label" data-on="&#xf26b;" data-off="&#xf136;"></span>
            <span class="switch-handle"></span>
        </label>
        {{ __('ctic_admin.mandatory') }}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 col-md-6 col-xl-4">
        <label class="switch switch-icon switch-pill switch-primary">
            {{ Form::checkbox("unique_group", 1, $group->manage_stock, ['class' => 'switch-input']) }}
            <span class="switch-label" data-on="&#xf26b;" data-off="&#xf136;"></span>
            <span class="switch-handle"></span>
        </label>
        {{ __('ctic_admin.unique_group') }}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 col-md-6 col-xl-4">
        <label class="switch switch-icon switch-pill switch-primary">
            {{ Form::checkbox("collapsed", 1, $group->manage_stock, ['class' => 'switch-input']) }}
            <span class="switch-label" data-on="&#xf26b;" data-off="&#xf136;"></span>
            <span class="switch-handle"></span>
        </label>
        {{ __('ctic_admin.collapsed') }}
    </div>
</div>
