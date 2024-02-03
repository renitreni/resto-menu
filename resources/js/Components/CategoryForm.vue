<script setup>
import { router } from '@inertiajs/vue3'
import axios from 'axios';
import { toRefs, ref, onMounted, watch } from 'vue';

const props = defineProps({
    itemId: String,
    categoryId: String,
    parentId: String
});

const { categoryId, parentId } = toRefs(props);

var categoryIdHold = ref(null);
var name = ref('');
var discount = ref(0);

function getItem() {
    console.log(categoryId.value);
    categoryIdHold.value = categoryIdHold.value ?? categoryId.value;
    axios.get('/dashboard/category/' + categoryId.value + '/parent/' + parentId.value).then((value) => {
        console.log(value)
        name.value = value.data.name;
        discount.value = value.data.discount;
    });
}

function submit() {
    axios.post('/dashboard/category',
        {
            categoryId: categoryIdHold.value,
            name: name.value,
            discount: discount.value,
            parentId: parentId.value,
        }
    ).then((value) => {
        router.visit('/dashboard', {
            only: ['categoryTree'],
        })
    }).catch((value) => {
        if (value.response.status == 500) {
            alert(value.response.data.message);
        }
    });
}
// single ref
onMounted(() => {
    getItem()
})

watch(categoryId, () => {
    getItem()
});
</script>

<template>
    <div class="flex flex-col px-1 py-2">
        <label class="text-lg font-bold text-gray-800">Category Form</label>
    </div>
    <div class="flex">
        <div class="flex flex-col px-1 py-2">
            <label class="font-bold text-gray-600">Category name</label>
            <input class="p-1 border-gray-300 rounded shadow focus:ring-gray-500 focus:border-transparent" v-model="name">
        </div>
        <div class="flex flex-col px-1 py-2">
            <label class="font-bold text-gray-600">Discount</label>
            <input type="number" class="p-1 border-gray-300 rounded shadow focus:ring-gray-500 focus:border-transparent"
                v-model="discount">
        </div>
    </div>
    <div class="flex py-2">
        <div class="grow">
            <button type="button" @click="submit"
                class="w-full p-2 font-bold text-white bg-indigo-500 rounded shadow-lg hover:bg-indigo-700"> Submit
            </button>
        </div>
    </div>
</template>
