<template>
    <div class="card">
        <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3 contct">
                        <VueCtkDateTimePicker 
                            :id="demo.options.id"
                            v-model="demo.value"
                            :range="demo.options.range"
                            :format="demo.options.format"
                            :formatted="demo.options.formatted"
                            :color="demo.options.color"
                            :label="demo.options.label"
                        >
                            <input
                            v-if="demo.options && demo.options.slot && demo.options.slot.type === 'input'"
                            type="text"  
                            >
                            <button
                            v-else-if="demo.options && demo.options.slot && demo.options.slot.type === 'button'"
                            type="button"
                            class="lm-btn"
                            style="margin: 0;"
                            />
                        </VueCtkDateTimePicker>
                    </div>
                    <div class="col-md-9">
                        <form  class="form-inline contct my-2 my-lg-0 pull-left">
                            
                            <select   v-model="search.vandor_id"  class="form-control" style="margin-right:10px" >
                                <option value="" >Select Vendor</option>
                                <option  v-if="contact.type == 4" :value="contact.id"  v-for="(contact,index) in allContacts" :key="index">{{contact.name}}</option>
                            </select>
                            <select  v-model="search.customer_id"  class="form-control" style="margin-right:10px" >
                                <option value="" >Select Customer</option>
                                <option  v-if="contact.type == 1" :value="contact.id"  v-for="(contact,index) in allContacts" :key="index">{{contact.name}}</option>
                            </select>

                            <select   v-model="search.account_id"  class="form-control" style="margin-right:10px" >
                                <option value="" >Select Purpose</option>
                                <option  :value="purpose.id"  v-for="(purpose,index) in purposes" :key="index">{{purpose.name}}</option>
                            </select>
                            <button @click.prevent="serachLeadger" class="btn btn-outline-success my-2 my-sm-0" >Search</button>
                            
                        </form>
                        <div style="margin:10px;" class="pull-right">
                            <downloadExcel :data="dataForExcel">
                                <button class="btn btn-success">Excel <i class="fa fa-file-excel-o" aria-hidden="true"></i></button>
                            </downloadExcel>
                        </div>
                        <div style="margin-top:10px" class="pull-right">
                            <button @click.prevent="makePdf" class="btn btn-success">Pdf <i class="fa fa-file-pdf-o" ></i></button>
                        </div>
                    </div>
                </div>

            
            <table id="my-table" class="table table-sm">
                <thead>
                    
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Account</th>
                    <th scope="col">Customer / Vendor</th>
                    <th scope="col">Transaction</th>
                    <th scope="col">Date</th>
                    <th scope="col">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(leadgerdata,index) in leadgerdatas" :key='index'>
                        <td>{{index+1}}</td>
                        <td>{{leadgerdata.account[0].name}}</td>
                        <td>                                                                                                                                                                                                                                                                                                                                                  
                        <span v-if="leadgerdata.vendor!='' || leadgerdata.customer!=''" >{{leadgerdata.vendor == "" ? leadgerdata.customer[0].name: leadgerdata.vendor[0].name}}</span>
                        
                        </td>
                        <td>{{leadgerdata.invoice_number}}{{leadgerdata.pr_number}}</td>
                        <td>{{leadgerdata.date}}</td>
                        <td v-if='leadgerdata.type ==2'>({{leadgerdata.total}})</td>
                        <td v-if='leadgerdata.type ==1 || leadgerdata.type ==3'>{{leadgerdata.total}}</td>
                    </tr>
                    <!-- <tr >
                        <td colspan="4"></td>
                        <td>total</td>
                        <td v-if='total2 < 0'>({{Math.abs(total2)}})</td>
                        <td v-if='total2 >= 0'>{{Math.abs(total2)}}</td>
                    </tr> -->
                </tbody>
            </table>
        </div>
        <Loader v-if="loading"></Loader>
    </div>
</template>

<script>
import Loader from '../common/Loader'
import VueCtkDateTimePicker from 'vue-ctk-date-time-picker'
import jsPDF from 'jspdf'
import 'jspdf-autotable'
import downloadExcel from 'vue-json-excel'
import { mapState,mapGetters } from "vuex"
import { CURRENT_LEADGER ,SEARCH_LEADGER,ALL_CONTACT,ALL_PURPOSE} from '../../store/action.type';
export default {
    data(){
        return {
           loading:false,
           dataForExcel: [],
           demo:{
            title: 'Range Date Picker',
            description: 'Date Range selector - With custom element to trigger the component (only input or button)',
            editOption: false,
            initial: {
              start: '2018-04-05',
              end: '2018-04-20'
            },
            value: {
              start: '2018-04-05',
              end: '2018-04-20'
            },
            options: {
              slot: {
                type: 'button'
              },
              range: true,
              formatted: 'll',
              format: 'YYYY-MM-DD',
              color: 'green',
              label: 'Select date range',
              id: 'RangeDatePicker'
            }
          },
          search:{
               customer_id:'',
               vandor_id:'',
               account_id:''
           },
        }
    },
    methods:{
        cuurentLeadger(){
            this.loading=true;
            this.$store.dispatch('CURRENT_LEADGER')
            .then(response=>{
                    this.loading=false;
            })
            .catch(error=>{
                this.loading=true;        
            });
            this.$store.dispatch('ALL_CONTACT')
            this.$store.dispatch('ALL_PURPOSE')
        },
        serachLeadger(){
            var data = {
               customer_id:this.search.customer_id,
               vandor_id:this.search.vandor_id,
               account_id:this.search.account_id,
               strat_date:this.demo.value.start,
               end_date:this.demo.value.end
            }
            this.$store.dispatch('SEARCH_LEADGER',data)
        },
        makePdf(){
            const doc = new jsPDF();
            doc.autoTable({html: '#my-table'});
            doc.save('table.pdf'); 
        }
    },
    mounted(){
        this.cuurentLeadger()
    },
    computed: {
        ...mapGetters(["leadgerdatas","allContacts","purposes"]),
        total2(){
            this.dataForExcel =[]
            var total = 0
            var that = this
            this.leadgerdatas.forEach(element => {
                if(element.vendor!='' || element.customer!=''){
                     let name = element.vendor == "" ? element.customer[0].name: element.vendor[0].name;
                };
               
                var exldata = {
                    "Account" : element.account[0].name,
                    "Customer / Vendor" : name,
                    "Transaction" : element.invoice_number + element.pr_number,
                    "Date" : element.date,
                    "Amount" : element.total
                }
                that.dataForExcel.push(exldata)

                if(element.type == 1){
                    total = total+ parseFloat(element.total)
                }
                if(element.type == 2){
                    total = total - parseFloat(element.total)
                }
            })
             
            return total
            
        }
        
    },
    components: {
        VueCtkDateTimePicker,
        downloadExcel,
        Loader
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
</style>
