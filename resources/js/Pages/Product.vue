<script setup>
    const props = defineProps({
        product: Object
    });


</script>

<template>
    <p>{{ JSON.stringify(product) }}</p>
</template>
