<script>
import { defineComponent } from 'vue';
import AddEditAddress from './Model/AddEditAddress.vue';
export default defineComponent({
    props: ['countries', 'company'],
    data() {
        return {
            isEdit: false
        }
    },

    components: {
        AddEditAddress,
    },
    methods: {
        toggleModal(value) {
            this.isEdit = value;
        }
    }
})
</script>
<template>
    <AddEditAddress :show="isEdit" @hidemodal="toggleModal" :countries="countries" :company="company" />
    <div class="col-xl-6" data-kt-billing-element="address">
        <!--begin::Address-->
        {{ company }}
        <div class="card card-dashed h-xl-100 flex-row flex-stack flex-wrap p-6">

            <div class="d-flex flex-column py-2">
                <div class="d-flex align-items-center fs-5 fw-bold mb-5">Address 1
                    <span class="badge badge-light-success fs-7 ms-2">Primary</span>
                </div>
                <div class="fs-6 fw-semibold text-gray-600">Ap #285-7193 Ullamcorper Avenue
                    <br />Amesbury HI 93373
                    <br />US
                </div>
            </div>
            <!--end::Details-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center py-2">
                <button class="btn btn-sm btn-light btn-active-light-primary me-3" data-kt-billing-action="address-delete">
                    <!--begin::Indicator label-->
                    <span class="indicator-label">Delete</span>
                    <!--end::Indicator label-->
                    <!--begin::Indicator progress-->
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    <!--end::Indicator progress-->
                </button>
                <button class="btn btn-sm btn-light btn-active-light-primary" @click=toggleModal(true)>Edit</button>
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Address-->
    </div>
</template>
