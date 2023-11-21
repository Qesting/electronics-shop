<script setup>

    import { Link } from '@inertiajs/vue3';
    import Helper from '../Helper';

    defineProps({
        sale: {
            type: Object,
            required: true
        }
    });

</script>

<template>
    <div
        class="mx-2 p-2 basis-1/5 lg:basis-1/6 flex-shrink-0 text-center flex flex-col items-center border border-white rounded-lg hover:border-red-700 transition-colors duration-300"
    >
        <img
            :src="Helper.imageSrc(sale.image)"
            alt="ilustracja wyprzedaży"
            class="rounded-lg"
        />
        <Link
            :href="'/sale/' + sale.id"
            class="underline transition-colors duration-300 hover:text-red-700 capitalize"
        >{{ sale.name }}</Link>
        <span><i>Tylko do {{ Helper.localeDateString(sale.expires_at) }}</i></span>
    </div>
</template>
