<script setup>

    import Layout from '../Components/Layout.vue';
    import Section from '../Components/Section.vue';

    import { Head, useForm, Link } from '@inertiajs/vue3';

    defineProps({
        categories: Array,
        errors: Object
    });

    const registerForm = useForm({
        emailAddress: null,
        password: null,
        repeatPassword: null
    });

</script>

<template>
    <Head>
        <title>Rejestracja | Ars Insolitam</title>
    </Head>
    <Layout :categories="categories">
        <div class="py-4">
            <Section name="Rejestracja">
                <form
                    @submit.prevent="registerForm.post('/user/register')"
                    class="py-4 flex flex-col items-center"
                >
                <label>
                    <span>Adres e-mail</span>
                    <input
                        type="email"
                        class="w-80 block p-1 border border-current rounded-lg"
                        v-model="registerForm.emailAddress"
                        />
                    </label>
                    <span class="error-msg" v-if="errors?.emailAddress">{{ errors?.emailAddress }}</span>

                    <label>
                        <span>Hasło</span>
                        <input
                            type="password"
                            class="w-80 block p-1 border border-current rounded-lg"
                            v-model="registerForm.password"
                        />
                    </label>
                    <span class="error-msg" v-if="errors?.password">{{ errors?.password }}</span>
                    <label>
                        <span>Powtórz hasło</span>
                        <input
                            type="password"
                            class="w-80 block p-1 border border-current rounded-lg"
                            v-model="registerForm.repeatPassword"
                        />
                    </label>
                    <span class="error-msg" v-if="errors?.repeatPassword">{{ errors?.repeatPassword }}</span>
                    <div class="my-4">
                        Masz już konto?
                        <Link
                            href="/user/login"
                            class="ml-1 underline hover:text-red-700 transition-colors duration-300"
                        >Zaloguj się</Link>
                    </div>
                    <button
                        class="inline-block rounded-lg text-white bg-red-700 p-2 hover:bg-red-800 transition-colors duration-300"
                    >Zarejestruj</button>
                </form>
            </Section>
        </div>
    </Layout>
</template>
