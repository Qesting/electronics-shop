<script setup>

    import Layout from '../Components/Layout.vue';
    import Section from '../Components/Section.vue';

    import { Head, useForm } from '@inertiajs/vue3';
    import { unflatten } from 'flat';
    import { watch, computed } from 'vue';

    const props = defineProps({
        categories: Array,
        shippingData: Object,
        errors: Object
    });

    const shippingDataForm = useForm(props.shippingData);
    const unflattenedErrors = computed(() => unflatten(props.errors));
</script>

<template>
    <Head>
        <title>Dane Adresowe | Ars Insolitam</title>
    </Head>
    <Layout :categories="categories">
        <div class="py-4">
            <Section name="Dane Adresowe">
                <form
                    @submit.prevent="shippingDataForm.post('/user/dashboard/shipping')"
                    class="flex flex-col justify-between items-center lg:flex-row py-4"
                >
                    <h3
                        class="block text-xl font-bold my-4 text-center"
                    >Dane Do Wysyłki</h3>
                    <article
                        class="grid grid-cols-2 gap-y-2 w-full"
                    >
                        <label
                            for="first-name"
                            class="self-end pb-1"
                        >Imię<span class="text-red-700">*</span></label>
                        <div class="w-full">
                            <span class="error-msg !text-left" v-if="unflattenedErrors?.firstName">{{ unflattenedErrors?.firstName }}</span>
                            <input
                                class="p-1 border border-current rounded-lg w-full"
                                id="first-name"
                                type="text"
                                v-model="shippingDataForm.firstName"
                            />
                        </div>
                        <label
                            for="last-name"
                            class="self-end pb-1"
                        >Nazwisko<span class="text-red-700">*</span></label>
                        <div class="w-full">
                            <span class="error-msg !text-left" v-if="unflattenedErrors?.lastName">{{ unflattenedErrors?.lastName }}</span>
                            <input
                                class="p-1 border border-current rounded-lg w-full"
                                id="last-name"
                                type="text"
                                v-model="shippingDataForm.lastName"
                            />
                        </div>
                        <label
                            for="email-address"
                            class="self-end pb-1"
                        >Adres e-mail<span class="text-red-700">*</span></label>
                        <div class="w-full">
                            <span class="error-msg !text-left" v-if="unflattenedErrors?.emailAddress">{{ unflattenedErrors?.emailAddress}}</span>
                            <input
                                class="p-1 border border-current rounded-lg w-full"
                                id="email-address"
                                type="email"
                                v-model="shippingDataForm.emailAddress"
                            />
                        </div>
                        <label
                            for="phone-number"
                            class="self-end pb-1"
                        >Numer telefonu</label>
                        <div class="w-full">
                            <span class="error-msg !text-left" v-if="unflattenedErrors?.phoneNumber">{{ unflattenedErrors?.phoneNumber }}</span>
                            <input
                                class="p-1 border border-current rounded-lg w-full"
                                id="phone-number"
                                type="tel"
                                v-model="shippingDataForm.phoneNumber"
                            />
                        </div>

                        <label
                            for="country"
                            class="self-end pb-1"
                        >Państwo<span class="text-red-700">*</span></label>
                        <div class="w-full">
                            <span class="error-msg !text-left" v-if="unflattenedErrors?.address?.country">{{ unflattenedErrors?.address?.country }}</span>
                            <input
                                class="p-1 border border-current rounded-lg w-full"
                                id="country"
                                type="text"
                                v-model="shippingDataForm.address.country"
                            />
                        </div>
                        <label
                            for="city"
                            class="self-end pb-1"
                        >Miasto<span class="text-red-700">*</span></label>
                        <div class="w-full">
                            <span class="error-msg !text-left" v-if="unflattenedErrors?.address?.city">{{ unflattenedErrors?.address?.city }}</span>
                            <input
                                class="p-1 border border-current rounded-lg w-full"
                                id="city"
                                type="text"
                                v-model="shippingDataForm.address.city"
                            />
                        </div>
                        <label
                            for="postal-code"
                            class="self-end pb-1"
                        >Kod pocztowy<span class="text-red-700">*</span></label>
                        <div class="w-full">
                            <span class="error-msg !text-left" v-if="unflattenedErrors?.address?.postalCode">{{ unflattenedErrors?.address?.postalCode }}</span>
                            <input
                                class="p-1 border border-current rounded-lg w-full"
                                id="postal-code"
                                type="text"
                                v-model="shippingDataForm.address.postalCode"
                            />
                        </div>
                        <label
                            for="street"
                            class="self-end pb-1"
                        >Ulica<span class="text-red-700">*</span></label>
                        <div class="w-full">
                            <span class="error-msg !text-left" v-if="unflattenedErrors?.address?.street">{{ unflattenedErrors?.address?.street }}</span>
                            <input
                                class="p-1 border border-current rounded-lg w-full"
                                id="street"
                                type="text"
                                v-model="shippingDataForm.address.street"
                            />
                        </div>
                        <label
                            for="building"
                            class="self-end pb-1"
                        >Nr budynku<span class="text-red-700">*</span></label>
                        <div class="w-full">
                            <span class="error-msg !text-left" v-if="unflattenedErrors?.address?.building">{{ unflattenedErrors?.address?.building }}</span>
                            <input
                                class="p-1 border border-current rounded-lg w-full"
                                id="building"
                                type="text"
                                inputmode="numeric"
                                v-model="shippingDataForm.address.building"
                            />
                        </div>
                        <label
                            for="apartment"
                            class="self-end pb-1"
                        >Nr lokalu</label>
                        <div class="w-full">
                            <span class="error-msg !text-left" v-if="unflattenedErrors?.address?.apartment">{{ unflattenedErrors?.address?.apartment }}</span>
                            <input
                                class="p-1 border border-current rounded-lg w-full"
                                id="apartment"
                                type="text"
                                inputmode="numeric"
                                v-model="shippingDataForm.address.apartment"
                            />
                        </div>
                    </article>
                    <button
                        class="inline-block py-2 px-4 bg-red-700 text-white rounded-lg hover:bg-red-800 transition-colors duration-300 mt-4 w-fit"
                    >Zatwierdź</button>
                </form>
            </Section>
        </div>
    </Layout>
</template>
