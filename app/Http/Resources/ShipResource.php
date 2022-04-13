<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShipResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'fuel_capacity' => $this->fuel_capacity,
            'fuel_level' => $this->fuel_level,
            'weight_capacity' => $this->weight_capacity,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'pilot' => new PilotResource($this->whenLoaded('pilot')),
        ];
    }
}
