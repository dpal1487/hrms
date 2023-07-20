<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
    props: ['user', 'address'],

    components: {
        AppLayout,
        Header,
        Link,
        Head,
    },
    data() {
        return {
            title: "Overview",
            null: '',
        };
    },
    methods: {

    },

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
                <Link href="/users" class="text-muted text-hover-primary">Users</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="text-muted text-hover-primary">
                {{ user?.data?.first_name }}
            </li>
        </template>

        <!--begin::Navbar-->
        <Header :user="user.data" :address="address?.data" />
        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
            <!--begin::Card header-->
            <div class="card-header cursor-pointer">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Profile Details</h3>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body p-9">
                <!--begin::Row-->
                <div class="row mb-7">
                    <!--begin::Label-->
                    <!-- <label class="col-6 fw-bold fs-5 text-gray-800">Full Name</label> -->
                    <label class="col-6 fw-bold fs-5 text-gray-800">Full Name</label>

                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-6">
                        <span class="fw-bold fs-6 text-gray-800">{{ user?.data?.first_name + " " + user?.data?.last_name
                        }}</span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->

                <!--begin::Input group-->
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-6 fw-bold fs-5 text-gray-800">Contact Phone
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                            title="Phone number must be active"></i></label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-6 d-flex align-items-center">
                        <span class="fw-bold fs-6 text-gray-800 me-2">{{ user?.data?.mobile }}</span>
                        <span class="badge badge-success">Verified</span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-6 fw-bold fs-5 text-gray-800">Email ID
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title=""></i></label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-6 d-flex align-items-center">
                        <span class="fw-bold fs-6 text-gray-800 me-2" v-if="user?.data?.email">
                            {{ user?.data?.email }}
                        </span>
                        <span class="fw-bold fs-6 text-gray-800 me-2" v-else>
                            N / A
                        </span>
                        <div class="fw-bold fs-2" v-if="user?.data?.email_verified_at == null">
                            <Link href="#" class="badge badge-danger">Not Verified
                            </Link>

                        </div>
                        <div class="fw-bold fs-2" v-else>

                            <span class="badge badge-success">Verified</span>
                        </div>

                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-6 fw-bold fs-5 text-gray-800">Country
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                            title="Country of origination"></i></label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-6">
                        <span class="fw-bold fs-6 text-gray-800">{{ user?.data?.country?.name }}</span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-6 fw-bold fs-5 text-gray-800">Communication</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-6">
                        <span class="fw-bold fs-6 text-gray-800">Email, Phone</span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-10">
                    <!--begin::Label-->
                    <label class="col-6 fw-bold fs-5 text-gray-800">Allow Changes</label>
                    <!--begin::Label-->
                    <!--begin::Label-->
                    <div class="col-6">
                        <span class="fw-bold fs-6 text-gray-800">Yes</span>
                    </div>
                    <!--begin::Label-->
                </div>
                <!--end::Input group-->
                <!--begin::Notice-->
                <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                    <!--begin::Icon-->
                    <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                    <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                            <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)"
                                fill="currentColor" />
                            <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)"
                                fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <!--end::Icon-->
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack flex-grow-1">
                        <!--begin::Content-->
                        <div class="fw-semibold">
                            <h4 class="text-gray-900 fw-bold">We need your attention!</h4>
                            <div class="fs-6 text-gray-700">Your payment was declined. To start using tools, please
                                <a class="fw-bold" href="billing.html">Add Payment Method</a>.
                            </div>
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Notice-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::details View-->
    </AppLayout>
</template>
