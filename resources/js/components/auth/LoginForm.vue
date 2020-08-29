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
                <v-form>
                <v-toolbar color="teal" dark>
                  <v-card-title>
                    <h4>Login Account</h4>
                </v-card-title>  
                </v-toolbar>
                <v-progress-linear v-if="apiRequest" :indeterminate="true" color="orange"></v-progress-linear>
                
                <v-card-text>
                    
                        <!-- Email field -->
                        <div class="email_field">
                            
                            <v-text-field  label="Enter your email"
                                prepend-icon="mdi-account-circle" color="orange darken-4"
                                v-model.trim="$v.user.email.$model"
                                @blur="$v.user.email.$touch()"
                            />
                            <!-- email error messages -->
                            <div v-if="$v.user.email.$error" class="error-margin">
                                <small class="errorMessage red--text" v-if="!$v.user.email.required">
                                    Email is required*
                                </small>
                                 <small class="errorMessage red--text" v-if="!$v.user.email.email">
                                    Email is invalid*
                                </small>
                            </div>
                        </div>
                      
                      <!-- Password Field -->
                      <div class="password_field">
                        <v-text-field 
                            :type="showPassword ? 'text' : 'password'"
                            label="Enter your assword"
                            prepend-icon="mdi-lock"
                            :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                            @click:append="showPassword = !showPassword"
                            v-model="user.password"
                            color="orange darken-4"
                            @blur="$v.user.password.$touch()"
                        />
                        <div v-if="$v.user.password.$error" class="error-margin">
                            <small class="errorMessage red--text" v-if="!$v.user.password.required">
                                Password is required*
                            </small>
                            <small class="errorMessage red--text" v-if="!$v.user.password.minLength">
                                Password length must be atleast 5 characters*
                            </small>

                        </div>
                      </div>
                    
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="teal" dark @click="login" :disabled="$v.$invalid">LOGIN</v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
                </v-form>
            </v-card>
        </v-col>
    </v-row>
    </v-content>
    </v-app>
</template>

<script>

import Api from '../../service/api.js'
 import { required, minLength, email } from 'vuelidate/lib/validators'
 

export default {
// name:'LoginForm',
 data(){
    return{
        showPassword:false,
        apiRequest:false,
        user:{
            email:'',
            password:''
        },
        feedback:'',
        errors:[]
    } 
 },
 validations: {
     user:{
        email: {
        required,
        email
        },
        password: {
        required,
        minLength: minLength(5)
        }
     }
  },
  computed:{
      
  },


 methods:{

     
    //  async login(){
    //      this.apiRequest = true;
    //      this.$v.$touch();
    //      if(!this.$v.$invalid)
    //      {
    //     //  this.$store.dispatch("user/loginUser",this.user)
    //         let response = await axios.post("api/user/login",{
    //                     email:this.user.email,
    //                     password:this.user.password
    //         })

    //         if(response.data.access_token){
    //             //save token
    //             localStorage.setItem(
    //                 "access_token",response.data.access_token
    //             )
    //             window.location.replace('/app')
    //         }
    //         console.log(response.data)
            
    //         this.apiRequest = false;
    //      }
    //  }

    login(){
        this.apiRequest = true;
        this.$v.$touch();
        if(!this.$v.$invalid)
        {
            axios.post("api/user/login",{
                        email:this.user.email,
                        password:this.user.password
            }).then((response) => {
                if(response.data.access_token){
                                //save token
                localStorage.setItem(
                    "access_token",response.data.access_token
                )
                window.location.replace('/app')
                }
                console.log(response.data)
            
                this.apiRequest = false;
                
            }).catch((error) => {
                this.errors = error.response.message
                console.log(this.errors)
            });

        }
    }
 

}

// End of export default
}

</script>

<style>
    .background-color{
        background-color: #E0F2F1;
    }
    .error-margin{
        margin-top: -25px;
        margin-left: 35px;
    }
</style>