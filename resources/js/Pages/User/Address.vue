<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import useVuelidate from "@vuelidate/core";

export default defineComponent({
    props: ['address', 'user'],
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
    <Head title="Employee Address" />
    <AppLayout>
        <div class="app-content flex-column-fluid ">
            <!--begin::Content container-->
            <div class="app-container container-xxl">
                <Header :user="user.data" :address="address.data" />

                <!--begin::details View-->
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header cursor-pointer">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">Address</h3>
                        </div>
                        <!--end::Card title-->
                        <Link class="btn btn-primary align-self-center" href="/account/address/edit">
                        Edit
                        Address
                        </Link>
                    </div>
                    <!--begin::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body p-9">
                        <!-- {{ address.data }} -->
                        <!--begin::Row-->
                        <div class="row mb-7">
                            <!--begin::Label-->

                            <label class="col-lg-4 fw-semibold text-muted">Address Line 1</label>
                            <!--end::Label-->
                            <!--begin::Col-->

                            <div class="col-lg-8">
                                <span class="fw-bold fs-6 text-gray-800">{{ this.address?.data?.address_line_1
                                }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Address Line 2</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold fs-6 text-gray-800">{{ this.address?.data?.address_line_2
                                }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">City</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 d-flex align-items-center">
                                <span class="fw-bold fs-6 text-gray-800 me-2">{{ this.address?.data?.city
                                }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">State</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 d-flex align-items-center">
                                <span class="fw-bold fs-6 text-gray-800 me-2">{{ this.address?.data?.state
                                }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Country
                            </label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 d-flex align-items-center">
                                <span class="fw-bold fs-6 text-gray-800 me-2">{{
                                    this.address?.data?.country?.name
                                }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Pincode
                            </label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 d-flex align-items-center">
                                <span class="fw-bold fs-6 text-gray-800 me-2">{{ this.address?.data?.pincode
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
