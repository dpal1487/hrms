<script>
import { defineComponent } from 'vue';

import { Link } from "@inertiajs/inertia-vue3";
import CustomerForm from './Model/CustomerForm.vue';
export default defineComponent({
    emits: ['onhide'],

    data() {
        return {
            isModalOpen: false,
        }
    },

    components: {
        Link,
        CustomerForm
    },
    methods: {
        showCreateTicketModal() {
            this.isModalOpen = true;
        },
        hideCreateTicketModal() {
            this.isModalOpen = false;
        }
    }

})
</script>

<template>
    <CustomerForm :show="isModalOpen" @hidemodal="hideCreateTicketModal" />

    <!--begin::Customer-->
    <div class="card card-flush pt-3 mb-5 mb-lg-10">
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Card title-->
            <div class="card-title">
                <h2 class="fw-bold">Customer</h2>
            </div>
            <!--begin::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Description-->
            <div class="text-gray-500 fw-semibold fs-5 mb-5">Select or add a customer to a
                subscription:</div>
            <!--end::Description-->
            <!--begin::Selected customer-->
            <div class="d-flex align-items-center p-3 mb-2">
                <!--begin::Avatar-->
                <div class="symbol symbol-60px symbol-circle me-3">
                    <img alt="Pic" src="/assets/media/avatars/300-5.jpg" />
                </div>
                <!--end::Avatar-->
                <!--begin::Info-->
                <div class="d-flex flex-column">
                    <!--begin::Name-->
                    <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-2">Sean
                        Bean</a>
                    <!--end::Name-->
                    <!--begin::Email-->
                    <a href="#" class="fw-semibold text-gray-600 text-hover-primary">sean@dellito.com</a>
                    <!--end::Email-->
                </div>
                <!--end::Info-->
            </div>
            <!--end::Selected customer-->
            <!--begin::Customer add buttons-->
            <div class="mb-7 d-none">
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_customer_search">Select
                    Customer</a>
                <span class="fw-bold text-gray-500 mx-2">or</span>
                <a href="../customers/list.html" class="btn btn-light-primary">Add New Customer</a>
            </div>
            <!--end::Customer add buttons-->
            <!--begin::Customer change button-->
            <div class="mb-10">
                <button type="submit" @click="showCreateTicketModal" class="btn btn-light-primary">Change
                    Customer</button>
            </div>
            <!--end::Customer change button-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Customer-->
</template>