<script setup>

    import Layout from '../Components/Layout.vue';
    import Section from '../Components/Section.vue';

    import { Head, useForm, Link } from '@inertiajs/vue3';

    defineProps({
        categories: Array,
        errors: Object
    });

    const loginForm = useForm({
        emailAddress: null,
        password: null,
        remember: false
    });

</script>

<template>
    <Head>
        <title>Logowanie | Ars Insolitam</title>
    </Head>
    <Layout :categories="categories">
        <div class="py-4">
            <Section name="Logowanie">
                <form
                    @submit.prevent="loginForm.post('/user/login')"
                    class="py-4 flex flex-col items-center"
                >
                    <label>
                        <span>Adres e-mail</span>
                        <input
                            type="email"
                            class="w-80 block p-1 border border-current rounded-lg"
                            v-model="loginForm.emailAddress"
                        />
                    </label>
                    <span class="error-msg" v-if="errors?.emailAddress">{{ errors?.emailAddress }}</span>
                    <label>
                        <span>Hasło</span>
                        <input
                            type="password"
                            class="w-80 block p-1 border border-current rounded-lg"
                            v-model="loginForm.password"
                        />
                    </label>
                    <span class="error-msg" v-if="errors?.password">{{ errors?.password }}</span>
                    <label class="w-80 my-2">
                        <input
                            type="checkbox"
                            v-model="loginForm.remember"
                            class="mr-2"
                        />
                        <span>Zapamiętaj</span>
                    </label>
                    <div class="my-4">
                        Nie masz jeszcze konta?
                        <Link
                            href="/user/register"
                            class="ml-1 underline hover:text-red-700 transition-colors duration-300"
                        >Zarejestruj się</Link>
                    </div>
                    <button
                        class="inline-block rounded-lg text-white bg-red-700 p-2 hover:bg-red-800 transition-colors duration-300"
                    >Zaloguj</button>
                </form>
            </Section>
        </div>
    </Layout>
</template>
