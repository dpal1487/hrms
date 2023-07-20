<script>
import { defineComponent } from 'vue';
import Multiselect from '@vueform/multiselect';
import { Link } from '@inertiajs/inertia-vue3';
import utils from '../../../utils.js';
import { Inertia } from '@inertiajs/inertia';

export default defineComponent({
    props: ['brand'],
    data: () => {
        return {

        }
    },
    methods: {
        async changeStatus(status, id) {
            this.isLoading = true;
            await utils.changeStatus(route('brand-model.status'), { id: id, status: status });
            Inertia.get(
                "/brand/" + this.brand.brand_id,
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
    <td class="fs-6 fw-bold text-gray-800 text-capitalize">

        {{ brand?.name }}
    </td>
    <td>
        <div class="form-switch form-check-solid d-block form-check-custom form-check-success">
            <input class="form-check-input h-20px w-30px" type="checkbox"
                @input="changeStatus($event.target.checked, brand?.id)" :checked="brand?.status == 1 ? true : false" />
        </div>
    </td>
    <td>
        <slot name="action"></slot>
    </td>
</template>