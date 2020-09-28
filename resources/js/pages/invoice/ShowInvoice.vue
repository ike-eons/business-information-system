<template>
  <v-container>
    
    <!-- invoice -->
    <v-row>
      <v-col cols="9">
          <v-card tile class="p-3">
                <v-row class="invoice-printable-area">
                  <v-col cols="4">
                    
                      <h6>Bill From</h6>
                      <div>
                        <span>Emmandget 19 Enterprise</span>
                      </div>
                      <div>
                        <span><i class="fa fa-phone-square"></i>&ensp;0244547665</span>
                      </div>
                      <div>
                        <span><i class="fa fa-envelope-square"></i>&ensp;e.agyeidarko@gmail.com</span>
                      </div>
                      
                    
                  </v-col>
                  <v-col cols="4">
                    <h6>Bill To</h6>
                    <div>
                        <span>{{invoice.customer.fullname}}</span>
                    </div>
                    <div>
                        <span><i class="fa fa-address-card">&nbsp;</i>{{invoice.customer.shop_name}} </span>
                    </div>
                    <div>
                        <span>{{invoice.customer.shop_address}}</span>
                    </div>
                    <div>
                      <span><i class="fa fa-phone-square" aria-hidden="true"></i>&ensp; {{invoice.customer.phone}}</span>
                    </div>  
                      
                  </v-col>
                  <v-col>
                      <br>
                      <div>
                        <span>Date: {{invoice.date}}</span>
                      </div>
                      <div>
                        <span>Invoice# {{invoice.counter_number}}</span>
                      </div>
                      
                  </v-col>
                </v-row>

                <v-divider></v-divider>

                <v-row >
                  <v-col cols="1">#</v-col>
                  <v-col cols="7">Item Description</v-col>
                  <v-col cols="2">Quantity</v-col>
                  <v-col cols="2">Unit Price</v-col>
                </v-row>
                <v-divider></v-divider>

                <v-row v-for="(item,index) in invoice.invoice_items" :key="item.id">
                  <v-col cols="1">{{index+1}}</v-col>
                  <v-col cols="7">{{item.product.description}}</v-col>
                  <v-col cols="2">{{item.quantity}}</v-col>
                  <v-col cols="2">{{item.unit_price | formatMoney}}</v-col>
                </v-row>

                <v-divider></v-divider>

                <v-row>
                  <v-col cols="8">
                     Qrcode here
                  </v-col>
                  <v-col cols="4">
                    <p class="h5">Total: GH¢{{invoice.total | formatMoney}}</p>
                     <p class="h5">Total: GH¢{{invoice.total | formatMoney}}</p>
                  </v-col>
                </v-row>

          </v-card>
      </v-col>

      <!-- buttons -->
      <v-col cols="3">
        
        <v-card tile class="p-3 pl-3">
          <div class="ma-2">
            <v-btn block tile color="teal" large dark>
              <v-icon small>print</v-icon>
              <span>Print</span>
            </v-btn>
          </div>
          <div class="ma-2">
            <v-btn block tile color="#1565C0" large dark>
              <v-icon small>cloud</v-icon>
              <span>Save</span>
            </v-btn>
          </div>
          <div class="ma-2">
            <v-btn tile block depressed large>
              <v-icon small>edit</v-icon>
              <span color="primary">Edit</span>
            </v-btn>
          </div>
        </v-card>
        
      </v-col>
    </v-row>
    
  </v-container>
</template>

<script>

import Api from '../../service/api.js';

export default {
  data(){
    return{
      invoice:{
        customer:{}
      },
    }
  },
  created(){
     Api().get(`/invoices/${this.$route.params.id}`)
        .then(res=>console.log(this.invoice = res.data.invoice))
  

  },

  method:{

      
  }

}
</script>

<style>

</style>