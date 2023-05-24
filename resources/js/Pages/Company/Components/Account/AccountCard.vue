<script>
import { defineComponent } from 'vue';
import 'vue3-toastify/dist/index.css';
export default defineComponent({
    props: ['account'],
})
</script>
<template>
    <!--begin::account-->
    <div class="card card-dashed h-xl-100 flex-row flex-stack flex-wrap p-6">
        <div class="d-flex flex-column gap-3">
            <div class="d-flex align-items-center fs-5 fw-bold mb-5" >Account
                <span class="badge badge-light-success fs-7 ms-2" v-if="account?.is_primary == 1">Primary</span>
            </div>
            <div class="d-flex align-items-center flex-wrap">
                <div class="fw-bold me-4 text-gray-800">Bank Name : </div>
                <div class="text-gray-600"> {{ account?.bank_name }}</div>
            </div>

            <div class="d-flex align-items-center flex-wrap">
                <div class="fw-bold me-4 text-gray-800">Bank Address : </div>
                <div class="text-gray-600"> {{ account?.bank_address }}</div>
            </div>


            <div class="d-flex align-items-center flex-wrap">
                <div class="fw-bold me-4 text-gray-800">Beneficiary Name : </div>
                <div class="text-gray-600"> {{ account?.beneficiary_name }}</div>
            </div>
            <div class="d-flex align-items-center flex-wrap">
                <div class="fw-bold me-4 text-gray-800">Account Number : </div>
                <div class="text-gray-600"> {{ account?.account_number }}</div>
            </div>

            <div class="d-flex align-items-center flex-wrap">
                <div class="fw-bold me-4 text-gray-800">Routing Number : </div>
                <div class="text-gray-600"> {{ account?.routing_number }}</div>
            </div>
            <div class="d-flex align-items-center flex-wrap">
                <div class="fw-bold me-4 text-gray-800">Swift Code : </div>
                <div class="text-gray-600"> {{ account?.swift_code }}</div>
            </div>
            <div class="d-flex align-items-center flex-wrap">
                <div class="fw-bold me-4 text-gray-800">IFSC Code : </div>
                <div class="text-gray-600"> {{ account?.ifsc_code }}</div>
            </div>
            <div class="d-flex align-items-center flex-wrap">
                <div class="fw-bold me-4 text-gray-800">SORT Code : </div>
                <div class="text-gray-600"> {{ account?.sort_code }}</div>
            </div>
            <div class="d-flex align-items-center flex-wrap">
                <div class="fw-bold me-4 text-gray-800">Pan Number : </div>
                <div class="text-gray-600"> {{ account?.pan_number }}</div>
            </div>
        </div>

        <!--end::Details-->
        <!--begin::Actions-->
        <slot name="action"></slot>
        <!--end::Actions-->
    </div>
    <!--end::account-->
</template>
