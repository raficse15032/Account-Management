<template>
  <div class="app">
    <AppHeader fixed>
      <SidebarToggler class="d-lg-none" display="md" mobile />
      <b-link class="navbar-brand" to="#">
        <h4>BMAMS</h4>
        <!-- <img class="navbar-brand-full" src="img/brand/logo.svg" width="89" height="25" alt="CoreUI Logo"> -->
        <!-- <img class="navbar-brand-minimized" src="img/brand/sygnet.svg" width="30" height="30" alt="CoreUI Logo"> -->
      </b-link>
      <SidebarToggler class="d-md-down-none" display="lg" />
      <b-navbar-nav class="d-md-down-none">
        <b-nav-item class="px-3" to="/dashboard">Dashboard</b-nav-item>
        <b-nav-item class="px-3" to="/users" exact>Users</b-nav-item>
        <!-- <b-nav-item class="px-3">Settings</b-nav-item> -->
      </b-navbar-nav>
      <b-navbar-nav class="ml-auto">
        <!-- <b-nav-item class="d-md-down-none">
          <i class="icon-bell"></i>
          <b-badge pill variant="danger">5</b-badge>
        </b-nav-item> -->
        <!-- <b-nav-item class="d-md-down-none">
          <i class="icon-list"></i>
        </b-nav-item> -->
        <!-- <b-nav-item class="d-md-down-none">
          <i class="icon-location-pin"></i>
        </b-nav-item> -->
        <DefaultHeaderDropdownAccnt/>
      </b-navbar-nav>
      <!-- <AsideToggler class="d-none d-lg-block" /> -->
      <!-- <AsideToggler class="d-lg-none" mobile /> -->
    </AppHeader>
    <div class="app-body">
      <AppSidebar fixed>
        <SidebarHeader/>
        <SidebarForm/>
        <SidebarNav :navItems="nav"></SidebarNav>
        <SidebarFooter/>
        <SidebarMinimizer/>
      </AppSidebar>
      <main class="main">
        <Breadcrumb :list="list"/>
        <div class="container-fluid">
          <router-view></router-view>
        </div>
      </main>
      <AppAside fixed>
        <!--aside-->
        <DefaultAside/>
      </AppAside>
    </div>
    <TheFooter>
      <!--footer-->
      <div>
        <a href="http://bemantech.com/">BMAMS</a>
        <span class="ml-1">&copy; 2019 BMAMS</span>
      </div>
      <div class="ml-auto">
        <span class="mr-1">Powered by</span>
        <a href="http://bemantech.com/">BMAMS</a>
      </div>
    </TheFooter>
  </div>
</template>

<script>
import nav from '@/_nav'
import { Header as AppHeader, SidebarToggler, Sidebar as AppSidebar, SidebarFooter, SidebarForm, SidebarHeader, SidebarMinimizer, SidebarNav, Aside as AppAside, AsideToggler, Footer as TheFooter, Breadcrumb } from '@coreui/vue'
import DefaultAside from './DefaultAside'
import DefaultHeaderDropdownAccnt from './DefaultHeaderDropdownAccnt'
import { ALL_USER_ROLE2 } from '../store/action.type';
import { mapState,mapGetters } from "vuex"
export default {
  name: 'DefaultContainer',
  components: {
    AsideToggler,
    AppHeader,
    AppSidebar,
    AppAside,
    TheFooter,
    Breadcrumb,
    DefaultAside,
    DefaultHeaderDropdownAccnt,
    SidebarForm,
    SidebarFooter,
    SidebarToggler,
    SidebarHeader,
    SidebarNav,
    SidebarMinimizer
  },
  data () {
    return {
      nav: nav.items,
      item2:'',
      permission:[]
    }
  },
  computed: {
    name () {
      return this.$route.name
    },
    list () {
      return this.$route.matched.filter((route) => route.name || route.meta.label )
    },
    ...mapGetters(["user_roles"]),
  },
  methods:{
    
    getPermission(){
          var self = this
          this.$store.dispatch('ALL_USER_ROLE2')
          .then(response=>{
              this.permission = response.data.permission
              setInterval(function(){
                  self.testy()
              },2000)
              
          })
    },
    testy(){
      var self = this
        this.nav.forEach(function (element,index){
              if(element.name == "Clients"){
                  if(!self.permission.contact_view && self.contact_viewall){
                    self.nav.splice(index,1)
                  } 
              }
              else if(element.name == "Workers Info"){
                var child = element.children
                var size = child.length
                if(size>0){
                  
                  if(element.children[size-1].name == "Recruiting"){
                    if(!self.permission.recuiting_view && !self.recuiting_viewall){
                      element.children.splice(size-1,1)
                    } 
                  }
                  else if(element.children[size-2].name == "Recruiting"){
                    if(!self.permission.recuiting_view && !self.recuiting_viewall){
                      element.children.splice(size-2,1)
                    } 
                  }
                  if(element.children[size-1].name == "Processing"){
                    if(!self.permission.recuiting_view && !self.recuiting_viewall){
                      element.children.splice(size-1,1)
                    } 
                  }
                } 
              }

              else if(element.name == "Money In"){
                var child = element.children
                var size = child.length
                if(size>0){
                  if(element.children[size-1].name == "Invoice"){
                    if(!self.permission.invoice_view && !self.permission.invoice_viewall){
                      element.children.splice(size-1,1)
                    } 
                  }
                  else if(element.children[size-2].name == "Invoice"){
                    if(!self.permission.invoice_view && !self.permission.invoice_viewall){
                      element.children.splice(size-2,1)
                    } 
                  }
                  else if(element.children[size-3].name == "Invoice"){
                    if(!self.permission.invoice_view && !self.permission.invoice_viewall){
                      element.children.splice(size-3,1)
                    } 
                  }

                  if(element.children[size-1].name == "Payment Received"){
                    if(!self.permission.payment_view && !self.permission.payment_viewall){
                      element.children.splice(size-1,1)
                    } 
                  }
                  else if(element.children[size-2].name == "Payment Received"){
                    if(!self.permission.payment_view && !self.permission.payment_viewall){
                      element.children.splice(size-2,1)
                    } 
                  }
                  
                  if(element.children[size-1].name == "Installment"){
                    if(!self.permission.installment_view && !self.permission.installment_viewall){
                      element.children.splice(size-1,1)
                    } 
                  }
                } 
              }

              else if(element.name == "Money Out"){
                var child = element.children
                var size = child.length
                if(size>0){
                  if(element.children[size-1].name == "Expense"){
                    if(!self.permission.expense_view && !self.expense_viewall){
                      element.children.splice(size-1,1)
                    } 
                  }
                } 
              }

              // else if(element.name == "Report"){
              //   if(!self.permission.report_view && !self.report_viewall){
              //       self.nav.splice(index,1)
              //     } 
              // }

              else if(element.name == "System Users"){
                var child = element.children
                var size = child.length
                if(size>0){
                  
                  if(element.children[size-1].name == "User Role"){
                    if(!self.permission.role_view && !self.role_viewall){
                      element.children.splice(size-1,1)
                    } 
                  }
                  else if(element.children[size-2].name == "User Role"){
                    if(!self.permission.role_view && !self.role_viewall){
                      element.children.splice(size-2,1)
                    } 
                  }
                  else if(element.children[size-1].name == "Assign Role"){
                    if(!self.permission.role_view && !self.role_viewall){
                      element.children.splice(size-1,1)
                    } 
                  }
                } 
              }

              else if(element.name == "Account"){
                  if(!self.permission.purpose_view && !self.purpose_viewall){
                    self.nav.splice(index,1)
                  } 
              }
        })

    }
    // menuAdd(){
    //   var roles =  this.user_roles
    //   this.nav[12].children = []
    //   roles.forEach(element => {
    //     var a = {
    //       name: element.name,
    //       url: '/role-permission/'+element.id,
    //       icon: 'fa fa-money'
    //     }
    //     this.nav[12].children.push(a)
    //   })
    // }
  },
  mounted(){
    this.getPermission()
    
    // var that = this
    // setInterval(function(){
    //     that.menuAdd()
    // },2000)
  }
}
</script>
