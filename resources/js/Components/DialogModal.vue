<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {onMounted, onUnmounted} from "vue";

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    title: {
        type: String,
        default: ''
    },
    closeButton: {
        type: String,
        default: 'Закрыть'
    }
});

const emit = defineEmits(['close']);

const close = () => {
    emit('close');
};

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && props.show) {
        close();
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    document.body.style.overflow = null;
});
</script>

<template>
    <dialog v-bind:open="show"
            class="z-20 fixed w-full h-full inset-0 overflow-y-auto"
            style="background-color: rgba(1,1,1,0.5)">
        <div class="mx-auto mt-32 p-5 w-4/5 md:w-1/4 border-primary bg-white rounded-md shadow">
            <span class="w-full cursor-pointer border-0 shadow-none font-bold text-red-700"
                  v-on:click="close">
                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="1.5"
                     stroke="currentColor"
                     class="w-6 h-6 ml-auto">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                </svg>
            </span>

            <p class="text-center font-bold mb-5" v-if="title !== ''">
                {{ title }}
            </p>

            <div>
                <slot/>
            </div>

            <PrimaryButton class="mt-4 p-1 text-white bg-main block ml-auto"
                           v-if="closeButton !== 'null'"
                           v-on:click="close">
                {{ closeButton }}
            </PrimaryButton>
        </div>
    </dialog>
</template>

<style scoped>

</style>
