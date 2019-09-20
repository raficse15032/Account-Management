
<template>
    <b-modal title="Workers Information Add Form" no-close-on-backdrop hide-footer size="xl" v-model="largeModal" @ok="largeModal = false">
        <form @submit.prevent="addVisa" >
            <div class="container custom_modal_body">
                <div class="form-group row"  v-if="list.entryType==1">
                    <label for="inputPassword3" class="col-sm-2 col-form-label ">Select Customer</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <select :disabled="list.entryType!=1" @change="errorClear('user_id')" name="Category" v-model="list.user_id"  class="form-control" >
                                <option value="" >Select Client</option>
                                <option  v-if="contact.type == 1" :value="contact.id"  v-for="(contact,index) in allContacts" :key="index">{{contact.name}}</option>
                            </select>
                        </div>
                        <p style="color:red" v-for="(error,k) in errors.user_id" v-bind:key="'user_id'+k">{{error}}</p>
                    </div>
                   <!--  <label for="inputPassword3" class="col-sm-2 col-form-label">Select Agent</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <select :disabled="list.entryType!=1" @change="errorClear('agent_id')" name="Category" v-model="list.agent_id"  class="form-control" >
                                <option value="" >Select Agent</option>
                                <option v-if="contact.type == 2" :value="contact.id" v-for="(contact,index) in allContacts" :key="index+1000">{{contact.name}}</option>
                            </select>
                        </div>
                        <p style="color:red" v-for="(error,k) in errors.agent_id" v-bind:key="'user_id'+k">{{error}}</p>
                    </div> -->
                </div>
                <div class="form-group row"  v-if="list.entryType==1">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Passport Name</label>
                    <div class="col-sm-4">
                    <input @keydown="errorClear('passport_name')"  v-model="list.passport_name" :disabled="list.entryType!=1" type="text" class="form-control" id="inputPassword3" placeholder="passport name">
                    <p style="color:red" v-for="(error,k) in errors.passport_name" v-bind:key="'passport_name'+k">{{error}}</p>
                    </div>
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Passport Number</label>
                    <div class="col-sm-4">
                    <input @keydown="errorClear('passport_number')" v-model="list.passport_number" :disabled="list.entryType!=1" type="text" class="form-control" id="inputPassword3" placeholder="passport number">
                    <p style="color:red" v-for="(error,k) in errors.passport_number" v-bind:key="'user_id'+k">{{error}}</p>
                    </div>
                    
                </div>
                <div class="form-group row"  v-if="list.entryType==1">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Visa Number</label>
                    <div class="col-sm-4">
                    <input @keydown="errorClear('visa_number')" v-model="list.visa_number" :disabled="list.entryType!=1" type="text" class="form-control" id="inputPassword3" placeholder="visa number">
                    <p style="color:red" v-for="(error,k) in errors.visa_number" v-bind:key="'user_id'+k">{{error}}</p>
                    </div>
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Processing Rate</label>
                    <div class="col-sm-4">
                    <input  @keydown="errorClear('processing_rate')" v-model="list.processing_rate" type="text" :disabled="list.entryType!=1 || list.id!=''" class="form-control" id="inputPassword3" placeholder="processing rate">
                    </div>
                    
                </div>
                <div class="form-group row"  v-if="list.entryType==1">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Company ID Number</label>
                    <div class="col-sm-4">
                    <input v-model="list.company_id_number" :disabled="list.entryType!=1" type="text" class="form-control" id="inputPassword3" placeholder="company id number">
                    </div>
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Occupation</label>
                    <div class="col-sm-4">
                    <input v-model="list.occupation" :disabled="list.entryType!=1" type="text" class="form-control" id="inputPassword3" placeholder="occupation">
                    </div>
                </div>
                <div class="form-group row" v-if="list.entryType==1">
                    <label for="inputPassword3" class="col-sm-2 col-form-label ">Select gender</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <select  name="Category" :disabled="list.entryType!=1" v-model="list.gender"  class="form-control">
                                <option value="" selected>Select gender</option>
                                <option value="Male" >Male</option>
                                <option value="Female" >Female</option>
                                <option value="Others" >Others</option>
                            </select>
                        </div>
                    </div>
                    <label for="workernumber" class="col-sm-2 col-form-label">Worker Number</label>
                    <div class="col-sm-4">
                    <input v-model="list.worker_number" disabled type="text" class="form-control" id="workernumber" placeholder="workernumber">
                    </div>
                </div>
                <div class="form-group row" v-if="list.entryType==2 ||  list.entryType==1">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Diving Licence </label>
                    <div class="col-sm-4">
						<div class="custom-control custom-checkbox custom-control-inline"><input  v-model="list.diving_licence_status" type="checkbox" id="diving_licence_status"  checked="checked" class="custom-control-input"><label  for="diving_licence_status" class="custom-control-label">Status</label>
						</div>
                    </div>
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Police Clearence</label>
                    <div class="col-sm-4">
						<div  class="custom-control custom-checkbox custom-control-inline"><input  v-model="list.police_clearence_status" type="checkbox" id="police_clearence_status"  checked="checked" class="custom-control-input"><label  for="police_clearence_status" class="custom-control-label">Status</label>
						</div>
                    </div>
                </div>
                <div class="form-group row" v-if="list.entryType==3">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Medical</label>
                    <div class="col-sm-4">
                        <div class="custom-control custom-checkbox custom-control-inline"><input  v-model="list.medical_status" type="checkbox" id="medical_status"  checked="checked" class="custom-control-input"><label  for="medical_status" class="custom-control-label">Status</label>
                        </div>
                    </div>
                    <label for="inputPassword3" class="col-sm-2 col-form-label ">Select Medical Status</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <select  name="Category" v-model="list.medical"  class="form-control">
                                <option value="" selected>Select Medical Status</option>
                                <option value="1">Fit</option>
                                <option value="0">Update</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row" v-if="list.entryType==4">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Musaned</label>
                    <div class="col-sm-4">
                        <div class="custom-control custom-checkbox custom-control-inline"><input  v-model="list.musaned_status" type="checkbox" id="musaned_status"  checked="checked" class="custom-control-input"><label  for="musaned_status" class="custom-control-label">Status</label>
                        </div>
                    </div>
                     <label for="inputPassword3" class="col-sm-2 col-form-label">Musaned Date</label>
                    <div class="col-sm-4">
                        <input v-model="list.musaned_date" type="date" class="form-control" id="musaned_date" placeholder="Date">
                    </div>
                </div>
                <div class="form-group row" v-if="list.entryType==5">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Okala</label>
                    <div class="col-sm-4">
                        <div class="custom-control custom-checkbox custom-control-inline"><input  v-model="list.okala_status" type="checkbox" id="okala_status"  checked="checked" class="custom-control-input"><label  for="okala_status" class="custom-control-label">Status</label>
                        </div>
                    </div>
                     <label for="inputPassword3" class="col-sm-2 col-form-label">Okala Date</label>
                    <div class="col-sm-4">
                        <input v-model="list.okala_date" type="date" class="form-control" id="okala_date" placeholder="Date">
                    </div>
                </div>
                <div class="form-group row" v-if="list.entryType==6">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Mofa</label>
                    <div class="col-sm-4">
                        <div class="custom-control custom-checkbox custom-control-inline"><input  v-model="list.mofa_status" type="checkbox" id="mofa_status"  checked="checked" class="custom-control-input"><label  for="mofa_status" class="custom-control-label">Status</label>
                        </div>
                    </div>
                     <label for="inputPassword3" class="col-sm-2 col-form-label">Mofa Date</label>
                    <div class="col-sm-4">
                        <input v-model="list.mofa_date" type="date" class="form-control" id="mofa_date" placeholder="Date">
                    </div>
                </div>
                <div class="form-group row" v-if="list.entryType==7">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Stamping</label>
                    <div class="col-sm-4">
                        <div class="custom-control custom-checkbox custom-control-inline"><input  v-model="list.stamping_status" type="checkbox" id="stamping_status"  checked="checked" class="custom-control-input"><label  for="stamping_status" class="custom-control-label">Status</label>
                        </div>
                    </div>
                     <label for="inputPassword3" class="col-sm-2 col-form-label">Stamping Date</label>
                    <div class="col-sm-4">
                        <input v-model="list.stamping_date" type="date" class="form-control" id="stamping_date" placeholder="Date">
                    </div>
                </div>
                <div class="form-group row" v-if="list.entryType==8">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Finger Training</label>
                    <div class="col-sm-4">
                        <div class="custom-control custom-checkbox custom-control-inline"><input  v-model="list.finger_training_status" type="checkbox" id="finger_training_status"  checked="checked" class="custom-control-input"><label  for="finger_training_status" class="custom-control-label">Status</label>
                        </div>
                    </div>
                     <label for="inputPassword3" class="col-sm-2 col-form-label">Finger Training Date</label>
                    <div class="col-sm-4">
                        <input v-model="list.finger_training_date" type="date" class="form-control" id="finger_training_date" placeholder="Date">
                    </div>
                </div>
                <div class="form-group row" v-if="list.entryType==9">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Manpower</label>
                    <div class="col-sm-4">
                        <div class="custom-control custom-checkbox custom-control-inline"><input  v-model="list.manpower_status" type="checkbox" id="manpower_status"  checked="checked" class="custom-control-input"><label  for="manpower_status" class="custom-control-label">Status</label>
                        </div>
                    </div>
                     <label for="inputPassword3" class="col-sm-2 col-form-label">Manpowe Date</label>
                    <div class="col-sm-4">
                        <input v-model="list.manpowe_date" type="date" class="form-control" id="manpowe_date" placeholder="Date">
                    </div>
                </div>
                <div class="form-group row" v-if="list.entryType==10">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Flight</label>
                    <div class="col-sm-4">
                        <div class="custom-control custom-checkbox custom-control-inline"><input  v-model="list.flight_status" type="checkbox" id="flight_status"  checked="checked" class="custom-control-input"><label  for="flight_status" class="custom-control-label">Status</label>
                        </div>
                    </div>
                     <label for="inputPassword3" class="col-sm-2 col-form-label">Flight Date</label>
                    <div class="col-sm-4">
                        <input v-model="list.flight_date" type="date" class="form-control" id="flight_date" placeholder="Date">
                    </div>
                </div>
                <div class="form-group row" v-if="list.entryType==11">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Delivery Status</label>
                    <div class="col-sm-4">
                        <div class="custom-control custom-checkbox custom-control-inline"><input  v-model="list.account_status" type="checkbox" id="account_status"  checked="checked" class="custom-control-input"><label  for="account_status" class="custom-control-label">Status</label>
                        </div>
                    </div>
                     <label for="inputPassword3" class="col-sm-2 col-form-label">Account Date</label>
                    <div class="col-sm-4">
                        <input v-model="list.account_date" type="date" class="form-control" id="account_date" placeholder="Date">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                <input type="submit" value="submit" v-if="!addLoader"  class="btn btn-primary pull-right">
                 <button v-if="addLoader" class="btn btn-primary pull-right" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Submitting...
                </button>
                <button @click.prevent="close" class="btn btn-success pull-right" style="margin-right:5px;">Close</button>
                </div>
            </div>
        </form>
    </b-modal>
</template>

<script>
import {ALL_PURPOSE,ALL_ACCOUNT_TYPE,ALL_CONTACT,ADD_INCOME} from "../../../store/action.type"
import { mapState,mapGetters } from "vuex"
import { VueEditor } from 'vue2-editor'
export default {
	props:['list'],
    data(){
        return{
            largeModal:false,
            errors:[],
            addLoader:false,
        }
    },
    watch:{
        list(val){
            //alert(val);
            //this.list.entryType = val.entryType;
            //this.openModal();
        }
    },
    methods:{
        close(){
            this.largeModal = false;
        },
        errorClear(fields)
        {
            delete this.errors[fields];
        },
        openModal(){
            this.largeModal = true
        },
        addVisa(){
            this.addLoader=true;
            var type = this.$parent.list.entryType;
            this.$store.dispatch('ADD_VISA',this.list)
            .then(response=>{
                this.addLoader=false;
                this.largeModal = false;
                if(type==1){
                    this.$parent.list={entryType:1};
                    this.errors = [];
                }
                this.$parent.list.entryType= type;
                this.$parent.active =false;
            }).catch(errors=>{
                this.addLoader=false;
                this.errors=errors.response.data.errors;
            });
        },
        necessaryThings(){
            this.$store.dispatch('ALL_PURPOSE')
            this.$store.dispatch('ALL_CONTACT')
            this.$store.dispatch('ALL_ACCOUNT_TYPE',1)
        }
    },
    mounted(){
        this.necessaryThings()
    },
    computed:{
        ...mapGetters(["accountTypes","purposes","allContacts"]),
        total(){
            return ((parseFloat(this.newIncome.amount)+parseFloat(this.newIncome.utility)+parseFloat(this.newIncome.car_parking)+parseFloat(this.newIncome.registration_cost)+parseFloat(this.newIncome.other_cost))-(parseFloat(this.newIncome.discount)+parseFloat(this.newIncome.gift)))
        }
        
    },
    components:{
        VueEditor
    }
}
</script>

<style>
#preview {
        height: 120px;
        width: 70%;
    }
    #preview img{
        height: 100%;
        width: 100%;
    }
</style>
