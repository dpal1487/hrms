<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import PrimaryButton from "@/Jetstream/Button.vue";


export default defineComponent({
    props: ['company'],

    components: {
        AppLayout,
        Header,
        PrimaryButton,
        Link,
        Head
    },

});
</script>
<template>
    <Head title="Overview" />
    <AppLayout>
        <div class="app-content flex-column-fluid ">
            <!--begin::Content container-->
            <div class="app-container container-xxl">
                <Header />
                <!--begin::details View-->
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header cursor-pointer">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">Company Details</h3>
                            <!-- {{ company.data }} -->
                        </div>
                        <!--end::Card title-->
                        <Link class="btn btn-primary align-self-center" :href="`/company/overview/edit`">
                        Edit
                        Company
                        </Link>
                        <!-- <a href="settings.html" class="btn btn-primary align-self-center">Edit Profile</a> -->
                    </div>
                    <!--begin::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body p-9">
                        <!--begin::Row-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-6 fw-semibold text-muted">User Name</label>
                            <!--end::Label-->
                            <!-- {{ company?.data?.user }} -->
                            <!--begin::Col-->
                            <div class="col-lg-6">
                                <span class="fw-bold fs-6 text-gray-800"> {{ company?.data?.user?.first_name + " " +
                                    company?.data?.user.last_name }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                        <!--begin::Row-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-6 fw-semibold text-muted">Company Type</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-6">
                                <span class="fw-bold fs-6 text-gray-800"> {{ company?.data?.company_type }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-6 fw-semibold text-muted">Company Size</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row">
                                <span class="fw-semibold text-gray-800 fs-6">{{ this.company?.data?.size.size }}
                                </span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-6 fw-semibold text-muted">Corporation Type</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-6 d-flex align-items-center">
                                <span class="fw-bold fs-6 text-gray-800 me-2">{{ this.company?.data?.corporation_type_id }}
                                </span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-6 fw-semibold text-muted">Legal Registration_no</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-6 d-flex align-items-center">
                                <span class="fw-bold fs-6 text-gray-800 me-2">{{ this.company?.data?.legal_registration_no
                                }}
                                </span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-6 fw-semibold text-muted">Description</label>
                            <!--begin::Label-->
                            <!--begin::Label-->
                            <div class="col-lg-6">
                                <span class="fw-semibold fs-6 text-gray-800">{{ this.company?.data?.description }}</span>
                            </div>
                            <!--begin::Label-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-6 fw-semibold text-muted">Website</label>
                            <!--begin::Label-->
                            <!--begin::Label-->
                            <div class="col-lg-6">
                                <span class="fw-semibold fs-6 text-gray-800">{{ this.company?.data?.website }}</span>
                            </div>
                            <!--begin::Label-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-6 fw-semibold text-muted">Subdomain</label>
                            <!--begin::Label-->
                            <!--begin::Label-->
                            <div class="col-lg-6">
                                <span class="fw-semibold fs-6 text-gray-800">{{ this.company?.data?.subdomain
                                }}</span>
                            </div>
                            <!--begin::Label-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-6 fw-semibold text-muted">Linkedin Profile</label>
                            <!--begin::Label-->
                            <!--begin::Label-->
                            <div class="col-lg-6">
                                <span class="fw-semibold fs-6 text-gray-800">{{ this.company?.data?.linkedin_profile
                                }}</span>
                            </div>
                            <!--begin::Label-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-6 fw-semibold text-muted">Skype Profile</label>
                            <!--begin::Label-->
                            <!--begin::Label-->
                            <div class="col-lg-6">
                                <span class="fw-semibold fs-6 text-gray-800">{{ this.company?.data?.skype_profile
                                }}</span>
                            </div>
                            <!--begin::Label-->
                        </div>
                        <!--end::Input group-->

                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::details View-->
            </div>
            <!--end::Content container-->
        </div>
    </AppLayout>
</template>
