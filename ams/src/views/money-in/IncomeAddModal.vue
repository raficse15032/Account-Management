<template>
    <b-modal title="Income" no-close-on-backdrop hide-footer size="xl" v-model="largeModal" @ok="largeModal = false">
        <form @submit.prevent="addIncome">
            <div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Purpose</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <select v-validate="'required'"  name="Account type" v-model="newIncome.account_id"  class="form-control" >
                                <option value="" >Select Account Type</option>
                                <option v-if="index == 0" disabled style="font-weight:800" v-for="(accountType,index) in getAccountType" :key="index+1000">{{accountType.name.toUpperCase()}}</option>
                                <option v-if="purpose.account_type_id == 15"  v-for="(purpose,index) in purposes" :key="index+2000" :value="purpose.id">{{purpose.name}}</option>
                                <option v-if="index == 1" disabled style="font-weight:800"  v-for="(accountType,index) in getAccountType" :key="index+3000">{{accountType.name.toUpperCase()}}</option>
                                <option v-if="purpose.account_type_id == 16"  v-for="(purpose,index) in purposes" :key="index+4000" :value="purpose.id">{{purpose.name}}</option> -->
                            </select>
                            <span v-if="purposes.length <= 0" style="background: #e0ebeb;padding-left:10px;padding-right:10px;" class="input-group-addon">
                                <i style="margin-top:10px;" class="fa fa-refresh fa-spin"></i>
                            </span>
                        </div>
                        <p  v-show="errors.has('Account type')" style="color:red">* {{ errors.first('Account type') }}</p>
                    </div>
                    <label for="inputPassword3" class="col-sm-2 col-form-label ">Select Customer</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <select v-validate="'required'"  name="Customer" v-model="newIncome.customer_id"  class="form-control" >
                                <option value="" >Select Client</option>
                                <option   :value="contact.id"  v-for="(contact,index) in clients" :key="index">{{contact.name}}</option>
                            </select>
                            <span v-if="clients.length <= 0" style="background: #e0ebeb;padding-left:10px;padding-right:10px;" class="input-group-addon">
                                <i style="margin-top:10px;" class="fa fa-refresh fa-spin"></i>
                            </span>
                        </div>
                        <p  v-show="errors.has('Customer')" style="color:red">* {{ errors.first('Customer') }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Select Agent</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <select v-validate="'required'"  name="Agent" v-model="newIncome.agent_id"  class="form-control" >
                                <option value="" >Select Agent</option>
                                <option  :value="contact.id" v-for="(contact,index) in agents" :key="index+1000">{{contact.name}}</option>
                            </select>
                            <span  v-if="agents.length <= 0" style="background: #e0ebeb;padding-left:10px;padding-right:10px;" class="input-group-addon">
                                <i style="margin-top:10px;" class="fa fa-refresh fa-spin"></i>
                            </span>
                        </div>
                        <p  v-show="errors.has('Agent')" style="color:red">* {{ errors.first('Agent') }}</p>
                    </div>
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Date</label>
                    <div class="col-sm-4">
                        <input v-validate="'required'" name="Date" v-model="newIncome.date" type="date" class="form-control" id="inputPassword3" placeholder="Date">
                        <p  v-show="errors.has('Date')" style="color:red">* {{ errors.first('Date') }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Anount</label>
                    <div class="col-sm-2">
                    <input v-validate="'required|numeric'" name="Amount" v-model="newIncome.amount" type="number" class="form-control" id="inputPassword3" placeholder="Anount">
                    <p  v-show="errors.has('Amount')" style="color:red">* {{ errors.first('Amount') }}</p>
                    </div>
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Utility Charge</label>
                    <div class="col-sm-2">
                    <input v-validate="'required|numeric'" name="Utility charge" v-model="newIncome.utility" type="number" class="form-control" id="inputPassword3" placeholder="Utility Charge">
                    <p  v-show="errors.has('Utility charge')" style="color:red">* {{ errors.first('Utility charge') }}</p>
                    </div>
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Car Parking</label>
                    <div class="col-sm-2">
                    <input v-validate="'required|numeric'" name="Car parking" v-model="newIncome.car_parking" type="number" class="form-control" id="inputPassword3" placeholder="Car Parking">
                    <p  v-show="errors.has('Car parking')" style="color:red">* {{ errors.first('Car parking') }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Registration Cost</label>
                    <div class="col-sm-2">
                    <input v-validate="'required|numeric'" name="Registration cost" v-model="newIncome.registration_cost" type="number" class="form-control" id="inputPassword3" placeholder="Registration Cost">
                    <p  v-show="errors.has('Registration cost')" style="color:red">* {{ errors.first('Registration cost') }}</p>
                    </div>
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Other Cost</label>
                    <div class="col-sm-2">
                    <input v-validate="'required|numeric'" name="Other cost" v-model="newIncome.other_cost" type="number" class="form-control" id="inputPassword3" placeholder="Other Cost">
                    <p  v-show="errors.has('Other cost')" style="color:red">* {{ errors.first('Other cost') }}</p>
                    </div>
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Gift</label>
                    <div class="col-sm-2">
                    <input v-validate="'required|numeric'" name="Gift" v-model="newIncome.gift" type="number" class="form-control" id="inputPassword3" placeholder="Gift">
                    <p  v-show="errors.has('Gift')" style="color:red">* {{ errors.first('Gift') }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Discount</label>
                    <div class="col-sm-2">
                    <input v-validate="'required|numeric'" name="Discount" v-model="newIncome.discount" type="number" class="form-control" id="inputPassword3" placeholder="Discount">
                    <p  v-show="errors.has('Discount')" style="color:red">* {{ errors.first('Discount') }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Total</label>
                    <div  class="col-sm-10">
                        <div style="border-top:2px solid #888;margin-top:3px;">
                            <p class="pull-right"  style="padding-left:10px;margin-top:2px;">{{total}}</p>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Reference Name</label>
                    <div class="col-sm-4">
                    <input v-model="newIncome.reference" type="text" class="form-control" id="inputPassword3" placeholder="Reference Name">
                    </div>
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Bank Info</label>
                    <div class="col-sm-4">
                    <input v-model="newIncome.bank_info" type="text" class="form-control" id="inputPassword3" placeholder="Bank Info">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Note</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" v-model="newIncome.note" cols="20" rows="5"></textarea>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                <input v-if="!addLoader" type="submit" value="Submit" class="btn btn-primary pull-right"/>
                <button v-if="addLoader" class="btn btn-primary pull-right" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Submitting...
                </button>
                <button v-if="!addLoader"  @click.prevent="close" class="btn btn-success pull-right" style="margin-right:5px;">Close</button>
                </div>
            </div>
        </form>
    </b-modal>
</template>

<script>
import Vue from 'vue'
import VeeValidate from 'vee-validate';
Vue.use(VeeValidate)
import axios from 'axios'
import {ALL_PURPOSE,ALL_ACCOUNT_TYPE2,ALL_CONTACT,ADD_INCOME} from "../../store/action.type"
import { mapState,mapGetters } from "vuex"
import { VueEditor } from 'vue2-editor'
export default {
    data(){
        return{
            clients:[],
            agents:[],
            largeModal:false,
            addLoader:false,
            newIncome:{
                date:'',
                amount:0,
                utility:0,
                car_parking:0,
                registration_cost:0,
                gift:0,
                discount:0,
                other_cost:0,
                reference:'',
                account_id:'',
                agent_id:'',
                customer_id:'',
                bank_info:'',
                note:'',
            }
        }
    },
    methods:{
        openModal(){
            this.largeModal = true
        },
        addIncome(){
            this.$validator.validateAll().then( result =>{
                if(result){
                    var data = this.newIncome
                    this.addLoader = true
                    this.$store.dispatch('ADD_INCOME',data)
                    .then(response=>{
                        this.addLoader = false;
                        this.largeModal = false
                        this.$iziToast.success({position:'topRight',title:'Ok',message:"Income Added Successsfully"})
                        
                    })
                    .catch(error=>{
                        this.addLoader = false; 
                        this.$iziToast.error({position:'topRight',title:'Error',message:"Something Wrong !!"})       
                    });
                }
                
            })
            
        },
        close(){
            this.largeModal = false
        },
        contactClients(){
            return new Promise((resolve, reject) => {
                var type = 1
                axios.get("api/specific/contacts/"+type)
                .then(response => {
                    this.clients = response.data
                    resolve(response)
                })
                .catch(error => {
                    reject(error)
                });
            });
        },
        contactAgents(){
            return new Promise((resolve, reject) => {
                var type = 2
                axios.get("api/specific/contacts/"+type)
                .then(response => {
                    this.agents = response.data
                    resolve(response)
                })
                .catch(error => {
                    reject(error)
                });
            });
        },
        necessaryThings(){
            this.$store.dispatch('ALL_PURPOSE')
            this.contactClients()
            this.contactAgents()
            var id = 4;
            this.$store.dispatch('ALL_ACCOUNT_TYPE2',id)
        }
    },
    mounted(){
        this.necessaryThings()
    },
    computed:{
        ...mapGetters(["getAccountType","purposes","allContacts"]),
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
