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
          <v-toolbar flat elevation-1 color="#d1d1d1" class="lighten-2">
            <v-toolbar-title >CUSTOMERS</v-toolbar-title>
            <v-divider
              class="mx-5"
              inset
              vertical
            ></v-divider>
            <v-spacer></v-spacer>

            <v-form v-model="valid">

            <v-dialog v-model="dialog" max-width="500px">
              <template v-slot:activator="{ on }">
                <v-btn  class="mb-2" v-on="on">
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
                            :rules="[required('firstname')]"
                        />
                      </v-col>
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.lastname" label="Lastame"
                            :rules="[required('lastname')]"
                        />
                      </v-col>
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.phone" label="Phone number" type="number"
                            :rules="[required('phone number'),minLength('phone number',10)]" />
                      </v-col>
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.shop_name" label="Shop name"
                            :rules="[required('shope name')]"/>
                      </v-col>
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.shop_address" label="Shop address"
                            :rules="[required('shop address')]"
                        />
                      </v-col>
                    </v-row>
                    
                  </v-container>
                </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                  <v-btn color="blue darken-1" :disabled="!valid" text @click="save">Save</v-btn>
                </v-card-actions>
              </v-card>
            
            </v-dialog>
            </v-form>
          </v-toolbar>
        </template>
        <template v-slot:item.actions="{ item }">
          <v-icon
            small
            class="mr-2"
            @click="showItem(item)"
          >
            mdi-eye
          </v-icon>
          <v-icon
            small
            class="mr-2"
            @click="editItem(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
            small
            @click="deleteItem(item)"
          >
            mdi-delete
          </v-icon>
        </template>
        <template v-slot:no-data>
          <v-btn color="primary" @click="customers">Reset</v-btn>
        </template>
      </v-data-table>
      </v-col>
    </v-row>  
</v-container>
</template>

<script>


import Api from '../../service/api.js'
// import {required,minLength,maxLength,} from 'vuelidate/lib/validators';

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
      required(propertyType){
        return v => v && v.length > 0 || ` ${propertyType} is required`
      },
      minLength(propertyType,length){
        return v=> v && v.length == 10 || `${propertyType} must be equal to ${length} digits`
      }
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Customer' : 'Edit Customer'
      },
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
          let response = await Api().post(`/customers`,this.editedItem);
          this.editedItem.id = response.data.customer.id
          this.editedItem.fullname = response.data.customer.fullname
          console.log(this.editedItem)
          this.customers.unshift(this.editedItem) 
          
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