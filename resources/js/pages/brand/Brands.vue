<template>
<v-container class="my-5">
  <v-row>
    <v-col md="12">
      <v-data-table
        :headers="headers"
        :items="brands"
        sort-by="text"
        class="elevation-1 strip-table"
      >
        <template v-slot:top>
          <v-toolbar flat elevation-1 color="#d1d1d1" class="lighten-2">
            <v-toolbar-title >List of all Brands</v-toolbar-title>
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
                    <span>New Brand</span>
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
                        <v-text-field v-model="editedItem.name" label="Brand name"
                            :rules="[required('brand name'),minLength('phone number',3)]" />
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
          <v-btn color="primary" @click="brands">Reset</v-btn>
        </template>
      </v-data-table>
      </v-col>
    </v-row>  
</v-container>
</template>

<script>

import Api from '../../service/api.js'


  export default {
    data: () => ({
      dialog: false,
      valid: false,
      headers: [
        {
          text: 'Name',
          align: 'left',
          sortable: true,
          value: 'name',
        },
        { text: 'Actions',align:'center', value: 'actions', sortable: false },
        // { text: 'ID',align:'center', value: 'id', sortable: false },
      ],
      
      brands: [],
      editedIndex: -1,
      editedItem: { 
        name: '',
        
      },
      defaultItem: {
        name: '',
      },
      required(propertyType){
        return v => v && v.length > 0 || ` ${propertyType} is required`
      },
      minLength(propertyType,length){
        return v=> v && v.length >= 3 || `${propertyType} must be equal to ${length} digits`
      }
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Brand' : 'Edit Brand'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
    },

    created () {
      Api().get('/brands')
        .then(res=>this.brands = res.data.brands)
    },

    methods: {

      editItem (item) {
        this.editedIndex = this.brands.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        const index = this.brands.indexOf(item)
        const id = this.brands[index].id;
        console.log(this.brands[index].id);
        confirm('Are you sure you want to delete this item?') && this.brands.splice(index, 1)
        
        Api().delete(`/brands/${id}`)
        // Nestlé
        // Promasidor
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
          Object.assign(this.brands[this.editedIndex], this.editedItem);
          // this.edit_brand(this.editedItem);
        } else {
          let response = await Api().post(`/brands`,this.editedItem);
          this.editedItem.id = response.data.brand.id
          console.log(this.editedItem)
          this.brands.unshift(this.editedItem) 
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