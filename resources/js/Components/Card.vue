

<script setup>
import { toRefs } from 'vue';


const props = defineProps({
    menu: Array,
    categoryId: String
});

const emit = defineEmits(['showForm'])
const { categoryId } = toRefs(props)

const callShowForm = (action = null, id = null) => {
    if (action) {
        window.localStorage.clear();
        window.localStorage.setItem("action", action);
        window.localStorage.setItem("categoryId", categoryId.value);
        window.localStorage.setItem("itemId", id);
    }
    emit('showForm')
}
</script>

<template>
    <a href="#" v-for="item in menu" @click="callShowForm('edit item', item.id)">
        <div class="flex justify-between">
            <p class="font-normal">
                ${{ item.price }} - {{ item.dicount }}%
            </p>
            <p class="font-normal">
                {{ item.name }}
            </p>
        </div>
    </a>
    <div v-if="!menu.length">
        <span class="italic">No Menu Item</span>
    </div>
</template>
