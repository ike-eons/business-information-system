<template>
<v-container class="my-5">
  
  <v-card tile>
      <v-data-table 
          :headers="headers" 
          :items="inventories" item-key="id">
          <template v-slot:item="{ item }">
              <tr>
                  <td>
                    {{item.product.description}}
                  </td>
                  <td>{{ item.available_quantity }}</td>
                  <td>GH¢ {{item.available_amount|formatMoney}}</td>
                  
              </tr>
          </template>

          <template v-slot:top>
          <v-toolbar color="#00695C" flat elevation-1 class="white--text">
            <v-toolbar-title color="teal lighten-2" class="text--teal"><v-icon color="#fff">layers</v-icon>&nbsp;INVENTORIES</v-toolbar-title>
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

</v-container>
</template>
  

<script>
import Api from '../../service/api.js';

  export default {
    data () {
      return {
        headers: [
          { text: "Products", value: "" },
          { text: "Available Quantity (GH¢)", value: "available_quantity" },
          { text: "Available Amt", value: "available_amount" },
        ],
        inventories:[]
      }
    },
    
    created(){
       Api().get('/all_inventory')
        .then(res=>console.log(this.inventories = res.data.inventories))
    },
  }
</script>

<style>

    /* .v-data-table-header{
        background-color :#00897B;
        color: #ffffff !important;
    } */
    /* .theme--light.v-data-table thead tr th {
    color: #ffffff;
    } */
</style>