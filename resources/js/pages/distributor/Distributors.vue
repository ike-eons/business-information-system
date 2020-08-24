<template>
<v-container class="my-5">
  <v-row>
    <v-col md="12">
      <v-data-table
        :headers="headers"
        :items="GET_DISTRIBUTORS"
        sort-by="text"
        class="elevation-1 strip-table"
      >
        <template v-slot:top>
          <v-toolbar flat elevation-1 color="#d1d1d1" class="lighten-2">
            <v-toolbar-title >DISTRIBUTORS</v-toolbar-title>
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
                    <span>new distributor</span>
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
                        <v-text-field v-model="editedItem.company_name" label=" company name"
                            :rules="[required('company name'),minLength('company name',3)]" />
                      </v-col>

                      <v-col cols="12">
                        <v-text-field v-model="editedItem.phone" label=" phone"
                            :rules="[required('phone number'),minLength('phone number',3)]" />
                      </v-col>

                      <v-col cols="12">
                        <v-text-field v-model="editedItem.email" label=" email"
                            :rules="[required('Email'),minLength('Email',3)]" />
                      </v-col>

                      <v-col cols="12">
                        <v-textarea label="Company Address" v-model="editedItem.address">

                        </v-textarea>
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
          <v-btn color="primary" @click="GET_DISTRIBUTORS">Reset</v-btn>
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
      required(propertyType){
        return v => v && v.length > 0 || ` ${propertyType} is required`
      },
      minLength(propertyType,length){
        return v=> v && v.length >= 3 || `${propertyType} must be equal to ${length} digits`
      }
    }),

    computed: {
      ...mapGetters("distributor",['GET_DISTRIBUTORS']),
      formTitle () {
        return this.editedIndex === -1 ? 'New Distributor' : 'Edit Distributor'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
    },

    created () {
      this.fetch_distributors()
    },

    methods: {
      ...mapActions("distributor",["fetch_distributors","create_distributor","edit_distributor","delete_distributor"]),

      editItem (item) {
        this.editedIndex = this.GET_DISTRIBUTORS.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        const index = this.GET_DISTRIBUTORS.indexOf(item)
        confirm('Are you sure you want to delete this item?') && this.GET_DISTRIBUTORS.splice(index, 1)
        this.delete_distirbutor(item);
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
          Object.assign(this.GET_DISTRIBUTORS[this.editedIndex], this.editedItem);
          this.edit_distributor(this.editedItem);
          this.$router.go(0);
        } else {
          this.create_distributor(this.editedItem);
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