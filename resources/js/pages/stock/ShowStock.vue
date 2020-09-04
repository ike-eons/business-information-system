<template>
  <v-container>
    
    <!-- stock -->
    <v-row>
      <v-col cols="9">
          <v-card tile class="p-3">
                <v-row class="stock-printable-area">
                  <v-col cols="8">
                    
                    <h6>Bill From</h6>
                    <div>
                        <span>{{stock.distributor.company_name}}</span>
                    </div>
                    <div>
                        <span>{{stock.distributor.address}}</span>
                    </div>
                    <div>
                      <span><i class="fa fa-phone-square" aria-hidden="true"></i>&ensp; {{stock.distributor.phone}}</span>
                    </div> 
                    <div>
                        <span>{{stock.distributor.email}}</span>
                    </div> 
                      
                  </v-col>
                  <v-col>
                      <br>
                      <div>
                        <span>Date: {{stock.date}}</span>
                      </div>
                      <div>
                        <span>stock# {{stock.reference}}</span>
                      </div>
                      <div>
                        <span> {{stock.counter_number}}</span>
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

                <v-row v-for="(item,index) in stock.stock_items" :key="item.id">
                  <v-col cols="1">{{index+1}}</v-col>
                  <v-col cols="7">{{item.product.description}}</v-col>
                  <v-col cols="2">{{item.quantity}}</v-col>
                  <v-col cols="2">{{item.unit_price | formatMoney}}</v-col>
                </v-row>

                <v-divider></v-divider>

                <v-row>
                  <v-col cols="8">
                    
                  </v-col>
                  <v-col cols="4">
                    <p>Total: {{stock.total | formatMoney}}</p>
                  </v-col>
                </v-row>

          </v-card>
      </v-col>

      <!-- buttons -->
      <v-col cols="3">
        
        <v-card tile class="p-3 pl-3">
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
      stock:{
        distributor:{}
      },
    }
  },
  created(){
     Api().get(`/stocks/${this.$route.params.id}`)
        .then(res=>console.log(this.stock = res.data.stock))
  

  },

  method:{

      
  }

}
</script>

<style>

</style>