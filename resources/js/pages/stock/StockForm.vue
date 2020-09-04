<template>
  <v-container>
    <v-card tile elevation-1>
        <v-card-title class="pb-0">
            <span class="headline">Add Stock</span>
        </v-card-title>
        <v-divider class="py-0"></v-divider>
        <v-card-text class="py-0">
            <v-row class="pa-0">
                <v-col cols="12" xs="12" sm="12" md="6"> 
                    <v-autocomplete
                    v-model="stock.distributor"
                    :items="distributors"
                    :return-object="true"
                    item-text="company_name"
                    item-id="id"
                    label="Select Distributor"
                    full-width
                    dense
                    solo

                    hint="Select a distributors"

                    @blur="$v.stock.distributor.$touch()"
                    @input="$v.stock.distributor.$touch()"
                    :error-messages="distributorErrors"
                >
                </v-autocomplete>
                </v-col>
                <v-col cols="12" xs="12" sm="6" md="3">
                    <v-text-field
                        label="Stock number"
                        v-model="stock.reference"
                        placeholder="Enter Stock Ref. number here"
                        outlined
                        dense
                    ></v-text-field>
                </v-col>
                <v-col cols="12" xs="12" sm="6" md="3">
                    
                    <v-menu
                        ref="menu"
                        v-model="menu"
                        :close-on-content-click="false"
                        :return-value.sync="date"
                        transition="scale-transition"
                        offset-y
                        min-width="290px"
                    >
                        <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                        dense
                            v-model="stock.date"
                            label="Select Date"
                            prepend-icon="event"
                            readonly
                            outlined
                            v-bind="attrs"
                            v-on="on"
                        ></v-text-field>
                        </template>
                        <v-date-picker v-model="stock.date" no-title scrollable>
                        <v-spacer></v-spacer>
                        <v-btn text color="primary" @click="menu = false">Cancel</v-btn>
                        <v-btn text color="primary" @click="$refs.menu.save(date)">OK</v-btn>
                        </v-date-picker>
                    </v-menu>

                </v-col>
            </v-row>

            <v-divider></v-divider>

            <v-row>
                <v-col cols="1">
                    <p>No.</p>
                </v-col>
                <v-col cols="6">
                    <p>Product Description</p>
                </v-col>
                <v-col cols="2">
                    <p>Quantity</p>
                </v-col>
                <v-col cols="2">
                    Unit Cost
                </v-col>
                <v-col cols="1">
                    <i class="fa fa-bolt"></i>
                </v-col>
                     
            </v-row>
            <v-divider></v-divider>
            <v-row v-for="(item, index) in $v.stock.stock_items.$each.$iter" 
                :key="item.product_id" dense     
            >
                <v-col cols="1">
                    {{ parseInt(index)+1 }}
                </v-col>
                <v-col cols="6">
                    <v-autocomplete
                        :items="products"
                        v-model="stock.stock_items[parseInt(index)].product"
                        item-text="description"
                        item-value="id"
                        :return-object="true"
                        background-color="#fefeff"
                        label="Select Product"
                        full-width
                        dense
                        solo
                        hint="list of all products"
                        hide-selected

                         @input="$v.stock.stock_items.$each[parseInt(index)].product.$touch()"
                        @blur="$v.stock.stock_items.$each[parseInt(index)].product.$touch()"
                        :error-messages="productErrors"
                    >
                    </v-autocomplete>
                </v-col>
                <v-col cols="2">
                    <v-text-field
                        type="number"
                        v-model="stock.stock_items[index].quantity"
                        min="1"
                        dense
                        filled
                        @input="$v.stock.stock_items.$each[parseInt(index)].quantity.$touch()"
                        @blur="$v.stock.stock_items.$each[parseInt(index)].quantity.$touch()"
                        :error-messages="quantityErrors"
                    ></v-text-field>
                </v-col>
                <v-col cols="2">
                    <v-text-field
                        type="number"
                        min="1"
                        v-model="stock.stock_items[index].unit_price = 
                            stock.stock_items[index].quantity * stock.stock_items[index].product['stock_price']"
                        dense
                        readonly
                    />
                    <!-- <input type="text" class="stock-control"  
                            v-model="stock.stock_items[index].unit_price = 
                            stock.stock_items[index].quantity * stock.stock_items[index].stock_price"
                            readonly
                    > -->
                </v-col>
                <v-col cols="1">
                    <span @click="remove_stock_item(index)">
                        <i class="fa fa-trash red-text"></i>
                    </span>
                </v-col>
            </v-row>

            <!-- ADD NEW ROW -->
            <v-row>
                <v-col cols="12" xs="4" sm="3" md="3">
                    <!-- <v-btn  @click="add_row">
                        <i class="fa fa-plus"> </i> 
                        new product
                    </v-btn> -->
                <v-btn class="mx-2" fab dark color="indigo" @click="add_row()">
                    <v-icon dark>mdi-plus</v-icon>
                </v-btn>
                </v-col>
            </v-row>

            <!-- SAVE STOCK BUTTON -->
            <v-row>
                <v-col cols="12" xs="12" sm="6" md="3" offset-md="9">
                    <v-divider></v-divider>
                     <p class="font-weight-bold" > 
                        <span>Total</span>
                        <v-text-field v-model="total" readonly />
                     </p>   
                    <v-btn block tile :disabled="$v.$invalid" @click="save">
                        <i class="fa fa-save">&nbsp; </i> 
                        SAVE
                    </v-btn>
                </v-col>
            </v-row>
        </v-card-text>
        
    </v-card>
      
  </v-container>
</template>

<script>

import moment from 'moment';
import Api from '../../service/api.js';
import { required, minLength, minValue, decimal,integer, numeric } from 'vuelidate/lib/validators'

export default {
    data: () => ({
        index : 0,
        distributors:null,
        // distributor:null,
        products:null,
        stocks:[],

        date: new Date().toISOString().substr(0, 10),
        menu: false,
        stock:{
            reference:null,
            total:0,
            date:moment().format("YYYY-MM-DD"),
            distributor:{},
            distributor_id:null,
            stock_items:[{
                product:{},
                product_id:null,
                quantity:1,
                unit_price:1
            }]
        }
    }),
    created(){
         Api().get('/products')
        .then(res=>console.log(this.products = res.data.products))

        Api().get('/distributors')
        .then(res=>console.log(this.distributors = res.data.distributors))
       
       Api().get('/stocks')
        .then(res=>console.log(this.stocks = res.data.stocks))
        
    },
    watch:{
        index:function(){
          console.log(this.index);
       },     
    },

    validations:{
        stock:{
            distributor:{
                required
            },
            stock_items:{
                required,
                $each:{
                    product:{
                        required
                    },
                    quantity:{
                        required,
                        integer,
                        minValue:minValue(1)
                    }
                }
            }
        },
        
    },

    computed:{

        distributorErrors(){
            const errors = [];

            if(!this.$v.stock.distributor.$dirty) return errors;
            !this.$v.stock.distributor.required &&
                errors.push("distributor is required*")
            return errors
        },
        productErrors(){
            const errors = [];
            if(!this.$v.stock.stock_items.$each[this.index].product.$dirty) return errors;
                !this.$v.stock.stock_items.$each[this.index].product.required &&
                errors.push("Select a product *")
            return errors
        },
        quantityErrors(){
             const errors = [];
            if(!this.$v.stock.stock_items.$each[this.index].quantity.$dirty) return errors;
            !this.$v.stock.stock_items.$each[this.index].quantity.required &&
                errors.push("Quantity is required *")
            !this.$v.stock.stock_items.$each[this.index].quantity.integer &&
                errors.push("Invalid input *")
            !this.$v.stock.stock_items.$each[this.index].quantity.minValue &&
                errors.push("minimum value of one(1) *")
            return errors
        },
      
        total: function () {
            let sum = 0;
         
            if ( this.stock.stock_items.length > 0 ){
                // console.log(this.stock.stock_items.length);
                for (let stock_item of this.stock.stock_items) {
                    sum +=  (stock_item.quantity * stock_item.product['stock_price']);
                    this.stock.total = parseFloat(sum.toFixed(2));
                }
            } else {
                this.stock.total = sum
            }
            if(isNaN(sum))
            {
                return 0;
            }
            else{
                return "GH¢ "+parseFloat(sum.toFixed(2))
            }
         
        },
    
    },
    methods:{
        
         add_row(){
            // this.fields.push({
            this.stock.stock_items.push({
            // product_id: null,
            product:{} ,
            unit_price: 0,
            quantity: 1,
            // invoice_price:null
         })
        },
        remove_stock_item(index) {
            this.stock.stock_items.splice(index, 1)
        },
        getIndex(index){
            this.index = parseInt(index);
        },
        async save(){
            this.$v.$touch();
            if(!this.$v.$invalid){

                this.$set(this.stock,'distributor_id',this.stock.distributor.id);

                for(let i = 0; i < this.stock.stock_items.length; i++){
                    this.$set(this.stock.stock_items[i],'product_id'
                                ,this.stock.stock_items[i].product.id);
                }
                console.log(this.stock)
                // this.$set(this.stock,'distributor_id',this.distributor.id);

                let response = await Api().post(`/stocks`,this.stock);
                this.stock.id = response.data.id
                console.log(this.stock.id)
                this.stocks.unshift(this.stock) 
                this.$router.push({
                    name:'showStock',
                    params:{
                        id:response.data.id
                    }
                })
            }
             
        
        }
    
    }
}
</script>

<style lang="scss" scoped>

.flex-table{
    row:nth-of-type(odd) {
   background-color: rgba(0, 0, 0, .05);
 }
}
</style>