<script setup>
    import { ref } from 'vue';
    import { Link } from '@inertiajs/vue3';
    import Helper from '../Helper';

    const props = defineProps({
        categories: Array
    });

    const expanded = ref(false);
    const selectedCategory = ref(props.categories[0]);

    const menuButtonClick = () => {
        const newExpanded = !expanded.value;
        expanded.value = newExpanded;
        if (newExpanded) {
            selectedCategory.value = props.categories[0];
        }
    };

    const flatten = (object, key) => [object].concat(object[key].map(e => e[key] ? flatten(e, key) : e).flat());

    const enter = element => {
        const width = getComputedStyle(element).width;
        element.style.width = width;
        element.style.position = 'absolute';
        element.style.visibility = 'hidden';
        element.style.height = 'auto';

        const height = getComputedStyle(element).height;
        element.style.width = null;
        element.style.position = null;
        element.style.visibility = null;
        element.style.height = 0;

        getComputedStyle(element).height;

        requestAnimationFrame(() => {
            element.style.height = height;
        });
    };

    const afterEnter = element => {
        element.style.height = 'auto';
    };

    const leave = element => {
        const height = getComputedStyle(element).height;
        element.style.height = height;

        getComputedStyle(element).height;

        requestAnimationFrame(() => {
            element.style.height = 0;
        });
    };
</script>

<template>
    <nav class="border-b-2 border-red-700 lg:border-r top-0 z-40 rounded-t-lg">
        <div class="flex items-center bg-red-700 text-white py-4 px-4 rounded-t-lg">
            <button
                @click="menuButtonClick"
                class="bi-list text-2xl text-center inline-block box-border w-10 h-10 p-0.5 rounded-lg hover:bg-red-800 transition-colors duration-300"
                aria-label="menu kategorii"
            ></button>
            <Link
                href="/"
                class="bi-house-fill text-2xl text-center inline-block box-border w-10 h-10 p-0.5 rounded-lg hover:bg-red-800 transition-colors duration-300"
                aria-label="strona główna"
            ></Link>
            <Link
                href="/cart"
                class="bi-cart-fill text-2xl text-center inline-block box-border w-10 h-10 p-0.5 rounded-lg hover:bg-red-800 transition-colors duration-300"
                aria-label="koszyk"
            ></Link>
            <h1 class="grow text-center text-3xl capitalize font-bold">ars insolitam</h1>
        </div>
        <Transition
            name="expand"
            :duration="300"
            @enter="enter"
            @afterEnter="afterEnter"
            @leave="leave"
        >
            <div
                v-show="expanded"
                class="h-0 overflow-hidden flex flex-row transition-[height] duration-300 bg-white "
            >
                <div class="inline-flex flex-col w-min justify-start items-start bg-red-700 pb-2">
                    <template
                        v-for="category in categories"
                        :key="category.id"
                    >
                        <button
                            v-if="category.children.length"
                            @mouseover="selectedCategory = category"
                            :class="{'bg-red-800' : selectedCategory?.id == category.id}"
                            class="w-40 text-left pl-5 pr-1 py-1 capitalize relative text-white bg-red-700 hover:bg-red-800 active:bg-red-800 focus:bg-red-800 transition-colors duration-300"
                        >
                            <span>{{ category.name }}</span>
                            <span class="bi-caret-right-fill absolute right-1"></span>
                        </button>
                        <Link
                            v-else
                            :href="'/category/' + category.id"
                            class="w-40 text-left pl-5 pr-1 py-1 capitalize relative text-white bg-red-700 hover:bg-red-800 hover:underline active:bg-red-800 focus:bg-red-800 transition-colors duration-300"
                        >
                            <span>{{ category.name }}</span>
                            <span class="bi-caret-right-fill absolute right-1"></span>
                        </Link>
                    </template>
                </div>
                <ul
                    v-for="category in categories"
                    v-show="selectedCategory?.id == category.id"
                    class="flex flex-row flex-wrap w-full my-2 mx-2 items-start"
                >
                    <template
                        v-for="child in flatten(category, 'children').slice(1)"
                    >
                        <li
                            v-if="!(child?.children?.length)"
                            :key="child.id"
                            class="mx-2 p-2 basis-1/4 min-w-fit lg:basis-1/5 border border-white rounded-lg hover:border-red-600 transition-colors duration-300 redden-child-link"
                        >
                            <Link
                                :href="'/category/' + child.id"
                                class="underline capitalize flex flex-col items-center transition-colors duration-300"
                            >
                                <span>{{ child.name }}</span>
                                <img
                                    :src="Helper.imageSrc(child.image)"
                                    alt="ilustracja kategorii"
                                    class="rounded-lg mt-2"
                                />
                            </Link>
                        </li>
                    </template>
                </ul>
            </div>
        </Transition>
    </nav>
</template>
