<template>
<v-container class="my-5">
  
  <v-card tile>
      <v-data-table 
          :headers="headers" 
          :items="invoices" item-key="id">
          <template v-slot:item="{ item }">
              <tr>
                  <td>
                      <router-link :to="`/invoices/${item.id}`">
                        {{item.counter_number}}
                      </router-link>
                  </td>
                  <td>{{ item.customer.fullname }}</td>
                  <td>GH¢ {{item.total|formatMoney}}</td>
                  <td>{{item.date}}</td>
                  <td>
                    <v-icon small class="mr-2"
                      @click="editItem(item)"
                    >
                      mdi-pencil
                    </v-icon>
                    <v-icon small
                      @click="deleteItem(item)"
                    >
                      mdi-delete
                    </v-icon></td>
              </tr>
          </template>

          <template v-slot:top>
          <v-toolbar flat elevation-1 color="#d1d1d1" class="lighten-2">
            <v-toolbar-title >INVOICE GENERATED</v-toolbar-title>
            <v-divider
              class="mx-5"
              inset
              vertical
            ></v-divider>
            <v-spacer></v-spacer>
            <v-btn  class="mb-2" to="/invoices/new">
              <i class="fa fa-plus" aria-hidden="true"></i>
                <span>new invoice</span>
            </v-btn>
          </v-toolbar>
          </template>

          <!-- reset button -->
          <template v-slot:no-data>
            <v-btn color="primary" @click="invoices">Reset</v-btn>
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
          {
            text: "Reference #No",
            align: "left",
            sortable: false,
            value: "number"
          },
          { text: "Customer", value: "customer_id" },
          { text: "Total (GH¢)", value: "total" },
          { text: "Date", value: "date" },
          { text: "Actions", value: "actions",sortable:false },
        ],
        customers:[],
        invoices:[]
      }
    },
    
    created(){
       Api().get('/invoices')
        .then(res=>console.log(this.invoices = res.data.invoices))

       Api().get('/customers')
        .then(res=>this.customers = res.data.customers)
    },
  }
</script>