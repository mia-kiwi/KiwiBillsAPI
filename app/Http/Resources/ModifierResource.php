<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ModifierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'value' => $this->value,
            'is_percentage' => $this->is_percentage,
            'literal_value' => $this->is_percentage ? $this->value . '%' : $this->value,
            'literal_sign' => $this->value > 0 ? '+' : '-',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
