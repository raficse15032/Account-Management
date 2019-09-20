<template>
	<div class="card">
		<div class="form-group row" style="margin: 9px;">
            <div class="col-sm-4">
                <p><b>Name:</b> {{contactDetails.name}}</p>
            </div>
            <div class="col-sm-4">
                <p v-if="contactDetails.agent"><b>Agent:</b> {{contactDetails.agent}}</p>
            </div>
            <div class="col-sm-4">
                <p><b>Type:</b>
                    {{contactDetails.type == 1 ? 'Client':''}}
                    {{contactDetails.type == 2 ? 'Marketing':''}}
                    {{contactDetails.type == 3 ? 'Land Owner':''}}
                    {{contactDetails.type == 4 ? 'Vendor':''}}
                    {{contactDetails.type == 5 ? 'Unknown':''}}
                </p>
            </div>
            <div class="col-sm-4">
                <p><b>District:</b> {{contactDetails.district_name}}</p>
            </div>
            <div class="col-sm-4">
                <p><b>Subdistric:</b> {{contactDetails.subdistrict_name}}</p>
            </div>
            <div class="col-sm-4">
                <p><b>Designation:</b> {{contactDetails.designation}}</p>
            </div>
            <div class="col-sm-4">
                <p><b>Father Name:</b> {{contactDetails.father_name}}</p>
            </div>
            <div class="col-sm-4">
                <p><b>Mother Name:</b> {{contactDetails.mother_name}}</p>
            </div>
            <div class="col-sm-4">
                <p><b>Spouse Name:</b> {{contactDetails.spouse_name}}</p>
            </div>
            <div class="col-sm-4">
                 <p><b>Area Code:</b> {{contactDetails.area_code}}</p>
            </div>
            <div class="col-sm-4">
                <p><b>Mobile Number:</b> {{contactDetails.mobile_number}}</p>
            </div>
            <div class="col-sm-4">
                <p><b>Contact Number:</b> {{contactDetails.contact_number}}</p>
            </div>
            <div class="col-sm-4">
                <p><b>Email:</b> {{contactDetails.email}}</p>
            </div>
            <div class="col-sm-4">
                <p><b>Occupation:</b> {{contactDetails.occupation}}</p>
            </div>
            <div class="col-sm-4">
                <p><b>Nid:</b> {{contactDetails.nid}}</p>
            </div>
            <div class="col-sm-4">
                <p><b>Birthday:</b> {{contactDetails.birthday}}</p>
            </div>
            <div class="col-sm-4">
                <p><b>Ward/Union:</b> {{contactDetails.ward_union}}</p>
            </div>
            <div class="col-sm-4">
                <p><b>Area/Village:</b> {{contactDetails.area_village}}</p>
            </div>
            <div class="col-sm-4">
                <p><b>Street/Para:</b> {{contactDetails.street_para}}</p>
            </div>
            <div class="col-sm-4">
                <p><b>Post Office:</b> {{contactDetails.post_ofiice}}</p>
            </div>
            
            <div class="col-sm-4">
                <p><b>Created By:</b> {{contactDetails.created_by}}</p>
            </div>
            <div class="col-sm-4">
                <p><b>Updated By:</b> {{contactDetails.updated_by}}</p>
            </div>
        </div>
        <div class="form-group container-fluid row">
                <label for="inputPassword3" class="col-sm-2 col-form-label"></label>
                <div  class="col-sm-10">
                    <div style="border-top:2px solid #888;margin-top:3px;">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Total Invoice</label>
                        <p class="pull-right"  style="padding-left:10px;margin-top:2px;">{{contactDetails.total_invoice}}</p>
                    </div>
                </div>
                <label for="inputPassword3" class="col-sm-2 col-form-label"></label>
                <div  class="col-sm-10">
                    <div style="border-top:2px solid #888;margin-top:3px;">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Total Receive</label>
                        <p class="pull-right"  style="padding-left:10px;margin-top:2px;">{{contactDetails.total_receive}}</p>
                        <input v-model="newInvoice.total" type="hidden">
                    </div>
                </div>
                <label for="inputPassword3" class="col-sm-2 col-form-label"></label>
                <div  class="col-sm-10">
                    <div style="border-top:2px solid #888;margin-top:3px;">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Account Status</label>
                        <p class="pull-right"  style="padding-left:10px;margin-top:2px;">{{parseInt(contactDetails.total_invoice)-parseInt(contactDetails.total_receive)}}</p>
                        <input v-model="newInvoice.total" type="hidden">
                    </div>
                </div>
            </div>
         <div class="container-fluid" style="overflow: auto;">
                <table id="my-table" class="table table-striped table_fields">
                    <thead>
                        <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Workers Number</th>
                        <th scope="col">Passport Name</th>
                        <th scope="col">Processing Rate</th>
                        <th scope="col">Update</th>
                        <th scope="col">Other's</th>
                        <th scope="col">Total</th>
                        <th scope="col">Due</th>
                        <th scope="col">Passport Number</th>
                        <th scope="col">Visa Number</th>
                        <th scope="col">Company ID Number</th>
                        <th scope="col">Occupation</th>
                        <th scope="col">Diving Licence</th>
                        <th scope="col" >Police Clearence</th>
                        <th scope="col">Medical</th>
                        <th scope="col">Musaned</th>
                        <th scope="col">Okala</th>
                        <th scope="col">Mofa</th>
                        <th scope="col">Stamping</th>
                        <th scope="col">Finger Training</th>
                        <th scope="col">Manpower</th>
                        <th scope="col">Flight</th>
                       <!--  <th scope="col">Actions</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(visa,index) in contactDetails.visas" :key="index" >
                            <td>{{visa.created_at}}</td>
                            <td>{{visa.worker_number}}</td>
                            <td>{{visa.passport_name}}</td>
                            <td>{{visa.processing_rate}}</td>
                            <td><span @click="addInvoiceModal(2,visa)">{{visa.update}}</span></td>
                            <td><span @click="addInvoiceModal(3,visa)">{{visa.others}}</span></td>
                            <td>{{parseInt(visa.processing_rate)+parseInt(visa.update)+parseInt(visa.others)}}</td>
                            <td>{{visa.due_amount}}</td>
                            <td>{{visa.passport_number}}</td>
                            <td>{{visa.visa_number}}</td>
                            <td>{{visa.company_id_number}}</td>
                            <td>{{visa.occupation}}</td>
                            <td>
                                   <span @click="updateModal(2,index)" v-if="visa.diving_licence_status==0 || visa.diving_licence_status==null" class="badge badge-warning">No</span>
                                   <span @click="updateModal(2,index)" v-else class="badge badge-success">Yes</span>
                            </td>
                            <td>
                                <span @click="updateModal(2,index)" v-if="visa.police_clearence_status==0 || visa.police_clearence_status==null" class="badge badge-warning">No</span>
                               <span  @click="updateModal(2,index)" v-else class="badge badge-success">Yes</span>
                            <td>
                                <span @click="updateModal(3,index)" v-if="visa.medical_status==0 || visa.medical_status==null" class="badge badge-warning">No</span>
                               <span @click="updateModal(3,index)" v-else class="badge badge-success">Yes
                                </br></br>
                                <p v-if="visa.medical==1">Fit</p>
                                <p v-if="visa.medical==0">Update</p>
                               </span>
                            </td>
                            <td>
                                <span @click="updateModal(4,index)" v-if="visa.musaned_status==0 || visa.musaned_status==null" class="badge badge-warning">No</span>
                               <span @click="updateModal(4,index)" v-else class="badge badge-success">Yes </br>
                                {{visa.musaned_date}}
                               </span>
                               
                            </td>
                            <td>
                                <span @click="updateModal(5,index)" v-if="visa.okala_status==0 || visa.okala_status==null" class="badge badge-warning">No</span>
                               <span @click="updateModal(5,index)" v-else class="badge badge-success">Yes</br>
                                {{visa.okala_date}}
                               </span>
                            </td>
                            <td>
                                <span @click="updateModal(6,index)" v-if="visa.mofa_status==0 || visa.mofa_status==null" class="badge badge-warning">No</span>
                               <span @click="updateModal(6,index)" v-else class="badge badge-success">Yes </br>
                                {{visa.mofa_date}}
                               </span>
                            </td>
                            <td>
                                <span @click="updateModal(7,index)" v-if="visa.stamping_status==0 || visa.stamping_status==null" class="badge badge-warning">No</span>
                               <span @click="updateModal(7,index)" v-else class="badge badge-success">Yes</br>
                                {{visa.stamping_date}}
                               </span>
                            </td>
                            <td>
                                <span @click="updateModal(8,index)" v-if="visa.finger_training_status==0 || visa.finger_training_status==null" class="badge badge-warning">No</span>
                               <span @click="updateModal(8,index)" v-else class="badge badge-success">Yes </br>
                                {{visa.finger_training_date}}
                               </span>
                            </td>
                            <td>
                                <span @click="updateModal(9,index)" v-if="visa.manpower_status==0 || visa.manpower_status==null" class="badge badge-warning">No</span>
                                <span @click="updateModal(9,index)" v-else class="badge badge-success">Yes</br>
                                    {{visa.manpower_date}}
                               </span>
                            </td>
                            <td>
                                <span @click="updateModal(10,index)" v-if="visa.flight_status==0 || visa.flight_status==null" class="badge badge-warning">No</span>
                                   <span @click="updateModal(10,index)" v-else class="badge badge-success">Yes</br>
                                    {{visa.flight_date}}
                               </span>
                            </td>
                            <!-- <td>
                                <i  class="icon-note icons actn" @click="updateModal(1,index)"> </i>
                               
                                <i class="icon-trash icons   actn" @click="del(index,visa.id)"> </i>
                            </td> -->
                        </tr>
                    </tbody>
                </table>
            </div>
      <AddInvoice :newInvoice="newInvoice" ref="add_invoice_modal"></AddInvoice>
	</div>
</template>
<script>

import Loader from '../common/Loader'
import { CONTACT_DETAILS,ALL_VISA,DELETE_VISA,GETLASTID } from "../../store/action.type"
import { mapState,mapGetters } from "vuex"
import AddInvoice from './addInvoice'
export default {
    data(){
        return {
        	id:this.$route.params.id,
            largeModal2: false,
            contacts:[],
            permission:'',
            loading:false,
            search:{
                search_item:'',
                type:''
            },
            newInvoice:{
                date:'',
                account_id:'',
                agent_id:'',
                customer_id:'',
                visa_id:'',
                invoice_number:'',
                due_date:'',
                customer_id:'',
                commission_type:'',
                commission_amount:'',
                shipping_charge:'',
                adjustment:0,
                total:'',
                personal_note:'',
                customer_note:'',
                invoice_items:[{
                    project_id:'',
                    quantity:1,
                    rate:0,
                    discount:0,
                    tax:0,
                    amount:0,
                    purpose_id:''
                }],
            },
        }
    },
    methods:{
        addInvoiceModal(account_id,visa){
            this.newInvoice.account_id=account_id;
            this.newInvoice.customer_id=visa.user_id;
            this.newInvoice.visa_id=visa.id;
            this.newInvoice.agent_id=visa.agent_id;
            this.newInvoice.date='';
            this.newInvoice.due_date='';
            this.newInvoice.total='';
            this.newInvoice.personal_note='';
            this.newInvoice.customer_note='';
            this.$refs.add_invoice_modal.openModal()
        },
        
        getResults() {

            this.$store.dispatch('CONTACT_DETAILS',this.id)
            .then(response=>{
                this.loading=false;
            })
            .catch(error=>{
                this.loading=true;        
            });

        },
        
        getPermission(){
            this.$store.dispatch('ALL_USER_ROLE2')
            .then(response=>{
                this.permission = response.data.permission
            })
        }
    },
    mounted(){
        this.getResults()
    },
    computed: {
        ...mapGetters(["contactDetails"]),
    },
    components: {
        Loader,
        AddInvoice,
    }

}
</script>

<style>
 .actn{
     margin-left: 10px;
     cursor: pointer;
 }
 .contct{
     padding-bottom: 10px;
     padding-top: 10px
 }
 .contct-b{
     margin-bottom: 10px;
     margin-top: 10px
 }
 .load{
     margin-left: 50%;
 }
 .table_fields>td>span{
 	cursor:pointer;
 }
</style>
