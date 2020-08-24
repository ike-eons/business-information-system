<template>
  <!-- <v-content> -->
    <v-container class="pa-1" fluid>
      <v-row>
        <v-col xs="12">
          <h2 class="display-1 mb-1 pl-5 pt-2">
              Dashboard
          </h2>
        </v-col>
      </v-row>

      <v-row class="ma-3">

        <v-col cols="12" xs="12" sm="6" md="3">
         <v-card>
          <v-card-text>
            <p class="text-xs-center h3">{{customers.length}}</p>
            <p class="text-xs-center">Customers</p>
          </v-card-text>
        </v-card> 
        </v-col>

        <v-col cols="12" xs="12" sm="6" md="3">
         <v-card>
          <v-card-text>
            <p class="text-xs-center h3">{{invoices.length}}</p>
            <p class="text-xs-center">Invoice Generated</p>
          </v-card-text>
        </v-card> 
        </v-col>

        <v-col cols="12" xs="12" sm="6" md="3">
         <v-card>
          <v-card-text>
            <p class="text-xs-center h3">GH¢{{inventory.total_inventory|formatMoney}}</p>
            <p class="text-xs-center">Inventory Amount</p>
          </v-card-text>
        </v-card> 
        </v-col>

        <v-col cols="12" xs="12" sm="6" md="3">
         <v-card>
          <v-card-text>
            <p class="text-xs-center h3">{{inventory.total_quantity}}</p>
            <p class="text-xs-center">Inventory Quantity</p>
          </v-card-text>
        </v-card> 
        </v-col>

      </v-row>
      <v-row class="mx-3">
        <EventsTimeLine/>
      </v-row>

      <v-row class="mx-3">
          <v-col>
            <v-card tile>
              <!-- <line-chart 
              :data="{'2017-05-13': 2, '2017-05-15': 15,
                      '2017-05-15':18,'2017-05-16':3,
                      '2017-05-17':5,'2017-05-19':12}">

              </line-chart> -->
              <DailySalesGraph />
            </v-card>
          </v-col>
      </v-row>
      
    </v-container>

  <!-- </v-content> -->
</template>

<script>
import EventsTimeLine from './EventsTimeLine';
import StockGraph from './StockGraph'
import DailySalesGraph from './DailySalesGraph'
import Api from '../../service/api.js'

export default {
  components:{
    EventsTimeLine,
    StockGraph,
    DailySalesGraph
  },
  data(){
    return {
        customers:[],
        invoices:[],
        inventory:[],
        // transactions:[]
    }
  },
  created(){
      Api().get('/customers')
        .then(res=>this.customers = res.data.customers)

       Api().get('/invoices')
        .then(res=>this.invoices = res.data.invoices)
      
      Api().get('/inventory')
        .then(res=>this.inventory = res.data)

      
      
  }

}
</script>

<style scoped>

</style>