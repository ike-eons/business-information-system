<template>
    <bar-chart :data="customer_products"></bar-chart>
</template>

<script>

import Api from '../../service/api.js';

export default {
    data(){
        return{
            customer_products:{}
        }
    },
    created(){
          Api().get(`/customer_products/${this.$route.params.id}`)
        .then(res=>console.log(this.customer_products = res.data.target_products))

    }
}
</script>

<style>

</style>