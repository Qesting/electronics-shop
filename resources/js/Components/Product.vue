<script setup>
import { Link } from '@inertiajs/vue3';

    defineProps({
        product: {
            type: Object,
            required: true
        }
    });

    const imageSrc = image => image ? image.origin + image.name : '';
    const locale =  navigator.languages && navigator.languages.length
        ? navigator.languages[0]
        : navigator.language;
</script>

<template>
    <div
        class="mx-2 p-2 basis-1/5 lg:basis-1/6 flex-shrink-0 text-center flex flex-col items-center border border-white rounded-lg hover:border-red-700 transition-colors duration-300"
    >
        <img
            :src="imageSrc(product.images[0])"
            alt="zdjęcie produktu"
            class="rounded-lg"
        />
        <Link
            :href="'/product/' + product.id"
            class="underline transition-colors duration-300 hover:text-red-700 capitalize"
        >{{ product.name }}</Link>
        <div class="mt-auto mb-0 flex flex-col items-center">
            <span><i>{{ product.manufacturer.name }}</i>, {{ product.price.toLocaleString(locale, {style: 'currency', currency: 'PLN', minimumFractionDigits: 2}) }}</span>
            <Link
                :href="'/addToCart/' + product.id"
                class="rounded-lg text-white bg-red-700 py-1 px-2 hover:bg-red-800 transition-colors duration-300"
            >Do koszyka</Link>
        </div>
    </div>
</template>
