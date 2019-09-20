<?php

namespace App\Http\Resources\Recruiting;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;
use App\Models\MoneyIn\Invoice;
use App\Models\MoneyIn\PaymentReceive;
class VisaBasic extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
         $processing_rate = Invoice::where('account_id',1)->where('visa_id',$this->id)->sum('total');
         $update = Invoice::where('account_id',2)->where('visa_id',$this->id)->sum('total');
         $others = Invoice::where('account_id',3)->where('visa_id',$this->id)->sum('total');
         $due_amount = Invoice::where('account_id',[1,2,3])->where('visa_id',$this->id)->sum('due_amount');

         return [
            'id'                              =>$this->id,
            'worker_number'                   =>$this->worker_number,
            'passport_number'                 =>$this->passport_number,
            'passport_name'                   =>$this->passport_name,
            'processing_rate'                 =>$processing_rate,
            'update'                          =>$update,
            'others'                          =>$others,
            'due_amount'                      =>$due_amount,
            'visa_number'                     =>$this->visa_number,
            'company_id_number'               =>$this->company_id_number,
            'occupation'                      =>$this->occupation,
            'diving_licence_status'           =>$this->diving_licence_status,
            'gender'                          =>$this->gender,
            'police_clearence_status'         =>$this->police_clearence_status,
            'medical_status'                  =>$this->medical_status,
            'medical'                         =>$this->medical,
            'musaned_status'                  =>$this->musaned_status,
            'musaned_date'                    =>$this->musaned_date,
            'okala_status'                    =>$this->okala_status,
            'okala_date'                      =>$this->okala_date,
            'mofa_status'                     =>$this->mofa_status,
            'mofa_date'                       =>$this->mofa_date,
            'stamping_status'                 =>$this->stamping_status,
            'stamping_date'                   =>$this->stamping_date,
            'finger_training_status'          =>$this->finger_training_status,
            'finger_training_date'            =>$this->finger_training_date,
            'manpower_status'                 =>$this->manpower_status,
            'manpowe_date'                    =>$this->manpowe_date,
            'type'                            =>$this->type,
            'flight_status'                   =>$this->flight_status,
            'flight_date'                     =>$this->flight_date,
            'account_status'                  =>$this->account_status,
            'agent_id'                        =>$this->agent_id,
            'user_id'                         =>$this->user_id,
            'created_at'                      =>$this->created_at->diffForHumans(),
            'updated_at'                      =>$this->updated_at->diffForHumans(),
        ];
    }
}
