<template>
  <nav style="-webkit-app-region: drag">
    <!-- MAIN NAVIGATION -->
    <v-navigation-drawer
      v-model="drawer"
      :mini-variant.sync="miniVariant"
      permanent=""
      color="#222d32"
      dark
      app
    >
      <!-- company name & logo -->
      <v-list-item class="px-2 pt-1">
        <v-list-item-avatar>
          <v-img src="" alt="admin" class="mx-auto"/>
        </v-list-item-avatar>
        <v-list-item-title class="ml-4 text-capitalize">
          EMMG-19
        </v-list-item-title>
      </v-list-item>
    
      <v-divider></v-divider>

      <v-list-item two-line :class="miniVariant && 'px-0'">
        <v-list-item-avatar class="ml-n4">
            <v-img src="https://cdn0.iconfinder.com/data/icons/man-user-human-profile-avatar-person-business/100/10B-1User-512.png" />
        </v-list-item-avatar>

        <v-list-item-content v-if="user">
            <v-list-item-title><span color="white">welcome Isaac</span></v-list-item-title>
            <v-list-item-subtitle>Admin</v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>

      <v-list dense shaped nav class="clickable">
        <template v-for="item in items">
          <v-list-group
          v-if="item.children"
          :key="item.text"
          v-model="item.model"
          :prepend-icon="item['icon-ctr']"
          :append-icon="item.model ? item.icon : item['icon-alt']"
          active-class="white--text"
          >

          <template v-slot:activator>
            <v-list-item-content>
              <v-list-item-title>
                {{item.text}}
              </v-list-item-title>
            </v-list-item-content>
          </template>

            <v-list-item v-for="(child,i) in item.children" 
            :key="i"
            route :to="child.route"
            active-class="red--text"
            >
            <v-list-item-action v-if="child.icon">
              <v-icon>{{child.icon}}</v-icon>
            </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>
                  {{child.text}}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list-group>
          
          <v-list-item class="style-type"
            v-else
            :key="item.text"
            active-class="white--text"
            route
            :to="item.route"
          >
            <v-list-item-action>
              <v-icon>{{item.icon}}</v-icon>
            </v-list-item-action>
            <v-list-item-title>
              {{item.text}}
            </v-list-item-title>
          </v-list-item>
        </template>

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

    </v-navigation-drawer>

      <!-- <v-app-bar app dark color="red" class="darken-4" :clipped-left="$vuetify.breakpoint.lgAndUp">
          
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

      </v-app-bar> color="#009688" -->
        <!-- APP BAR -->
    <v-app-bar app color="#009688" dark>
      <v-app-bar-nav-icon @click.stop="miniVariant = !miniVariant" class="clickable"></v-app-bar-nav-icon>
      <v-toolbar-title
        style="width: 300px"
        class="ml-0 pl-4"
      >
        <span class="hidden-sm and down">Emmandget-19 Enterprise</span>
      </v-toolbar-title>
      <v-spacer />
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
      items:[
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
 .style-type{
    text-decoration: none !important;
 }
  .clickable{
    -webkit-app-region: no-drag
  }
  ::-webkit-scrollbar{
    width:12px;
  }
  ::-webkit-scrollbar-track{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    border-radius:10px;
  }
  ::-webkit-scrollbar-thumb{
    border-radius: 10px;
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5)
  }
</style>