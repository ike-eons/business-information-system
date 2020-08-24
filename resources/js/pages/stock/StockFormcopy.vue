<template>
  <v-container>
    <v-card tile elevation-1>
        <v-card-title class="pb-0">
            <span class="headline">Add Stock</span>
        </v-card-title>
        <v-divider class="py-0"></v-divider>
        <v-card-text class="py-0">
            <v-row class="pa-0">
                <v-col cols="12" xs="12" sm="12" md="6"> 
                    <v-autocomplete
                    v-model="distributor"
                    :items="GET_DISTRIBUTORS"
                    :return-object="true"
                    item-text="company_name"
                    item-id="id"
                    label="Select Distributor"
                    full-width
                    dense
                    solo

                    hint="list of all distributors"
                >
                </v-autocomplete>
                </v-col>
                <v-col cols="12" xs="12" sm="6" md="3">
                    <v-text-field
                        label="Stock number"
                        v-model="form.reference"
                        placeholder="Enter Stock number here"
                        outlined
                        dense
                    ></v-text-field>
                </v-col>
                <v-col cols="12" xs="12" sm="6" md="3">
                    
                    <v-menu
                        ref="menu"
                        v-model="menu"
                        :close-on-content-click="false"
                        :return-value.sync="date"
                        transition="scale-transition"
                        offset-y
                        min-width="290px"
                    >
                        <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                        dense
                            v-model="date"
                            label="Select Date"
                            prepend-icon="event"
                            readonly
                            outlined
                            v-bind="attrs"
                            v-on="on"
                        ></v-text-field>
                        </template>
                        <v-date-picker v-model="date" no-title scrollable>
                        <v-spacer></v-spacer>
                        <v-btn text color="primary" @click="menu = false">Cancel</v-btn>
                        <v-btn text color="primary" @click="$refs.menu.save(date)">OK</v-btn>
                        </v-date-picker>
                    </v-menu>

                </v-col>
            </v-row>

            <v-divider></v-divider>

            <v-row>
                <v-col cols="1">
                    <p>No.</p>
                </v-col>
                <v-col cols="6">
                    <p>Product Description</p>
                </v-col>
                <v-col cols="2">
                    <p>Quantity</p>
                </v-col>
                <v-col cols="2">
                    Unit Cost
                </v-col>
                <v-col cols="1">
                    <i class="fa fa-bolt"></i>
                </v-col>
                     
            </v-row>
            <v-divider></v-divider>
            <!-- <v-row v-for="(field, index) in fields" 
                   :key="field.product_id" dense     
            > -->
             <v-row v-for="(item, index) in form.stock_items" 
                   :key="item.product_id" dense     
            >
                <v-col cols="1">
                    {{ index+1 }}
                </v-col>
                <v-col cols="6">
                    <v-autocomplete
                        :items="GET_PRODUCTS"
                        v-model="form.stock_items[index]"
                        item-text="description"
                        item-value="id"
                        :return-object="true"
                        background-color="#fefeff"
                        label="Select Product"
                        full-width
                        dense
                        solo
                        hint="list of all products"
                        hide-selected
                    >
                    </v-autocomplete>
                </v-col>
                <v-col cols="2">
                    <v-text-field
                        type="number"
                        v-model="form.stock_items[index].quantity"
                        min="1"
                        dense
                        filled
                    ></v-text-field>
                </v-col>
                <v-col cols="2">
                    <v-text-field
                        type="number"
                        min="1"
                        v-model="form.stock_items[index].unit_cost = 
                            form.stock_items[index].quantity * form.stock_items[index].stock_price"
                        filled
                        dense
                        readonly
                    />
                    <!-- <input type="text" class="form-control"  
                            v-model="form.stock_items[index].unit_cost = 
                            form.stock_items[index].quantity * form.stock_items[index].stock_price"
                            readonly
                    > -->
                </v-col>
                <v-col cols="1">
                    <span @click="remove_stock_item(index)">
                        <i class="fa fa-trash red-text"></i>
                    </span>
                </v-col>
            </v-row>

            <!-- ADD NEW ROW -->
            <v-row>
                <v-col cols="12" xs="4" sm="3" md="3">
                    <!-- <v-btn  @click="add_row">
                        <i class="fa fa-plus"> </i> 
                        new product
                    </v-btn> -->
                <v-btn class="mx-2" fab dark color="indigo" @click="add_row">
                    <v-icon dark>mdi-plus</v-icon>
                </v-btn>
                </v-col>
            </v-row>

            <!-- SAVE STOCK BUTTON -->
            <v-row>
                <v-col cols="12" xs="12" sm="6" md="3" offset-md="9">
                    <v-divider></v-divider>
                     <p class="font-weight-bold" > 
                        <span>Total</span>
                        <v-text-field v-model="total" readonly />
                     </p>   
                    <v-btn block tile @click="save">
                        <i class="fa fa-save">&nbsp; </i> 
                        SAVE
                    </v-btn>
                </v-col>
            </v-row>
        </v-card-text>
        
    </v-card>
      
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Api from '../../service/api.js';
export default {
    data: () => ({
        index:0,
        distributor:null,
        // quantity:1,
        // fields:[{
        //     dataModel:[]
        // }],
        date: new Date().toISOString().substr(0, 10),
        menu: false,
        form:{
            stock_items:{
                stock_item:[]
            }
        }
    }),
    created(){
        this.fetch_products();
        // this.GET_PRODUCTS;
        this.load_fetch_form();
        this.fetch_distributors();
        console.log(this.total);
        
    },
    watch:{
        index:function(){
          console.log(this.index);
       },
      
            
    },
    computed:{
        ...mapGetters("product",["GET_PRODUCTS"]),
        ...mapGetters("distributor",["GET_DISTRIBUTORS"]),
       
        total: function () {
         let sum = 0;
         
        if ( this.form.stock_items.length > 0 ){
            // console.log(this.form.stock_items.length);
            for (let stock_item of this.form.stock_items) {
                sum +=  (stock_item.quantity * stock_item.stock_price);
                this.form.total = parseFloat(sum.toFixed(2));
            }
         } else {
             this.form.total = sum
         }
        if(isNaN(sum))
        {
            return 0;
        }
        else{
            return "GH¢ "+parseFloat(sum.toFixed(2))
        }
         
      },
    
    },
    methods:{
        ...mapActions('product',["fetch_products"]),
        ...mapActions('distributor',["fetch_distributors"]),
        ...mapActions('stock',["create_stock"]),

        async load_fetch_form(){
            let response = await Api().get('/load_stock_form');
            console.log(response.data.form);
            this.$set(this.$data,'form',response.data.form);
        },
        
        
        add_row(){
            // this.fields.push({
            this.form.stock_items.push({
            product_id: null,
            product: null,
            unit_price: 0,
            quantity: 1,
            stock_price:null
         })
        },
        remove_stock_item(index) {
            // this.fields.splice(index, 1)
            this.form.stock_items.splice(index, 1)
        },
        getIndex(index){
            this.index = parseInt(index);
        },
        save(){
           
            this.$set(this.form,'distributor_id',this.distributor.id);
            this.create_stock(this.form);
            this.$router.go(-1);
            console.log(this.form)
        }
    
    }
}
</script>

<style lang="scss" scoped>

.flex-table{
    row:nth-of-type(odd) {
   background-color: rgba(0, 0, 0, .05);
 }
}
</style>