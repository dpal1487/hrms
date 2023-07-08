
<style>
.toggle {
    z-index: 107;
    position: absolute;
    top: 100%;
    right: 0;
    margin: 0px;
}
</style>
<script>
import { defineComponent } from "vue"
import AppLayout from "@/Layouts/AppLayout.vue"
import { Head, Link } from "@inertiajs/inertia-vue3";
import ChatLayout from "../Layouts/ChatLayout.vue";

export default defineComponent({

    props: ['users'],

    data() {
        return {
            isContact: false,
            showAddContacModal: false,
            showInviteContacModal: false,
            user: null,

        }
    },
    components: {
        AppLayout,
        Head,
        Link,
        ChatLayout
    },
    methods: {
        ToggleMenu() {
            this.isContact = !this.isContact;
        },
        handleUserClick(id) {
            this.user = this.users?.data.find(user => user.id == id);
        }
    },
    mounted() {
        const queryParams = new URLSearchParams(window.location.search);
        const uid = queryParams.get('uid');
        this.user = uid ? this.users?.data.find(user => user.id == uid) : null;
    },
});
</script>

<template>
    <ChatLayout :users="users" :user="user" @userClick="handleUserClick">
        <div class="card-body" id="kt_chat_messenger_body">
            <!--begin::Messages-->
            <div class="scroll-y me-n5 pe-5 h-300px h-lg-auto" data-kt-element="messages" data-kt-scroll="true"
                data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                data-kt-scroll-dependencies="#kt_header, #kt_app_header, #kt_app_toolbar, #kt_toolbar, #kt_footer, #kt_app_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer"
                data-kt-scroll-wrappers="#kt_content, #kt_app_content, #kt_chat_messenger_body" data-kt-scroll-offset="5px">
                <!--begin::Message(in)-->
                <div class="d-flex justify-content-start mb-10">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column align-items-start">
                        <!--begin::User-->
                        <div class="d-flex align-items-center mb-2">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-35px symbol-circle" v-if="user?.full_path">
                                <img alt="Pic" :src="user.full_path" />
                            </div>
                            <div class="symbol symbol-35px symbol-circle" v-else>
                                <img alt="Pic" src="/assets/media/avatars/300-5.jpg" />
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Details-->
                            <div class="ms-3">
                                <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Brian
                                    Cox</a>
                                <span class="text-muted fs-7 mb-1">2 mins</span>
                            </div>
                            <!--end::Details-->
                        </div>
                        <!--end::User-->
                        <!--begin::Text-->
                        <div class="p-5 rounded bg-light-info text-dark fw-semibold mw-lg-400px text-start"
                            data-kt-element="message-text">How likely are you to recommend our
                            company to your friends and family ?</div>
                        <!--end::Text-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Message(in)-->
                <!--begin::Message(out)-->
                <div class="d-flex justify-content-end mb-10">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column align-items-end">
                        <!--begin::User-->
                        <div class="d-flex align-items-center mb-2">
                            <!--begin::Details-->
                            <div class="me-3">
                                <span class="text-muted fs-7 mb-1">5 mins</span>
                                <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
                            </div>
                            <!--end::Details-->
                            <!--begin::Avatar-->
                            <div class="symbol symbol-35px symbol-circle">
                                <img alt="Pic" src="/assets/media/avatars/300-1.jpg" />
                            </div>
                            <!--end::Avatar-->
                        </div>
                        <!--end::User-->
                        <!--begin::Text-->
                        <div class="p-5 rounded bg-light-primary text-dark fw-semibold mw-lg-400px text-end"
                            data-kt-element="message-text">Hey there, we’re just writing to let
                            you know that you’ve been subscribed to a repository on GitHub.
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Message(out)-->
            </div>
            <!--end::Messages-->
        </div>
    </ChatLayout>
</template>
    