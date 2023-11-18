<script setup>
    import Navbar from './Navbar.vue';

    defineProps({
        categories: Array
    });
</script>

<template>
    <div class="bg-hero-pattern h-screen fixed top-0 left-0 right-0 bottom-0 z-0">

    </div>
    <div class="mx-auto lg:w-3/4 lg:mt-32 min-h-screen bg-white shadow-md relative z-10 flex flex-col rounded-t-lg">
        <Navbar :categories="categories"/>
        <div class="flex-grow">
            <slot/>
        </div>
        <footer class="bg-red-700 text-white px-8 py-4 clear-both">
            <div class="flex flex-row justify-around text-center">
                <div class="grid grid-cols-1 gap-y-2">
                    <h4 class="text-xl mb-2">Witryna</h4>
                    <a class="hover:underline">Polityka prywatności</a>
                    <a class="hover:underline">Polityka cookies</a>
                    <a class="hover:underline">Zasady wykorzystania danych</a>
                    <a class="hover:underline">Regulamin</a>
                </div>
                <div class="grid grid-cols-1 gap-y-2">
                    <h4 class="text-xl mb-2">Zamówienia</h4>
                    <a class="hover:underline">Dostawa</a>
                    <a class="hover:underline">Płatność</a>
                    <a class="hover:underline">Realizacja gwarancji</a>
                    <a class="hover:underline">Zwroty i reklamacje</a>
                </div>
            </div>
            <div class="text-center mt-8">
                <span>Ars Insolitam, &copy;KK i PB 2023&ndash;też 2023</span>
            </div>
        </footer>
    </div>
</template>
