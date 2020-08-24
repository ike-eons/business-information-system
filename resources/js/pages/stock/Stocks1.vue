<template>
<v-container class="my-5">
  <v-row>
    <v-col md="12">
      <v-data-table
        :headers="headers"
        :items="GET_STOCKS"
        sort-by="text"
        class="elevation-1"
      >
        <template v-slot:top>
          <v-toolbar flat elevation-1 color="#d1d1d1" class="lighten-2">
            <v-toolbar-title >stocks</v-toolbar-title>
            <v-divider
              class="mx-5"
              inset
              vertical
            ></v-divider>
            
            <v-spacer></v-spacer>

            <v-btn  class="mb-2" to="/stocks/new">
                <i class="fa fa-plus" aria-hidden="true"></i>
                <span>New Stock</span>
            </v-btn>
           
          </v-toolbar>
        </template>
       
        <template v-slot:no-data>
          <v-btn color="primary" @click="GET_STOCKS">Reset</v-btn>
        </template>
      </v-data-table>
      </v-col>
    </v-row>  
</v-container>
</template>

<script>

import {mapGetters, mapActions} from "vuex";


  export default {
    data: () => ({
      dialog: false,
      valid: false,
      headers: [
        {
          text: '#No',
          align: 'left',
          sortable: true,
          value: number,
        },
        {text:'Distributor',value:distributor_id},
        {text:'Reference',value:reference,sortable:true},
        {text:'Total (Stock)',value:total},
        { text: 'Actions',align:'center', value: 'actions', sortable: false },
      ],
      
      required(propertyType){
        return v => v && v.length > 0 || ` ${propertyType} is required`
      },
      minLength(propertyType,length){
        return v=> v && v.length >= 3 || `${propertyType} must be equal to ${length} digits`
      }
    }),

    computed: {
      ...mapGetters('stock',['GET_STOCKS']),
    },


    created () {
      this.fetch_stocks()
    },

    methods: {
      ...mapActions("stock",["fetch_stocks","create_stock","delete_stock","edit_stock"]),

    },
  }
</script>

<style scoped>
  .v-data-table table tr:nth-of-type(2n) {
    background: lightslategrey;
  }
    
</style>