<template>
<v-container class="my-5">
  <v-row>
    <v-col md="12">
      <v-data-table
        :headers="headers"
        :items="categories"
        sort-by="name"
        class="elevation-1 strip-table"
      >
        <template v-slot:top>
          <v-toolbar flat elevation-1 color="teal darken-1" dark class="lighten-2">
            <v-toolbar-title ><v-icon>category</v-icon>&nbsp;CATEGORIES</v-toolbar-title>
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
                    <span>New Category</span>
                </v-btn>
              </template>

              <v-card > 
                <v-card-title>
                  <span class="headline">{{ formTitle }}</span>
                </v-card-title>

                <v-card-text>
                  <v-container>
                    
                    <v-row dense>
                      <!-- Categories Form Textfields -->
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.name" label="Category name"
                          @input="$v.editedItem.name.$touch()"
                          @blur="$v.editedItem.name.$touch()"
                          :error-messages="nameErrors"
                        />
                      </v-col>
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.description" label="description"
                          @input="$v.editedItem.description.$touch()"
                          @blur="$v.editedItem.description.$touch()"
                          :error-messages="descriptionErrors"
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
            class="mr-2" color="teal darken-2"
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
          <v-btn color="teal darken-2" dark @click="categories">Reset</v-btn>
        </template>
      </v-data-table>
      </v-col>
    </v-row>  
</v-container>
</template>


 
<script>

import { required, minLength} from 'vuelidate/lib/validators'
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
        { text: 'Description', value: 'description', sortable: true },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      
      categories: [],
      editedIndex: -1,
      editedItem: { 
        name: '',
        description:''
      },
      defaultItem: {
        name: '',
        description: ''
      },
    
    }),

    validations:{
      editedItem: { 
        name:{
          required,
          minLength:minLength(3),
          async uniqueName(value){
            if(value=="") return true
            
            const categories = this.categories
            const name_alreadyExist =
              categories.find(category=>category.name.toLowerCase() === value.toLowerCase())   
            if(name_alreadyExist){
              return false;
            }
            return true
          },
        },
        description:{
          required,
          minLength:minLength(3)
        }
      }
    },

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Category' : 'Edit Category'
      },
      nameErrors(){
        const errors = []
        if(!this.$v.editedItem.name.$dirty) return errors;
          !this.$v.editedItem.name.required &&
            errors.push("Category name is required*") 
          !this.$v.editedItem.name.minLength &&
            errors.push("Category name must be atleast 3 characters*")
          !this.$v.editedItem.name.uniqueName &&
            errors.push("Category name already Exist*")
        return errors
      },
      descriptionErrors(){
        const errors = [];
        if(!this.$v.editedItem.description.$dirty) return errors;
           !this.$v.editedItem.description.required &&
            errors.push('Category description is required')
           !this.$v.editedItem.description.minLength &&
            errors.push("Category description must be atleast 3 characters*")
        return errors
      }

    },

    watch: {
      dialog (val) {
        val || this.close()
      },
    },

    created () {
      Api().get('/categories')
        .then(res=>this.categories = res.data.categories)
    },

    methods: {
     
      editItem (item) {
        this.editedIndex = this.categories.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        const index = this.categories.indexOf(item)
        const id = this.categories[index].id
        confirm('Are you sure you want to delete this item?') && this.categories.splice(index, 1)
        Api().delete(`/categories/${id}`)
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
          Object.assign(this.categories[this.editedIndex], this.editedItem);
          // this.edit_categorie(this.editedItem);
        } else {

          this.$v.$touch();
          if(!this.$v.$invalid){

          let response = await Api().post(`/categories`,this.editedItem);
          this.editedItem.id = response.data.category.id
          
          console.log(this.editedItem)
          this.categories.unshift(this.editedItem) 
          
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