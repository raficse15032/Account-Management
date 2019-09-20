<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GeneralLeadger extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'date' => $this->date,
            // 'amount' => $this->amount,
            // 'customer' => $this->customer ? $this->customer->name:'',
            // 'vendor' => $this->vendor ? $this->vendor->name:'',
            // 'total' => $this->total,
            // 'ok' => 'ok'
        ];
    }
}
