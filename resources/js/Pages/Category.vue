<script setup>
    import { ref, reactive, computed } from 'vue';
    import { Link } from '@inertiajs/vue3';

    import Layout from "./../Components/Layout.vue";
    import Product from './../Components/Product.vue';

    const props = defineProps({
        categories: Array,
        category: Object,
        properties: Object,
        products: Array
    });

    const emptyFilters = {};
    Object.keys(props.properties).forEach(key => {
        emptyFilters[key] = props.properties[key].type === 'value' ? {} : []
    });

    const filterSidebarExpanded = ref(false);
    const filterValues = reactive(emptyFilters);
    const linkWithFilters = computed(() => {
        const finalFilters = {};
        Object.keys(filterValues).forEach(key => {
            const filter = filterValues[key];
            if (Object.keys(filter)?.length) {
                finalFilters[key] = filter;
            }
        });
        return `./${JSON.stringify(finalFilters)}`;
    });

    const sliderValue = (event, property, key) => {
        if (!filterValues[property]) {
            filterValues[property] = {};
        }
        const value = +event.target.value;
        if (value > +event.target.max) {
            filterValues[property][key] = event.target.max;
            event.target.value = event.target.max
        } else if (value < +event.target.min) {
            filterValues[property][key] = event.target.min;
            event.target.value = event.target.min
        } else {
            filterValues[property][key] = value;
        }
    };

    const enter = element => {
        const height = getComputedStyle(element).height;
        element.style.height = height;
        element.style.position = 'absolute';
        element.style.visibility = 'hidden';
        element.style.width = 'auto';

        const width = getComputedStyle(element).width;
        element.style.height = null;
        element.style.position = null;
        element.style.visibility = null;
        element.style.width = 0;

        getComputedStyle(element).width;

        requestAnimationFrame(() => {
            element.style.width = width;
        });
    };

    const afterEnter = element => {
        element.style.width = 'auto';
    };

    const leave = element => {
        const width = getComputedStyle(element).width;
        element.style.width = width;

        getComputedStyle(element).width;

        requestAnimationFrame(() => {
            element.style.width = 0;
        });
    };
</script>

<template>
    <Layout :categories="categories">
        <Transition
            name="expand"
            :duration="300"
            @enter="enter"
            @afterEnter="afterEnter"
            @leave="leave"
        >
            <aside
                v-show="filterSidebarExpanded"
                class="fixed top-0 bottom-0 left-0 w-0 h-screen bg-white z-30 overflow-hidden transition-[width] duration-300 lg:w-min-1/5 lg:!w-1/5 lg:relative lg:!block lg:float-left lg:h-auto"
            >
                <h2
                    class="text-3xl capitalize text-center mb-4 py-8 font-bold relative w-screen lg:w-full"
                >
                    <span>Filtry</span>
                    <span class="block w-full h-0.5 absolute bottom-0 left-0 right-0 bg-gradient-to-r from-white via-red-700 to-white"></span>
                </h2>
                <form
                    class="w-screen lg:w-full px-2 h-full overflow-auto lg:overflow-visible"
                >
                    <article
                        v-for="key in Object.keys(properties)"
                        class="my-2"
                    >
                        <span
                            class="block text-center font-bold"
                        >
                            <span class="capitalize">{{ properties[key].name }}</span>&nbsp;
                            <span v-if="properties[key].unit">({{ properties[key].unit }})</span>
                        </span>
                        <div
                            class="flex flex-row justify-between w-full mx-auto lg:w-full px-8 sm:w-3/4 md:w-1/2 md:px-2"
                            :class="{'flex-col': properties[key].type !== 'value'}"
                        >
                            <template v-if="properties[key].type === 'value'">
                                <input
                                    @change="event => sliderValue(event, key, 'min')"
                                    inputmode="numeric"
                                    :min="properties[key].min"
                                    :max="filterValues[properties[key].name]?.max < properties[key].max ? filterValues[properties[key].name]?.max : properties[key].max"
                                    :step="1/properties[key].step"
                                    :placeholder="properties[key].min"
                                    class="w-10"
                                />
                                <span>&ndash;</span>
                                <input
                                    @change="event => sliderValue(event, key, 'max')"
                                    inputmode="numeric"
                                    :min="filterValues[properties[key].name]?.min > properties[key].min ? filterValues[properties[key].name]?.min : properties[key].min"
                                    :max="properties[key].max"
                                    :step="1/properties[key].step"
                                    :placeholder="properties[key].max"
                                    class="w-10"
                                />
                            </template>
                            <template v-else>
                                <label v-for="choice in properties[key].choices">
                                    <input v-model="filterValues[key]" type="checkbox" :name="key+'[]'" :value="choice"/>
                                    {{ choice }}
                                </label>
                            </template>
                        </div>
                    </article>
                    <div
                        class="w-full mx-auto lg:w-full px-8 sm:w-3/4 md:w-1/2 md:px-2"
                    >
                        <button
                            @click="Object.keys(filterValues).forEach(key => delete filterValues[key])"
                            type="reset"
                            class="block w-32 mx-auto text-center py-2 px-4 text-white bg-gray-800 rounded-lg my-2 transition-colors duration-300 hover:bg-gray-900"
                        ><span class="bi-arrow-clockwise"></span> Wyczyść</button>
                        <Link
                            :href="linkWithFilters"
                            preserve-state
                            class="block w-32 mx-auto text-center py-2 px-4 text-white bg-red-700 rounded-lg my-2 transition-colors duration-300 hover:bg-red-800"
                        ><span class="bi-check-lg"></span> Zastosuj</Link>
                    </div>
                </form>
            </aside>
        </Transition>
        <main
            class="lg:w-4/5 lg:float-left mb-4"
        >
            <h2
                class="text-3xl capitalize text-center mb-4 py-8 font-bold relative"
            >
                <span>{{ category.name }}</span>
                <span class="block w-full h-0.5 absolute bottom-0 left-0 right-0 bg-gradient-to-r from-white via-red-700 to-white"></span>
            </h2>
            <div class="grid grid-cols-4">
                <Product v-for="product in products" :key="product.id" :product="product"/>
            </div>
        </main>
        <button
            @click="filterSidebarExpanded = !filterSidebarExpanded"
            type="button"
            class="fixed z-40 bottom-2 left-2 lg:hidden bg-red-700 text-white text-2xl w-10 h-10 text-center rounded-full p-0.5 hover:bg-red-800 transition-colors duration-300"
        >
            <span
                class="bi-caret-right-fill block absolute top-0 bottom-0 left-0 right-0 m-auto w-fit h-fit transition-transform duration-300"
                :class="{'rotate-180': filterSidebarExpanded}"
            ></span>
        </button>
    </Layout>
</template>
