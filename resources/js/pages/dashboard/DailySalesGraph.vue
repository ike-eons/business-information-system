<template>
    <line-chart 
        :data="daily_sales">
    </line-chart>
</template>

<script>

import Api from '../../service/api.js';
export default {
    data(){
        return {
            daily_sales:[]
        }
    },
    created(){
          Api().get(`/daily_invoice_graph`)
        .then(res=>console.log(this.daily_sales = res.data.daily_sales))
    }
}
</script>

<style>

</style>