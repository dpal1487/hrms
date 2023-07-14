<script>
import { defineComponent } from 'vue';
import Multiselect from '@vueform/multiselect';
import { Link } from '@inertiajs/inertia-vue3';
import utils from '../../../utils.js';
import { Inertia } from '@inertiajs/inertia';

export default defineComponent({
    props: ['faq_category'],
    data: () => {
        return {

        }
    },
    components: {
        Multiselect,
        Link
    }
})
</script>

<template>
    <td class="fs-6 fw-bold text-gray-800 text-capitalize">
        {{ faq_category?.title }}
    </td>
    <td class="fs-6 fw-bold text-gray-800 text-capitalize">
        {{ faq_category?.artical }}
    </td>
    <td>
        <slot name="action"></slot>
    </td>
</template>