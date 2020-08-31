<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductIndexRequest;
use Jenssegers\Agent\Agent;
use Vanilo\Category\Contracts\Taxon;
use Vanilo\Category\Models\TaxonomyProxy;
use Vanilo\Framework\Search\ProductFinder;
use Vanilo\Product\Contracts\Product;
use Vanilo\Properties\Models\PropertyProxy;
use function GuzzleHttp\Psr7\str;

class ProductController extends Controller
{
    /** @var ProductFinder */
    private $productFinder;

    public function __construct(ProductFinder $productFinder)
    {
        $this->productFinder = $productFinder;
    }

    public function index(ProductIndexRequest $request, string $taxonomyName = null, Taxon $taxon = null)
    {
        $taxonomies = TaxonomyProxy::first();
        $taxons = ($taxonomies) ? $taxonomies->rootLevelTaxons() : [];
        $properties = PropertyProxy::get();

        if ($taxon) {
            $this->productFinder->withinTaxon($taxon);
        }

        foreach ($request->filters($properties) as $property => $values) {
            $this->productFinder->havingPropertyValuesByName($property, $values);
        }

        $agent = new Agent();

        return view('product.index', [
            'products'   => $this->productFinder->getResults(),
            'agent'      => $agent,
            'taxons'     => $taxons,
            'taxon'      => $taxon,
            'properties' => $properties,
            'filters'    => $request->filters($properties)
        ]);
    }

    public function show(Product $product)
    {
        return view('product.show', ['product' => $product]);
    }
}
