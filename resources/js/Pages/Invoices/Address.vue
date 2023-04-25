<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import CompanyLayout from "@/Layouts/CompanyLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import useVuelidate from "@vuelidate/core";
import AddressComponent from "../../Components/Company/Address/AddressComponent.vue";
import AddAddress from "../../Components/Company/Address/Model/AddAddress.vue";

export default defineComponent({
    props: ['company', 'countries'],
    setup() {
        return {
            v$: useVuelidate(),
            // isEdit: false
        };
    },
    data() {
        return {
            isEdit: false,
        }
    },
    components: {
        AppLayout,
        CompanyLayout,
        Link,
        Head,
        AddressComponent,
        AddAddress,

    },
    methods: {
        toggleModal(value) {
            this.isEdit = value;
        }

    },
    created() {



    }
});
</script>
<template>
    <Head title="Company Address" />
    <AppLayout>
        <CompanyLayout :company="company">
            <!--begin::details View-->
            <!--begin::Billing Address-->
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Title-->
                    <div class="card-title">
                        <h3>Billing Address</h3>
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <AddAddress :show="isEdit" @hidemodal="toggleModal" :countries="countries" :company="company" />
                <div class="card-body">
                    <!--begin::Addresses-->
                    <div class="row gx-9 gy-6">
                        <!--begin::Col-->
                        <AddressComponent :countries="countries" :company="company" />
                        <!--end::Col-->

                        <div class="col-xl-6">
                            <!--begin::Notice-->
                            <div
                                class="notice d-flex bg-light-primary rounded border-primary border border-dashed flex-stack h-xl-100 mb-10 p-6">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                                    <!--begin::Content-->
                                    <div class="mb-3 mb-md-0 fw-semibold">
                                        <h4 class="text-gray-900 fw-bold">This is a very important note!</h4>
                                        <div class="fs-6 text-gray-700 pe-7">Writing headlines for blog posts is much
                                            science and probably cool audience</div>
                                    </div>
                                    <!--end::Content-->
                                    <!--begin::Action-->
                                    <button class="btn btn-primary px-6 align-self-center text-nowrap"
                                        @click=toggleModal(true)>New Address</button>
                                    <!--end::Action-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Notice-->
                        </div>
                    </div>
                    <!--end::Addresses-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Billing Address-->
        </CompanyLayout>
    </AppLayout>
</template>
