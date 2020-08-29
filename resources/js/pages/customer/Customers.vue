<template>
<v-container class="my-5">
  <v-row>
    <v-col md="12">
      <v-data-table
        :headers="headers"
        :items="customers"
        sort-by="text"
        class="elevation-1 strip-table"
      >
        <template v-slot:top>
          <v-toolbar flat elevation-1 color="teal darken-2" dark class="lighten-2">
            <v-toolbar-title ><v-icon>assignment_ind</v-icon>&nbsp;CUSTOMERS</v-toolbar-title>
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
                    <span>New Customer</span>
                </v-btn>
              </template>

              <v-card  title elevation-3> 
                <v-card-title>
                  <span class="headline">{{ formTitle }}</span>
                </v-card-title>

                <v-card-text>
                  <v-container>
                    
                    <v-row dense>
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.firstname" label="Firstname"
                          @blur="$v.editedItem.firstname.$touch()"
                          @input="$v.editedItem.firstname.$touch()"
                          :error-messages="firstNameErrors"
                        />
                      </v-col>
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.lastname" label="Lastame"
                          @blur="$v.editedItem.lastname.$touch()"
                          @input="$v.editedItem.lastname.$touch()"
                          :error-messages="lastNameErrors"
                        />
                      </v-col>
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.phone" label="Phone number" type="number"
                          @blur="$v.editedItem.phone.$touch()"
                          @input="$v.editedItem.phone.$touch()"
                          :error-messages="phoneErrors"
                        />
                      </v-col>
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.shop_name" label="Shop name"
                          @blur="$v.editedItem.shop_name.$touch()"
                          @input="$v.editedItem.shop_name.$touch()"
                          :error-messages="shopNameErrors"
                        />
                      </v-col>
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.shop_address" label="Shop address"
                          @blur="$v.editedItem.shop_address.$touch()"
                          @input="$v.editedItem.shop_address.$touch()"
                          :error-messages="shopAddressErrors"
                        />
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
            small
            class="mr-2" color="primary lighten-1"
            @click="showItem(item)"
          >
            mdi-eye
          </v-icon>
          <v-icon
            small
            class="mr-2" color="teal darken-2"
            @click="editItem(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
            small color="red dark-2"
            @click="deleteItem(item)"
          >
            mdi-delete
          </v-icon>
        </template>
        <template v-slot:no-data>
          <v-btn color="teal darken-2" dark @click="customers">Reset</v-btn>
        </template>
      </v-data-table>
      </v-col>
    </v-row>  
</v-container>
</template>

<script>


import Api from '../../service/api.js'
import { required, minLength,numeric } from 'vuelidate/lib/validators'

  export default {
    data: () => ({
      dialog: false,
      valid: false,
      headers: [
        {
          text: 'Name',
          align: 'start',
          sortable: true,
          value: 'fullname',
        },
        { text: 'Phone no.', value: 'phone' },
        { text: 'Shop name', value: 'shop_name' },
        { text: 'Shop address', value: 'shop_name' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      
      customers: [],
      editedIndex: -1,
      editedItem: { 
        firstname: '',
        lastname:'',
        phone: '',
        shop_name: '',
        shop_address: '',
      },
      defaultItem: {
        firstname: '',
        lastname:'',
        phone: '',
        shop_name: '',
        shop_address: '',
      },
  
    }),

    validations:{
      editedItem: { 
        firstname:{
          required,
          minLength:minLength(2)
        },
        lastname:{
          required,
          minLength:minLength(2)
        },
        phone:{
          required,
          numeric,
          tenDigitPhonNumber(value){
            return value.trim().length === 10
          },
           async uniquePhone(value){
            if(value=="") return true
            
            const customers = this.customers
            const phone_no_AlreadyExist =
                  customers.find(customer=>customer.phone === value)   
            if(phone_no_AlreadyExist){
              return false;
            }
            return true
          }
        },
        shop_name:{
          required,
          minLength:minLength(4)
        },
        shop_address:{
          required,
          minLength:minLength(4)
        },
      },
    },

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Customer' : 'Edit Customer'
      },
       firstNameErrors(){
        const errors = [];
        if(!this.$v.editedItem.firstname.$dirty) return errors;
          !this.$v.editedItem.firstname.minLength &&
            errors.push("First name must be atleast 2 characters*")
          !this.$v.editedItem.firstname.required &&
            errors.push("First name is required*")
        return errors
      },
      lastNameErrors(){
        const errors = [];
        if(!this.$v.editedItem.lastname.$dirty) return errors;
          !this.$v.editedItem.lastname.minLength &&
            errors.push("Last name must be atleast 2 characters*")
          !this.$v.editedItem.lastname.required &&
            errors.push("Last name is required*")
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
      shopNameErrors(){
        const errors = [];
        if(!this.$v.editedItem.shop_name.$dirty) return errors;
          !this.$v.editedItem.shop_name.minLength &&
            errors.push("Shop name must be atleast 4 characters*")
          !this.$v.editedItem.shop_name.required &&
            errors.push("Shop name is required*")
        return errors
      },
      shopAddressErrors(){
        const errors = [];
        if(!this.$v.editedItem.shop_address.$dirty) return errors;
          !this.$v.editedItem.shop_address.minLength &&
            errors.push("Shop address must be atleast 4 characters*")
          !this.$v.editedItem.shop_address.required &&
            errors.push("Shop address is required*")
        return errors
      }
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
    },

    created () {
      Api().get('/customers')
        .then(res=>this.customers = res.data.customers)
    },

    methods: {
      showItem(item){
        this.editedIndex = this.customers.indexOf(item)
        const id = this.customers[this.editedIndex].id
        this.$router.push({
                    name:'customerdetail',
                    params:{
                        id:id
                    }
                })
      },
      editItem (item) {
        this.editedIndex = this.customers.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        const index = this.customers.indexOf(item)
        const id = this.customers[index].id
        confirm('Are you sure you want to delete this item?') && this.customers.splice(index, 1)
        Api().delete(`/customers/${id}`)
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
          Object.assign(this.customers[this.editedIndex], this.editedItem);
          // this.edit_customer(this.editedItem);
        } else {
            this.$v.touch();
            if(!this.$v.$invalid){
            let response = await Api().post(`/customers`,this.editedItem);
            this.editedItem.id = response.data.customer.id
            this.editedItem.fullname = response.data.customer.fullname
            console.log(this.editedItem)
            this.customers.unshift(this.editedItem) 
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