<div class="collapse @if(! $agent->isMobile()) show @endif w-100" id="categoriesMenu">
    <!-- Authentication Links -->
    <!-- Authentication duplicated in app.blade.php layout -->
    @if($agent->isMobile())
        <div class="row background-grey-scale background-grey-scale-0 auth-style w-100">
            @guest
                <a href="{{ route('login') }}" class="col-md-2 col-6">{{ __('ctic_shop.login') }}</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="col-md-2 col-6">{{ __('ctic_shop.register') }}</a>
                @endif
            @else
                <a href="{{ route('account.home') }}" class="col-md-2 col-6">
                    {{ Auth::user()->name }}
                </a>

                <a href="{{ route('logout') }}"
                   class="col-md-2 col-6"
                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                    {{ __('ctic_shop.logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endguest
        </div>
        <div class="row background-grey-scale background-grey-scale-0 auth-style w-100">
            @if (setting('ctic.general.defaults.help'))
                <a href="{{ setting('ctic.general.defaults.help_url') }}" class="col-md-2 col-6">
                    {{ setting('ctic.general.defaults.help') }}
                </a>
            @endif
            @if (setting('ctic.general.defaults.reference'))
                <a href="{{ setting('ctic.general.defaults.reference_url') }}" class="col-md-2 col-6">
                    {{ setting('ctic.general.defaults.reference') }}
                </a>
            @endif
        </div>
    @endif

    <div class="@if(! $agent->isMobile()) row @endif background-grey-scale background-grey-scale-0 w-100">
        @foreach($taxons as $currentTaxon)
            <a
                    href="{{ route('product.category', [$currentTaxon->slug]) }}"
                    class="col-md-2 col-6"
            >
                {{ $currentTaxon->name }}
            </a>
        @endforeach
        @if (setting('ctic.general.defaults.blog'))
            <a
                    href="{{ setting('ctic.general.defaults.blog_url') }}"
                    class="col-md-2 col-6"
            >
                {{ setting('ctic.general.defaults.blog') }}
            </a>
        @endif
    </div>
    @foreach($taxons as $currentTaxon)
        @if($taxon && $currentTaxon->isInTaxonTree($taxon))
            @include('category._category_level', ['taxons' => $currentTaxon->children, 'requestedTaxon' => $taxon])
        @endif
    @endforeach
</div>
