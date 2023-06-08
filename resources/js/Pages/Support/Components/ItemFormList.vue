<script>

import { defineComponent } from 'vue';
import Multiselect from "@vueform/multiselect";

export default defineComponent({
    props: ["items", "form", "faq"],
    emits: ["removeSingle"],
    components: {
        Multiselect
    },
    methods: {
        upLiftId(data) {
            this.$emit("removeSingle", data);
        },
    },
})
</script>
<template>
    <tr v-if="(faq?.data?.items)" v-for="(item, index) in faq?.data?.items" :key="index"
        class="border-bottom border-bottom-dashed" data-kt-element="item">
        <td>
            <input type="text" class="form-control form-control-solid mb-2" v-model="item.project_name"
                placeholder="Item name" />
        </td>
        <td>
            <input type="text" class="form-control form-control-solid" v-model="item.description"
                placeholder="Description" />
        </td>

        <td class="pt-5 text-end">
            <button :disabled="index < 1" type="button" class="btn btn-sm btn-icon btn-active-color-primary"
                @click="$emit('removeSingle', index)">
                <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                            fill="currentColor" />
                        <path opacity="0.5"
                            d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                            fill="currentColor" />
                        <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                            fill="currentColor" />
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </button>
        </td>
    </tr>
    <tr v-for="(item, index) in form.items.length" :key="index" class="border-bottom border-bottom-dashed"
        data-kt-element="item">
        <td>
            <input type="text" class="form-control form-control-solid mb-2" v-model="form.items[index].faq_title"
                placeholder="Faq Title" />
        </td>

        <td>
            <input type="text" class="form-control form-control-solid mb-2" v-model="form.items[index].faq_artical"
                placeholder="Faq Artical" />

        </td>

        <td class="pt-5 text-end">
            <button :disabled="index < 1" type="button" class="btn btn-sm btn-icon btn-active-color-primary"
                @click="$emit('removeSingle', index)">
                <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                            fill="currentColor" />
                        <path opacity="0.5"
                            d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                            fill="currentColor" />
                        <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                            fill="currentColor" />
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </button>
        </td>
    </tr>
</template>
