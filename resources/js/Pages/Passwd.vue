<script setup>

    import { computed } from '@vue/reactivity';

    import Layout from '../Components/Layout.vue';
    import Section from '../Components/Section.vue';

    import { Head, useForm } from '@inertiajs/vue3';

    import { unflatten } from 'flat';

    const props = defineProps({
        categories: Array,
        orders: Array,
        errors: Object
    });

    const form = useForm({
        password: '',
        newPassword: ''
    });
    const unflattenedErrors = computed(() => unflatten(props.errors));
</script>

<template>
    <Head>
        <title>Zmiana Hasła | Ars Insolitam</title>
    </Head>
    <Layout :categories="categories">
        <div class="py-4">
            <Section name="Zmiana Hasła">
                <form
                    class="py-4 flex flex-col items-center"
                    @submit.prevent="form.post('/user/dashboard/passwd')"
                >
                    <div>
                        <span class="error-msg" v-if="unflattenedErrors?.password">{{ unflattenedErrors?.password }}</span>
                        <label>
                            <span class="block">Hasło</span>
                            <input
                                type="password"
                                class="p-1 border border-current rounded-lg w-80"
                                v-model="form.password"
                            />
                        </label>
                    </div>
                    <div>
                        <span class="error-msg" v-if="unflattenedErrors?.newPassword">{{ unflattenedErrors?.newPassword }}</span>
                        <label>
                            <span class="block">Nowe hasło</span>
                            <input
                                type="password"
                                class="p-1 border border-current rounded-lg w-80"
                                v-model="form.newPassword"
                            />
                        </label>
                    </div>
                    <button
                        class="inline-block py-2 px-4 bg-red-700 text-white rounded-lg hover:bg-red-800 transition-colors duration-300 mt-4 w-fit"
                    >Zatwierdź</button>
                </form>
            </Section>
        </div>
    </Layout>
</template>
