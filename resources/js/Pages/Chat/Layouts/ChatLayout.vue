<script>
import { Head, Link, InertiaLink } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import { Inertia } from "@inertiajs/inertia";

export default {
    props: ['users', 'user', 'uid'],

    components: {
        Head,
        Link,
        InertiaLink,
        JetInput
    },

    data() {
        return {
            isContact: false,
            form: {},
            form: this.$inertia.form({
                message: ''
            }),
        };
    },


    methods: {
        submit() {

            this.form
                .transform((data) => ({
                    ...data,
                    id: this.user?.id,
                }))
            this.form.post(route('chat.store'));
            this.form.reset();
        },
        ToggleMenu() {
            this.isContact = !this.isContact;
        },

        search() {
            Inertia.get(
                "/chat",
                this.form,
            );
        },
    },

    computed: {

    },
};
</script>


<template>
    <div class="d-flex flex-column flex-lg-row">
        <!--begin::Sidebar-->
        <div class="flex-column flex-lg-row-auto w-100 w-lg-300px w-xl-400px mb-10 mb-lg-0">
            <!--begin::Contacts-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header pt-7" id="kt_chat_contacts_header">
                    <!--begin::Form-->
                    <form class="w-100 position-relative" autocomplete="off" @submit.prevent="search()">
                        <!--begin::Icon-->
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                        <span
                            class="svg-icon svg-icon-2 svg-icon-lg-1 svg-icon-gray-500 position-absolute top-50 ms-5 translate-middle-y">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                    transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <!--end::Icon-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid px-15" v-model="form.q"
                            placeholder="Search by username or email..." />
                        <!--end::Input-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-5" id="kt_chat_contacts_body">
                    <!--begin::List-->
                    <div class="scroll-y me-n5 pe-5 h-200px h-lg-auto" data-kt-scroll="true"
                        data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_header, #kt_app_header, #kt_toolbar, #kt_app_toolbar, #kt_footer, #kt_app_footer, #kt_chat_contacts_header"
                        data-kt-scroll-wrappers="#kt_content, #kt_app_content, #kt_chat_contacts_body"
                        data-kt-scroll-offset="5px">
                        <!--begin::User-->
                        <div class="d-flex flex-stack py-4" v-for="user in users?.data">
                            <!--begin::Details-->
                            <div class="d-flex align-items-center">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-45px symbol-circle">
                                    <span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">M</span>
                                    <div class="symbol-badge bg-success start-100 top-100 border-4 h-8px w-8px ms-n2 mt-n2">
                                    </div>
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Details-->
                                <div class="ms-5">
                                    <!-- <button @click="() => $emit('userClick', user.id)">
                                        {{
                                            user?.first_name + " " + user?.last_name }}
                                    </button> -->
                                    <Link preserve-state @click="() => $emit('userClick', user.id)"
                                        :href="`/chat?uid=${user.id}`"
                                        class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">{{
                                            user?.first_name + " " + user?.last_name }}</Link>
                                    <div class="fw-semibold text-muted">{{ user?.email }}</div>
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::Details-->
                            <!--begin::Lat seen-->
                            <div class="d-flex flex-column align-items-end ms-2">
                                <span class="text-muted fs-7 mb-1">1 week</span>
                                <span class="badge badge-sm badge-circle badge-light-warning">9</span>
                            </div>
                            <!--end::Lat seen-->
                        </div>
                        <!--end::User-->
                        <!--begin::Separator-->
                        <div class="separator separator-dashed d-none"></div>
                        <!--end::Separator-->

                    </div>
                    <!--end::List-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Contacts-->
        </div>
        <!--end::Sidebar-->

        <!--begin::Content-->
        <div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">
            <!--begin::Messenger-->
            <div v-if="user" class="card">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Title-->
                    <div class="card-title">

                        <!--begin::User-->
                        <div class="d-flex justify-content-center flex-column me-3">
                            <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 mb-2 lh-1">{{
                                user?.first_name + " " + user?.last_name }} </a>
                            <!--begin::Info-->
                            <div class="mb-0 lh-1">
                                <span class="badge badge-success badge-circle w-10px h-10px me-1"></span>
                                <span class="fs-7 fw-semibold text-muted">Active</span>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                    </div>
                    <!--end::Title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Menu-->
                        <div class="me-n3 position-relative">
                            <button class="btn btn-sm btn-icon btn-active-light-primary" @click="ToggleMenu"
                                data-kt-menu-placement="bottom-end">
                                <i class="bi bi-three-dots fs-2"></i>
                            </button>
                            <!--begin::Menu 3-->

                            <div v-if="isContact"
                                class="toggle  menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3 show"
                                data-kt-menu="true" data-popper-placement="bottom-end">
                                <!--begin::Heading-->
                                <div class="menu-item px-3">
                                    <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
                                    </div>
                                </div>
                                <!--end::Heading-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" @click=toggleAddContactModal(true)> Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu 3-->
                        </div>
                        <!--end::Menu-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <slot />
                <!--end::Card body-->
                <!--begin::Card footer-->
                <div class="card-footer pt-4">
                    <form @submit.prevent="submit()">

                        <!--begin::Input-->
                        <jet-input type="text" v-model="form.message" placeholder="Type a message..." />
                        <!--end::Input-->
                        <!--begin:Toolbar-->
                        <div class="d-flex flex-end">
                            <!--begin::Send-->
                            <button preserve-state class="btn btn-primary btn-sm my-5" type="submit"><i
                                    class="bi bi-send"></i>
                                Send</button>
                            <!--end::Send-->
                        </div>
                    </form>

                    <!--end::Toolbar-->
                </div>
                <!--end::Card footer-->
            </div>


            <div v-else class="card">
                <!--begin::Card body-->
                <div class="card-body h-100 text-center">
                    <!--begin::Messages-->
                    <span class="fs-2 text-gray-900 text-center">No messages, yet?</span>


                    <!--end::Messages-->
                </div>
                <!--end::Card body-->
            </div>

            <!--end::Messenger-->
        </div>
        <!--end::Content-->
    </div>
</template>


