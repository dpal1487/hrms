<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import useVuelidate from "@vuelidate/core";

export default defineComponent({
    props: ['supplier', 'account' , 'address'],
    setup() {
        return { v$: useVuelidate() };
    },
    data() {
        return {
            id: route().params.id
        }
    },

    components: {
        AppLayout,
        Header,
        Link,
        Head,
    },
    methods: {

    },
    created() {

    }
});
</script>
<template>
    <Head title="Supplier Account" />
    <AppLayout title="Supplier">
        <div class="app-content flex-column-fluid ">
            <!--begin::Content container-->
            <div class="app-container container-xxl">

                <Header :supplier="supplier?.data" :address="address?.data"/>
                <!--begin::details View-->
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header cursor-pointer">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">Account</h3>
                        </div>
                        <!--end::Card title-->
                        <Link class="btn btn-primary align-self-center" :href="`/supplier/${id}/account/edit`">
                        Edit
                        Account
                        </Link>
                    </div>
                    <!--begin::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body p-9">
                        <!-- {{ address.data }} -->
                        <!--begin::Row-->
                        <div class="row mb-7">
                            <!--begin::Label-->

                            <label class="col-lg-6 fw-bold fs-5 text-gray-800">Bank Name</label>
                            <!--end::Label-->
                            <!--begin::Col-->

                            <div class="col-lg-6">
                                <span class="fw-bold fs-6 text-gray-700">{{ this.account?.data?.bank_name
                                }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-6 fw-bold fs-5 text-gray-800">Bank Address</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row">
                                <span class="fw-bold fs-6 text-gray-700">{{ this.account?.data?.bank_address
                                }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-6 fw-bold fs-5 text-gray-800">Benificiary Name</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-6 d-flex align-items-center">
                                <span class="fw-bold fs-6 text-gray-700">{{ this.account?.data?.beneficiary_name
                                }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-6 fw-bold fs-5 text-gray-800">Account Number</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-6 d-flex align-items-center">
                                <span class="fw-bold fs-6 text-gray-700">{{ this.account?.data?.account_number
                                }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-6 fw-bold fs-5 text-gray-800">Routing Number
                            </label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-6 d-flex align-items-center">
                                <span class="fw-bold fs-6 text-gray-700">{{
                                    this.account?.data?.routing_number
                                }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-6 fw-bold fs-5 text-gray-800">SWIFT Code
                            </label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-6 d-flex align-items-center">
                                <span class="fw-bold fs-6 text-gray-700">{{
                                    this.account?.data?.swift_code
                                }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-6 fw-bold fs-5 text-gray-800">IFSC Code
                            </label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-6 d-flex align-items-center">
                                <span class="fw-bold fs-6 text-gray-700">{{
                                    this.account?.data?.ifsc_code
                                }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-6 fw-bold fs-5 text-gray-800">Sort Code
                            </label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-6 d-flex align-items-center">
                                <span class="fw-bold fs-6 text-gray-700">{{
                                    this.account?.data?.sort_code
                                }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-6 fw-bold fs-5 text-gray-800">Pan Number
                            </label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-6 d-flex align-items-center">
                                <span class="fw-bold fs-6 text-gray-700">{{ this.account?.data?.pan_number
                                }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::details View-->
            </div>
        </div>

    </AppLayout>
</template>
