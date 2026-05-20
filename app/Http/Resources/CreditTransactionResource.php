<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreditTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'label' => match ($this->type) {
                'purchase' => 'Starter Pack',
                'usage' => 'Resume Optimization',
                'refund' => 'Refund',
                'bonus' => 'Bonus',
                default => 'Transaction',
            },

            'detail' => "+{$this->credits} {$this->description}" ,
        ];
    }
}
