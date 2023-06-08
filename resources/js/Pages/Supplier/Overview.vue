<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import PrimaryButton from "@/Jetstream/Button.vue";
import Edit from "./Edit.vue";

export default defineComponent({
    props: ['supplier', 'address', 'company'],
    data() {
        return {
            isEdit: false,

        }
    },
    components: {
        AppLayout,
        Header,
        PrimaryButton,
        Link,
        Head,
        Edit
    },

});
</script>
<template>
    <Head title="Supplier Overview" />
    <AppLayout>
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/supplier" class="text-muted text-hover-primary">Supplier</Link>
            </li>
        </template>
        <div class="app-content flex-column-fluid ">
            <!--begin::Content container-->
            <div class="app-container container-xxl">
                <!--begin::Navbar-->
                <Header :supplier="supplier?.data" :address="address?.data" />
                <!-- {{ $page }} -->
                <!--begin::details View-->
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header cursor-pointer">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">Manage Supplier </h3>
                            <!-- {{ supplier }} -->
                        </div>
                        <!--end::Card title-->
                        <button class="btn btn-primary align-self-center"
                            @click="this.isEdit = this.isEdit ? false : true"><i class="bi bi-pencil me-2"></i>Edit Company
                        </button>

                        <!-- <a href="settings.html" class="btn btn-primary align-self-center">Edit Profile</a> -->
                    </div>
                    <!--begin::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body p-9">

                        <Edit v-if="isEdit" :supplier="supplier" :company="company" />
                        <div v-else>
                            <!--begin::Row-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-6 fw-bold fs-5 text-gray-800">Company Name</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6">
                                    <span class="fw-bold fs-6 text-gray-700">{{ this.supplier?.data?.company?.company_name
                                    }}
                                    </span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-6 fw-bold fs-5 text-gray-800">Supplier Name</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <span class="fw-bold fs-6 text-gray-700">{{ this.supplier?.data?.supplier_name }}
                                    </span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-6 fw-bold fs-5 text-gray-800">Display Name</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <span class="fw-bold fs-6 text-gray-700">{{ this.supplier?.data?.display_name }}
                                    </span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-6 fw-bold fs-5 text-gray-800">Website
                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6 d-flex align-items-center">
                                    <span class="fw-bold fs-6 text-gray-700">{{ this.supplier?.data?.website }} </span>

                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-6 fw-bold fs-5 text-gray-800">Skype ID</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6">
                                    <span class="fw-bold fs-6 text-gray-700">{{
                                        this.supplier?.data?.skype_profile }} </span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-6 fw-bold fs-5 text-gray-800">Linked Profile ID</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6">
                                    <span class="fw-bold fs-6 text-gray-700">{{ this.supplier?.data?.linkedIn_profile
                                    }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-6 fw-bold fs-5 text-gray-800">Description</label>
                                <!--begin::Label-->
                                <!--begin::Label-->
                                <div class="col-lg-6">
                                    <span class="fw-bold fs-6 text-gray-700">{{ this.supplier?.data?.description }}</span>
                                </div>
                                <!--begin::Label-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-6 fw-bold fs-5 text-gray-800">Status</label>
                                <!--begin::Label-->
                                <!--begin::Label-->
                                <div class="col-lg-6">
                                    <span class="fw-bold fs-6 text-gray-700"
                                        v-if="this.supplier?.data?.status == 1">Active</span>
                                    <span class="fw-bold fs-6 text-gray-700"
                                        v-if="this.supplier?.data?.status == 0">Inactive</span>
                                </div>
                                <!--begin::Label-->
                            </div>
                            <!--end::Input group-->
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
            </div>
        </div>
        <!--end::details View-->
    </AppLayout>
</template>
