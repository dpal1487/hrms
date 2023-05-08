<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";

import { Head, Link } from "@inertiajs/inertia-vue3";
import useVuelidate from "@vuelidate/core";
import AddressCard from "./Components/Address/AddressCard.vue";
import FormAddress from "./Components/Address/FormAddress.vue";

export default defineComponent({
    props: ['addresses', 'countries'],
    emits: ['hidemodal', 'address'],
    setup() {
        return {
            v$: useVuelidate(),
        };
    },
    data() {
        return {
            isEdit: false,
            isLoading: false,
            address: [],
            showModal: false,
        }
    },
    components: {
        AppLayout,
        Header,
        Link,
        Head,
        AddressCard,
        FormAddress
    },
    methods: {
        toggleModal(value) {
            if (value) {
                this.showModal = true;
            }
            else {
                this.showModal = false;
            }
        }
    },
    created() {

    }
});
</script>
<template>
    <Head title="Company Address" />
    <AppLayout>
        <formAddress :show="showModal" :isEdit="false" @hidemodal="toggleModal(false)" :countries="countries" />
        <div class="app-content flex-column-fluid ">
            <!--begin::Content container-->
            <div class="app-container container-xxl">
                <Header />
                <!--begin::details View-->
                <!--begin::Company Address-->
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Title-->
                        <div class="card-title">
                            <h3>Manage Address</h3>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Addresses-->
                        <div class="row gx-9 gy-6">
                            <!--begin::Col-->
                            <AddressCard :countries="countries" :addresses="addresses" />
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
                                            @click=toggleModal(true)>New Address</button>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Notice-->
                            </div>
                        </div>
                        <!--end::Addresses-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Company Address-->
            </div>
            <!--end::Content container-->
        </div>
    </AppLayout>
</template>
