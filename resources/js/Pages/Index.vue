<script setup>
    import { Head } from '@inertiajs/vue3';

    import Layout from '../Components/Layout.vue';
    import IndexSection from '../Components/Section.vue';
    import Product from '../Components/Product.vue';
    import SaleThumbnail from '../Components/SaleThumbnail.vue';

    defineProps({
        categories: Array,
        newProducts: Array,
        sales: {
            type: Array,
            default: []
        }
    });
</script>

<template>
    <Head>
        <title>Sklep z elektroniką Ars Insolitam</title>
        <meta name="description" content="Jak wyżej."/>
    </Head>

    <Layout :categories="categories">
       <main>
            <IndexSection name="Nowości">
                <div class="grid grid-cols-4 lg:grid-cols-5 py-2 gap-y-2">
                    <Product v-for="product in newProducts" :key="product.id" :product="product"/>
                </div>
            </IndexSection>
            <IndexSection name="Promocje">
                <div
                    v-if="sales.length"
                    class="grid grid-cols-4 py-2 gap-y-2"
                >
                    <SaleThumbnail v-for="sale in sales" :key="sale?.id" :sale="sale"/>
                </div>
                <h3
                    v-else
                    class="text-2xl text-center py-4"
                >Niestety aktualnie nie mamy żadnych promocji.</h3>
            </IndexSection>
            <IndexSection name="O nas" omitTrailingLine>
                <div class="py-4 px-4 grid grid-cols-1 gap-y-2">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec elementum quam quis erat tempus luctus. Etiam tempus tortor ut sapien malesuada malesuada. Aliquam erat volutpat. Proin aliquam justo quis quam ultrices bibendum. Sed hendrerit nisl sed libero finibus, at varius lorem placerat. Proin mollis commodo nisl, nec rhoncus felis ullamcorper a. Curabitur in mi id mauris sagittis ornare a at nunc. Sed tempus neque ipsum, a placerat nisl aliquet nec. Nullam maximus purus at dolor maximus viverra. Mauris venenatis purus tortor. Suspendisse eu elementum sapien. Donec eget venenatis justo, quis cursus justo. Donec rhoncus sodales pellentesque. Sed ac tristique lacus.</p>
                    <p>Cras lobortis, velit in sodales tincidunt, justo ante placerat leo, ut rhoncus enim mi in lectus. Suspendisse quis placerat leo. Fusce vehicula, neque rutrum imperdiet interdum, nulla mi congue velit, et imperdiet purus massa nec nunc. Suspendisse dignissim ipsum velit, vel posuere nibh commodo vestibulum. Nunc vitae odio quis metus elementum bibendum. Ut pharetra dolor id urna varius condimentum. Praesent vitae diam dictum, aliquet dolor id, feugiat leo. Sed libero nisl, ultricies a magna ac, finibus vestibulum ante. Nam bibendum ante ut ipsum placerat, ut ultricies orci cursus. Vestibulum rhoncus et orci in varius. Aliquam nec dignissim ipsum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque pharetra sagittis diam, sed tincidunt orci gravida nec. Pellentesque leo est, efficitur quis nibh in, convallis interdum ipsum. Quisque lobortis, ipsum id sodales varius, sem magna pellentesque nibh, ut posuere magna tortor vel nisl. Maecenas id tempus nisl, id accumsan odio.</p>
                    <p>Maecenas facilisis eros nec justo sollicitudin, in suscipit nulla maximus. In aliquet lorem eget tempus hendrerit. Quisque quis augue pharetra, mollis magna vitae, aliquet ligula. Duis sed magna dolor. Etiam nec ipsum sagittis, rutrum velit nec, eleifend purus. Curabitur nunc urna, volutpat ut ipsum a, ultrices accumsan diam. Etiam ut eros eget lorem venenatis tristique et quis nisl. Duis posuere tempor odio non posuere. Duis convallis risus sit amet pulvinar ultrices. Sed id aliquet nulla, ac suscipit sapien. Etiam sit amet velit sit amet libero feugiat ultrices. Quisque faucibus elit quis erat fringilla fermentum. Praesent in eleifend magna, nec bibendum nulla.</p>
                    <p>Tak.</p>
                </div>
            </IndexSection>
       </main>
    </Layout>
</template>
