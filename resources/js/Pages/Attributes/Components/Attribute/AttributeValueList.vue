<script>
import { defineComponent } from 'vue';
import Multiselect from '@vueform/multiselect';
import { Link } from '@inertiajs/inertia-vue3';
import utils from '../../../utils.js';

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
    <td>
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