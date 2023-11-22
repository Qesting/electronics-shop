<script setup>
    import Layout from '../Components/Layout.vue';
    import RatingStars from '../Components/RatingStars.vue';
    import Section from '../Components/Section.vue';
    import Helper from '../Helper';
    import { Head, Link, useForm } from '@inertiajs/vue3';
    import { ref } from 'vue';

    const props = defineProps({
        categories: Array,
        product: Object,
        loggedIn: Boolean,
        errors: Object
    });

    const selectedImage = ref(props.product.images[0]);
    const form = useForm({
        productId: props.product.id,
        count: 1
    });

    const salePrice =
        props.product?.pivot?.price ??
        props.product?.sales[0]?.pivot?.price ??
        null;

    const reviewForm = useForm({
        rating: null,
        content: null
    });

    const resizeTextarea = event => {
        const area = event.target;
        area.style.height = "";
        area.style.height = `${area.scrollHeight}px`;
    };
</script>

<template>
    <Layout :categories="categories">
        <Head>
            <title>{{ Helper.capitalize(product.name) }} | Ars Insolitam</title>
            <meta name="description" :content="product.name + ' w Ars Insolitam.'"/>
        </Head>
        <main class="py-4">
            <Link
                class="capitalize ml-8 hover:underline"
                :href="`/category/${product.category.id}`"
            ><span class="bi-arrow-left"></span> {{ product.category.name }}</Link>
            <Section class="flex justify-between px-8 mx-auto lg:w-4/5 py-4" :name="Helper.capitalize(product.name)">
                <article class="flex flex-row w-3/5">
                    <div class="w-4/5 p-2">
                        <img
                            :src="Helper.imageSrc(selectedImage)"
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
                                :src="Helper.imageSrc(image)"
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
                        <h3
                            v-if="salePrice === null"
                            class="text-2xl"
                        >{{ Helper.localeCurrencyString(product.price) }}</h3>
                        <h3
                            v-else
                            class="text-2xl"
                        >
                            <span class="line-through">{{ Helper.localeCurrencyString(product.price) }}</span>&nbsp;
                            <span>{{ Helper.localeCurrencyString(+salePrice) }}</span>
                        </h3>
                        <span>{{ product.number_in_stock }} w magazynie</span>
                        <div class="flex items-center justify-end mt-4">
                            <input type="number" min="1" :max="product.number_in_stock" inputmode="numeric" v-model="form.count" class="w-14 mr-2 p-2 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-300 flex-grow"/>
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
                    <span class="rounded-lg bg-gray-200 dark:bg-gray-700 p-2 capitalize">{{ property.name }}</span>
                    <span class="rounded-lg bg-gray-200 dark:bg-gray-700 p-2 text-right">{{ property.value }}{{ property?.unit }}</span>
                </template>
                <span class="rounded-lg bg-gray-200 dark:bg-gray-700 p-2 capitalize">okres gwarancyjny</span>
                <span class="rounded-lg bg-gray-200 dark:bg-gray-700 p-2 text-right">{{ product.warranty_period }} mies.</span>
            </Section>
            <Section name="Opinie" class="py-4">
                <article v-if="loggedIn" class="py-2">
                    <h2
                        class="text-2xl mb-4 font-bold text-center"
                    >Twoja Opinia</h2>
                    <form
                        @submit.prevent="reviewForm.post(`/product/${product.id}/review`, {preserveState: false, preserveScroll: true})"
                        class="flex flex-row justify-between items-start"
                    >
                        <label class="w-1/5">
                            <span class="error-msg" v-if="errors?.rating">{{ errors?.rating }}</span>
                            <span>Ocena</span>
                            <span class="block text-red-700 text-xl">
                                <span
                                    v-for="index in 5"
                                    :class="[index <= reviewForm.rating ? 'bi-star-fill' : 'bi-star']"
                                    class="cursor-pointer"
                                    @click="reviewForm.rating = index"
                                ></span>
                            </span>
                        </label>
                        <label class="w-3/4 flex-shrink">
                            <span class="error-msg" v-if="errors?.content">{{ errors?.content }}</span>
                            <span>Treść</span>
                            <textarea
                                class="block w-full p-2 border border-current rounded-lg resize-none overflow-hidden"
                                v-model="reviewForm.content"
                                @input="resizeTextarea"
                            ></textarea>
                        </label>
                        <button
                            class="ml-4 self-center inline-block py-2 px-4 bg-red-700 text-white rounded-lg hover:bg-red-800 transition-colors duration-300 mt-4 w-fit"
                        >Zapisz</button>
                    </form>
                </article>
                <article>
                    <div
                        v-for="review in product.reviews"
                        class="flex flex-row py-2 justify-between"
                    >
                        <div class="w-1/5">
                            <h3>
                                <span class="text-xl font-bold block">
                                    {{ Helper.fullName(review.user.customer) }}
                                </span>
                                <span>
                                    {{ Helper.localeDateString(review.created_at) }}
                                </span>
                            </h3>
                            <RatingStars :rating="review.rating"/>
                        </div>
                        <p class="w-3/4">
                            {{ review.content }}
                        </p>
                    </div>
                </article>
            </Section>
        </main>
    </Layout>
</template>
