<script setup>
import { router } from '@inertiajs/vue3'
import { onMounted, toRefs, ref, watch } from 'vue';
import axios from 'axios';

const props = defineProps({
    itemId: String,
    categoryId: String,
});

const { itemId, categoryId } = toRefs(props);
var itemIdHold = ref(null);
var name = ref('');
var price = ref(0);
var dicount = ref(0);
var applyDiscount = ref(0);

function getItem() {
    itemIdHold.value = itemIdHold.value ?? itemId.value;
    axios.get('/dashboard/item/' + (itemIdHold.value ?? '0') + '/category/' + (categoryId.value ?? '0')).then((value) => {
        console.log(value)
        name.value = value.data.name;
        price.value = value.data.price;
        dicount.value = value.data.dicount;
        applyDiscount.value = value.data.apply_discount;
    });
}

function submit() {
    axios.post('/dashboard/item',
        {
            item: itemIdHold.value,
            categoryId: categoryId.value,
            name: name.value,
            price: price.value,
            dicount: dicount.value
        }
    ).then((value) => {
        itemIdHold.value = value.data.id;
        name.value = value.data.name;
        price.value = value.data.price;
        dicount.value = value.data.dicount;
        applyDiscount.value = value.data.apply_discount;
        router.visit('/dashboard', {
            only: ['categoryTree'],
        })
        getItem();
    }).then(() => { getItem() });
}
// single ref
onMounted(() => {
    getItem()
})

watch(itemId, () => {
    getItem()
});

</script>

<template>
    <div class="flex flex-col px-1 py-2">
        <label class="text-lg font-bold text-gray-800">Item Form</label>
    </div>
    <div class="flex">
        <div class="flex flex-col px-1 py-2">
            <label class="font-bold text-gray-600">Item name</label>
            <input class="p-1 border-gray-300 rounded shadow focus:ring-gray-500 focus:border-transparent" v-model="name">
        </div>
        <div class="flex flex-col px-1 py-2">
            <label class="font-bold text-gray-600">Price</label>
            <input type="number" class="p-1 border-gray-300 rounded shadow focus:ring-gray-500 focus:border-transparent"
                v-model="price">
        </div>
        <div class="flex flex-col px-1 py-2">
            <label class="font-bold text-gray-600">Discount</label>
            <input type="number" class="p-1 border-gray-300 rounded shadow focus:ring-gray-500 focus:border-transparent"
                v-model="dicount">
        </div>
        <div class="flex flex-col px-1 py-2">
            <label class="font-bold text-gray-600">Applied Discount</label>
            <input type="number" class="p-1 border-gray-300 rounded shadow focus:ring-gray-500 focus:border-transparent"
                v-model="applyDiscount" readonly>
        </div>
    </div>
    <div class="flex py-2">
        <div class="grow">
            <button type="button" @click="submit"
                class="w-full p-2 font-bold text-white bg-indigo-500 rounded shadow-lg hover:bg-indigo-700">
                Submit
            </button>
        </div>
    </div>
</template>
