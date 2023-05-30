<script>
import { defineComponent } from 'vue';

import { Link } from "@inertiajs/inertia-vue3";
import CreateTicket from './CreateTicket.vue';


export default defineComponent({
    props: ['employees'],
    emits: ['onhide'],
    data() {
        return {
            isModalOpen: false,
        }
    },

    components: {
        Link,
        CreateTicket
    },
    methods: {
        showCreateTicketModal() {
            this.isModalOpen = true;
        },
        hideCreateTicketModal() {
            this.isModalOpen = false;
        }
    }


})
</script>

<template>
    <CreateTicket :show="isModalOpen" @hidemodal="hideCreateTicketModal" :employees="employees" />
    <!--begin::Hero card-->
    <div class="card mb-12">
        <!--begin::Hero body-->
        <div class="card-body flex-column p-5">
            <!--begin::Hero content-->
            <div class="d-flex align-items-center h-lg-300px p-5 p-lg-15">
                <!--begin::Wrapper-->
                <div class="d-flex flex-column align-items-start justift-content-center flex-equal me-5">
                    <!--begin::Title-->
                    <h1 class="fw-bold fs-4 fs-lg-1 text-gray-800 mb-5 mb-lg-10">How Can We Help You?
                    </h1>
                    <!--end::Title-->
                    <!--begin::Input group-->
                    <div class="position-relative w-100">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                        <span class="svg-icon svg-icon-2 svg-icon-primary position-absolute top-50 translate-middle ms-8">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                    transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <input type="text" class="form-control fs-4 py-4 ps-14 text-gray-700 placeholder-gray-400 mw-500px"
                            name="search" value="" placeholder="Ask a question" />
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Wrapper-->
                <!--begin::Wrapper-->
                <div class="flex-equal d-flex justify-content-center align-items-end ms-5">
                    <!--begin::Illustration-->
                    <img src="/assets/media/illustrations/sketchy-1/20.png" alt=""
                        class="mw-100 mh-125px mh-lg-275px mb-lg-n12" />
                    <!--end::Illustration-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Hero content-->
            <!--begin::Hero nav-->
            <div class="card-rounded bg-light d-flex flex-stack flex-wrap p-5 gap-2">
                <!--begin::Nav-->
                <ul class="nav flex-wrap border-transparent fw-bold gap-1">
                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <Link
                            :class="`btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${route().current('support.show') && 'active'}`"
                            href="/support"> Overview
                        </Link>

                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <Link
                            :class="`btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${route().current('support.tickets') && 'active'}`"
                            href="/support/tickets">Tickets</Link>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <Link
                            :class="`btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${route().current('support.tutorials') && 'active'}`"
                            href="/support/tutorials">Tutorials</Link>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <Link
                            :class="`btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${route().current('support.faq') && 'active'}`"
                            href="/support/faq">FAQ</Link>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <Link
                            :class="`btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${route().current('support.licenses') && 'active'}`"
                            href="/support/licenses">Licenses</Link>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <Link
                            :class="`btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${route().current('support.contact-us') && 'active'}`"
                            href="/support/contact-us">Contact US</Link>
                    </li>
                    <!--end::Nav item-->
                </ul>
                <!--end::Nav-->
                <!--begin::Action-->
                <button type="submit" @click="showCreateTicketModal" class="btn btn-primary fw-bold fs-8 fs-lg-base">Create
                    Ticket</button>
                <!--end::Action-->
            </div>
            <!--end::Hero nav-->

        </div>
        <!--end::Hero body-->
    </div>
    <!--end::Hero card-->
</template>