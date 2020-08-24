<template>
<v-container class="my-5">
  <v-row>
    <v-col md="12">
      <v-data-table
        :headers="headers"
        :items="transactions"
        sort-by="text"
        class="elevation-1 strip-table"
      >
        <template v-slot:top>
          <v-toolbar flat elevation-1 color="#d1d1d1" class="lighten-2">
            <v-toolbar-title >Events Timeline</v-toolbar-title>
            <v-divider
              class="mx-5"
              inset
              vertical
            ></v-divider>
            <v-spacer></v-spacer>
          </v-toolbar>
        </template>
        <template v-slot:no-data>
          <v-btn color="primary" @click="GET_BRANDS">Reset</v-btn>
        </template>
      </v-data-table>
      </v-col>
    </v-row>  
</v-container>
</template>

<script>

import {mapGetters, mapActions} from "vuex";
import Api from '../../service/api.js'

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
          text: 'ID',
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
    },
  }
</script>

<style scoped>
  .v-data-table table tr:nth-of-type(2n) {
    background: lightslategrey;
  }
    
</style>