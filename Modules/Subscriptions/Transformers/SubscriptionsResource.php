<?php

namespace Modules\Subscriptions\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SubscriptionsResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => SubscriptionResource::collection($this->collection),
        ];
    }
}
