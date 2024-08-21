<script setup>
import {onMounted, ref} from "vue";

const flag = ref(null);
const password = ref(null);
const attempts = ref(0);
const timeout = ref(null);

const tilixText = ref([]);
const showTilixInitialSession = ref(false);
const showTilixInitialCommand = ref(false);
const showTilixFirstOutput = ref(false);

function input() {
    if (timeout.value !== null) {
        return;
    }

    timeout.value = setTimeout(() => {
        axios
            .post(route('task-bypass-check-password'), {'password': password.value})
            .then((r) => {
                if (r.data.success !== true) {
                    attempts.value++;

                    tilixText.value.push("[sudo] пароль для admin: " + '•'.repeat(password.value.length));
                    tilixText.value.push(r.data.message);
                    password.value = null;
                } else {
                    flag.value = r.data.message;
                }

                if (attempts.value >= 3) {
                    closeSession()
                } else {
                    timeout.value = null;
                }
            });
    }, 300);
}

onMounted(() => {
    setTimeout(() => {
        showTilixInitialSession.value = true
    }, 150);
    setTimeout(() => {
        showTilixInitialCommand.value = true
    }, 300);
    setTimeout(() => {
        showTilixFirstOutput.value = true
    }, 800);
})

function closeSession(maxAttempts = true) {
    password.value = undefined;
    if (maxAttempts) {
        tilixText.value.push('Maximum attempts exceeded! Close session...')
    } else {
        tilixText.value.push('[sudo] пароль для admin: ')
        tilixText.value.push('Terminate session...')
    }

    setTimeout(() => {
        tilixText.value.push('3...')
        setTimeout(() => {
            tilixText.value.push('2...')
            setTimeout(() => {
                tilixText.value.push('1...')
                setTimeout(() => {
                    location.reload()
                }, 1000)
            }, 1000)
        }, 1000)
    }, 1000);
}

function fullscreen() {

}

</script>

<template>
    <div class="p-48 pt-8 mx-16">
        <section class="w-5/6 mx-auto">
            <div class="p-6 bg-white rounded-md shadow-md">
                <p class="text-2xl font-bg text-center">У компьютера была найдена записка с текстом. Что он означает?</p>
            </div>

            <div class="mt-32 grid grid-cols-2">
                <div class="py-20 px-8 mr-5 text-4xl" style="background-image: url('/note.png'); background-size: cover;">
                    <div class="flex flex-row">
                        <p class="parabola-font">Логин: </p>
                        <p class="parabola-font ml-2">admin</p>
                    </div>
                    <div class="flex flex-row">
                        <p class="parabola-font">Пароль: </p>
                        <p class="parabola-font ml-2">=DzpjpUWxNRp</p>
                    </div>
                    <div class="mt-4 text-gray-400">
                        <div class="flex flex-row items-center">
                            <span class="parabola-font">??-</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                            </svg>
                            <span class="parabola-font">??-</span>
                        </div>
                    </div>
                </div>
                <div class="border-4 border-slate-700 bg-slate-600" id="tilix">
                    <div class="flex flex-row bg-slate-700 text-white py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 inline ml-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6.75 7.5 3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0 0 21 18V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v12a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                        <p class="text-white font-bold ml-2"><span>Tilix</span></p>

                        <div class="ml-auto flex flex-row">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25 12 21m0 0-3.75-3.75M12 21V3" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 hover:text-green-500 hover:stroke-2 active:text-green-600" @click="fullscreen">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 8.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v8.25A2.25 2.25 0 0 0 6 16.5h2.25m8.25-8.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-7.5A2.25 2.25 0 0 1 8.25 18v-1.5m8.25-8.25h-6a2.25 2.25 0 0 0-2.25 2.25v6" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 hover:text-red-500 hover:stroke-2 active:text-red-600" @click="closeSession(false)">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                    </div>
                    <div class="" v-on:keydown.enter="input">
                        <p>
                            <span :class="{'text-transparent': !showTilixInitialSession, 'text-lime-500': showTilixInitialSession}">h@ck3r</span>
                            <span :class="{'text-transparent': !showTilixInitialSession, 'text-white': showTilixInitialSession}">:</span>
                            <span :class="{'text-transparent': !showTilixInitialSession, 'text-blue-400': showTilixInitialSession}">~$</span>
                            <span :class="{'text-transparent': !showTilixInitialCommand, 'text-white': showTilixInitialCommand}">&nbsp;sudo admin && cat /etc/databases/flag.txt</span>
                        </p>
                        <p v-show="showTilixFirstOutput">
                            <span class="text-red-600 block" :class="{'text-white': text.toLowerCase().includes('flag') || text.toLowerCase().includes('sudo')}" v-for="text in tilixText" v-if="tilixText.length">&nbsp{{text}}</span>
                            <span class="text-white" v-if="password !== undefined">&nbsp;[sudo] пароль для admin: </span>
                            <input v-model="password"
                                   v-if="password !== undefined"
                                   autofocus
                                   class="bg-transparent ring-0 active:ring-0 hover:ring-0 border-0 active:border-0 hover:border-0 focus:ring-0 focus:border-0 text-white ml-0 pl-0 pt-0 mt-0"
                                   type="password">
                        </p>
                    </div>
                    <div class="text-white" v-if="flag">
                        {{flag}}
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
@font-face {
    font-family: "Parabola";
    src: url("/Parabola.ttf");
}
    .parabola-font {
        font-family: 'Parabola', serif !important;
    }
</style>
