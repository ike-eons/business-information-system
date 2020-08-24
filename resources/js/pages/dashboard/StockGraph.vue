<template>
    <line-chart 
        :data="stock_intake">
    </line-chart>
</template>

<script>

import Api from '../../service/api.js';
export default {
    data(){
        return {
            stock_intake:[]
        }
    },
    created(){
          Api().get(`/stock_graph`)
        .then(res=>console.log(this.stock_intake = res.data.stock_intake))
    }
}
</script>

<style>

</style>