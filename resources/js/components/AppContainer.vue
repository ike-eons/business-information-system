<template>
  <v-app>
    <Navbar/>
    <v-content class="background-color">
      <v-container
        class="scroll-y"
        fluid
      >
        <router-view  :key="$route.path" />
      </v-container>
        <v-btn
          v-scroll="onScroll"
          bottom
          color="red"
          dark
          fab
          fixed
          right
          @click="toTop"
          class="clickable"
        >
          <v-icon>mdi-chevron-up</v-icon>
        </v-btn>
    </v-content>

  </v-app>
</template>

<script>
import Navbar from './Navbar.vue';

export default {
  name:'Admin',
  components:{
    Navbar,
  },
  props:{

  },
  data(){
    return{

    }
  },
  created(){
    if( localStorage.hasOwnProperty("access_token") ){
      axios.defaults.headers.common['Authorization'] = "Bearer "+localStorage.getItem('access_token')
    }else{
      window.location.replace("/login");
    }
  },
  methods:{
    onScroll(e){
      if(typeof window === 'undefined') return
      const top = window.pageYOffset || e.target.scrollTop || 0
      this.fab = top > 20
    },
    toTop(){
      this.$vuetify.goTo(0)
    },
  }
}
</script>

<style>
  .background-color{
    background-color: #ededed;
  }
</style>
