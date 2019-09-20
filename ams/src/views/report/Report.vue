<template>
    <div class="card">
        <div class="container-fluid">
            <div style="padding-bottom:20px;" class="contct list-group col-md-12">
                <div class="row">
                    <div  class="col-md-4 contct">
                        <a href="#" style="background-color:#bce8f1 ;" class="list-group-item ">Accountant </a>
                        <a class="list-group-item " href="#"><router-link to="/general-leadger">General Ledger</router-link></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueCtkDateTimePicker from 'vue-ctk-date-time-picker'

import { mapState,mapGetters } from "vuex"
import { ALL_PURPOSE,DELETE_PROJECT } from '../../store/action.type';
export default {
    data(){
        return {
           yourValue: null ,
           demo:{
            id: '2',
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
              color: 'purple',
              label: 'Select date range',
              id: 'RangeDatePicker'
            }
          },
        }
    },
    methods:{
        addProjectModal(){
            // this.$refs.add_purpose_modal.openModal()
        },
        editProjectModal(project,index){
            // this.$refs.edit_project_modal.openModal(project,index)
        },
        viewProjectModal(){
            // this.$refs.view_project_modal.openModal()
        },
        allPurpose(){
            this.$store.dispatch('ALL_PURPOSE')
        },
        deleteProject(index,id){
            
            this.$store.dispatch('DELETE_PROJECT',{index,id})
        },
    },
    mounted(){
        this.allPurpose()
    },
    computed: {
        ...mapGetters(["purposes"]),
    },
    components: {
        VueCtkDateTimePicker
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
