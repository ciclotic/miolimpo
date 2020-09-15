<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Jenssegers\Agent\Agent;
use Vanilo\Category\Contracts\Taxon;
use Vanilo\Category\Models\TaxonomyProxy;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getCommonParameters(Taxon $taxon = null)
    {
        $showCart = request()->get('show-cart', false);

        $agent = new Agent();

        $taxonomies = TaxonomyProxy::first();
        $taxons = ($taxonomies) ? $taxonomies->rootLevelTaxons() : [];

        return [
            'agent'      => $agent,
            'taxons'     => $taxons,
            'taxon'      => $taxon,
            'showCart'   => $showCart,
        ];
    }
}
