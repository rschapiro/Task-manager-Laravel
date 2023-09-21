<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'title' => strtoupper($this->title),
            'description' => $this->description,
            'completed' => $this->completed == 1 ? 'Task completed' : 'Task pending',
            'updated_at' => $this->updated_at->diffForHumans()
        ];
    }
}
