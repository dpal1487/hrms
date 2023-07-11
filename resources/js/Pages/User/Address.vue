<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
    props: ['address', 'user'],

    data() {
        return {
            title: "Address",

        };
    },

    components: {
        AppLayout,
        Header,
        Link,
        Head,
    },
    methods: {
    }
});
</script>
<template>
    <Head :title="title" />
    <AppLayout :title="title">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/user" class="text-muted text-hover-primary">User</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="text-muted text-hover-primary">
                {{ user?.data?.first_name }}
            </li>
        </template>

        <Header :user="user?.data" :address="address?.data" />

        <!--begin::details View-->
        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
            <!--begin::Card header-->
            <div class="card-header cursor-pointer">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">User Address</h3>
                </div>
                <!--end::Card title-->

            </div>
            <!--begin::Card header-->

            <div class="card-body p-9">
                <!--begin::Row-->
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-6 fw-bold fs-5 text-gray-800">Address Line 1</label>

                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-6">
                        <span class="fw-bold fs-6 text-gray-800">
                            {{ address?.data?.address_line_1 }}</span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-6 fw-bold fs-5 text-gray-800">Address Line 2</label>

                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-6">
                        <span class="fw-bold fs-6 text-gray-800">
                            {{ address?.data?.address_line_2 }}</span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
                <!--begin::Input group-->
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-6 fw-bold fs-5 text-gray-800">City</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-6 fv-row">
                        <span class="fw-bold text-gray-800 fs-6">{{ address?.data?.city }}</span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-6 fw-bold fs-5 text-gray-800">State</label>

                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-6 fv-row">

                        <span class="fw-bold fs-6 text-gray-800 me-2">{{ address?.data?.state }}</span>
                    </div>
                    <!--end::Col-->
                </div>

                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-6 fw-bold fs-5 text-gray-800">Country
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                            title="Country of origination"></i></label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-6">
                        <span class="fw-bold fs-6 text-gray-800">{{ address?.data?.country?.name }}</span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-6 fw-bold fs-5 text-gray-800">Pincode</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-6">
                        <span class="fw-bold fs-6 text-gray-800">{{ address?.data?.pincode }}</span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

            </div>
            <!--end::Card body-->
        </div>
        <!--end::details View-->
    </AppLayout>
</template>
