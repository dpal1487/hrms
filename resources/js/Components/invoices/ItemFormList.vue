<script>

import { defineComponent } from 'vue';
import ItemForm from './ItemForm.vue';

export default defineComponent({
    props: ["items" , "form"],
    emits: ["removeSingle"],
    components: {
        ItemForm
    },
    methods: {
        upLiftId(data) {
            this.$emit("removeSingle", data);
        }
    }
})
</script>
<template>

    <ItemForm v-for="(item, index) in items" :key="item.id" :id="item.id" @removeSingle="upLiftId" :count="items.length"
        :index="index" :form="form"/>
</template>
