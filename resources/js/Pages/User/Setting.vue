<script>
import { defineComponent } from "vue";
import AppLayout from "../../Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import UserEmail from "./Components/Setting/UserEmail.vue";
import TwoFactor from "./Components/Setting/TwoFactor.vue";
import UserPassword from "./Components/Setting/UserPassword.vue";
import DeactivateAccount from "./Components/Setting/DeactivateAccount.vue";
import EmailPreference from "./Components/Setting/EmailPreference.vue";
import Notification from "./Components/Setting/Notification.vue";
import UserInfo from "./Components/Setting/UserInfo.vue";

export default defineComponent({
    props: ['address', 'user'],

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
        UserEmail,
        TwoFactor,
        UserPassword,
        DeactivateAccount,
        EmailPreference,
        Notification,
        UserInfo
    },
    methods: {
        onAvatarChange(e) {
            this.avatar = URL.createObjectURL(e.target.files[0]);
        },
    },
    created() {

    }
});
</script>
<template>
    <Head title="User Setting" />

        <AppLayout title="User">

        <div class="app-content flex-column-fluid ">
            <!--begin::Content container-->
            <div class="app-container container-xxl">
                <Header :user="user?.data" :address="address?.data" />
                <!--begin::Basic info-->
                <UserInfo :user="user?.data" :address="address?.data" />
                <!--end::Basic info-->
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
                            <UserEmail :email='this.user?.data' />
                            <!--end::Email Address-->
                            <!--begin::Separator-->
                            <div class="separator separator-dashed my-6"></div>
                            <!--end::Separator-->
                            <!--begin::Password-->
                            <UserPassword :password="this.user?.data" />
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
                <!--begin::Email Preferences-->
                <EmailPreference />
                <!--end::Email Preferences-->
                <!--begin::Notifications-->

                <Notification />
                <!--end::Notifications-->
                <!--begin::Deactivate Account-->
                <DeactivateAccount :user="this.user" />
                <!--end::Deactivate Account-->
            </div>
        </div>

    </AppLayout>
</template>
