<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import Helper from '../Helper';

    const props = defineProps({
        product: {
            type: Object,
            required: true
        }
    });

    const cart = useForm({
        productId: props.product.id,
        count: 1
    });
</script>

<template>
    <div
        class="mx-2 p-2 basis-1/5 lg:basis-1/6 flex-shrink-0 text-center flex flex-col items-center border border-white rounded-lg hover:border-red-700 transition-colors duration-300"
    >
        <img
            :src="Helper.imageSrc(product.images[0])"
            alt="zdjęcie produktu"
            class="rounded-lg"
        />
        <Link
            :href="'/product/' + product.id"
            class="underline transition-colors duration-300 hover:text-red-700 capitalize"
        >{{ product.name }}</Link>
        <div class="mt-auto mb-0 flex flex-col items-center">
            <span><i>{{ product.manufacturer.name }}</i>, {{ Helper.localeCurrencyString(product.price) }}</span>
            <button
                :disabled="cart.processing"
                @click="cart.put('/cart/add', { preserveState: true, preserveScroll: true })"
                class="rounded-lg text-white bg-red-700 py-1 px-2 hover:bg-red-800 transition-colors duration-300"
            >Do koszyka</button>
        </div>
    </div>
</template>
