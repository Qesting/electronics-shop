<script setup>
import { ref } from 'vue';

    const props = defineProps({
        category: {
            type: Object,
            required: true
        },
        children: {
            type: Array,
            required: true,
            default: []
        },
        depth: {
            type: Number,
            required: true,
            default: 0
        }
    });

    const expanded = ref(false);

    const name = (
        () => {
            const nm = props.category.name.split(' ');
            return props.category.ignoreParent ?
                nm[0] :
                nm[nm.length - 1];
        }
    )();
</script>

<template>
    <div v-if="children.length !== 0" class="inline-block basis-1/8 shrink">
        <button @click="expanded = !expanded" class="w-full text-left flex flex-row items-center space-x-1">
            <span :class="[expanded ? 'rotate-180' : 'rotate-90']">
                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M7.022 1.566a1.13 1.13 0 0 1 1.96 0l6.857 11.667c.457.778-.092 1.767-.98 1.767H1.144c-.889 0-1.437-.99-.98-1.767L7.022 1.566z"/>
                </svg>
            </span>
            <span>{{ name }}</span>
        </button>
        <Transition
            name="expand"
            :duration="500"
            @enter="enter"
            @afterEnter="afterEnter"
            @leave="leave"
        >
            <div v-show="expanded" class="h-0 overflow-hidden flex flex-col transition-height duration-500">
                <RecursiveCategory v-for="child in children" :category="child" :children="child.children"/>
            </div>
        </Transition>
    </div>
    <a v-else class="basis-1/8 shrink">{{ name }}</a>
</template>
