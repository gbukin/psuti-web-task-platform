<script setup>
import {ref} from "vue";

const input = ref(null)
const defaultTitle = 'Enter pasword';
const currentTitle = ref(defaultTitle)

let fgd432 = 'n';
let hfgh34 = 'd';
let dfg342 = 't';
let dfgfd9 = 'in';

let lsdj6 = 'rr';
let ldfk6 = 'pa';
let sdgs7 = 'or';
let g6g7g = 'sw';

let p2s4s = 'co';
let asd24 = 'ag';
let dfhf4 = 'ec';
let d111r = 'ai';

let DFKJ3 = 'Ro';
let KJK12 = '0t';
let ASl2D = 'R0';
let lk__4 = 'OT';

let KJsdf = 'A';
let KLJ76d = 'DM';
let KLJUH3 = 'IN';

let kljuh3 = 'aD';
let kjhsdf = 'Mi';
let qwersd = 'N';

let f98_s = 'Q';
let _45gg = 'W';
let c_asd = 'E';
let fgf3g = 'R';
let flk34 = 'T';
let rhkk3 = 'Y';

let KSDFK = 'PS';
let KJS23 = 'UT';
let KJSDH = 'IC'
let SKDJF = 'TF'
let KSJDF = String.fromCharCode(123)
let LKSDJ = String.fromCharCode(125)

let slkdi4564 = 'Try';
let ncvx5 = ' again';
let cxviu2342 = 'Password';
let sdd23423 = ' is ';
let sdf3jsf87 = 'incorrect';

console.log(KSDFK + KJS23 + KJSDH + SKDJF + KSJDF + DFKJ3.toUpperCase() + KJK12.toUpperCase() + ASl2D + lk__4 + kljuh3.toUpperCase() + kjhsdf.toUpperCase() + qwersd + KJsdf + KLJ76d + KLJUH3 + f98_s + _45gg + c_asd + fgf3g + flk34 + rhkk3 + LKSDJ)

const click = () => {
    if (input.value === ldfk6 + g6g7g + sdgs7 + hfgh34 && currentTitle.value === defaultTitle) {
        currentTitle.value = cxviu2342 + sdd23423 + sdf3jsf87;
        input.value = null;
        return
    }

    if (input.value === dfgfd9 + p2s4s + lsdj6 + dfhf4 + dfg342 && currentTitle.value === cxviu2342 + sdd23423 + sdf3jsf87) {
        currentTitle.value = slkdi4564 + ncvx5;
        input.value = null;
        return
    }

    if (input.value === asd24 + d111r + fgd432 && currentTitle.value === slkdi4564 + ncvx5) {
        currentTitle.value = KSDFK + KJS23 + KJSDH + SKDJF + KSJDF + DFKJ3.toUpperCase() + KJK12.toUpperCase() + ASl2D + lk__4 + kljuh3.toUpperCase() + kjhsdf.toUpperCase() + qwersd + KJsdf + KLJ76d + KLJUH3 + f98_s + _45gg + c_asd + fgf3g + flk34 + rhkk3 + LKSDJ;
        input.value = null;
        return
    }

    currentTitle.value = defaultTitle;
    input.value = null;
}
</script>

<template>
    <section class="w-1/4 px-12 py-10 bg-white border border-slate-800 shadow-lg rounded-lg mx-auto my-64">
        <h2 :class="{'text-red-600': currentTitle !== defaultTitle}"
            class="font-bold text-lg w-full text-center">
            {{ currentTitle }}
        </h2>

        <div class="mt-12 space-y-6">
            <div>
                <label for="login"
                       class="block">
                    Login:
                </label>
                <input id="login"
                       type="text"
                       value="Admin"
                       class="p-1 border border-gray-500 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                       disabled
                       readonly>
            </div>
            <div>
                <label for="password"
                       class="block">
                    Password:
                </label>
                <input id="password"
                       type="password"
                       v-model="input"
                       @keydown.enter="click"
                       class="p-1 border border-gray-500 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
            </div>
        </div>

        <button
            class="border border-slate-700 bg-slate-600 hover:bg-slate-700 active:bg-slate-800 text-center py-2 px-4 mt-4 rounded-md text-white font-bold"
            @click="click"
        >
            Login
        </button>
    </section>
</template>

<style scoped>

</style>
