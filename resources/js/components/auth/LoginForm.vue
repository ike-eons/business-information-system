<template>
    <v-app >
    <v-content class="background-color">
    <v-row>
       
        <v-spacer></v-spacer>
            <div width="600" class="mx-auto pt-5 mt-5">
                <h1 class="teal--text"><v-icon color="orange darken-3" large>layers</v-icon> BUSINESS INFORMATION SYSTEM</h1>
            </div>
            
        <v-spacer></v-spacer>
       <v-col cols="12">
            <v-card width="400" class="mx-auto" elevation-11>
                <v-toolbar color="teal" dark>
                  <v-card-title>
                    <h4>Login Account</h4>
                </v-card-title>  
                </v-toolbar>
                <v-progress-linear v-if="apiRequest" :indeterminate="true" color="orange"></v-progress-linear>
                
                <v-card-text>
                    <v-form>
                        <v-text-field  label="Enter your email"
                            prepend-icon="mdi-account-circle" color="orange darken-4"
                            v-model="user.email"
                        />
                        <!-- <span class="danger" v-if="errors.email">
                            {{errors.email[0]}}
                        </span> -->
                        <v-text-field 
                            :type="showPassword ? 'text' : 'password'"
                            label="Enter your assword"
                            prepend-icon="mdi-lock"
                            :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                            @click:append="showPassword = !showPassword"
                            v-model="user.password"
                            color="orange darken-4"
                        />
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="teal" dark @click="login">LOGIN</v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-col>
    </v-row>
    </v-content>
    </v-app>
</template>

<script>

import Api from '../../service/api.js'
export default {
 data(){
    return{
        showPassword:false,
        apiRequest:false,
        user:{
            email:'',
            password:''
        }
    } 
 },

 methods:{

     async login(){
         this.apiRequest = true;
         
        //  this.$store.dispatch("user/loginUser",this.user)
        let response = await axios.post("api/user/login",{
                    email:this.user.email,
                    password:this.user.password
        })

        if(response.data.access_token){
            //save token
            localStorage.setItem(
                "access_token",response.data.access_token
            )
            window.location.replace('/app')
        }
        console.log(response.data)
        
        this.apiRequest = false;
     }
 }
 

}

</script>

<style>
    .background-color{
    background-color: #E0F2F1;
  }
</style>