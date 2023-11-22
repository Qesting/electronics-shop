<script setup>

    import Layout from '../Components/Layout.vue';
    import Section from '../Components/Section.vue';

    import { Head, Link } from '@inertiajs/vue3';
    import Helper from '../Helper';

    defineProps({
        categories: Array,
        orders: Array
    });

</script>

<template>
    <Head>
        <title>Strona Użytkownika | Ars Insolitam</title>
    </Head>
    <Layout :categories="categories">
        <div class="py-4">
            <Section name="Strona Użytkownika">
                <div class="py-4 flex flex-col lg:flex-row-reverse">
                    <article class="w-full lg:w-1/4 lg:ml-auto">
                        <h3
                            class="text-2xl font-bold my-4 text-center"
                        >Opcje</h3>
                        <div class="flex flex-row justify-center">
                            <Link
                                class="py-2 px-4 rounded-lg bg-red-700 text-white transition-colors"
                                href="/user/dashboard/passwd"
                            >Zmień hasło</Link>
                            <Link
                                class="mx-4 py-2 px-4 rounded-lg bg-red-700 text-white transition-colors"
                                href="/user/dashboard/shipping"
                            >Zmień dane adresowe</Link>
                            <Link
                                class="py-2 px-4 rounded-lg bg-red-700 text-white transition-colors"
                                href="/user/dashboard/logout"
                            >Wyloguj</Link>
                        </div>
                    </article>
                    <article class="w-full lg:w-2/3">
                        <h3
                            class="text-2xl font-bold my-4 text-center"
                        >Zamówienia</h3>
                        <div>
                            <div
                                v-for="order in orders"
                                class="flex flex-row justify-between"
                            >
                                <div class="w-1/4">
                                    <h3
                                        class="text-lg font-bold"
                                    >Zamówienie z {{ Helper.localeDateString(order.created_at) }}</h3>
                                    <span class="block">{{ Helper.localeCurrencyString(+order.total) }}</span>
                                    <span class="block italic">{{ order.completed ? 'zrealizowane' : 'niezrealizowane' }}</span>
                                </div>
                                <div class="w-2/3">
                                    <div
                                        v-for="product in order.products"
                                        class="relative w-fit my-2"
                                    >
                                        <Link
                                            :href="`/product/${product.id}`"
                                        >
                                            <img
                                                :src="Helper.imageSrc(product.images[0])"
                                                class="w-20 rounded-lg"
                                            />
                                        </Link>
                                        <span
                                            class="font-bold bg-red-700 px-0.5 rounded-full text-white absolute bottom-1 right-1 block text-center"
                                        >{{ product.pivot.quantity }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </Section>
        </div>
    </Layout>
</template>
