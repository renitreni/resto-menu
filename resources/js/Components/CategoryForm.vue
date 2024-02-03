<script setup>
import { router } from '@inertiajs/vue3'
defineProps({
    categoryId: String,
});

const { categoryId } = toRefs(props);

var name = ref('');
var price = ref(0);
var dicount = ref(0);

function getItem() {
    axios.get('/dashboard/category/' + categoryId.value).then((value) => {
        console.log(value)
        name.value = value.data.name;
        price.value = value.data.price;
        dicount.value = value.data.dicount;
    });
}

function submit() {

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
            <input type="number" class="p-1 border-gray-300 rounded shadow focus:ring-gray-500 focus:border-transparent" v-model="dicount">
        </div>
    </div>
    <div class="flex py-2">
        <div class="grow">
            <button type="button"
                class="w-full p-2 font-bold text-white bg-indigo-500 rounded shadow-lg hover:bg-indigo-700"> Submit
            </button>
        </div>
    </div>
</template>
