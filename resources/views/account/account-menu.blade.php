<style>
    .route_active {
        font-weight: bold;
    }
</style>

<div class="col-md-3">
    <div class="card">
        <div class="card-body">
            <h4>Mi cuenta</h4>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('account.home') }}" title="{{ __('ctic_shop.my_orders') }}" class="@if (Route::current()->getName() === 'account.home') route_active @endif">{{ __('ctic_shop.my_orders') }}</a>
                </div>
                <div class="col-md-12">
                    <a href="{{ route('account.data') }}" title="{{ __('ctic_shop.my_data') }}" class="@if (Route::current()->getName() === 'account.data') route_active @endif">{{ __('ctic_shop.my_data') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
