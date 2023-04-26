<script>

import { defineComponent } from 'vue';

export default defineComponent({
    data() {
        return {
            rowCount: 1,
        }
    },
    methods: {
        handleRowCount(e) {
            this.rowCount = e.target.value;
        }
    }
})
</script>
<template>
    <tr class="border-top border-top-dashed align-top fs-6 fw-bold text-gray-700">
        <input type="number" class="form-control mt-4" :value="rowCount" min="1" @change="handleRowCount">
        <th class="text-primary">
            <button type="button" class="btn btn-link py-1" @click="$emit('addItemForm', this.rowCount)">Add
                item</button>
        </th>
        <th colspan="2" class="border-bottom border-bottom-dashed ps-0">
            <div class="d-flex flex-column align-items-start">
                <div class="fs-5">Subtotal</div>
                <button class="btn btn-link py-1" data-bs-toggle="tooltip" data-bs-trigger="hover" title="Coming soon">Add
                    tax</button>
                <button class="btn btn-link py-1" data-bs-toggle="tooltip" data-bs-trigger="hover" title="Coming soon">Add
                    discount</button>
            </div>
        </th>
        <th colspan="2" class="border-bottom border-bottom-dashed text-end">
            $
            <span data-kt-element="sub-total">0.00</span>
        </th>
    </tr>
</template>
