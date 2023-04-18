<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import UserLayout from "@/Layouts/UserLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

import useVuelidate from "@vuelidate/core";

import UserEmail from "@/Components/User/UserEmail.vue";
import TwoFactor from "@/Components/User/TwoFactor.vue";
import UserPassword from "../../Components/User/UserPassword.vue";
import DeactivateAccount from "../../Components/User/DeactivateAccount.vue";
// Vue.use(Datetime);
// import { Datetime } from 'vue-datetime';

export default defineComponent({
    props: ["employees", 'employee'],
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
        UserLayout,
        Link,
        Head,
        UserEmail,
        TwoFactor,
        UserPassword,
        DeactivateAccount
    },
    methods: {
        onAvatarChange(e) {
            console.log("see file", e.target.files[0], this);
            this.avatar = URL.createObjectURL(e.target.files[0]);
        },
        // removeSelectedAvatar() {
        //     this.avatar = null;
        // },
        // removeExistingAvatar() {
        //     alert("Are you sure ?...")
        // }
    },
    created() {

    }
});
</script>
<template>
    <Head :title="Address" />

    <AppLayout>
        <UserLayout :employee="employee">

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
                        <UserEmail :email='this.employee?.data?.user' />
                        <!--end::Email Address-->
                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-6"></div>
                        <!--end::Separator-->
                        <!--begin::Password-->
                        <UserPassword :password="this.employee?.data?.user" />
                        <!--end::Password-->
                        <!--begin::Notice-->
                        <TwoFactor />
                        <!--end::Notice-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Sign-in Method-->
            <!--begin::Deactivate Account-->
            <DeactivateAccount />
            <!--end::Deactivate Account-->
        </UserLayout>
    </AppLayout>
</template>
