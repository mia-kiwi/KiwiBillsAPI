<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'title' => $this->title,
            'info' => $this->info,
            'reference' => $this->reference,
            'recieved_at' => $this->recieved_at,
            'due_at' => $this->due_at,
            'issued_at' => $this->issued_at,
            'issued_by' => $this->issuedBy,
            'payable_to' => $this->payableTo,
            'payable_by' => $this->payableBy,
            'lines' => LineResource::collection($this->lines),
            'total' =>  round($this->getTotal(), 2),
            'currency' => $this->getCurrency(),
            'owed' => round($this->getOwed(), 2),
            'status' => $this->getStatus(),
        ];
    }
}
