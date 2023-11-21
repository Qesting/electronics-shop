<script setup>

    import Layout from '../Components/Layout.vue';

    import { Head } from '@inertiajs/vue3';

    defineProps({
        categories: Array
    });

</script>

<template>
    <Head>
        <title>Strona Użytkownika | Ars Insolitam</title>
    </Head>
    <Layout :categories="categories">
    </Layout>
</template>
