<template>
  <v-app>
    <Navbar/>
    <v-content>
        <router-view  :key="$route.path" />
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
  }
}
</script>

<style>

</style>
