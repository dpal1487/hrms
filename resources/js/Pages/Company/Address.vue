<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import CompanyLayout from "@/Layouts/CompanyLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import useVuelidate from "@vuelidate/core";
import AddressComponent from "../../Components/Company/Address/AddressComponent.vue";

export default defineComponent({
    props: ['company', 'countries'],
    setup() {
        return { v$: useVuelidate() };
    },
    components: {
        AppLayout,
        CompanyLayout,
        Link,
        Head,
        AddressComponent
    },
    methods: {

    },
    created() {

    }
});
</script>
<template>
    <Head :title="Address" />
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
                <div class="card-body">
                    <!--begin::Addresses-->
                    <div class="row gx-9 gy-6">
                        <!-- {{ company }} -->
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
                                    <a href="#" class="btn btn-primary px-6 align-self-center text-nowrap"
                                        data-bs-toggle="modal" data-bs-target="#kt_modal_new_address">New Address</a>
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
