<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnalyseListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'id'               => $this->id,
            'uuid'             => $this->uuid,
            'status'           => $this->status,
            'score'            => $this->score,
            'is_full_unlocked' => (bool) $this->is_full_unlocked,
            'created_at'       => $this->created_at,
        ];
    }
}
