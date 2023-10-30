<script setup>
    const props = defineProps({
        args: Array
    });
</script>

<template>
    <p>Działa</p>
    <table>
        <tbody>
            <tr v-for="arg in args">
                <td v-for="prop in arg">{{ prop }}</td>
            </tr>
        </tbody>
    </table>
</template>