<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "../../Components/Company/Header.vue";

import { Head, Link } from "@inertiajs/inertia-vue3";
import useVuelidate from "@vuelidate/core";
import AccountComponent from "../../Components/Company/Account/AccountComponent.vue";
import FormAccount from "../../Components/Company/Account/Model/FormAccount.vue";

export default defineComponent({
    props: ['company', 'onOnhide'],
    emits: ['onhide', 'hidemodel'],
    setup() {
        return {
            v$: useVuelidate(),
            // isEdit: false
        };
    },
    data() {
        return {
            isEdit: false,
        }
    },
    components: {
        AppLayout,
        Header,
        Link,
        Head,
        AccountComponent,
        FormAccount,

    },
    methods: {
        toggleModal(value) {
            this.isEdit = value;
        }

    },
    created() {



    }
});
</script>
<template>
    <Head title="Company Account" />
    <AppLayout>
        <Header>
            <!--begin::details View-->
            <!--begin::Billing Account-->
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Title-->
                    <div class="card-title">
                        <h3>Company Account Details</h3>
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <FormAccount :show="isEdit" @hidemodal="toggleModal" :company="company" />
                <div class="card-body">
                    <!--begin::Accounts-->
                    <div class="row gx-9 gy-6">
                        <!-- {{ company.data.company_account }} -->
                        <!--begin::Col-->
                        <AccountComponent :company="company" />
                        <!--end::Col-->

                        <div class="col-xl-6">
                            <!--begin::Notice-->
                            <div
                                class="notice d-flex bg-light-primary rounded border-primary border border-dashed flex-stack h-xl-100 mb-10 p-6">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                                    <!--begin::Content-->
                                    <div class="mb-3 mb-md-0 fw-semibold">
                                        <h4 class="text-gray-900 fw-bold">This is a very important note!</h4>
                                        <div class="fs-6 text-gray-700 pe-7">Writing headlines for blog posts is much
                                            science and probably cool audience</div>
                                    </div>
                                    <!--end::Content-->
                                    <!--begin::Action-->
                                    <button class="btn btn-primary px-6 align-self-center text-nowrap"
                                        @click=toggleModal(true)>New Account</button>
                                    <!--end::Action-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Notice-->
                        </div>
                    </div>
                    <!--end::Accounts-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Billing Account-->
        </Header>
    </AppLayout>
</template>
