<template>
<v-container class="my-5">
  <v-row>
    <v-col md="12">
      <v-data-table
        :headers="headers"
        :items="distributors"
        sort-by="text"
        class="elevation-1 strip-table"
      >
        <template v-slot:top>
          <v-toolbar flat elevation-1 color="teal darken-1" dark  class="lighten-2">
            <v-toolbar-title><v-icon>card_membership</v-icon> DISTRIBUTORS</v-toolbar-title>
            <v-divider
              class="mx-5"
              inset
              vertical
            ></v-divider>
            <v-spacer></v-spacer>

            <v-form v-model="valid">

            <v-dialog v-model="dialog" max-width="500px">
              <template v-slot:activator="{ on }">
                <v-btn  class="mb-2 teal--text" color="white" v-on="on">
                  <i class="fa fa-plus" aria-hidden="true"></i>
                    <span>new distributor</span>
                </v-btn>
              </template>

              <v-card > 
                <v-card-title>
                  <span class="headline">{{ formTitle }}</span>
                </v-card-title>

                <!-- Form Textfields -->
                <v-card-text>
                  <v-container>
                    
                    <v-row dense>
                      
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.company_name" label=" company name"
                            @input="$v.editedItem.company_name.$touch()"
                            @blur="$v.editedItem.company_name.$touch()"
                            :error-messages="companyNameErrors"
                             />
                      </v-col>

                      <v-col cols="12">
                        <v-text-field v-model="editedItem.phone" label=" phone"
                            @input="$v.editedItem.phone.$touch()"
                            @blur="$v.editedItem.phone.$touch()"
                            :error-messages="phoneErrors"
                        />
                      </v-col>

                      <v-col cols="12">
                        <v-text-field v-model="editedItem.email" label=" email"
                            @input="$v.editedItem.email.$touch()"
                            @blur="$v.editedItem.email.$touch()"
                            :error-messages="emailErrors"
                          />
                      </v-col>

                      <v-col cols="12">
                        <v-textarea label="Company Address" v-model="editedItem.address"
                          @input="$v.editedItem.address.$touch()"
                          @blur="$v.editedItem.address.$touch()"
                          
                          :error-messages="companyAddressErrors" />
                          

                      </v-col>
                      
                    </v-row>
                    
                  </v-container>
                </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                  <v-btn color="blue darken-1" :disabled="$v.$invalid" text @click="save">Save</v-btn>
                </v-card-actions>
              </v-card>
            
            </v-dialog>
            </v-form>
          </v-toolbar>
        </template>
        <template v-slot:item.actions="{ item }">
          <v-icon
            small color="teal darken-2"
            class="mr-2"
            @click="editItem(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon 
            small color="red darken-2"
            @click="deleteItem(item)"
          >
            mdi-delete
          </v-icon>
        </template>
        <template v-slot:no-data>
          <v-btn color="teal darken-2" dark @click="distributors">Reset</v-btn>
        </template>
      </v-data-table>
      </v-col>
    </v-row>  
</v-container>
</template>

<script>
import Api from '../../service/api.js'
import { required, minLength, email, numeric } from 'vuelidate/lib/validators'
import { min } from 'moment';

  export default {
    data: () => ({
      dialog: false,
      valid: false,
      headers: [
        {
          text: 'Company Name',
          align: 'left',
          sortable: true,
          value: 'company_name',
        },
        { text: 'Address', value: 'address' },
        { text: 'Phone', value: 'phone' },
        { text: 'Email', value: 'email' },
        { text: 'Actions',align:'center', value: 'actions', sortable: false },
      ],
      distributors:[],
      editedIndex: -1,
      editedItem: { 
        company_name: '',
        phone: '',
        email: '',
        address:''
        
      },
      defaultItem: {
        company_name: '',
        phone: '',
        email: '',
        address:''
      },
    
    }),
    validations:{
       editedItem: { 
        company_name: {
          required,
           async uniqueCompanyName(value){
            if(value=="") return true
            
            const distributors = this.distributors
            const companyname_AlreadyExist =
                    distributors.find(distributor=>distributor.company_name.toLowerCase() === value.toLowerCase())   
            if(companyname_AlreadyExist){
              return false;
            }
            return true
          },
          minLength:minLength(5)
        },
        phone: {
          required,
          numeric,
          tenDigitPhonNumber(value){
            return value.trim().length === 10
          },
           async uniquePhone(value){
            if(value=="") return true
            
            const distributors = this.distributors
            const phone_no_AlreadyExist =
                    distributors.find(distributor=>distributor.phone.toLowerCase() === value.toLowerCase())   
            if(phone_no_AlreadyExist){
              return false;
            }
            return true
          }

        },
        email: {
          required,
          email:email,
          async uniqueEmail(value){
            if(value=="") return true
            
            const distributors = this.distributors
            const emailAlreadyExist =
                    distributors.find(distributor=>distributor.email.toLowerCase() === value.toLowerCase())   
            if(emailAlreadyExist){
              return false;
            }
            return true
          }
        },
        address:{
          required
        }
        
      }
    },
    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Distributor' : 'Edit Distributor'
      },
      companyNameErrors(){
        const errors = [];
        if(!this.$v.editedItem.company_name.$dirty) return errors;
          !this.$v.editedItem.company_name.minLength &&
            errors.push("Distributor's company name must be atleast 5 characters*")
          !this.$v.editedItem.company_name.required &&
            errors.push("Distributor name is required*") 
          !this.$v.editedItem.company_name.uniqueCompanyName &&
            errors.push("Distributor's company name already Exist*")
        return errors
      },
      phoneErrors(){
        const errors = [];
        if(!this.$v.editedItem.phone.$dirty) return errors;
          !this.$v.editedItem.phone.uniquePhone &&
            errors.push("Phone number already exist*")
          !this.$v.editedItem.phone.required &&
            errors.push("phone number is required*") 
          !this.$v.editedItem.phone.numeric &&
            errors.push("phone number is INVALID, must only be digits (0 - 9) *")
          !this.$v.editedItem.phone.tenDigitPhonNumber &&
            errors.push("phone number must be exactly 10 digits *")
          
        return errors
      },
      emailErrors(){
         const errors = [];
        if(!this.$v.editedItem.email.$dirty) return errors;
          !this.$v.editedItem.email.uniqueEmail &&
            errors.push("Phone number already exist*")
          !this.$v.editedItem.email.required &&
            errors.push("phone number is required*") 
          !this.$v.editedItem.email.email &&
            errors.push("Email is invalid*")
          
        return errors
      },
      companyAddressErrors(){
        const errors = [];
        !this.$v.editedItem.address.required &&
            errors.push("address is required*") 
        return errors
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
    },

    created () {
      Api().get(`/distributors`)
          .then(res=>this.distributors = res.data.distributors)
    },

    methods: {
     
      editItem (item) {
        this.editedIndex = this.distributors.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        const index = this.distributors.indexOf(item)
        const id = this.distributors[index].id;
        confirm('Are you sure you want to delete this item?') && this.distributors.splice(index, 1)
        
        Api().delete(`/distributors/${id}`)
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      async save () {
        if (this.editedIndex > -1) {
          Object.assign(this.distributors[this.editedIndex], this.editedItem);
         
        } else {
          this.$v.$touch()
          if(!this.$v.$invalid){
            let response = await Api().post(`/distributors`,this.editedItem);
            this.editedItem.id = response.data.distributor.id
            console.log(this.editedItem)
            this.distributors.unshift(this.editedItem)
          }
         
        }
        this.close()
      },
    },
  }
</script>

<style scoped>
  .v-data-table table tr:nth-of-type(2n) {
    background: lightslategrey;
  }
    
</style>