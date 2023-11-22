<script setup>
    defineProps({
        name: {
            type: String,
            required: true
        },
        omitTrailingLine: {
            type: Boolean,
            default: false
        },
        tagName: {
            type: String,
            default: 'section'
        },
        class: {
            type: String,
            required: false
        }
    });
</script>

<template>
    <component :is="tagName" class="px-4">
        <h2 class="font-bold text-4xl text-gray-800 dark:text-current text-center my-8 ">{{ name }}</h2>
        <div class="relative z-20" :class="class">
            <span class="block w-full h-0.5 absolute top-0 left-0 right-0 bg-gradient-to-r from-white via-red-700 to-white dark:from-gray-900 dark:via-red-700 dark:to-gray-900"></span>
            <slot/>
            <span v-if="!omitTrailingLine" class="block w-full h-0.5 absolute bottom-0 left-0 right-0 bg-gradient-to-r from-white via-red-700 to-white dark:from-gray-900 dark:via-red-700 dark:to-gray-900"></span>
        </div>
    </component>
</template>
