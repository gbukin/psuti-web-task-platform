<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";

const tasks = [
    {'link': route('task-password', {}, false), 'name': 'PA$$w0RD'},
    {'link': route('task-web-basic-get', {}, false), 'name': 'W3B-BaS1C'},
    {'link': route('task-bypass', {}, false), 'name': 'W3B-ByPa$$'},
    {'link': route('task-shop', {}, false), 'name': 'W3B-Shop'},
]
</script>

<template>
    <div class="p-64 m-32">
        <section class="w-4/6 mx-auto shadow-md">
            <div class="p-6 bg-white rounded-md shadow-md">
                <p class="text-2xl font-bg text-center">Tasks:</p>
                <div class="mt-16 flex flex-row justify-between">
                    <div v-for="item in tasks"
                         class="border border-slate-600 p-4 flex flex-col items-start rounded shadow">
                        <p class="text-center w-full font-bold">{{ item.name }}</p>
                        <a class="pt-8" :href="item.link" target="_blank"><PrimaryButton>Перейти</PrimaryButton></a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
