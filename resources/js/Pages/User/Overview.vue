<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import PrimaryButton from "@/Jetstream/Button.vue";

export default defineComponent({
    props: ['user', 'address'],
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
    <Head title="Account Overview" />
    <AppLayout>

        <div class="app-content flex-column-fluid ">
            <!--begin::Content container-->
            <div class="app-container container-xxl">
                <!--begin::Navbar-->
                <Header :user="user.data" :address="address?.data" />
                <!-- {{ $page }} -->
                <!--begin::details View-->
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header cursor-pointer">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0"> Account Overview</h3>
                        </div>
                        <!--end::Card title-->
                        <!-- <Link class="btn btn-primary align-self-center" href="/account/overview/edit">Edit
                        Account
                        </Link> -->
                        <!-- <a href="settings.html" class="btn btn-primary align-self-center">Edit Profile</a> -->
                    </div>
                    <!--begin::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body p-9">
                        <!-- {{ user }} -->
                        <!--begin::Row-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Full Name</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <span class="fw-bold fs-6 text-gray-800">{{ this.user?.data?.first_name }} {{
                                    this.user?.data?.last_name }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Email</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-semibold text-gray-800 fs-6">{{ this.user?.data?.email }}
                                </span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->


                    </div>
                    <!--end::Card body-->
                </div>
            </div>
        </div>
        <!--end::details View-->
    </AppLayout>
</template>
