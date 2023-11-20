<script setup>

    import { Link, Head } from '@inertiajs/vue3';

    import Layout from '../Components/Layout.vue';
    import Section from '../Components/Section.vue';

    import Helper from '../Helper';

    const props = defineProps({
        categories: Array,
        products: Array,
        customerData: Object,
        orderMethods: Object,
        discountCode: Object
    });

    const totalPrice = props.products.map(product => +(product?.sales[0]?.pivot?.price ?? product.price) * product.quantity).reduce((accumulator, value) => accumulator + value);
</script>

<template>
    <Head>
        <title>Podsumowanie Zamówienia | Ars Insolitam</title>
    </Head>
    <Layout :categories="categories">
        <div class="py-4">
            <Section name="Podsumowanie zamówienia">
            <div class="lg:flex flex-row justify-between py-4">
                <div class="basis-3/5">
                    <article>
                        <h3 class="py-4">
                            <span class="text-lg font-bold">Produkty</span>
                            <Link href="/cart" class="ml-2 underline hover:text-red-700 transition-colors duration-300">Edytuj</Link>
                        </h3>
                        <div
                            v-for="product in products"
                            class="flex my-2"
                        >
                            <img
                                :src="Helper.imageSrc(product?.images[0])"
                                class="w-32 rounded-lg"
                            />
                            <div class="flex-grow ml-4">
                                <h4 class="text-lg font-bold">{{ Helper.capitalize(product.name) }}</h4>
                                <span>{{ product.manufacturer.name }}</span>&nbsp;
                                <span v-if="product?.sales[0]?.pivot?.price !== null">
                                    <span class="line-through">{{ Helper.localeCurrencyString(product.price) }}</span>&nbsp;
                                    <span>{{ Helper.localeCurrencyString(+product?.sales[0]?.pivot?.price) }}</span>
                                </span>
                                <span v-else>{{ Helper.localeCurrencyString(product.price) }}</span>
                            </div>
                            <div
                                class="w-24"
                            >
                                <span>{{ product.quantity }}</span>
                                <span class="block">{{ Helper.localeCurrencyString(+(product?.sales[0]?.pivot?.price ?? product.price) * product.quantity) }}</span>
                            </div>
                        </div>
                    </article>
                    <article>
                        <h3 class="py-4">
                            <span class="text-lg font-bold">Dostawa i płatność</span>
                            <Link href="/cart/shippingAndPayment" class="ml-2 underline hover:text-red-700 transition-colors duration-300">Edytuj</Link>
                        </h3>
                        <div>
                            <p>{{ customerData.firstName }} {{ customerData.lastName }}</p>
                            <p>{{ customerData.emailAddress }}</p>
                            <p>{{ customerData?.phoneNumber ?? 'Nie podano numeru telefonu' }}</p>
                            <p>{{ customerData.address.country }}</p>
                            <p>{{ customerData.address.postalCode }} {{ customerData.address.city }}</p>
                            <p>{{ customerData.address.street }} {{ customerData.address.building }}{{ customerData.address?.apartment ? '/' + customerData.address.apartment : '' }}</p>
                        </div>
                    </article>
                </div>
                <article class="basis-1/4">
                    <h3 class="text-lg font-bold py-4">Podsumowanie</h3>
                    <div>
                        <p>Kod promocyjny: {{ discountCode?.code ?? 'brak' }} (&minus;{{ discountCode.discount }}&percnt;)</p>
                        <p
                            v-if="discountCode === null || discountCode?.discount === 0"
                            class="text-xl font-bold"
                        >
                            {{ Helper.localeCurrencyString(totalPrice) }}
                        </p>
                        <p
                            v-else
                            class="text-xl font-bold"
                        >
                            <span class="line-through font-normal">
                                {{ Helper.localeCurrencyString(totalPrice) }}
                            </span>&nbsp;
                            <span>
                                {{ Helper.localeCurrencyString(totalPrice * (1 - (discountCode?.discount / 100))) }}
                            </span>
                        </p>
                        <Link
                            href="/cart/order"
                            class="inline-block py-2 px-4 bg-red-700 text-white rounded-lg hover:bg-red-800 transition-colors duration-300 mt-4 w-fit"
                        >Kupuję i płacę</Link>
                    </div>
                </article>
            </div>
        </Section>
        </div>
    </Layout>
</template>
