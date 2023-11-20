<script setup>

    import { ref } from 'vue';
    import { Head, useForm, Link } from '@inertiajs/vue3';
    import Helper from '../Helper';

    import Layout from "../Components/Layout.vue";
    import Section from '../Components/Section.vue';

    const props = defineProps({
        categories: Array,
        products: Array,
        notLoggedIn: Boolean,
        shippingMethods: Array,
        paymentMethods: Array,
        customerData: Object,
        orderMethods: Object
    });

    const loggedInScreen = ref(
        props.notLoggedIn &&
        props.orderMethods === null
    );
    const customerData = Object.keys(props.customerData).length !== 0
        ? props.customerData
        : {address: {}};
    const checkoutForm = useForm({
        shippingData: customerData,
        shippingMethod: props.orderMethods?.shippingMethod?.id,
        paymentMethod: props.orderMethods?.paymentMethod?.id
    });
</script>

<template>
    <Head>
        <title>Dostawa i Płatność | Ars Insolitam</title>
    </Head>
    <Layout :categories="categories">
        <div class="fixed top-0 left-0 right-0 bottom-0 z-40 bg-white" v-show="loggedInScreen">
            <h2 class="text-3xl font-bold my-4 text-center relative py-4">
                <span>Zanim Zamówisz</span>
                <span class="block w-full h-0.5 absolute bottom-0 left-0 right-0 bg-gradient-to-r from-white via-red-700 to-white"></span>
            </h2>
            <div class="grid grid-cols-2 px-4 gap-x-4 h-2/5">
                <article class="p-4 border border-current rounded-lg h-full text-center flex flex-col items-center">
                    <h3 class="mb-8 text-2xl text-center font-bold">Masz już konto w Ars Insolitam?</h3>
                    <p>Z kontem otrzymujesz dostęp do wygodnej historii zamówień w jednym miejscu.</p>
                    <div class="mt-auto">
                        <Link
                            href="/user/login"
                            class="mr-4 underline hover:!text-red-700 transition-colors duration-300"
                        >Zaloguj się</Link>
                        <Link
                            href="/user/register"
                            class="underline hover:!text-red-700 transition-colors duration-300"
                        >Zarejestruj się</Link>
                    </div>
                </article>
                <article class="p-4 border border-current rounded-lg h-full text-center flex flex-col items-center">
                    <h3 class="mb-8 text-2xl text-center font-bold">Nie chcesz się rejestrować?</h3>
                    <p>Rozumiemy.</p>
                    <button
                        @click="loggedInScreen = false"
                        class="mt-auto underline hover:!text-red-700 transition-colors duration-300"
                        >Przejdź dalej</button>
                </article>
            </div>
        </div>
        <div class="my-4" :class="{'overflow-hidden': loggedInScreen, 'h-0': loggedInScreen}">
            <Section name="Dostawa i Płatność">
                <form
                    @submit.prevent="checkoutForm.post('/cart/checkout')"
                    class="flex flex-col justify-between lg:flex-row py-4"
                >
                    <div class="w-full lg:w-3/5">
                        <h3
                            class="block text-xl font-bold my-4 text-center"
                        >Dane Do Wysyłki</h3>
                        <article
                            class="grid grid-cols-2 gap-y-2"
                        >
                            <label
                                for="first-name"
                            >Imię<span class="text-red-700">*</span></label>
                            <input
                                class="p-1 border border-current rounded-lg"
                                id="first-name"
                                type="text"
                                v-model="checkoutForm.shippingData.firstName"
                            />
                            <label
                                for="last-name"
                            >Nazwisko<span class="text-red-700">*</span></label>
                            <input
                                class="p-1 border border-current rounded-lg"
                                id="last-name"
                                type="text"
                                v-model="checkoutForm.shippingData.lastName"
                            />
                            <label
                                for="email-address"
                            >Adres e-mail<span class="text-red-700">*</span></label>
                            <input
                                class="p-1 border border-current rounded-lg"
                                id="email-address"
                                type="email"
                                v-model="checkoutForm.shippingData.emailAddress"
                            />
                            <label
                                for="phone-number"
                            >Numer telefonu</label>
                            <input
                                class="p-1 border border-current rounded-lg"
                                id="phone-number"
                                type="tel"
                                v-model="checkoutForm.shippingData.phoneNumber"
                            />

                            <label
                                for="country"
                            >Państwo<span class="text-red-700">*</span></label>
                            <input
                                class="p-1 border border-current rounded-lg"
                                id="country"
                                type="text"
                                v-model="checkoutForm.shippingData.address.country"
                            />
                            <label
                                for="city"
                            >Miasto<span class="text-red-700">*</span></label>
                            <input
                                class="p-1 border border-current rounded-lg"
                                id="city"
                                type="text"
                                v-model="checkoutForm.shippingData.address.city"
                            />
                            <label
                                for="postal-code"
                            >Kod pocztowy<span class="text-red-700">*</span></label>
                            <input
                                class="p-1 border border-current rounded-lg"
                                id="postal-code"
                                type="text"
                                v-model="checkoutForm.shippingData.address.postalCode"
                            />
                            <label
                                for="street"
                            >Ulica<span class="text-red-700">*</span></label>
                            <input
                                class="p-1 border border-current rounded-lg"
                                id="street"
                                type="text"
                                v-model="checkoutForm.shippingData.address.street"
                            />
                            <label
                                for="building"
                            >Nr budynku<span class="text-red-700">*</span></label>
                            <input
                                class="p-1 border border-current rounded-lg"
                                id="building"
                                type="text"
                                inputmode="numeric"
                                v-model="checkoutForm.shippingData.address.building"
                            />
                            <label
                                for="apartment"
                            >Nr lokalu</label>
                            <input
                                class="p-1 border border-current rounded-lg"
                                id="apartment"
                                type="text"
                                inputmode="numeric"
                                v-model="checkoutForm.shippingData.address.apartment"
                            />
                        </article>
                    </div>
                    <div class="w-full lg:w-1/3 flex flex-col items-center">
                        <h3
                            class="block text-xl font-bold my-4 text-center"
                        >Metoda Wysyłki</h3>
                        <article class="grid grid-cols-4 lg:grid-cols-2 gap-2 w-full">
                            <div
                                v-for="method in shippingMethods"
                                @click="checkoutForm.shippingMethod = method.id"
                                class="hover:cursor-pointer border border-current p-2 rounded-lg transition-colors duration-300"
                                :class="{'border-red-700': checkoutForm.shippingMethod === method.id}"
                            >
                                <h4 class="text-lg">{{ method.name }} <span class="italic">+{{ Helper.localeCurrencyString(+method.fee) }}</span></h4>
                                <span class="block">{{ method.min_days }}-{{ method.max_days }} dni roboczych</span>
                                <span class="block italic">{{ method.shipper.name }}</span>
                            </div>
                        </article>
                        <h3
                            class="block text-xl font-bold my-4 text-center"
                        >Metoda Płatności</h3>
                        <article class="grid grid-cols-4 lg:grid-cols-2 gap-2 w-full">
                            <div
                                v-for="method in paymentMethods"
                                @click="checkoutForm.paymentMethod = method.id"
                                class="hover:cursor-pointer border border-current p-2 rounded-lg transition-colors duration-300"
                                :class="{'border-red-700': checkoutForm.paymentMethod === method.id}"
                            >
                                <h4>{{ method.name }}</h4>
                            </div>
                        </article>
                        <button
                            class="inline-block py-2 px-4 bg-red-700 text-white rounded-lg hover:bg-red-800 transition-colors duration-300 mt-4 w-fit"
                        >Zatwierdź</button>
                    </div>
                </form>
            </Section>
        </div>
    </Layout>
</template>
