<script>
import { defineComponent } from 'vue';
import Multiselect from '@vueform/multiselect';
import { Link } from '@inertiajs/inertia-vue3';
import utils from '../../../utils.js';
import { Inertia } from '@inertiajs/inertia';

export default defineComponent({
    props: ['attribute'],
    data: () => {
        return {
        }
    },
    methods: {
        async changeStatus(status, id) {
            this.isLoading = true;
            await utils.changeStatus(route('attribute-value.status'), { id: id, status: status });
            Inertia.get(
                "/attribute/" + this.attribute.attribute_id,
                this.form,
            );
            this.isLoading = false;
        },
    },
    components: {
        Multiselect,
        Link
    }
})
</script>

<template>
    <td class="fs-6 fw-bold text-gray-700">
        {{ attribute?.attribute_value }}
    </td>
    <td>
        <div class="form-switch form-check-solid d-block form-check-custom form-check-success">
            <input class="form-check-input h-20px w-30px" type="checkbox"
                @input="changeStatus($event.target.checked, attribute?.id)"
                :checked="attribute?.status == 1 ? true : false" />
        </div>
    </td>
    <td>
        <slot name="action"></slot>
    </td>
</template>