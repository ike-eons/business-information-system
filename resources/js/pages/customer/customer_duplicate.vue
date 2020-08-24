<template>
<v-container class="my-5">
  <v-row>
    <v-col md="12">
      <v-data-table
        :headers="headers"
        :items="GET_CUSTOMERS"
        sort-by="text"
        class="elevation-1 strip-table"
      >
        <template v-slot:top>
          <v-toolbar flat elevation-1 color="#d1d1d1" class="lighten-2">
            <v-toolbar-title >List of all Customers</v-toolbar-title>
            <v-divider
              class="mx-5"
              inset
              vertical
            ></v-divider>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="500px">
              <template v-slot:activator="{ on }">
                <v-btn  class="mb-2" v-on="on">
                  <i class="fa fa-plus" aria-hidden="true"></i>
                    <span>New Customer</span>
                </v-btn>
              </template>
              <v-card > 
                <v-card-title>
                  <span class="headline">{{ formTitle }}</span>
                </v-card-title>

                <v-card-text>
                  <v-container>
                    <v-row dense>
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.firstname" label="Firstname"></v-text-field>
                      </v-col>
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.lastname" label="Lastame"></v-text-field>
                      </v-col>
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.phone" label="Phone number"></v-text-field>
                      </v-col>
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.shop_name" label="Shop name"></v-text-field>
                      </v-col>
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.shop_address" label="Shop address"></v-text-field>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                  <v-btn color="blue darken-1" text @click="save">Save</v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-toolbar>
        </template>
        <template v-slot:item.actions="{ item }">
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
          <v-btn color="primary" @click="GET_CUSTOMERS">Reset</v-btn>
        </template>
      </v-data-table>
      </v-col>
    </v-row>  
</v-container>
</template>

<script>

import {mapGetters, mapActions} from "vuex";


  export default {
    data: () => ({
      dialog: false,
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
      // customer:{
      //   fullname:'',
      //   phone:'',
      //   shop_name:'',
      //   shop_address:'',
      // },
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

    computed: {
      ...mapGetters(['GET_CUSTOMERS']),
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
      this.fetch_customers()
    },

    methods: {
      ...mapActions(["fetch_customers","create_customer","delete_customer"]),

      editItem (item) {
        this.editedIndex = this.GET_CUSTOMERS.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        const index = this.GET_CUSTOMERS.indexOf(item)
        confirm('Are you sure you want to delete this item?') && this.GET_CUSTOMERS.splice(index, 1)
        this.delete_customer(item);
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.GET_CUSTOMERS[this.editedIndex], this.editedItem)
        } else {
          //  this.customer.fullname = this.editedItem.firstname+' - '+this.editedItem.lastname;
          //  this.customer.phone = this.editedItem.phone;
          //  this.customer.shop_name = this.editedItem.shop_name;
          //  this.customer.shop_address = this.editedItem.shop_address;

          // console.log(this.customer);
          this.create_customer(this.editedItem);
          // this.GET_CUSTOMERS.push(this.customer);
          this.$router.go(0);
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