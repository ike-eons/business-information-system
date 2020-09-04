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
                    hint="select Customer"
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
                    {{ parseInt(index)+1 }}
                </v-col>
                <v-col cols="6">
                    <!-- Select a product -->
                    <v-autocomplete
                        :items="products"
                        v-model="invoice.invoice_items[parseInt(index)].product"
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

                        @input="$v.invoice.invoice_items.$each[parseInt(index)].product.$touch()"
                        @blur="$v.invoice.invoice_items.$each[parseInt(index)].product.$touch()"
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
                        @input="$v.invoice.invoice_items.$each[parseInt(index)].quantity.$touch()"
                        @blur="$v.invoice.invoice_items.$each[parseInt(index)].quantity.$touch()"
                        :error-messages="quantityErrors"
                    ></v-text-field>
                </v-col>
                <v-col cols="2">
                    <v-text-field
                        type="number"
                        min="1"
                        v-model="invoice.invoice_items[index].unit_price = 
                            invoice.invoice_items[index].quantity * invoice.invoice_items[index].product['sales_price']"
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
                <v-col cols="12" xs="12" sm="6" md="4" offset-md="8" class="mb-5 pb-5">
                    <v-divider></v-divider>
                     <p class="font-weight-light h5 teal--text" > 
                        Total: <span>GH¢&nbsp;{{total}}</span>
                     </p>  
                     <v-divider></v-divider> 
                     <div>
                         <!-- Payment Field -->
                         <v-row>
                            <v-col md="8">
                                <div >
                                    <v-text-field
                                    @click="check($event)"
                                        name="payment"
                                        label="Enter Payment" outlined dense
                                        color="green"
                                        min="0"
                                        step=".01"
                                        type="number" 
                                        id="amount_paid"
                                        v-model="invoice.amount_paid"
                                        @input="$v.invoice.amount_paid.$touch()"
                                        @blur="$v.invoice.amount_paid.$touch()"
                                        :error-messages="amountPaidErrors"
                                    />
                                </div>
                            </v-col>
                            <v-col md="4">
                                <v-spacer></v-spacer>
                                <div class="mt-n5">
                                    <v-checkbox
                                        name="fullpayment"
                                        id="fullpayment"
                                        label="Full payment"
                                        color="success"
                                        v-model="full_payment"
                                        hide-details
                                    ></v-checkbox>
                                </div>
                               
                            </v-col>
                         </v-row>
                        
                         
                     </div>
                     <v-divider></v-divider> 
                     <div class="mt-2">
                        <v-btn block tile color="success" class="white--text" :disabled="$v.$invalid" @click="onSave">
                            <i class="fa fa-save">&nbsp; </i> 
                            Preview
                        </v-btn>
                    </div>
                    
                   
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
        customers:[],
        // customer:{},
        products:[],

        // errors:{},
        date:moment().format("YYYY-MM-DD"),
        menu: false,
        invoices:[],
        invoice:{
            total:0,
            date:moment().format("YYYY-MM-DD"),
            amount_paid:0.00,
            customer:{},
            customer_id:1,
            invoice_items:[{
                product:{},
                product_id:null,
                quantity:1,
                unit_price:1
            }]
        },
        amount_paid:0.0,
        full_payment:false
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
        amount_paid: function (newValue) {
          this.invoice.amount_paid = parseFloat(newValue);
        //   return this.invoice.amount_paid
      },
      full_payment:function(){
        if(true){
            this.amount_paid = this.total
            // return this.invoice.amount_paid
        }
      }
      
            
    },
    validations:{
        invoice:{
            customer:{
                required
            },
            amount_paid:{
                decimal,
                minValue:minValue(0),
                maxValue(value){
                    return value <= this.invoice.total 
                }
            },
            invoice_items:
            {
                required,
                $each:{
                    product:{
                    required
                },
                quantity:{
                    required,
                    integer,
                    minValue:minValue(1),
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
            if(!this.$v.invoice.invoice_items.$each[this.index].product.$dirty) return errors;
                !this.$v.invoice.invoice_items.$each[this.index].product.required &&
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
        amountPaidErrors(){
            const errors=[];
            if(!this.$v.invoice.amount_paid.$dirty) return errors;
            !this.$v.invoice.amount_paid.decimal &&
                errors.push("Invalid input")
            !this.$v.invoice.amount_paid.minValue && 
                errors.push("minimum value of 0 ")
            !this.$v.invoice.amount_paid.maxValue && 
                errors.push("maximum value can't exceed total ");
            return errors
        },
        
        total: function () {
            let sum = 0;
         
            if ( this.invoice.invoice_items.length > 0 ){
                // console.log(this.invoice.invoice_items.length);
                for (let invoice_item of this.invoice.invoice_items) {
                    sum +=  (invoice_item.quantity * invoice_item.product['sales_price']);
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
                // return "GH¢ "+parseFloat(sum.toFixed(2))
                return parseFloat(sum.toFixed(2))
            }
         
        },
    
    },
    methods:{
        check(e){
            this.full_payment = false;
            console.log(this.full_payment)
        },
        add_row(){
            // this.fields.push({
            this.invoice.invoice_items.push({
            // product_id: null,
            product:{} ,
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
                this.$v.$touch()
                    if(!this.$v.$invalid){
                        this.$set(this.invoice,'customer_id',this.invoice.customer.id);

                        for(let i = 0; i < this.invoice.invoice_items.length; i++){
                            this.$set(this.invoice.invoice_items[i],'product_id'
                                        ,this.invoice.invoice_items[i].product.id);
                        }

                    let response = await Api().post(`/invoices`,this.invoice);
                    this.invoice.id = response.data.invoice.id
                    this.$v.invoice.$reset();
                    console.log(this.invoice)
                    this.invoices.unshift(this.invoice) 

                    this.$router.push({
                        name:'showInvoice',
                        params:{
                            id:this.invoice.id
                        }
                    })
                }
                
            
        },

        validation(){
        }
    }
}
</script>

<style lang="scss">

.flex-table{
    row:nth-of-type(odd) {
   background-color: rgba(0, 0, 0, .05);
 }
 .v-list-item__title{
     color:#fff;
 }
}
</style>