<?php

namespace Modules\Notes\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
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
            'type' => 'notes',
            'id' => (string) $this->id,
            'attributes' => [
                'id' => $this->id,
                'name' => $this->name,
                'description' => $this->description,
                'date' => $this->date,
                'noteable' => [
                    'id' => $this->noteable->id,
                    'name' => $this->noteable->name,
                ],
                'user_id' => $this->user_id,
                'created_at' => $this->created_at->toIso8601String(),
                'updated_at' => $this->updated_at->toIso8601String(),
            ],
        ];
    }
}
