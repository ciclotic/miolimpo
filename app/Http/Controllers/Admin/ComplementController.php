<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Konekt\AppShell\Http\Controllers\BaseController;
use Vanilo\Framework\Contracts\Requests\CreatePropertyValueForm;
use Vanilo\Framework\Contracts\Requests\SyncModelPropertyValues;
use Vanilo\Framework\Contracts\Requests\UpdatePropertyValue;
use Vanilo\Properties\Contracts\Property;
use Vanilo\Properties\Contracts\PropertyValue;
use Vanilo\Properties\Models\PropertyProxy;
use Vanilo\Properties\Models\PropertyValueProxy;

class ComplementController extends BaseController
{
    public function store(integer $complementProduct, Request $request)
    {
        try {
            $propertyValue = PropertyValueProxy::create(
                array_merge(
                    $request->all(),
                    ['property_id' => $property->id]
                )
            );

            flash()->success(__(':title :property has been created', [
                'title'    => $propertyValue->title,
                'property' => $property->name
            ]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.property.show', $property));
    }

    public function update(integer $complementProduct, Product $product, UpdatePropertyValue $request)
    {
        try {
            $property_value->update($request->all());

            flash()->success(__(':title has been updated', ['title' => $property_value->title]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.property.show', $property));
    }

    public function destroy(integer $complementProduct, Product $product)
    {
        try {
            $title = $property_value->title;
            $property_value->delete();

            flash()->warning(__(':title has been deleted', ['title' => $title]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('vanilo.property.show', $property));
    }

    public function sync(SyncModelPropertyValues $request, $for, $forId)
    {
        $model = $request->getFor();
        $model->propertyValues()->sync($request->getPropertyValueIds());

        return redirect(route(sprintf('vanilo.%s.show', shorten(get_class($model))), $model));
    }
}
