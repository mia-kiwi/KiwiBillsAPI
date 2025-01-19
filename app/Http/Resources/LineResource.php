<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LineResource extends JsonResource
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
            'index' => $this->index,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'vat' => $this->vat,
            'invoice_id' => $this->invoice_id,
            'item' => new ItemResource($this->item),
            'modifiers' => ModifierResource::collection($this->modifiers),
            'line_total' => floatval($this->getLineTotal()),
            'literal_short_line_total' => $this->getShortFormattedTotal(),
            'literal_line_total' => $this->getFormattedTotal(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
