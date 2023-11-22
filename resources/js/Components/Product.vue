<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import Helper from '../Helper';
import RatingStars from './RatingStars.vue';

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

    const salePrice =
        props.product?.pivot?.price ??
        props.product?.sales[0]?.pivot?.price ??
        null;
</script>

<template>
    <div
        class="mx-2 p-2 basis-1/5 lg:basis-1/6 flex-shrink-0 text-center flex flex-col items-center border border-white dark:border-gray-900 rounded-lg hover:border-red-700 transition-colors duration-300"
    >
        <div class="relative">
            <img
                :src="Helper.imageSrc(product.images[0])"
                alt="zdjęcie produktu"
                class="rounded-lg"
            />
            <span class="block absolute top-1 right-1">
                <RatingStars :rating="product.rating"/>
            </span>
        </div>
        <Link
            :href="'/product/' + product.id"
            class="underline transition-colors duration-300 hover:text-red-700 capitalize"
        >{{ product.name }}</Link>
        <div class="mt-auto mb-0 flex flex-col items-center">
            <span><i>{{ product.manufacturer.name }}</i></span>
            <p
                v-if="salePrice == null"
                class="font-bold"
            >
                {{ Helper.localeCurrencyString(product.price) }}
            </p>
            <p
                v-else
                class="font-bold"
            >
                <span class="line-through font-normal">
                    {{ Helper.localeCurrencyString(product.price) }}
                </span>&nbsp;
                <span>
                    {{ Helper.localeCurrencyString(+salePrice) }}
                </span>
            </p>
            <button
                :disabled="cart.processing"
                @click="cart.put('/cart/add', { preserveState: true, preserveScroll: true })"
                class="rounded-lg text-white bg-red-700 py-1 px-2 hover:bg-red-800 transition-colors duration-300"
            >Do koszyka</button>
        </div>
    </div>
</template>
