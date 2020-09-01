<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductIndexRequest;
use Vanilo\Category\Contracts\Taxon;
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

    public function index(ProductIndexRequest $request, Taxon $taxon = null)
    {
        $properties = PropertyProxy::get();

        if ($taxon) {
            $this->productFinder->withinTaxon($taxon);
        }

        foreach ($request->filters($properties) as $property => $values) {
            $this->productFinder->havingPropertyValuesByName($property, $values);
        }

        return view('product.index', array_merge(
            [
                'products'   => $this->productFinder->getResults(),
                'properties' => $properties,
                'filters'    => $request->filters($properties)
            ],
            $this->getCommonParameters($taxon)
        ));
    }

    public function show(Taxon $taxon, Product $product)
    {
        return view('product.show', array_merge(['product' => $product], $this->getCommonParameters()));
    }
}
