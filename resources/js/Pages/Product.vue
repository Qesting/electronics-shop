<script setup>
    import Layout from '../Components/Layout.vue';
    import Section from '../Components/Section.vue';
    import { Head, Link, useForm } from '@inertiajs/vue3';
    import { ref } from 'vue';

    const props = defineProps({
        categories: Array,
        product: Object
    });

    const capitalize = string => string.split(/\s+/).map(word => word[0].toUpperCase() + word.substring(1)).join(' ');
    const imageSrc = image => image ? image.origin + image.name : '';

    const selectedImage = ref(props.product.images[0]);
    const form = useForm({
        productId: props.product.id,
        count: 1
    });

    const locale =  navigator.languages && navigator.languages.length
        ? navigator.languages[0]
        : navigator.language;
</script>

<template>
    <Layout :categories="categories">
        <Head>
        <title>{{ capitalize(product.name) }} | Ars Insolitam</title>
        <meta name="description" :content="product.name + ' w Ars Insolitam.'"/>
    </Head>
    <main>
        <Link
            class="capitalize ml-8 hover:underline"
            :href="`/category/${product.category.id}`"
        ><span class="bi-arrow-left"></span> {{ product.category.name }}</Link>
        <Section class="flex justify-between px-8 mx-auto lg:w-4/5 py-4" :name="capitalize(product.name)">
            <article class="flex flex-row w-3/5">
                <div class="w-4/5 p-2">
                    <img
                            :src="imageSrc(selectedImage)"
                            alt="product.name"
                            class="w-full rounded-lg"
                        />
                </div>
                <div class="w-1/5">
                    <div
                        v-for="image in product.images"
                        class="m-2 relative rounded-lg overflow-hidden cursor-pointer"
                        @click="selectedImage = image"
                    >
                        <img
                            :src="imageSrc(image)"
                            alt="product.name"
                        />
                        <div
                            class="w-full h-full bg-gray-800 opacity-0 hover:opacity-30 transition-opacity duration-300 absolute top-0 bottom-0 left-0 right-0"
                            :class="{'!opacity-30': selectedImage.id === image.id}"
                        ></div>
                    </div>
                </div>
            </article>
            <article class="w-2/5 md:w-1/4 lg:w-1/5">
                <div class="border border-gray-800 rounded-lg p-4 text-right">
                    <h3 class="text-2xl">{{ product.price.toLocaleString(locale, {style: 'currency', currency: 'PLN', minimumFractionDigits: 2}) }}</h3>
                    <div class="flex items-center justify-end mt-4">
                        <input type="number" min="1" inputmode="numeric" v-model="form.count" class="w-14 mr-2 p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-300 flex-grow"/>
                        <button
                            @click="form.put('/cart/add')"
                            class="inline-block rounded-lg text-white bg-red-700 p-2 hover:bg-red-800 transition-colors duration-300"
                        >Do koszyka</button>
                    </div>
                </div>
            </article>
        </Section>
        <Section name="Parametry" class="grid grid-cols-2 gap-2 mx-auto px-[10%] py-4">
            <template v-for="property in JSON.parse(product.details)">
                <span class="rounded-lg bg-gray-200 p-2 capitalize">{{ property.name }}</span>
                <span class="rounded-lg bg-gray-200 p-2 text-right">{{ property.value }}{{ property?.unit }}</span>
            </template>
            <span class="rounded-lg bg-gray-200 p-2 capitalize">okres gwarancyjny</span>
            <span class="rounded-lg bg-gray-200 p-2 text-right">{{ product.warranty_period }} mies.</span>
        </Section>
    </main>
    </Layout>
</template>
