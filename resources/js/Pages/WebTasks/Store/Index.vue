<script setup>
import {onMounted, ref} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DialogModal from "@/Components/DialogModal.vue";

const props = defineProps({
    account: {
        type: Object,
    }
})

const shops = ['М-ПГУТИо', 'ПГУТИ`радо', 'ПГУТИ.Маркет', 'ПГУТИ-link'];
let shop = ref('М-ПГУТИ');

const email = ref(null);
const password = ref(null);

function getNextShop() {
    let current = shop.value;
    let next = current;

    while (next === current) {
        next = shops[Math.floor(Math.random()*shops.length)];
    }

    return next;
}

const openDialog = ref(false);
const dialogTitle = ref('');
const dialogMessage = ref('Если вы видите это сообщение, значит что-то пошло не так');
const blockRedeem = ref(false);
const reloadAfterDialogClose = ref(false);

function createAccount() {
    if (props.account) {
        showDialog('Аккаунт уже создан!');
        return;
    }

    if (!email.value || !password.value) {
        showDialog('Введите Email и пароль', 'Ошибка!');
        return;
    }

    if (password.value.length < 8) {
        showDialog('Минимальное количество символов в пароле: 8', 'Ошибка!');
    }

    axios
        .post(route('task-shop-create-account'), {email: email.value, password: password.value})
        .then((r) => {
            if (r.data.status === 200) {
                reloadAfterDialogClose.value = true;
                showDialog('Вы успешно авторизовались');
            }

            if (r.data.status === 400) {
                reloadAfterDialogClose.value = true;
                showDialog(r.data.message, 'Ошибка!');
            }
        });
}

function redeemCertificate() {
    if (!props.account) {
        showDialog('Сначала необходимо создать аккаунт или авторизоваться', 'Ошибка!');

        return;
    }

    blockRedeem.value = true;
    axios
        .post(route('task-shop-redeem-certificate'))
        .then((r) => {
            if (r.data.status === 400) {
                reloadAfterDialogClose.value = true;
                showDialog(r.data.message, 'Ошибка!');
            }

            if (r.data.status === 200) {
                reloadAfterDialogClose.value = true;
                showDialog('Заявка принята. Ожидайте!');
            }
        });
    blockRedeem.value = false;
}

function buyFlag() {
    if (!props.account) {
        showDialog('Сначала необходимо создать аккаунт или авторизоваться', 'Ошибка!');

        return;
    }

    axios
        .post(route('task-shop-buy-flag'))
        .then((r) => {
            if (r.data.status === 400) {
                reloadAfterDialogClose.value = true;
                showDialog(r.data.message, 'Ошибка!');
            }

            if (r.data.status === 200) {
                reloadAfterDialogClose.value = true;
                showDialog(r.data.message);
            }
        });
}

function refundCertificate() {
    if (!props.account) {
        showDialog('Сначала необходимо создать аккаунт или авторизоваться', 'Ошибка!');

        return;
    }

    axios
        .post(route('task-shop-refund-certificate'))
        .then((r) => {
            if (r.data.status === 400) {
                reloadAfterDialogClose.value = true;
                showDialog(r.data.message, 'Ошибка!');
            }

            if (r.data.status === 200) {
                reloadAfterDialogClose.value = true;
                showDialog('Вы успешно вернули сертификат');
            }
        });
}

function showDialog(message, title = '') {
    dialogMessage.value = message;
    dialogTitle.value = title;
    openDialog.value = true;
}

function closeDialog() {
    openDialog.value = !openDialog.value;
    dialogTitle.value = '';
    dialogMessage.value = 'Если вы видите это сообщение, значит что-то пошло не так';

    if (reloadAfterDialogClose.value === true) {
        location.reload();
    }
}

onMounted(() => {
    setInterval(() => {
        shop.value = getNextShop();
    }, 500);
});
</script>

<template>
    <DialogModal :show="openDialog"
                 v-on:close="closeDialog"
                 :title="dialogTitle">
        {{dialogMessage}}
    </DialogModal>
    <section class="px-64 pt-0.5 mx-64 mt-0.5">
        <div class="bg-white rounded p-4 w-fit mx-auto border border-slate-700 shadow-md">
            <p class="font-bold text-3xl">Онлайн магазин {{ shop }}</p>
        </div>

        <div class="mt-8 bg-white border border-slate-700 rounded shadow p-4">
            <section id="head" class="flex flex-row">
                <!-- Account Start -->
                <div v-if="!account">
                    <input v-model="email" class="mr-5" type="text" placeholder="Email">
                    <input v-model="password" class="mr-5" type="password" placeholder="Password">
                    <PrimaryButton class="text-left bg-blue-600 hover:bg-blue-700 active:bg-blue-700 focus:bg-blue-700" v-if="!account" @click="createAccount">Create Account</PrimaryButton>
                </div>
                <div v-if="account" class="flex flex-row items-center border border-slate-900 rounded p-2 bg-gray-800 text-white">
                    <span class="text-gray-300 mr-2">You are logged in via:</span>{{ account.email }}
                </div>
                <!-- Account End -->
                <div class="text-white bg-gray-800 border-2 border-gray-900 p-1 rounded-md flex items-center ml-auto" v-if="account">
                    <span class="text-gray-300 mr-2 font-bold">Balance:</span> {{ account.balance }} USD
                </div>
            </section>

            <hr class="my-4">

            <section id="certificate">
                <div class="font-bold">Подарочные сертификаты:</div>

                <div class="flex flex-row items-center h-12">
                    <div class="ml-2 w-48">1. Gift Card 100 USD</div>
                    <div class="ml-7">
                        <PrimaryButton class="bg-green-600 hover:bg-green-600 active:bg-green-600 w-28" disabled>
                            <span class="mx-auto">REDEEMED</span>
                        </PrimaryButton>
                    </div>
                    <div class="ml-7">
                        <PrimaryButton class="bg-red-600 hover:bg-red-600 active:bg-red-600 w-36" disabled>
                            <span class="mx-auto">CAN'T REFUND</span>
                        </PrimaryButton>
                    </div>
                </div>
                <div class="flex flex-row items-center h-12">
                    <div class="ml-2 w-48">2. Gift Card 200 USD</div>
                    <div class="font-bold text-green-600 ml-7">
                        <PrimaryButton class="w-28 bg-blue-600 hover:bg-blue-700 active:bg-blue-700 focus:bg-blue-700" @click="redeemCertificate" v-if="account && !account.redeemCertificate">
                            <span class="mx-auto">REDEEM</span>
                        </PrimaryButton>
                        <PrimaryButton class="bg-green-600 hover:bg-green-600 active:bg-green-600 w-28" disabled v-if="account && account.redeemCertificate">
                            <span class="mx-auto">REDEEMED</span>
                        </PrimaryButton>
                    </div>
                    <div class="ml-7">
                        <PrimaryButton class="w-36" v-if="account && account.redeemCertificate" @click="refundCertificate">
                            <span class="mx-auto">REFUND</span>
                        </PrimaryButton>
                    </div>
                </div>
            </section>

            <hr class="my-4">

            <section id="shop">
                <div class="font-bold text-xl my-4">Позиции:</div>

                <div class="flex flex-col space-y-4">
                    <div class="flex flex-col p-3 border border-slate-800 rounded-sm bg-gray-100">
                        <div class="flex flex-row">
                            <p class="w-72 font-bold text-lg">PSUTI CTF. Admin Credentials</p>
                            <p class="ml-auto font-bold">Наличие: <br><span class="font-normal text-gray-700">Нет в наличии</span></p>
                        </div>
                        <button class="mt-4 rounded-md bg-gray-800 text-white p-2 w-48 pointer-events-none ml-auto" disabled>
                            10 USD <span class="line-through text-red-600">999 USD</span>
                        </button>
                    </div>

                    <div class="flex flex-col p-3 border border-slate-800 rounded-sm bg-gray-100">
                        <div class="flex flex-row">
                            <p class="w-72 font-bold text-lg">All flags for PSUTI CTF 2024</p>
                            <p class="ml-auto font-bold">Наличие: <br><span class="font-normal text-gray-700">Нет в наличии</span></p>
                        </div>
                        <button class="mt-4 rounded-md bg-gray-800 text-white p-2 w-48 pointer-events-none ml-auto" disabled>
                            300 USD <span class="line-through text-red-600">455 USD</span>
                        </button>
                    </div>

                    <div class="flex flex-col p-3 border border-slate-800 rounded-sm bg-gray-100">
                        <div class="flex flex-row">
                            <p class="w-72 font-bold text-lg">Flag for this task:</p>
                            <p class="ml-auto font-bold">Наличие: <br><span class="font-normal text-gray-700">1 шт.</span></p>
                        </div>
                        <button class="mt-4 rounded-md bg-gray-800 hover:bg-gray-700 hover:font-bold active:bg-gray-700 text-white p-2 w-48 ml-auto" @click="buyFlag">
                            500 USD
                        </button>
                    </div>
                </div>
            </section>
        </div>
    </section>
</template>

<style scoped>

</style>
