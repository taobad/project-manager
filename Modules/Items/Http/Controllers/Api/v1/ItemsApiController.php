<?php

namespace Modules\Items\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Items\Entities\Item;
use Modules\Items\Http\Requests\ItemRequest;
use Modules\Items\Services\TaxCalculator;

class ItemsApiController extends Controller
{
    protected $item;
    protected $request;
    /**
     * Create a new controller instance.
     */
    public function __construct(Request $request)
    {
        $this->item = new Item;
        $this->request = $request;
    }

    public function save(ItemRequest $request)
    {
        $request->validate(
            [
                'module' => 'required',
                'module_id' => 'required|numeric',
            ]
        );
        $entity = classByName($request->module)->findOrFail($request->module_id);
        $item = $entity->items()->create($request->except(['tax_rate']));

        if (isset($request->tax_rate[0]) && !is_null($request->tax_rate[0])) {
            (new TaxCalculator($entity, $item, $request->tax_rate))->saveTaxes();
        }
        if (!is_null($entity->tax_types) && !is_null($entity->tax_types[0])) {
            (new TaxCalculator($entity, $item, $entity->tax_types))->saveTaxes();
        }
        $data['item'] = $item;
        $data['data'] = $entity->ajaxTotals();
        if ($request->has('json')) {
            $data['message'] = langapp('saved_successfully');
            $data['html'] = view('items::_ajax.' . $data['data']['scope'] . '.ajax_item')->with($data)->render();
            return $data;
        }

        return ajaxResponse(
            [
                'id' => $item->id,
                'message' => langapp('saved_successfully'),
                'redirect' => $request->url,
            ],
            true,
            Response::HTTP_OK
        );
    }
    public function update(ItemRequest $request, $id)
    {
        $item = $this->item->findOrFail($id);
        $item->update($request->except('id', 'tax_rate'));
        $item->taxes()->delete();
        if (isset($request->tax_rate[0]) && !is_null($request->tax_rate[0])) {
            (new TaxCalculator($item->itemable, $item, $request->tax_rate))->saveTaxes();
        } else {
            $item->update(['tax_total' => 0]);
        }
        return ajaxResponse(
            [
                'id' => $item->id,
                'message' => langapp('changes_saved_successful'),
                'redirect' => $request->url,
            ],
            true,
            Response::HTTP_OK
        );
    }

    public function saveTemplate(ItemRequest $request)
    {
        $subTotal = $request->unit_cost * $request->quantity;
        $discount = 0;
        if ($request->has('discount')) {
            $discount = ($request->discount / 100) * $subTotal;
        }
        $total = formatDecimal($subTotal - $discount);
        $request->request->add(['tax_total' => ($request->tax_rate / 100) * ($total)]);
        $item = $this->item->create($request->all());
        return ajaxResponse(
            [
                'id' => $item->id,
                'message' => langapp('saved_successfully'),
                'redirect' => $request->url,
            ],
            true,
            Response::HTTP_OK
        );
    }

    public function delete($id)
    {
        $item = $this->item->findOrFail($id);
        $item->taxes()->delete();
        $item->delete();
        return ajaxResponse(
            [
                'data' => $item->itemable_id > 0 ? $item->itemable->ajaxTotals() : [],
                'message' => langapp('deleted_successfully'),
                'redirect' => $this->request->url,
            ],
            true,
            Response::HTTP_OK
        );
    }
}
