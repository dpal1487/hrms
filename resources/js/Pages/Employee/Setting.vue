<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";

import { Head, Link } from "@inertiajs/inertia-vue3";

import useVuelidate from "@vuelidate/core";




// Vue.use(Datetime);
// import { Datetime } from 'vue-datetime';

export default defineComponent({
    props: ['employee', 'user'],
    setup() {
        return { v$: useVuelidate() };
    },
    data() {
        return {
            avatar: null,
        }
    },
    components: {
        AppLayout,
        Header,
        Link,
        Head,
    },
    methods: {
        onAvatarChange(e) {
            console.log("see file", e.target.files[0], this);
            this.avatar = URL.createObjectURL(e.target.files[0]);
        },
    },
    created() {

    }
});
</script>
<template>
    <Head title="Employee Setting" />

    <AppLayout>
        <Header :user="user.data" :employee="employee.data" />


        <!--begin::Sign-in Method-->
        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header border-0 cursor-pointer" role="button">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Sign-in Method</h3>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Content-->
            <div class="collapse show">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <!--begin::Email Address-->
                    <div class="d-flex flex-wrap align-items-center">
                        <!--begin::Label-->
                        <div>
                            <div class="fs-6 fw-bold mb-1">Email Address</div>
                            <div class="fw-semibold text-gray-600">support@keenthemes.com</div>
                        </div>
                        <!--end::Label-->
                        <!--begin::Edit-->
                        <div class="flex-row-fluid d-none">
                            <!--begin::Form-->
                            <form class="form" novalidate="novalidate">
                                <div class="row mb-6">
                                    <div class="col-lg-6 mb-4 mb-lg-0">
                                        <div class="fv-row mb-0">
                                            <label for="emailaddress" class="form-label fs-6 fw-bold mb-3">Enter New
                                                Email Address</label>
                                            <input type="email" class="form-control form-control-lg form-control-solid"
                                                id="emailaddress" placeholder="Email Address" name="emailaddress"
                                                value="support@keenthemes.com" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="fv-row mb-0">
                                            <label for="confirmemailpassword" class="form-label fs-6 fw-bold mb-3">Confirm
                                                Password</label>
                                            <input type="password" class="form-control form-control-lg form-control-solid"
                                                name="confirmemailpassword" id="confirmemailpassword" />
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <button type="button" class="btn btn-primary me-2 px-6">Update
                                        Email</button>
                                    <button type="button"
                                        class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancel</button>
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Edit-->
                        <!--begin::Action-->
                        <div class="ms-auto">
                            <button class="btn btn-light btn-active-light-primary">Change Email</button>
                        </div>
                        <!--end::Action-->
                    </div>
                    <!--end::Email Address-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-6"></div>
                    <!--end::Separator-->
                  
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Sign-in Method-->

      
    </AppLayout>
</template>
