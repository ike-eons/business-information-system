<template>
  <v-container>
      
          <v-row>
              <v-col cols="6">
                  <v-card round class="p-3">
                    <div>
                        <h4 class="font-weight-light">{{customer.fullname}}</h4>
                    </div>
                    <div>
                        <span>{{customer.shop_name}}</span>
                    </div>
                    <div>
                        <span>{{customer.shop_address}}</span>
                    </div>
                    <div>
                        <span>{{customer.phone}}</span>
                    </div>
                </v-card>
              </v-col>
              <v-col cols="6">
                  <v-card round class="p-3">
                    <div>
                        <h4 class="font-weight-light">Customer Invoice Statistics</h4>
                    </div>
                    <div>
                        <span>Total Amount: 2000 </span>
                    </div>
                    <div>
                        <span>Total amount paid: 1500</span>
                    </div>
                    <div>
                        <span>Generate Invoice: 15</span>
                    </div>
                    <div>
                        <!-- <InvoicePaymentChart/> -->
                    </div>
                </v-card>
              </v-col>
          </v-row>
      
      <!-- transaction datatable card -->
    <v-card tile class="mt-5">
      <v-data-table 
          :headers="headers" 
          :items="customer.invoices" item-key="id"
          :items-per-page="5"
          >
          <template v-slot:item="{ item,index}">
              <tr>
                  <td>{{index+1}}</td>
                  <td>
                    {{item.counter_number}}
                  </td>
                  <td>GH¢{{item.total |formatMoney}}</td>
                  <td v-for="(payment,i) in customer.payments" :key="payment.id" v-if="payment.invoice_id == item.id" >
                    <span >GH¢{{ customer.payments[i].amount_paid|formatMoney}}</span>
                  </td>
                  <td v-for="(payment,i) in customer.payments" v-if="payment.invoice_id === item.id">
                        <span v-if="customer.payments[i].amount_paid === item.total">
                            <v-chip
                            class="ma-2"
                            color="success"
                            text-color="white"
                            >
                            PAID
                            </v-chip>
                        </span>
                        <span v-else-if="customer.payments[i].amount_paid > 0 && customer.payments[i].amount_paid < item.total">
                        <v-chip
                        class="ma-2"
                        color="warning"
                        text-color="white"
                        >
                        Partially Paid
                        </v-chip>
                        </span>
                        <span v-else>
                            <v-chip
                            class="ma-2"
                            color="error"
                            text-color="white"
                            >
                            UNPAID
                            </v-chip>
                        </span>
                    </td>
                    <td>{{getHumanDate(item.date)}}</td>
                    <td v-for="(payment,i) in customer.payments" v-if="payment.invoice_id === item.id">
                        <span class="pl-12 pr-n10" v-if="customer.payments[i].amount_paid === item.total">
                            <v-icon small class="mr-2" color="teal darken-2"
                                :disabled="disable" @click="editItem(item)"
                            >
                            mdi-pencil
                            </v-icon>
                        </span>
                        <span class="pl-12" v-else>
                            <v-icon small class="mr-2" color="teal darken-2"
                                :disabled="false"
                                @click="editItem(item)"
                            >
                                mdi-pencil
                            </v-icon>
                        </span>
                        
                    </td>
              </tr>
          </template>

          <template v-slot:top>
          <v-toolbar color="teal" flat elevation-1 class="white--text">
            <v-toolbar-title><v-icon color="#fff">layers</v-icon>&nbsp;Customer Transactions</v-toolbar-title>
            <v-divider
              class="mx-5"
              inset
              vertical
            ></v-divider>
            <v-spacer></v-spacer>
          </v-toolbar>
          </template>
      </v-data-table>
  </v-card>


      <!-- end of transaction datatable  -->
      
      <v-card tile class="mt-5">
          <v-row>
              <v-col cols="12">
                  <ProductGraph />
              </v-col>
              
          </v-row>
          
      </v-card>
  </v-container>
</template>

<script>

import Api from '../../service/api.js';
import ProductGraph from './ProductGraph'
import InvoicePaymentChart from './InvoicePaymentChart'
import moment from 'moment'

export default {
    components:{
        ProductGraph,
        // InvoicePayementChart
    },
    data(){
        return{
            disable:true,
            customer:{
                invoices:[]
            },
            headers: [
                { text: "#", value: "" },
                {
                    text: "Reference #No",
                    align: "left",
                    sortable: false,
                    value: ""
                },
                { text: "Total (GH¢)", value: "total" },
                { text: "Paid Amount (GH¢)", value: "amount_paid" },
                { text: "Status", value: "status" },
                { text: "Date", value: "date" },
                { text: "Update Payment", align:"right", value: "actions",sortable:false },
            ],
        }
    },
    created(){
         Api().get(`/customers/${this.$route.params.id}`)
        .then(res=>console.log(this.customer = res.data.customer))
    },
    methods:{
        getHumanDate : function (date) {
            return moment(date, 'YYYY-MM-DD').format('DD/MM/YYYY');
            // return moment(date, "YYYYMMDD").fromNow();
        }
    }
}
</script>

<style>

</style>