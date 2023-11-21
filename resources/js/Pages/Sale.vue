<script setup>

    import Layout from '../Components/Layout.vue';
    import Section from '../Components/Section.vue';
    import Product from '../Components/Product.vue';
    import { Head } from '@inertiajs/vue3';
    import Helper from '../Helper';

    const props = defineProps({
        categories: Array,
        sale: Object
    });
</script>

<template>
    <Head>
        <title>{{ Helper.capitalize(sale.name) }} | Ars Insolitam</title>
    </Head>
    <Layout :categories="categories">
        <div class="py-4">
            <Section :name="Helper.capitalize(sale.name)">
                <div class="py-4">
                    <h3 class="text-lg text-center my-4">Tylko do {{ Helper.localeDateString(sale.expires_at) }}!</h3>
                    <div>
                        <img
                            class="w-1/4 lg:w-1/5 float-left rounded-lg mr-4 mb-4"
                            :src="Helper.imageSrc(sale.image)"
                            alt="ilustracja wyprzedaży"
                        />
                        <p>{{ sale.description }}</p>
                        <span class="block clear-both"></span>
                    </div>
                    <div>
                        <h2 class="text-2xl text-center font-bold my-4">Produkty objęte wyprzedażą</h2>
                        <div class="grid grid-cols-4 lg:grid-cols-5">
                            <Product v-for="product in sale.products" :product="product"/>
                        </div>
                    </div>
                </div>
            </Section>
        </div>
    </Layout>
</template>
