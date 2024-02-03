<script setup>
import ItemFrom from '@/Components/ItemForm.vue';
import CategoryForm from '@/Components/CategoryForm.vue';
import AccordionTree from '@/Components/AccordionTree.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({ categoryTree: Array });

var categoryFormShow = ref(0);
var itemFormShow = ref(0);
var itemId = ref(null);
var categoryId = ref(null);
var parentId = ref(null);

function addItem(obj) {
    categoryFormShow.value = 0;
    itemFormShow.value = 1;
    itemId.value = obj.itemId;
    categoryId.value = obj.categoryId;
}
function editItem(obj) {
    categoryFormShow.value = 0;
    itemFormShow.value = 1;
    itemId.value = obj.itemId;
    categoryId.value = obj.categoryId;
}

function addCategory(obj) {
    categoryFormShow.value = 1;
    itemFormShow.value = 0;
    itemId.value = obj.itemId;
    categoryId.value = obj.categoryId;
    parentId.value = obj.parentId;
}

function editCategory(obj) {
    categoryFormShow.value = 1;
    itemFormShow.value = 0;
    itemId.value = obj.itemId;
    categoryId.value = obj.categoryId;
    parentId.value = obj.parentId;
}

function showForm() {
    var action = window.localStorage.getItem("action");
    var itemId = window.localStorage.getItem("itemId");
    var categoryId = window.localStorage.getItem("categoryId");
    var parentId = window.localStorage.getItem("parentId");
    var obj = { action: action, itemId: itemId, categoryId: categoryId, parentId: parentId };

    switch (action) {
        case 'add category':
            addCategory(obj);
            break;
        case 'edit category':
            editCategory(obj);
            break;
        case 'add item':
            addItem(obj);
            break;
        case 'edit item':
            editItem(obj);
            break;
    }
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="pt-5 pl-3 min-w-72">
                        <AccordionTree :categories="categoryTree" class="w-auto" @show-form="showForm" />
                    </div>
                    <div class="p-6 text-gray-900">
                        <div v-if="itemFormShow == 1">
                            <ItemFrom :item-id="itemId" :category-id="categoryId" />
                        </div>
                        <div v-if="categoryFormShow == 1">
                            <CategoryForm :item-id="itemId" :category-id="categoryId" :parent-id="parentId" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
