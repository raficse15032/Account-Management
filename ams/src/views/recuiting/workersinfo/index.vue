<template>
    <div class="card">
        <div class="container-fluid">
            <div class="container-fluid">
            <button v-if="permission.recuiting_create" type="button" @click="openModal(1)" class="btn btn-primary contct-b pull-left"><i class="icons icon-user-follow"></i>Add Workers info</button>
            <div style="margin:10px;" class="pull-right">
            <downloadExcel :data="dataForExcel">
                <button class="btn btn-success">Excel <i class="fa fa-file-excel-o" aria-hidden="true"></i></button>
            </downloadExcel>
            </div>
            <form class="form-inline contct my-2 my-lg-0 pull-right" v-on:submit.prevent="onSubmit">
                <b-nav pills  style="margin-left: 387px;">
            <b-nav-item @click="activeDataF(1)" :class="activeData==1?'activesidebar':''">Active</b-nav-item>
            <b-nav-item @click="activeDataF(0)" :class="activeData==0?'activesidebar':''">Pending</b-nav-item>
          </b-nav>
                <input class="form-control mr-sm-2" v-model="search" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" @click="searchf">Search</button>
                 
            </form>
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
                        <th scope="col" v-if="sidebar==1 || sidebar==2">Diving Licence</th>
                        <th scope="col" v-if="sidebar==1 || sidebar==3">Police Clearence</th>
                        <th scope="col" v-if="sidebar==1 || sidebar==4">Medical</th>
                        <th scope="col"  v-if="sidebar==1 || sidebar==5">Musaned</th>
                        <th scope="col" v-if="sidebar==1 || sidebar==6">Okala</th>
                        <th scope="col" v-if="sidebar==1 || sidebar==7">Mofa</th>
                        <th scope="col"  v-if="sidebar==1 || sidebar==8">Stamping</th>
                        <th scope="col" v-if="sidebar==1 || sidebar==9">Finger Training</th>
                        <th scope="col" v-if="sidebar==1 || sidebar==10">Manpower</th>
                        <th scope="col"  v-if="sidebar==1 || sidebar==11">Flight</th>
                        <th scope="col"  v-if="sidebar==1 || sidebar==11">Delivery Status</th>
                        <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(visa,index) in visas.data" :key="index" >
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
                            <td v-if="sidebar==1 || sidebar==2">
                                   <span @click="updateModal(2,index)" v-if="visa.diving_licence_status==0 || visa.diving_licence_status==null" class="badge badge-warning">No</span>
                                   <span @click="updateModal(2,index)" v-else class="badge badge-success">Yes</span>
                            </td>
                            <td v-if="sidebar==1 || sidebar==3">
                                <span @click="updateModal(2,index)" v-if="visa.police_clearence_status==0 || visa.police_clearence_status==null" class="badge badge-warning">No</span>
                               <span  @click="updateModal(2,index)" v-else class="badge badge-success">Yes</span>
                            <td  v-if="sidebar==1 || sidebar==4">
                                <span @click="updateModal(3,index)" v-if="visa.medical_status==0 || visa.medical_status==null" class="badge badge-warning">No</span>
                               <span @click="updateModal(3,index)" v-else class="badge badge-success">Yes
                                </br></br>
                                <p v-if="visa.medical==1">Fit</p>
                                <p v-if="visa.medical==0">Update</p>
                               </span>
                            </td>
                            <td v-if="sidebar==1 || sidebar==5">
                                <span @click="updateModal(4,index)" v-if="visa.musaned_status==0 || visa.musaned_status==null" class="badge badge-warning">No</span>
                               <span @click="updateModal(4,index)" v-else class="badge badge-success">Yes </br>
                                {{visa.musaned_date}}
                               </span>
                               
                            </td>
                            <td v-if="sidebar==1 || sidebar==6">
                                <span @click="updateModal(5,index)" v-if="visa.okala_status==0 || visa.okala_status==null" class="badge badge-warning">No</span>
                               <span @click="updateModal(5,index)" v-else class="badge badge-success">Yes</br>
                                {{visa.okala_date}}
                               </span>
                            </td>
                            <td v-if="sidebar==1 || sidebar==7">
                                <span @click="updateModal(6,index)" v-if="visa.mofa_status==0 || visa.mofa_status==null" class="badge badge-warning">No</span>
                               <span @click="updateModal(6,index)" v-else class="badge badge-success">Yes </br>
                                {{visa.mofa_date}}
                               </span>
                            </td>
                            <td v-if="sidebar==1 || sidebar==8">
                                <span @click="updateModal(7,index)" v-if="visa.stamping_status==0 || visa.stamping_status==null" class="badge badge-warning">No</span>
                               <span @click="updateModal(7,index)" v-else class="badge badge-success">Yes</br>
                                {{visa.stamping_date}}
                               </span>
                            </td>
                            <td v-if="sidebar==1 || sidebar==9">
                                <span @click="updateModal(8,index)" v-if="visa.finger_training_status==0 || visa.finger_training_status==null" class="badge badge-warning">No</span>
                               <span @click="updateModal(8,index)" v-else class="badge badge-success">Yes </br>
                                {{visa.finger_training_date}}
                               </span>
                            </td>
                            <td  v-if="sidebar==1 || sidebar==10">
                                <span @click="updateModal(9,index)" v-if="visa.manpower_status==0 || visa.manpower_status==null" class="badge badge-warning">No</span>
                                <span @click="updateModal(9,index)" v-else class="badge badge-success">Yes</br>
                                    {{visa.manpower_date}}
                               </span>
                            </td>
                            <td  v-if="sidebar==1 || sidebar==11">
                                <span @click="updateModal(10,index)" v-if="visa.flight_status==0 || visa.flight_status==null" class="badge badge-warning">No</span>
                                   <span @click="updateModal(10,index)" v-else class="badge badge-success">Yes</br>
                                    {{visa.flight_date}}
                               </span>
                            </td>
                            <td  v-if="sidebar==1 || sidebar==11">
                                <span @click="updateModal(11,index)" v-if="visa.account_status==0 || visa.account_status==null" class="badge badge-warning">No</span>
                                   <span @click="updateModal(11,index)" v-else class="badge badge-success">Yes</br>
                                    {{visa.account_date}}
                               </span>
                            </td>
                            <td>
                                <i  class="icon-note icons actn" @click="updateModal(1,index)"> </i>
                                <!-- <i  class="icon-eye icons   actn"> </i> -->
                                <i class="icon-trash icons   actn" @click="del(index,visa.id)"> </i>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <nav aria-label="Page navigation example">
                    <!-- <ul class="pagination pagination-sm">
                        <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                        </li>
                    </ul> -->
                    <pagination :data="visas" @pagination-change-page="getResults"></pagination>
                </nav>
            </div>
            <!-- <Loader v-if="contactLoader"></Loader> -->
        </div>
        <Create :list="list" ref="create_modal"></Create>
        <Loader v-if="loader"></Loader>
        <AddInvoice :newInvoice="newInvoice" ref="add_invoice_modal"></AddInvoice>
    </div>
</template>
<script>
import Vue from "vue";
Vue.component('pagination', require('laravel-vue-pagination'));
import Create from './create'
import AddInvoice from './addInvoice'
import Loader from '../../common/Loader'
import { mapState,mapGetters } from "vuex"
import jsPDF from 'jspdf'
import 'jspdf-autotable'
import downloadExcel from 'vue-json-excel'
import { ALL_VISA,DELETE_VISA,GETLASTID,ALL_USER_ROLE2 } from '@/store/action.type';

export default {
    name:'Visa',
    components: {
        Create,
        Loader,
        downloadExcel,
        AddInvoice,
    },
    data(){
        return {
            permission:'',
            dataForExcel:[],
            lists:[],
            list:{
                entryType:1,
            },
            dataloading:false,
            data:{},
            sidebar:1,
            activeData:1,
            search:'',
            loader:false,
            type:'',
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
    computed: {
        ...mapGetters(["visas","allContacts","lastid"]),
    },
    mounted(){
        if(this.$route.name=='Recruiting Workers Infos'){
            this.type=2;
        }else{
            this.type=1;
        }
        this.getPermission();
       this.getResults(); 
    },
    watch:{
        '$route'(to,from){
            if(this.$route.name=='Recruiting Workers Infos'){
                this.type=2;
            }else{
                this.type=1;
            }
            this.getResults();
        }
    },
    methods:{
        getPermission(){
            this.$store.dispatch('ALL_USER_ROLE2')
            .then(response=>{
                this.permission = response.data.permission
            })
        },
        addInvoiceModal(account_id,visa){
            if(this.permission.invoice_create){
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
            }
            
        },
        makePdf(){
            const doc = new jsPDF();
            doc.autoTable({html: '#my-table'});
            doc.save('table.pdf'); 
        },
        sidebarActive(type){
            this.sidebar =  type;
            this.activeData = 1;
            if(type==1){
               this.data = {}; 
            }else if(type==2){
                this.data = {};
                this.data.diving_licence_status=1;
            }else if(type==3){
                this.data = {};
                this.data.police_clearence_status=1;
            }else if(type==4){
                this.data = {};
                this.data.medical_status=1;
            }else if(type==5){
                this.data = {};
                this.data.musaned_status=1;
            }else if(type==6){
                this.data = {};
                this.data.okala_status=1;
            }else if(type==7){
                this.data = {};
                this.data.mofa_status=1;
            }else if(type==8){
                this.data = {};
                this.data.stamping_status=1;
            }else if(type==9){
                this.data = {};
                this.data.finger_training_status=1;
            }else if(type==10){
                this.data = {};
                this.data.manpower_status=1;
            }else if(type==11){
                this.data = {};
                this.data.flight_status=1;
            }else if(type==12){
                this.data = {};
                this.data.account_status=1;
            }
            this.getResults();
        },
        activeDataF(type){
            this.activeData =  type;
            if(this.sidebar==1){
               this.data = {}; 
            }else if(this.sidebar==2){
                this.data = {};
                this.data.diving_licence_status=type;
            }else if(this.sidebar==3){
                this.data = {};
                this.data.police_clearence_status=type;
            }else if(this.sidebar==4){
                this.data = {};
                this.data.medical_status=type;
            }else if(this.sidebar==5){
                this.data = {};
                this.data.musaned_status=type;
            }else if(this.sidebar==6){
                this.data = {};
                this.data.okala_status=type;
            }else if(this.sidebar==7){
                this.data = {};
                this.data.mofa_status=type;
            }else if(this.sidebar==8){
                this.data = {};
                this.data.stamping_status=type;
            }else if(this.sidebar==9){
                this.data = {};
                this.data.finger_training_status=type;
            }else if(this.sidebar==10){
                this.data = {};
                this.data.manpower_status=type;
            }else if(this.sidebar==11){
                this.data = {};
                this.data.flight_status=type;
            }else if(this.sidebar==12){
                this.data = {};
                this.data.account_status=type;
            }
            this.getResults();
        },
        searchf(){
            this.data = {};
            this.data.search=this.search;
            this.getResults();
        },
        openModal(type){

                 this.$store.dispatch('GETLASTID')
                .then(response=>{
                    this.$refs.create_modal.openModal();
                    if(this.type==1){
                        this.list={
                            entryType:type,
                            id:'',
                            type:this.type,
                            worker_number:'RBL-P'+this.lastid,
                        };
                    }else{
                        this.list={
                            entryType:type,
                            id:'',
                            type:this.type,
                            worker_number:'RBL-R'+this.lastid,
                        };
                    }
                    
                })
                .catch(error=>{
                    this.loader=true;        
                });
            
           
            
        },
        updateModal(type,index){
           alert(type);
            let p =0;
            if(type==1 && this.permission.recuiting_update){
               p = 1; 
            }else if(type==2 && this.permission.recuiting_update){
                p = 1; 
            }else if(type==3 && this.permission.medical_update){
               
                p = 1; 
            }else if(type==4 && this.permission.musaned_update){
                p = 1; 
            }else if(type==5 && this.permission.okala_update){
                p = 1; 
            }else if(type==6 && this.permission.mofa_update){
                p = 1; 
            }else if(type==7 && this.permission.stamping_update){
                p = 1; 
            }else if(type==8 && this.permission.finger_update){
                p = 1;  
            }else if(type==9 && this.permission.manpower_update){
                p = 1; 
            }else if(type==10 && this.permission.flight_update){
                p = 1; 
            }else if(type==11 && this.permission.account_update){
                p = 1; 
            }
            if(p==1){
            this.list = this.visas.data[index];
            this.list.entryType = type;
            this.$refs.create_modal.openModal();
           }
        },
        getResults(page = 1){
            this.loader = true;
            this.data.type = this.type;
            var data = this.data;
            this.$store.dispatch('ALL_VISA',{data,page})
            .then(response=>{
                this.dataForExcel =[]
                var that = this
                var visadata = response.data.data;
                visadata.forEach(element => {
                    var exldata = {
                        "Worker Number" : element.worker_number,
                        "Passport Name" : element.passport_name,
                        "Processing Rate" : element.processing_rate,
                        "Update" : element.update,
                        "Other's" : element.others,
                        "Total" : parseInt(element.processing_rate)+parseInt(element.update)+parseInt(element.others),
                        "Due" : element.due_amount,
                        "Passport Number" : element.passport_number,
                        "Visa Number" : element.visa_number,
                        "Gender" : element.gender,
                        "Company ID Number" : element.company_id_number,
                        "Occupation" : element.occupation,
                        "Diving Licence" : element.diving_licence_status ==0||element.diving_licence_status ==null?"No":"Yes",
                        "Police Clearence" : element.police_clearence_status ==0||element.police_clearence_status ==null?"No":"Yes",
                        "Medical" : element.medical==0?"Update":""+element.medical==1?"Fit":"",
                        "Musaned" : element.musaned_date,
                        "Okala" : element.okala_date,
                        "Mofa" : element.mofa_date,
                        "Stamping" : element.stamping_date,
                        "Finger Training" : element.finger_training_date,
                        "Manpower" : element.manpower_date,
                        "Flight" : element.flight_date,
                    }
                    that.dataForExcel.push(exldata)
                })
                this.loader=false;
            })
            .catch(error=>{
                this.loader=true;        
            });

        },
        del(index,id){

            var self = this
            this.$iziToast.question({
                timeout: 10000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Hey',
                message: 'Are you sure To Delete?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        self.$store.dispatch(DELETE_VISA,{index,id})
                        .then(response=>{
                            this.dataloading=false;
                        })
                        .catch(error=>{
                            this.dataloading=true;        
                        }); 
                        
            
                    }, true],
                    ['<button>NO</button>', function (instance, toast) {
            
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            
                    }],
                ]
            });
        }
        
    },
}
</script>

<style scoped>
.table_fields td {
    text-align: center;
    border-bottom: 1px solid #dce1e9;
    border-right: 1px solid #dce1e9;
    font-size: 13px;
    line-height: 16px;
    color: #666;
    white-space:nowrap;
}
.table_fields th {
    text-align: center;
    border-bottom: 1px solid #dce1e9;
    border-right: 1px solid #dce1e9;
    font-size: 13px;
    line-height: 16px;
    color: #666;
    white-space:nowrap;
}
.table_main_div{
    overlay:auto;
}
.activesidebar{
    background: #20a8d8;
    margin: 3px;
    border-radius: 5px;
    color:#fff;
}
.activesidebar a {
    color:#fff;
}

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
 td span{
    cursor:pointer;
 }
</style>
