<template>
<v-container class="my-5">
  <v-row>
    <v-col md="12">
      <v-data-table
        :headers="headers"
        :items="transactions"
        :items-per-page="5"
        sort-by="text"
        class="elevation-5 strip-table"
      >
      <!-- item table -->
        <template v-slot:item="{ item }">
              <tr>
                  <td>
                      <!-- <router-link :to="`/invoices/${item.id}`"> -->
                        {{item.invoice_or_stock}}
                      <!-- </router-link> -->
                  </td>
                  <td>{{ item.number}}</td>
                  <td>GH¢ {{item.amount|formatMoney}}</td>
                  <td>{{getHumanDate(item.date)}}</td>
              </tr>
          </template>

      <!-- item table end -->

        <template v-slot:top>
          <v-toolbar flat elevation-1 color="teal darken-1" dark class="lighten-2">
            <v-toolbar-title >Transaction Timeline</v-toolbar-title>
            <v-divider
              class="mx-5"
              inset
              vertical
            ></v-divider>
            <v-spacer></v-spacer>
          </v-toolbar>
        </template>
        <template v-slot:no-data>
          <v-btn color="teal" class="white--text" @click="GET_BRANDS">Reset</v-btn>
        </template>
      </v-data-table>
    </v-col>
  </v-row>  
</v-container>
</template>

<script>

import {mapGetters, mapActions} from "vuex";
import Api from '../../service/api.js'
import moment from 'moment'

  export default {
    data: () => ({
      dialog: false,
      valid: false,
      headers: [
        {
          text: 'Type',
          align: 'left',
          sortable: true,
          value: 'invoice_or_stock',
        },
        {
          text: 'Transaction ID',
          align: 'left',
          sortable: true,
          value: 'number',
        },
        {
          text: 'Amount',
          align: 'left',
          sortable: true,
          value: 'amount',
        },
        {
          text: 'Date',
          align: 'left',
          sortable: true,
          value: 'date',
        },
        // { text: 'Actions',align:'center', value: 'actions', sortable: false },
      ],
      
      brands: [],
      transactions:[]
    }),

    computed: {
      ...mapGetters('brand',['GET_BRANDS']),
      
    },

    created () {
      this.fetch_brands()

      Api().get('/transactions')
        .then(res=>this.transactions = res.data.transactions)
    },

    methods: {
      ...mapActions("brand",["fetch_brands","create_brand","delete_brand","edit_brand"]),

       getHumanDate : function (date) {
            // return moment(date, 'YYYY-MM-DD').format('DD/MM/YYYY');
            return moment(date, "YYYYMMDD").fromNow();
        }
    },
  }
</script>

<style scoped>
  /* .v-data-table table tr:nth-of-type(2n) {
    background: lightslategrey;
  } */
    
</style>