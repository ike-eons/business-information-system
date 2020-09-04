<template>
  <v-container>
    <v-card tile elevation-1>
        <v-card-title class="pb-0">
            <span class="headline">Create Invoice</span>
        </v-card-title>
        <v-divider class="py-0"></v-divider>
        <v-card-text class="py-0">
            <v-row class="pa-0">

                <!-- select a customer -->
                <v-col cols="12" xs="12" sm="12" md="6"> 
                    <v-autocomplete
                    v-model="invoice.customer"
                    :items="customers"
                    :return-object="true"
                    item-text="fullname"
                    item-id="id"
                    label="Select Customer"
                    full-width
                    dense
                    solo
                    hint="select customer from the list"
                    @blur="$v.invoice.customer.$touch()"
                    @input="$v.invoice.customer.$touch()"
                    :error-messages="customerErrors"
                >
                </v-autocomplete>
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
                            v-model="invoice.date"
                            label="Select Date"
                            prepend-icon="event"
                            readonly
                            outlined
                            v-bind="attrs"
                            v-on="on"
                        ></v-text-field>
                        </template>
                        <v-date-picker v-model="invoice.date" no-title scrollable>
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
            <!-- <v-row v-for="(field, index) in fields" 
                   :key="field.product_id" dense     
            > -->
             <v-row v-for="(item, index) in $v.invoice.invoice_items.$each.$iter" 
                   :key="item.product_id" dense     
            >
                <v-col cols="1">
                    {{ index+1 }}
                </v-col>
                <v-col cols="6">
                    <!-- Select a product -->
                    <v-autocomplete
                        :items="products"
                        v-model="invoice.invoice_items[index]"
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

                        @input="$v.invoice.invoice_items.$each[index].$touch()"
                        @blur="$v.invoice.invoice_items.$each[index].$touch()"
                        :error-messages="productErrors"
                    >
                    </v-autocomplete>
                </v-col>
                <v-col cols="2">
                    <v-text-field
                        type="number"
                        v-model="invoice.invoice_items[index].quantity"
                        min="1"
                        dense
                        filled
                        @input="$v.invoice.invoice_items.$each[index].quantity.$touch()"
                        @blur="$v.invoice.invoice_items.$each[index].quantity.$touch()"
                        :error-messages="quantityErrors"
                    ></v-text-field>
                </v-col>
                <v-col cols="2">
                    <v-text-field
                        type="number"
                        min="1"
                        :value="invoice.invoice_items[index].unit_price = 
                            invoice.invoice_items[index].quantity * invoice.invoice_items[index].sales_price"
                        filled
                        dense
                        readonly
                    />
                </v-col>
                <v-col cols="1">
                    <span @click="remove_invoice_item(index)">
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
                <v-btn class="mx-2" fab dark color="indigo" @click="add_row">
                    <v-icon dark>mdi-plus</v-icon>
                </v-btn>
                </v-col>
            </v-row>

            <!-- SAVE INVOICE BUTTON -->
            <v-row>
                <v-col cols="12" xs="12" sm="6" md="3" offset-md="9">
                    <v-divider></v-divider>
                     <p class="font-weight-bold" > 
                        <span>Total</span>
                        <v-text-field v-model="total" readonly />
                     </p>   
                    <v-btn block tile :disabled="$v.$invalid" @click="onSave">
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
import { mapActions, mapGetters } from 'vuex';
import moment from 'moment';
import Api from '../../service/api.js';
import {get,byMethod} from '../../service/api.js'
import { required, minLength, minValue, decimal,integer, numeric } from 'vuelidate/lib/validators'

export default {
    data: () => ({
        index:0,
        customers:null,
        // customer:null,
        products:null,

        errors:{},
        date:moment().format("YYYY-MM-DD"),
        menu: false,
        invoices:[],
        invoice:{
            total:0,
            date:moment().format("YYYY-MM-DD"),
            customer:{},
            customer_id:null,
            invoice_items:[{
                product:{},
                product_id:null,
                quantity:1,
                unit_price:1
            }]
        }
    }),
    // beforeRouteEnter(to,from,next){

    // },
    created(){
         Api().get('/products')
        .then(res=>console.log(this.products = res.data.products))

         Api().get('/invoices')
        .then(res=>console.log(this.invoices = res.data.invoices))

        Api().get('/customers')
        .then(res=>console.log(this.customers = res.data.customers))
       
        
    },
    watch:{
        index:function(){
          console.log(this.index);
       },
      
            
    },
    validations:{
        invoice:{
            customer:{
                required
            },
            invoice_items:
            {
                required,
                $each:{
                //     product:{
                //     required
                // },
                quantity:{
                    required,
                    integer,
                    minValue:minValue(1)
                },
                }
                
            }
            
        }
    },
    computed:{
        customerErrors(){
            const errors = [];
            if(!this.$v.invoice.customer.$dirty) return errors;
            !this.$v.invoice.customer.required &&
                errors.push("customer is required*")
            return errors
        },
        productErrors(){
            const errors = [];
            if(!this.$v.invoice.invoice_items.$each[this.index].$dirty) return errors;
                !this.$v.invoice.invoice_items.$each[this.index].required &&
                errors.push("Select a product *")
            return errors
        },
        quantityErrors(){
             const errors = [];
            if(!this.$v.invoice.invoice_items.$each[this.index].quantity.$dirty) return errors;
            !this.$v.invoice.invoice_items.$each[this.index].quantity.required &&
                errors.push("Quantity is required *")
            !this.$v.invoice.invoice_items.$each[this.index].quantity.integer &&
                errors.push("Invalid input *")
            !this.$v.invoice.invoice_items.$each[this.index].quantity.minValue &&
                errors.push("minimum value of one(1) *")
            return errors
        },
        // get_customer_id:function(){
        //    if(this.customer != null){
        //    this.stock.customer_id = this.customer.id
        //    return this.stock.customer_id
        //    }
        // },
       
        total: function () {
            let sum = 0;
         
            if ( this.invoice.invoice_items.length > 0 ){
                // console.log(this.invoice.invoice_items.length);
                for (let invoice_item of this.invoice.invoice_items) {
                    sum +=  (invoice_item.quantity * invoice_item.sales_price);
                    this.invoice.total = parseFloat(sum.toFixed(2));
                }
            } else {
                this.invoice.total = sum
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
            this.invoice.invoice_items.push({
            // product_id: null,
            product: null,
            unit_price: 0,
            quantity: 1,
            // invoice_price:null
         })
        },
        remove_invoice_item(index) {
            // this.fields.splice(index, 1)
            this.invoice.invoice_items.splice(index, 1)
        },
        getIndex(index){
            this.index = parseInt(index);
        },
        async onSave(){
         
                this.$set(this.invoice,'customer_id',this.customer.id);

                let response = await Api().post(`/invoices`,this.invoice);
                this.invoice.id = response.data.invoice.id
                console.log(this.invoice)
                this.invoices.unshift(this.invoice) 

                this.$router.push({
                    name:'showInvoice',
                    params:{
                        id:this.invoice.id
                    }
                })
            
        },

        validation(){
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