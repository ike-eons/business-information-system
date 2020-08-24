<template>
  <v-container>
      <v-card tile class="p-3">
          <v-row>
              <v-col>
                  <div>
                      <h6>{{customer.fullname}}</h6>
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
              </v-col>
          </v-row>
      </v-card>
      <v-card class="p-2 mt-5">
          <v-row>
              <v-col>
                  <v-row >
                  <v-col cols="1">#</v-col>
                  <v-col cols="7">Reference #No</v-col>
                  <v-col cols="2">Total</v-col>
                  <v-col cols="2">Date</v-col>
                </v-row>
                <v-divider></v-divider>
                  <v-row v-for="(invoice,index) in customer.invoices" :key="invoice.id">
                    <v-col cols="1">{{index+1}}</v-col>
                    <v-col cols="7"><router-link :to="`/invoices/${invoice.id}`">{{invoice.counter_number}}</router-link></v-col>
                    <v-col cols="2">GH¢{{invoice.total |formatMoney}}</v-col>
                    <v-col cols="2">{{invoice.date}}</v-col>
                  </v-row>
              </v-col>
          </v-row>
      </v-card>
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

export default {
    components:{
        ProductGraph
    },
    data(){
        return{
            customer:{},
        }
    },
    created(){
         Api().get(`/customers/${this.$route.params.id}`)
        .then(res=>console.log(this.customer = res.data.customer))

      
    },
    methods:{
    }
}
</script>

<style>

</style>