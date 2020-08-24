<template>
  <nav>
      <v-navigation-drawer v-model="drawer" app 
        color="#f5f5f5"
        
        :clipped="$vuetify.breakpoint.lgAndUp"
      > 
      <v-list-item two-line :class="miniVariant && 'px-0'">
            <v-list-item-avatar>
              <img src="https://cdn0.iconfinder.com/data/icons/man-user-human-profile-avatar-person-business/100/10B-1User-512.png">
            </v-list-item-avatar>

            <v-list-item-content>
              <v-list-item-title>Isaac Agyei Duku</v-list-item-title>
              <v-list-item-subtitle>Admin</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>

      <v-divider></v-divider>

         <v-list  dense tile nav class="mt-8">
             <v-list-item v-for="link in links" :key="link.text" router :to="link.route">
                 <v-list-item-icon>
                     <v-icon>
                         {{ link.icon }}
                     </v-icon>
                 </v-list-item-icon>
                 <v-list-item-content>
                     <v-list-item-title >{{ link.text }}</v-list-item-title>
                 </v-list-item-content>
             </v-list-item>
         </v-list>

         <v-divider></v-divider>

        <v-list-item>
             <v-list-item-icon>
                <v-icon>
                    settings
                </v-icon>
            </v-list-item-icon>
            <v-list-item-content>
                <v-list-item-title class="sub-title">
                    Settings
                </v-list-item-title>
            </v-list-item-content>

            
            
        </v-list-item>

         <v-divider></v-divider>

      </v-navigation-drawer>

      <v-app-bar app dark color="red" class="darken-4" :clipped-left="$vuetify.breakpoint.lgAndUp">
          
          <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

          <v-toolbar-title style="width: 300px" class="ml-0 pl-4">
            <span class="hidden-sm-and-down">Emmandjet</span>
            <span class="hidden-sm-and-down black--text">19</span>
          </v-toolbar-title>

          <v-spacer></v-spacer>

          <v-btn small text rounded @click="logout">
              <span>Logout</span>
               <v-icon small right>exit_to_app</v-icon>
          </v-btn>

      </v-app-bar>

      
  </nav>
</template>

<script>

import {mapGetters,mapActions, mapMutations} from 'vuex';

export default {
     props: {
      source: String,
    },
    data: () => ({
      drawer: null,
      miniVariant: false,
      links:[
          {icon:'dashboard', text:'System Statistics', route:'/app'},
          {icon:'receipt', text:'Invoice', route:'/invoices'},
          {icon:'assignment_ind', text:'Customers', route:'/customers'},
          {icon:'card_membership', text:'Brand', route:'/brands'},
          {icon:'card_membership', text:'Distributors', route:'/distributors'},
          {icon:'category', text:'Categories', route:'/categories'},
          {icon:'eco', text:'Products', route:'/products'},
          {icon:'insert_chart', text:'Stocks', route:'/stocks'},
          {icon:'show_chart', text:'System Analytics', route:'/pagenotfound'},
      ]
    }),
    computed:{
        user:{
            get(){
                return this.$store.state.user.user
            }
        }
        
    },

    methods:{
        logout(){

            this.$store.dispatch("user/logoutUser");
            // axios.post("/logout")
            //     .then( response =>{
            //         window.location.href = "login"
            //     })
        }
    },
   
 created(){
    // this.$store.dispatch('user/fetchUser')
 }

}
</script>

<style>

</style>