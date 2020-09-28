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
          <v-toolbar flat elevation-1 color="teal darken-2" dark class="lighten-2">
            <v-toolbar-title><v-icon>eco</v-icon>&nbsp;PRODUCTS</v-toolbar-title>
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
                    <span>new product</span>
                </v-btn>
              </template>

              <!-- Form text field  -->
              <v-card> 
                <v-card-title>
                  <span class="headline">{{ formTitle }}</span>
                </v-card-title>

                <v-card-text>
                  <v-container>
                    
                    <v-row dense>
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.name" label="Product name"
                           @input="$v.editedItem.name.$touch()"
                           @blur="$v.editedItem.name.$touch()"
                           :error-messages="nameErrors"
                        />
                      </v-col>
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.stock_price" 
                            label="Stock price"
                            step=".01"
                            @input="$v.editedItem.stock_price.$touch()"
                            @blur="$v.editedItem.stock_price.$touch()"
                            :error-messages="stockPriceErrors"
                        />
                      </v-col>
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.sales_price" 
                            label="Sales price"
                            step=".01"
                          @input="$v.editedItem.sales_price.$touch()"
                          @blur="$v.editedItem.sales_price.$touch()" 
                          :error-messages="salesPriceErrors" 
                        />
                      </v-col>
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.weight" 
                             label="Weight"
                            step=".01"
                          @input="$v.editedItem.weight.$touch()"
                          @blur="$v.editedItem.weight.$touch()"
                          :error-messages="weightErrors"   
                        />
                      </v-col>
                      <v-col cols="12">
                        <v-text-field v-model="editedItem.carton_quantity" 
                            label="Carton Quantity" 
                            min="1"
                          @input="$v.editedItem.carton_quantity.$touch()"
                          @blur="$v.editedItem.carton_quantity.$touch()"
                          :error-messages="cartonQuantityErrors"
                        />
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

                          @input="$v.editedItem.category_id.$touch()"
                          @blur="$v.editedItem.category_id.$touch()"
                          :error-messages="categoryErrors"

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

                          @input="$v.editedItem.brand_id.$touch()"
                          @blur="$v.editedItem.brand_id.$touch()"
                          :error-messages="brandErrors"
                        ></v-select>
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
          <v-btn color="teal darken" dark @click="products">Reset</v-btn>
        </template>
      </v-data-table>
      </v-col>
    </v-row>  
</v-container>
</template>

<script>
import { required, minLength, minValue, decimal,integer, numeric } from 'vuelidate/lib/validators'
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
        category_id:'',
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
    }),

    validations:{
      editedItem: { 
        name: {
          required,
          minLength:minLength(3),

          async uniqueName(value){
            if(value===null) return true
            const products = this.products
            const nameAlreadyExist =
                    products.find(product=>product.name.toLowerCase() === value.toLowerCase())       
            if(nameAlreadyExist){
              return false;
            }
            return true
          }
        },
        stock_price:{
          required,
          decimal,
          minValue:minValue(0)
        },
        sales_price:{
          required,
          decimal,
          minValue:minValue(0)
        },
        weight: {
          required,
          decimal,
          minValue:minValue(0)
        },
        carton_quantity:{
          required,
          integer,
          minValue:minValue(1)
        },
        category_id:{
          required,
        },
        brand_id:{
          required,
        },
       
        
      },
    },

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Product' : 'Edit Product'
      },

       nameErrors(){
        const errors = [];
        if(!this.$v.editedItem.name.$dirty) return errors;
          !this.$v.editedItem.name.minLength &&
            errors.push("Product name must be atleast 3 characters*")
          !this.$v.editedItem.name.required &&
            errors.push("Product name is required*")
          !this.$v.editedItem.name.uniqueName &&
            errors.push("Product name already Exist*")
        return errors
      },
      stockPriceErrors(){
        const errors = [];
        if(!this.$v.editedItem.stock_price.$dirty) return errors;
          !this.$v.editedItem.stock_price.decimal &&
            errors.push("Stock price value is INVALID*")
          !this.$v.editedItem.stock_price.required &&
            errors.push("stock price is required*")
          !this.$v.editedItem.stock_price.minValue &&
            errors.push("stock price can't be less than 0 *")
        return errors
      },
      salesPriceErrors(){
        const errors = [];
        if(!this.$v.editedItem.sales_price.$dirty) return errors;
          !this.$v.editedItem.sales_price.decimal &&
            errors.push("Sales price value is INVALID*")
          !this.$v.editedItem.sales_price.required &&
            errors.push("Sales price is required*")
          !this.$v.editedItem.sales_price.minValue &&
            errors.push("Sales price can't be less than 0 *")
        return errors
      },
      weightErrors(){
        const errors = [];
        if(!this.$v.editedItem.weight.$dirty) return errors;
          !this.$v.editedItem.weight.decimal &&
            errors.push("Weight value is INVALID*")
          !this.$v.editedItem.weight.required &&
            errors.push("Weight is required*")
          !this.$v.editedItem.weight.minValue &&
            errors.push("Weight can't be less than 0 *")
        return errors
      },
      cartonQuantityErrors(){
        const errors = [];
        if(!this.$v.editedItem.carton_quantity.$dirty) return errors;
          !this.$v.editedItem.carton_quantity.integer &&
            errors.push("Carton quantity value is INVALID*")
          !this.$v.editedItem.carton_quantity.required &&
            errors.push("Carton quantity is required*")
          !this.$v.editedItem.carton_quantity.minValue &&
            errors.push("Carton quantity can't be less than 0 *")
        return errors
      },
      categoryErrors(){
         const errors = [];
        if(!this.$v.editedItem.category_id.$dirty) return errors;
          !this.$v.editedItem.category_id.required &&
            errors.push("Category is required*")
        return errors
      },
      brandErrors(){
        const errors = [];
        if(!this.$v.editedItem.brand_id.$dirty) return errors;
          !this.$v.editedItem.brand_id.required &&
            errors.push("Brand is required*")
        return errors
      }

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
          this.$v.$touch();
          if(!this.$v.$invalid)
          {
            let response = await Api().post(`/products`,this.editedItem);
            this.editedItem.id = response.data.product.id
            this.editedItem.text = response.data.product.description
            
            console.log(this.editedItem)
            this.products.unshift(this.editedItem) 
          }
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