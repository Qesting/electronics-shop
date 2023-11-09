<script setup>
    defineProps({
        name: {
            type: String,
            required: true
        },
        omitTrailingLine: {
            type: Boolean,
            default: false
        }
    });
</script>

<template>
    <section class="px-4">
        <h2 class="font-bold text-4xl text-gray-800 text-center my-8">{{ name }}</h2>
        <div class="relative z-20">
            <span class="block w-full h-0.5 absolute top-0 left-0 right-0 bg-gradient-to-r from-white via-red-700 to-white"></span>
            <slot/>
            <span v-if="!omitTrailingLine" class="block w-full h-0.5 absolute bottom-0 left-0 right-0 bg-gradient-to-r from-white via-red-700 to-white"></span>
        </div>
    </section>
</template>
