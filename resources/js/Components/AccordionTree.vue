<script setup>
import PrimaryButton from './PrimaryButton.vue';
import Card from '@/Components/Card.vue';
import { ref } from 'vue';

defineProps({
    categories: Array | Object,
});

var holdId = ref(null);

function toggling(id) {
    if (holdId.value != id || !holdId.value) {
        holdId.value = id;
    } else {
        holdId.value = null;
    }
}

const emit = defineEmits(['showForm'])

const callShowForm = (action = null, id = null, parentid = null) => {

    if (action) {
        window.localStorage.clear();
        window.localStorage.setItem("action", action);
        window.localStorage.setItem("categoryId", id);
        window.localStorage.setItem("parentId", parentid);
    }
    emit('showForm');
}
</script>

<template>
    <div v-for="(category, idx) in categories">
        <div>
            <div class="tab__header">
                <a href="#" class="flex justify-between border-b-2 border-indigo-300 break-keep">
                    <div class="flex" @click="callShowForm('edit category', category.id, category.parent_category_id)">
                        <div>
                            {{ category.discount }}%
                        </div>
                        <strong class="pl-2">{{ category.name }}</strong>
                    </div>
                    <span class="down-Arrow" v-show="category.id == holdId" @click="toggling(category.id)">&#9660;</span>
                    <span class="up-Arrow" v-show="category.id != holdId" @click="toggling(category.id)">&#9650;</span>
                </a>
            </div>
            <div class="pt-2 pl-4 tab__content" v-show="category.id == holdId">

                <div class="flex">
                    <div class="pr-1">
                        <PrimaryButton v-if="category.items != []" @click="callShowForm('add category', null, category.id)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-plus" viewBox="0 0 16 16">
                                <path
                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                            </svg>
                            Category
                        </PrimaryButton>
                    </div>
                    <PrimaryButton class="px-2" v-if="!category.sub_categories.length"
                        @click="callShowForm('add item', category.id)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-plus" viewBox="0 0 16 16">
                            <path
                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                        </svg>
                        Item
                    </PrimaryButton>
                </div>
                <AccordionTree v-if="category.sub_categories.length" :categories="category.sub_categories"
                    @show-form="callShowForm" />
                <Card :menu="category.items" @show-form="callShowForm" v-else :category-id="category.id" />
            </div>
        </div>
    </div>
</template>
