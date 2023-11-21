<script setup>

    import { Head, Link } from '@inertiajs/vue3';
    import Layout from '../Components/Layout.vue';
    import Section from '../Components/Section.vue';

    defineProps({
        categories: Array
    });
</script>

<template>
    <Head>
        <title>Zamówienie Złożone | Ars Insolitam</title>
    </Head>
    <Layout :categories="categories">
        <div class="py-4">
            <Section name="Zamówienie Złożone">
                <div class="py-4 text-center">
                    <h3
                        class="text-lg"
                    >Powinno dotrzeć do ciebie niedługo.</h3>
                    <Link
                        href="/"
                        class="underline hover:text-red-700 transition-colors duration-300"
                    >Wróć do sklepu</Link>
                </div>
            </Section>
        </div>
    </Layout>
</template>
