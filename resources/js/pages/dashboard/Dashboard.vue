<template>
  <!-- <v-content> -->
    <v-container class="pa-1" fluid>
      <!-- <v-row>
        <v-col xs="12">
          <h2 class="display-1 pl-5 pt-1">
              Dashboard
          </h2>
        </v-col>
      </v-row> -->
  
      <!-- Cards  -->
      <v-row class="ma-3">

        <!-- customer card -->
        <v-col cols="12" xs="12" sm="6" md="3">
           <v-card color="green lighten-1" class="justify-center pt-4" shaped dark max-height="300px">
             <div>
             <div>
               <p class="font-weight-bold text-center"><v-icon>perm_identity</v-icon> Cutomers</p>
               
               <p class="text-center h3 font-weight-light">{{customers.length}}</p>
             </div>
             </div>
             <v-card-actions class="justify-center green darken-1">
              <p>more info <span><v-icon small>fa-arrow-alt-circle-right</v-icon></span></p>
            </v-card-actions>
            </v-card>
        </v-col>

        <!-- invoice generated -->
        <v-col cols="12" xs="12" sm="6" md="3">
           <v-card color="orange lighten-1" class="justify-center pt-4" shaped dark max-height="300px">
             <div >
             <div>
               <p class="font-weight-bold text-center"><v-icon>content_copy</v-icon> Invoices</p>
               
               <p class="text-center h3 font-weight-light">{{customers.length}}</p>
             </div>
             </div>
             <v-card-actions class="justify-center orange darken-1">
              <p>more info <span><v-icon small>fa-arrow-alt-circle-right</v-icon></span></p>
            </v-card-actions>
            </v-card>
        </v-col>
         
        <!-- inventory total card -->
        <v-col cols="12" xs="12" sm="6" md="3">
           <v-card color="teal lighten-1" class="justify-center pt-4" shaped dark max-height="300px">
             <div >
             <div>
               <p class="font-weight-bold text-center"><v-icon>trending_up</v-icon> Inventory Amount</p>
               
               <p class="text-center h3 font-weight-light">GH¢ {{inventory.total_inventory|formatMoney}}</p>
             </div>
             </div>
             <v-card-actions class="justify-center teal darken-1">
              <p>more info <span><v-icon small>fa-arrow-alt-circle-right</v-icon></span></p>
            </v-card-actions>
            </v-card>
        </v-col>

          <!-- inventory quantity -->
         <v-col cols="12" xs="12" sm="6" md="3">
           <v-card color="red lighten-1" class="justify-center pt-4" shaped dark max-height="300px">
             <div >
             <div>
               <p class="font-weight-bold text-center"><v-icon>layers</v-icon> Inventory Quantity</p>
               
               <p class="text-center h3 font-weight-light">{{inventory.total_quantity}}</p>
             </div>
             </div>
             <v-card-actions class="justify-center red darken-1">
              <p>more info <span><v-icon small>fa-arrow-alt-circle-right</v-icon></span></p>
            </v-card-actions>
            </v-card>
        </v-col>

      </v-row>
      <!-- end of cards -->

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
import CardStats from './CardStats.vue'
import Api from '../../service/api.js'

export default {
  components:{
    EventsTimeLine,
    StockGraph,
    CardStats,
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
.one-line {
  overflow: hidden; 
  text-overflow: ellipsis;
  white-space: nowrap;
}
</style>