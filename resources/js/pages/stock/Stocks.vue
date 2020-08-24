<template>
<v-container class="my-5">
  
  <v-card tile>
      <v-data-table 
          :headers="headers" 
          :items="GET_STOCKS" item-key="id">
          <template v-slot:item="{ item }">
              <tr>
                  <td>{{item.counter_number}}</td>
                  <td>{{ item.distributor.company_name }}</td>
                  <td>{{item.reference}}</td>
                  <td>GH¢ {{item.total}}</td>
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
            <v-toolbar-title >STOCK INTAKE</v-toolbar-title>
            <v-divider
              class="mx-5"
              inset
              vertical
            ></v-divider>
            <v-spacer></v-spacer>
            <v-btn  class="mb-2" to="/stocks/new">
              <i class="fa fa-plus" aria-hidden="true"></i>
                <span>new stock</span>
            </v-btn>
          </v-toolbar>
          </template>
      </v-data-table>
  </v-card>

</v-container>
</template>
  

<script>
import { mapActions, mapGetters } from 'vuex'
  export default {
    data () {
      return {
        headers: [
          {
            text: "No.",
            align: "left",
            sortable: false,
            value: "number"
          },
          { text: "Distributor", value: "distributor_id" },
          { text: "Reference", value: "reference", sortable:true },
          { text: "Total (GH¢)", value: "total" },
          { text: "Actions", value: "actions",sortable:false },
        ],
      }
    },
    created(){
      this.fetch_stocks()
      this.fetch_distributors()
    },
    computed:{
      ...mapGetters('stock',['GET_STOCKS']),
      ...mapGetters('distributor',['GET_DISTRIBUTORS']),
     
    },
    methods:{
      ...mapActions('stock',['fetch_stocks']),
      ...mapActions("distributor",["fetch_distributors"]),
      },
      editeItem(item){

      },
      deleteItem(item){

      }
  }
</script>