<template>
<v-container class="my-5">
  <v-row>
    <v-col md="12">
      <v-data-table
        :headers="headers"
        :items="products"
        sort-by="text"
        class="elevation-1 "
      >
        <template v-slot:top>
          <v-toolbar flat elevation-1 color="#d1d1d1" class="lighten-2">
            <v-toolbar-title >PRODUCTS</v-toolbar-title>
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
                    <span>new product</span>
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
                        <v-text-field v-model="editedItem.name" label="Product name"
                            :rules="[required('product name'),minLength('product name',3)]"
                        />
                      </v-col>
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.stock_price" 
                            label="Stock price"
                            step=".01"
                            :rules="[required('stock price'),numberValidation('stock price')]"
                        />
                      </v-col>
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.sales_price" 
                            label="Sales price"
                            step=".01"
                            :rules="[required('sales price')]"
                        />
                      </v-col>
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.weight" 
                             label="Weight"
                            step=".01"
                            :rules="[required('weight')]"
                        />
                      </v-col>
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.carton_quantity" 
                            label="Carton Quantity" 
                            
                            min="1"
                            :rules="[required('carton_quantity')]" />
                      </v-col>
                      
                      <v-col class="d-flex" cols="12">
                        <v-select
                          :items="categories"
                          item-text="name"
                          item-value="id"
                          :return-object="false"
                          v-model=" editedItem.category_id"
                          bottom
                          outlined
                          label="Select Product's Category"
                          dense
                        ></v-select>
                      </v-col>
                      <v-col class="d-flex" cols="12">
                        <v-select
                          :items="brands"
                          item-text="name"
                          item-value="id"
                          :return-object="false"
                          v-model=" editedItem.brand_id"
                          bottom
                          outlined
                          label="Select Product's Brand"
                          dense
                        ></v-select>
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
          <v-btn color="primary" @click="products">Reset</v-btn>
        </template>
      </v-data-table>
      </v-col>
    </v-row>  
</v-container>
</template>

<script>

import Api from '../../service/api.js'

  export default {
    props:{
      
    },
    data: () => ({
      dialog: false,
      valid: false,
      headers: [
        {
          text: 'Name',
          align: 'start',
          sortable: true,
          value: 'name',
        },
        { text: 'Description', value: 'text' },
        { text: 'Stock Price', value: 'stock_price' },
        { text: 'Sales Price', value: 'sales_price' },
        { text: 'Carton Quantity', value: 'carton_quantity' },
        { text: 'Weight', value: 'weight' },
        // { text: 'Category', value: 'category_id' },
        // { text: 'Brand', value: 'brand_id' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      products:[],
      brands:[],
      categories:[],
      editedIndex: -1,
      editedItem: { 
        name: null,
        stock_price:null,
        sales_price:null,
        weight: null,
        carton_quantity:null,
        brand_id:null,
        category_id:null,
      },
      defaultItem: {
        name: '',
        stock_price:null,
        sales_price:null,
        weight: null,
        carton_quantity:null,
        brand_id:null,
        category_id:null,
      },
      required(propertyType){
        return v => v && v.length > 0 || ` ${propertyType} is required *`
      },
      minLength(propertyType,minlength){
        return v=> v && v.length >=minlength || `${propertyType} must be at least ${minlength} digits *`
      },
      numberValidation(propertyType){
        return v=> /^\d+$/.test(v)||`${propertyType} field only accept numbers *`
      }
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Product' : 'Edit Product'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
    },

    created () {
        Api().get('/products')
        .then(res=>console.log(this.products = res.data.products))

        Api().get('/brands')
        .then(res=>this.brands = res.data.brands)

        Api().get('/categories')
        .then(res=>this.categories = res.data.categories)
    },

    methods: {

      editItem (item) {
        this.editedIndex = this.products.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        const index = this.products.indexOf(item)
        const id = this.products[index].id
        confirm('Are you sure you want to delete this item?') && this.products.splice(index, 1)
        Api().delete(`/products/${id}`)
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
          Object.assign(this.products[this.editedIndex], this.editedItem);
          // this.edit_categorie(this.editedItem);
        } else {
          let response = await Api().post(`/products`,this.editedItem);
          this.editedItem.id = response.data.product.id
          this.editedItem.text = response.data.product.description
          
          console.log(this.editedItem)
          this.products.unshift(this.editedItem) 
          
        }
        this.close()
      },
    },
  }
</script>

<style>
  
  tbody tr:nth-of-type(odd) {
   background-color: rgba(0, 0, 0, .05);
 }
    
</style>