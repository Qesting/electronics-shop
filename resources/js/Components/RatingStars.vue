<script setup>
    defineProps({
        rating: Number,
        max: {
            type: Number,
            default: 5
        }
    });
</script>

<template>
    <span class="text-red-700 block">
        <span
            v-for="index in max"
            :class="[index <= rating ? 'bi-star-fill' : 'bi-star']"
        ></span>
    </span>
</template>
