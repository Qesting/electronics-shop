<script setup>

    import Layout from '../Components/Layout.vue';
    import Section from '../Components/Section.vue';
    import Helper from '../Helper';

    import { ref } from '@vue/reactivity';
    import { watch } from 'vue';
    import { useForm } from '@inertiajs/vue3';
    import { Head, Link } from '@inertiajs/vue3';

    const props = defineProps({
        categories: Array,
        products: Array,
        code: Number
    });

    const productQuantities = {};
    props.products.forEach(product => productQuantities[product.id] = {id: product.id, quantity: product.quantity});
    const quantities = useForm(productQuantities);
    const promoCode = useForm({
        code: ''
    })

    const edit = ref(false);
    const showCodeInput = ref(false);

    watch(edit, newEdit => {
        if (newEdit === false && quantities.isDirty) {
            quantities
            .defaults()
            .put('/cart/update', {
                preserveScroll: true,
                preserveState: true
            });
        }
    });

    const checkPromoCode = () => {
        if (promoCode.isDirty) {
            promoCode.post('/cart', {
                preserveScroll: true,
                preserveState: true,
                only: ['code']
            });
        }
    };

    const totalPrice = props.products
        .map(
            product =>  product.price * quantities[product.id].quantity
        ).reduce((accumulator, value) => accumulator + value, 0);
</script>

<template>
    <Layout :categories="categories">
        <Section name="Koszyk" class="my-8 py-4">
            <Head>
                <title>Koszyk | Ars Insolitam</title>
                <meta name="description" content="Strona koszyka."/>
            </Head>

            <div class="flex flex-col-reverse lg:flex-row">
                <div class="flex flex-col w-full lg:w-3/5">
                    <div>
                        <button
                            v-if="edit"
                            @click="edit = !edit"
                            class="py-2 px-4 bg-red-700 text-white rounded-lg hover:bg-red-800 transition-colors duration-300"
                        ><span class="bi-save"></span> Zapisz</button>
                        <button
                            v-else
                            @click="edit = !edit"
                            class="py-2 px-4 bg-red-700 text-white rounded-lg hover:bg-red-800 transition-colors duration-300"
                        ><span class="bi-pencil"></span> Edytuj</button>
                        <button
                            v-if="edit"
                            @click="quantities.reset()"
                            class="ml-4 py-2 px-4 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-colors duration-300"
                        ><span class="bi-arrow-clockwise"></span> Cofnij</button>
                    </div>
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
                            <span>{{ Helper.localeCurrencyString(product.price) }}</span>
                        </div>
                        <div
                            class="w-24"
                        >
                            <template v-if="edit">
                                <input
                                    class="w-12"
                                    type="number"
                                    min="0"
                                    v-model="quantities[product.id].quantity"
                                />
                                <button class="bi-trash " @click="quantities[product.id].quantity = 0"></button>
                            </template>
                            <span v-else>{{ quantities[product.id].quantity }}</span>
                            <span class="block">{{ Helper.localeCurrencyString(product.price * quantities[product.id].quantity) }}</span>
                        </div>
                    </div>
                </div>
                <div class="mb-4 lg:ml-4 lg:mb-0 border border-black rounded-lg p-4 h-fit lg:w-2/5">
                    <label>
                        Mam kod promocyjny&nbsp;
                        <input type="checkbox" v-model="showCodeInput"/>
                    </label>
                    <div v-show="showCodeInput">
                        <input
                            @change="checkPromoCode"
                            type="text"
                            placeholder="Wpisz kod..."
                            v-model="promoCode.code"
                            class="border border-black rounded-md p-1 my-2"
                        />
                        <span v-if="promoCode.isDirty && code === 0" class="bi-x"></span>
                    </div>
                    <p
                        v-if="code === null || code === 0"
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
                            {{ Helper.localeCurrencyString(totalPrice * (1 - (code / 100))) }}
                        </span>
                    </p>
                    <Link
                        href="/cart/checkout"
                        class="inline-block py-2 px-4 bg-red-700 text-white rounded-lg font-bold hover:bg-red-800 transition-colors duration-300"
                    >Przejdź do zamówienia</Link>
                </div>
            </div>
        </Section>
    </Layout>
</template>
