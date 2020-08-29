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
          <v-toolbar flat elevation-1 color="teal darken-1" dark class="lighten-2">
            <v-toolbar-title ><v-icon>spa</v-icon> Brands</v-toolbar-title>
            <v-divider
              class="mx-5"
              inset
              vertical
            ></v-divider>
            <v-spacer></v-spacer>

            <v-form v-model="valid">

            <v-dialog v-model="dialog" max-width="500px">
              <template v-slot:activator="{ on }">
                <v-btn  class="mb-2 teal--text" color="white " v-on="on">
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
                      <!-- NAME TEXT FIELD -->
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.name" label="Brand name" 
                          required
                          @input="$v.editedItem.name.$touch()"
                          @blur="$v.editedItem.name.$touch()"
                          :error-messages="nameErrors"
                        />
                        <!-- name errors -->
                         <!-- <div v-if="$v.editedItem.name.$error" class="error-margin">
                            <small class="errorMessage red--text" v-if="!$v.editedItem.name.required">
                                Brand name is required*
                            </small>
                            <small class="errorMessage red--text" v-if="!$v.editedItem.name.minLength">
                                Brand length must be atleast 3 characters*
                            </small>
                            <small class="errorMessage red--text" v-if="!$v.editedItem.name.uniqueName">
                                Brand name already Exist*
                            </small>

                        </div> -->
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
          <v-btn color="teal" dark @click="brands">Reset</v-btn>
        </template>
      </v-data-table>
      </v-col>
    </v-row>  
</v-container>
</template>

<script>

import Api from '../../service/api.js'
import { required, minLength, email } from 'vuelidate/lib/validators'

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
    }),

    validations:{
      editedItem:{
        name:{
          required,
          minLength:minLength(3), 
          async uniqueName(value){
            if(value=="") return true
            // const response = await  Api().get('/brands');
            // const brands = response.data.brands
            const brands = this.brands
            const nameAlreadyExist =
                    brands.find(brand=>brand.name.toLowerCase() === value.toLowerCase())
            // console.log("Print ".nameAlreadyExist)         
            if(nameAlreadyExist){
              return false;
            }
            return true
          }
         
        }
      }
    },

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Brand' : 'Edit Brand'
      },
      nameErrors(){
        const errors = [];
        if(!this.$v.editedItem.name.$dirty) return errors;
          !this.$v.editedItem.name.minLength &&
            errors.push("Brand name must be atleast 3 characters*")
          !this.$v.editedItem.name.required &&
            errors.push("Brand name is required*")
          !this.$v.editedItem.name.uniqueName &&
            errors.push("Brand name already Exist*")
        return errors
      }
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
          this.$v.$touch();
          if(!this.$v.$invalid){ 
            let response = await Api().post(`/brands`,this.editedItem);
            this.editedItem.id = response.data.brand.id
            console.log(this.editedItem)
            this.brands.unshift(this.editedItem) 
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