<script setup>

    import { ref, watch } from 'vue';
    import { Head, useForm, Link } from '@inertiajs/vue3';
    import Helper from '../Helper';
    import { unflatten } from 'flat';

    import Layout from "../Components/Layout.vue";
    import Section from '../Components/Section.vue';

    const props = defineProps({
        categories: Array,
        products: Array,
        notLoggedIn: Boolean,
        shippingMethods: Array,
        paymentMethods: Array,
        customerData: Object,
        orderMethods: Object,
        errors: Object
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

    let unflattenedErrors;
    watch(props, () => {
        unflattenedErrors = unflatten(props.errors);
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
                                class="self-end pb-1"
                            >Imię<span class="text-red-700">*</span></label>
                            <div class="w-full">
                                <span class="error-msg !text-left" v-if="unflattenedErrors?.shippingData?.firstName">{{ unflattenedErrors?.shippingData?.firstName }}</span>
                                <input
                                    class="p-1 border border-current rounded-lg w-full"
                                    id="first-name"
                                    type="text"
                                    v-model="checkoutForm.shippingData.firstName"
                                />
                            </div>
                            <label
                                for="last-name"
                                class="self-end pb-1"
                            >Nazwisko<span class="text-red-700">*</span></label>
                            <div class="w-full">
                                <span class="error-msg !text-left" v-if="unflattenedErrors?.shippingData?.lastName">{{ unflattenedErrors?.shippingData?.lastName }}</span>
                                <input
                                    class="p-1 border border-current rounded-lg w-full"
                                    id="last-name"
                                    type="text"
                                    v-model="checkoutForm.shippingData.lastName"
                                />
                            </div>
                            <label
                                for="email-address"
                                class="self-end pb-1"
                            >Adres e-mail<span class="text-red-700">*</span></label>
                            <div class="w-full">
                                <span class="error-msg !text-left" v-if="unflattenedErrors?.shippingData?.emailAddress">{{ unflattenedErrors?.shippingData?.emailAddress}}</span>
                                <input
                                    class="p-1 border border-current rounded-lg w-full"
                                    id="email-address"
                                    type="email"
                                    v-model="checkoutForm.shippingData.emailAddress"
                                />
                            </div>
                            <label
                                for="phone-number"
                                class="self-end pb-1"
                            >Numer telefonu</label>
                            <div class="w-full">
                                <span class="error-msg !text-left" v-if="unflattenedErrors?.shippingData?.phoneNumber">{{ unflattenedErrors?.shippingData?.phoneNumber }}</span>
                                <input
                                    class="p-1 border border-current rounded-lg w-full"
                                    id="phone-number"
                                    type="tel"
                                    v-model="checkoutForm.shippingData.phoneNumber"
                                />
                            </div>

                            <label
                                for="country"
                                class="self-end pb-1"
                            >Państwo<span class="text-red-700">*</span></label>
                            <div class="w-full">
                                <span class="error-msg !text-left" v-if="unflattenedErrors?.shippingData?.address?.country">{{ unflattenedErrors?.shippingData?.address?.country }}</span>
                                <input
                                    class="p-1 border border-current rounded-lg w-full"
                                    id="country"
                                    type="text"
                                    v-model="checkoutForm.shippingData.address.country"
                                />
                            </div>
                            <label
                                for="city"
                                class="self-end pb-1"
                            >Miasto<span class="text-red-700">*</span></label>
                            <div class="w-full">
                                <span class="error-msg !text-left" v-if="unflattenedErrors?.shippingData?.address?.city">{{ unflattenedErrors?.shippingData?.address?.city }}</span>
                                <input
                                    class="p-1 border border-current rounded-lg w-full"
                                    id="city"
                                    type="text"
                                    v-model="checkoutForm.shippingData.address.city"
                                />
                            </div>
                            <label
                                for="postal-code"
                                class="self-end pb-1"
                            >Kod pocztowy<span class="text-red-700">*</span></label>
                            <div class="w-full">
                                <span class="error-msg !text-left" v-if="unflattenedErrors?.shippingData?.address?.postalCode">{{ unflattenedErrors?.shippingData?.address?.postalCode }}</span>
                                <input
                                    class="p-1 border border-current rounded-lg w-full"
                                    id="postal-code"
                                    type="text"
                                    v-model="checkoutForm.shippingData.address.postalCode"
                                />
                            </div>
                            <label
                                for="street"
                                class="self-end pb-1"
                            >Ulica<span class="text-red-700">*</span></label>
                            <div class="w-full">
                                <span class="error-msg !text-left" v-if="unflattenedErrors?.shippingData?.address?.street">{{ unflattenedErrors?.shippingData?.address?.street }}</span>
                                <input
                                    class="p-1 border border-current rounded-lg w-full"
                                    id="street"
                                    type="text"
                                    v-model="checkoutForm.shippingData.address.street"
                                />
                            </div>
                            <label
                                for="building"
                                class="self-end pb-1"
                            >Nr budynku<span class="text-red-700">*</span></label>
                            <div class="w-full">
                                <span class="error-msg !text-left" v-if="unflattenedErrors?.shippingData?.address?.building">{{ unflattenedErrors?.shippingData?.address?.building }}</span>
                                <input
                                    class="p-1 border border-current rounded-lg w-full"
                                    id="building"
                                    type="text"
                                    inputmode="numeric"
                                    v-model="checkoutForm.shippingData.address.building"
                                />
                            </div>
                            <label
                                for="apartment"
                                class="self-end pb-1"
                            >Nr lokalu</label>
                            <div class="w-full">
                                <span class="error-msg !text-left" v-if="unflattenedErrors?.shippingData?.address?.apartment">{{ unflattenedErrors?.shippingData?.address?.apartment }}</span>
                                <input
                                    class="p-1 border border-current rounded-lg w-full"
                                    id="apartment"
                                    type="text"
                                    inputmode="numeric"
                                    v-model="checkoutForm.shippingData.address.apartment"
                                />
                            </div>
                        </article>
                    </div>
                    <div class="w-full lg:w-1/3 flex flex-col items-center">
                        <h3
                            class="block text-xl font-bold my-4 text-center"
                        >Metoda Wysyłki</h3>
                        <span class="error-msg" v-if="unflattenedErrors?.shippingMethod">{{ unflattenedErrors?.shippingMethod }}</span>
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
                        <span class="error-msg" v-if="unflattenedErrors?.paymentMethod">{{ unflattenedErrors?.paymentMethod }}</span>
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
