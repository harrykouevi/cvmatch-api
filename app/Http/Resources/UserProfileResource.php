<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CreditTransactionResource;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $u= [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'is_guest' => $this->is_guest,
            'resumes_count' =>  $this->resumes_count,
            'current_analyse_done'=> $this->current_analyse_done,

        ] ;
        if($this->is_guest){
            return  $u;
        }else{

            return [
                ...$u ,
                'has_accepted_terms' => $this->has_accepted_terms,
                'credits' => [
                    'remaining' => $this->credit?->balance ?? 0,
                    'used' => $this->credit?->used ?? 0,
                    'total' => $this->credit?->purchased_total ?? 0,
                ],

                'analyses_count' =>  $this->analyses_count,

                'transactions' => CreditTransactionResource::collection(
                    $this->creditTransactions
                ),

                'analyses' => AnalyseListResource::collection(
                    $this->analyses
                ),
            ];
        }
    }
}
