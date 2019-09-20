<?php

namespace App\Http\Resources\Recruiting;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;
use App\Models\MoneyIn\Invoice;
use App\Models\MoneyIn\PaymentReceive;
class Visa extends JsonResource
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
            'diving_licence_by_o'               =>new UserResource($this->diving_licence_by_o),
            'police_clearence_status'         =>$this->police_clearence_status,
            'police_clearence_by_o'             =>new UserResource($this->police_clearence_by_o),
            'medical_status'                  =>$this->medical_status,
            'medical'                         =>$this->medical,
            'medical_by_o'                      =>new UserResource($this->medical_by_o),
            'musaned_status'                  =>$this->musaned_status,
            'musaned_date'                    =>$this->musaned_date,
            'musaned_date_by_o'                 =>new UserResource($this->musaned_date_by_o),
            'okala_status'                    =>$this->okala_status,
            'okala_date'                      =>$this->okala_date,
            'okala_date_by_o'                   =>new UserResource($this->okala_date_by_o),
            'mofa_status'                     =>$this->mofa_status,
            'mofa_date'                       =>$this->mofa_date,
            'mofa_date_by_o'                    =>new UserResource($this->mofa_date_by_o),
            'stamping_status'                 =>$this->stamping_status,
            'stamping_date'                   =>$this->stamping_date,
            'stamping_by_o'                     =>new UserResource($this->stamping_by_o),
            'finger_training_status'          =>$this->finger_training_status,
            'finger_training_date'            =>$this->finger_training_date,
            'finger_training_by_o'              =>new UserResource($this->finger_training_by_o),
            'manpower_status'                 =>$this->manpower_status,
            'manpowe_date'                    =>$this->manpowe_date,
            'type'                            =>$this->type,
            'manpowe_date_by_o'               =>new UserResource($this->manpowe_date_by_o),
            'flight_status'                   =>$this->flight_status,
            'flight_date'                     =>$this->flight_date,
            'flight_date_by_o'                  =>new UserResource($this->flight_date_by_o),
            'account_status'                  =>$this->account_status,
            'agent_id'                        =>$this->agent_id,
            'user_id'                         =>$this->user_id,
            'agent_id_o'                      =>new UserResource($this->agent_id_o),
            'user_id_o'                       =>new UserResource($this->user_id_o),
            'created_by_o'                    =>new UserResource($this->created_by_o),
            'updated_by_o'                    =>new UserResource($this->updated_by_o),
            'created_at'                      =>$this->created_at->diffForHumans(),
            'updated_at'                      =>$this->updated_at->diffForHumans(),
        ];
    }
}
