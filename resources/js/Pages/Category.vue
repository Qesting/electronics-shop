<script setup>
    import Product from './Product.vue';

    const props = defineProps({
        products: Array
    });
</script>

<template>
    <Product v-for="product in props.products" :product="product"/>
</template>
