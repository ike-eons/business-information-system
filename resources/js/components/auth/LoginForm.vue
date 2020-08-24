<template>
  <v-app>
      <v-card width="600" class="mx-auto">
          <v-card-title>
              <h1>Login</h1>
          </v-card-title>
          <v-card-text>
              <v-form>
                <v-text-field  label="Email"
                    prepend-icon="mdi-account-circle"
                    v-model="user.email"
                />
                <v-text-field 
                    :type="showPassword ? 'text' : 'password'"
                    label="Password"
                    prepend-icon="mdi-lock"
                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    @click:append="showPassword = !showPassword"
                    v-model="user.password"
                />
              </v-form>
          </v-card-text>
          <v-divider></v-divider>
          <v-card-actions>
            <v-btn block color="primary" @click="login">LOGIN</v-btn>
          </v-card-actions>
      </v-card>
  </v-app>
</template>

<script>


export default {
 data(){
    return{
        showPassword:false,
        user:{
            email:'',
            password:''
        }
    } 
 },

 methods:{

     login(){
         this.$store.dispatch("user/loginUser",this.user)
     }
 }
 

}

</script>

<style>

</style>