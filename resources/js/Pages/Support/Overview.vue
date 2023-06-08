<script>
import { defineComponent } from 'vue';
import AppLayout from '../../Layouts/AppLayout.vue';
import Header from './Components/Header.vue';
import { Link } from '@inertiajs/inertia-vue3';

export default defineComponent({

    props: ['employees'],
    components: {
        AppLayout,
        Header,
        Link
    }
})
</script>


<template>
    <AppLayout>
        <Header :employees="employees.data" />
        <template #breadcrumb>

            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/support" class="text-muted text-hover-primary">Support</Link>
            </li>

        </template>

        <!--begin::Row-->
        <div class="row gy-0 mb-6 mb-xl-12">
            <!--begin::Col-->
            <div class="col-md-6">
                <!--begin::Card-->
                <div class="card card-md-stretch me-xl-3 mb-md-0 mb-6">
                    <!--begin::Body-->
                    <div class="card-body p-10 p-lg-15">
                        <!--begin::Header-->
                        <div class="d-flex flex-stack mb-7">
                            <!--begin::Title-->
                            <h1 class="fw-bold text-dark">Popular Tickets</h1>
                            <!--end::Title-->
                            <!--begin::Section-->
                            <div class="d-flex align-items-center">
                                <!--begin::Link-->
                                <Link href="/support/tickets" class="text-primary fw-bold me-1">Support</Link>
                                <!--begin::Link-->
                                <!--begin::Arrow-->
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                <span class="svg-icon svg-icon-2 svg-icon-primary">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                            transform="rotate(-180 18 13)" fill="currentColor" />
                                        <path
                                            d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <!--end::Arrow-->
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Accordion-->
                        <!--begin::Section-->
                        <div class="m-0">
                            <!--begin::Heading-->
                            <div class="d-flex align-items-center collapsible py-3 toggle mb-0" data-bs-toggle="collapse"
                                data-bs-target="#kt_support_1_1">
                                <!--begin::Icon-->
                                <div class="ms-n1 me-5">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                    <span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                                    <span class="svg-icon toggle-off svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-wrap">
                                    <!--begin::Title-->
                                    <h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">What
                                        admin theme does?</h3>
                                    <!--end::Title-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light my-1 d-block">React</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Body-->
                            <div id="kt_support_1_1" class="collapse show fs-6 ms-10">
                                <!--begin::Block-->
                                <div class="mb-4">
                                    <!--begin::Text-->
                                    <span class="text-muted fw-semibold fs-5">By Keenthemes to save tons and
                                        more to time money projects are listed and outstanding</span>
                                    <!--end::Text-->
                                    <!--begin::Link-->
                                    <a href="#" class="fs-5 link-primary fw-semibold">Check Out</a>
                                    <!--end::Link-->
                                </div>
                                <!--end::Block-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Body-->
                        <!--begin::Section-->
                        <div class="m-0">
                            <!--begin::Heading-->
                            <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0"
                                data-bs-toggle="collapse" data-bs-target="#kt_support_1_6">
                                <!--begin::Icon-->
                                <div class="ms-n1 me-5">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                    <span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                                    <span class="svg-icon toggle-off svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-wrap">
                                    <!--begin::Title-->
                                    <h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">How many
                                        end projects I can build?</h3>
                                    <!--end::Title-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light my-1 d-block">PHP</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Body-->
                            <div id="kt_support_1_6" class="collapse fs-6 ms-10">
                                <!--begin::Block-->
                                <div class="mb-4">
                                    <!--begin::Text-->
                                    <span class="text-muted fw-semibold fs-5">By Keenthemes to save tons and
                                        more to time money projects are listed and outstanding</span>
                                    <!--end::Text-->
                                    <!--begin::Link-->
                                    <a href="#" class="fs-5 link-primary fw-semibold">Check Out</a>
                                    <!--end::Link-->
                                </div>
                                <!--end::Block-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Body-->
                        <!--end::Accordion-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-6">
                <!--begin::Card-->
                <div class="card card-md-stretch ms-xl-3">
                    <!--begin::Body-->
                    <div class="card-body p-10 p-lg-15">
                        <!--begin::Header-->
                        <div class="d-flex flex-stack mb-7">
                            <!--begin::Title-->
                            <h1 class="fw-bold text-dark">FAQ</h1>
                            <!--end::Title-->
                            <!--begin::Section-->
                            <div class="d-flex align-items-center">
                                <!--begin::Link-->
                                <Link href="/support/faq" class="text-primary fw-bold me-1">Full
                                FAQ</Link>
                                <!--begin::Link-->
                                <!--begin::Arrow-->
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                <span class="svg-icon svg-icon-2 svg-icon-primary">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                            transform="rotate(-180 18 13)" fill="currentColor" />
                                        <path
                                            d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <!--end::Arrow-->
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Accordion-->
                        <!--begin::Section-->
                        <div class="m-0">
                            <!--begin::Heading-->
                            <div class="d-flex align-items-center collapsible py-3 toggle mb-0" data-bs-toggle="collapse"
                                data-bs-target="#kt_support_2_1">
                                <!--begin::Icon-->
                                <div class="ms-n1 me-5">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                    <span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                                    <span class="svg-icon toggle-off svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-wrap">
                                    <!--begin::Title-->
                                    <h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">What
                                        admin theme does?</h3>
                                    <!--end::Title-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light my-1 d-none">Bootstrap</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Body-->
                            <div id="kt_support_2_1" class="collapse show fs-6 ms-10">
                                <!--begin::Block-->
                                <div class="mb-4">
                                    <!--begin::Text-->
                                    <span class="text-muted fw-semibold fs-5">By Keenthemes to save tons and
                                        more to time money projects are listed and outstanding</span>
                                    <!--end::Text-->
                                    <!--begin::Link-->
                                    <a href="#" class="d-none"></a>
                                    <!--end::Link-->
                                </div>
                                <!--end::Block-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Body-->
                        <!--begin::Section-->
                        <div class="m-0">
                            <!--begin::Heading-->
                            <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0"
                                data-bs-toggle="collapse" data-bs-target="#kt_support_2_2">
                                <!--begin::Icon-->
                                <div class="ms-n1 me-5">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                    <span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                                    <span class="svg-icon toggle-off svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-wrap">
                                    <!--begin::Title-->
                                    <h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">How
                                        Extended Licese works?</h3>
                                    <!--end::Title-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light my-1 d-none">General</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Body-->
                            <div id="kt_support_2_2" class="collapse fs-6 ms-10">
                                <!--begin::Block-->
                                <div class="mb-4">
                                    <!--begin::Text-->
                                    <span class="text-muted fw-semibold fs-5">By Keenthemes to save tons and
                                        more to time money projects are listed and outstanding</span>
                                    <!--end::Text-->
                                    <!--begin::Link-->
                                    <a href="#" class="d-none"></a>
                                    <!--end::Link-->
                                </div>
                                <!--end::Block-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Body-->
                        <!--end::Accordion-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
        <!--begin::Row-->
        <div class="row gy-0 mb-6 mb-xl-12">
            <!--begin::Col-->
            <div class="col-md-6">
                <!--begin::Card-->
                <div class="card card-md-stretch me-xl-3 mb-md-0 mb-6">
                    <!--begin::Body-->
                    <div class="card-body p-10 p-lg-15">
                        <!--begin::Header-->
                        <div class="d-flex flex-stack mb-7">
                            <!--begin::Title-->
                            <h1 class="fw-bold text-dark">Tutorials</h1>
                            <!--end::Title-->
                            <!--begin::Section-->
                            <div class="d-flex align-items-center">
                                <!--begin::Link-->
                                <a href="" class="text-primary fw-bold me-1">All
                                    Tutorials</a>
                                <!--begin::Link-->
                                <!--begin::Arrow-->
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                <span class="svg-icon svg-icon-2 svg-icon-primary">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                            transform="rotate(-180 18 13)" fill="currentColor" />
                                        <path
                                            d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <!--end::Arrow-->
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Accordion-->
                        <!--begin::Section-->
                        <div class="m-0">
                            <!--begin::Heading-->
                            <div class="d-flex align-items-center collapsible py-3 toggle mb-0" data-bs-toggle="collapse"
                                data-bs-target="#kt_support_3_1">
                                <!--begin::Icon-->
                                <div class="ms-n1 me-5">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                    <span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                                    <span class="svg-icon toggle-off svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-wrap">
                                    <!--begin::Title-->
                                    <h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">What
                                        admin theme does?</h3>
                                    <!--end::Title-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light my-1 d-none">Bootstrap</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Body-->
                            <div id="kt_support_3_1" class="collapse show fs-6 ms-10">
                                <!--begin::Block-->
                                <div class="mb-4">
                                    <!--begin::Text-->
                                    <span class="text-muted fw-semibold fs-5">By Keenthemes to save tons and
                                        more to time money projects are listed and outstanding</span>
                                    <!--end::Text-->
                                    <!--begin::Link-->
                                    <a href="#" class="fs-5 link-primary fw-semibold">Check Out</a>
                                    <!--end::Link-->
                                </div>
                                <!--end::Block-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Body-->
                        <!--begin::Section-->
                        <div class="m-0">
                            <!--begin::Heading-->
                            <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0"
                                data-bs-toggle="collapse" data-bs-target="#kt_support_3_2">
                                <!--begin::Icon-->
                                <div class="ms-n1 me-5">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                    <span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                                    <span class="svg-icon toggle-off svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-wrap">
                                    <!--begin::Title-->
                                    <h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">How
                                        Extended Licese works?</h3>
                                    <!--end::Title-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light my-1 d-none">General</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Body-->
                            <div id="kt_support_3_2" class="collapse fs-6 ms-10">
                                <!--begin::Block-->
                                <div class="mb-4">
                                    <!--begin::Text-->
                                    <span class="text-muted fw-semibold fs-5">By Keenthemes to save tons and
                                        more to time money projects are listed and outstanding</span>
                                    <!--end::Text-->
                                    <!--begin::Link-->
                                    <a href="#" class="fs-5 link-primary fw-semibold">Check Out</a>
                                    <!--end::Link-->
                                </div>
                                <!--end::Block-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Body-->
                        <!--end::Accordion-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-6">
                <!--begin::Card-->
                <div class="card card-md-stretch ms-xl-3">
                    <!--begin::Body-->
                    <div class="card-body pp-10 p-lg-15">
                        <!--begin::Header-->
                        <div class="d-flex flex-stack mb-7">
                            <!--begin::Title-->
                            <h1 class="fw-bold text-dark">Videos</h1>
                            <!--end::Title-->
                            <!--begin::Section-->
                            <div class="d-flex align-items-center">
                                <!--begin::Link-->
                                <a href="#" target="_blank" class="text-primary fw-bold me-1">All Videos</a>
                                <!--begin::Link-->
                                <!--begin::Arrow-->
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                <span class="svg-icon svg-icon-2 svg-icon-primary">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                            transform="rotate(-180 18 13)" fill="currentColor" />
                                        <path
                                            d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <!--end::Arrow-->
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Video-->
                        <div class="mb-3">
                            <iframe class="embed-responsive-item card-rounded h-275px w-100"
                                src="https://www.youtube.com/embed/TWdDZYNqlg4" allowfullscreen="allowfullscreen"></iframe>
                        </div>
                        <!--end::Video-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
        <!--begin::Products Documentations-->
        <div class="card mb-2">
            <!--begin::Card body-->
            <div class="card-body p-10 p-lg-15">
                <!--begin::Title-->
                <h1 class="fw-bold text-dark mb-12 ps-0">Products Documentations</h1>
                <!--end::Title-->
                <!--begin::Row-->
                <div class="row">
                    <!--begin::Col-->
                    <div class="col-sm-4">
                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-6">
                            <!--begin::Icon-->
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                            <span class="svg-icon svg-icon-2 ms-n1 me-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--end::Icon-->
                            <!--begin::Subtitle-->
                            <a href="#" class="fw-semibold text-gray-800 text-hover-primary fs-3 m-0">Free
                                Admin Dashboard</a>
                            <!--end::Subtitle-->
                        </div>
                        <!--begin::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-6">
                            <!--begin::Icon-->
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                            <span class="svg-icon svg-icon-2 ms-n1 me-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--end::Icon-->
                            <!--begin::Subtitle-->
                            <a href="#" class="fw-semibold text-gray-800 text-hover-primary fs-3 m-0">Bootstrap 5
                                Admin Template</a>
                            <!--end::Subtitle-->
                        </div>
                        <!--begin::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-6">
                            <!--begin::Icon-->
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                            <span class="svg-icon svg-icon-2 ms-n1 me-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--end::Icon-->
                            <!--begin::Subtitle-->
                            <a href="#" class="fw-semibold text-gray-800 text-hover-primary fs-3 m-0">Google
                                Admin Dashboard</a>
                            <!--end::Subtitle-->
                        </div>
                        <!--begin::Item-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-sm-4">
                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-6">
                            <!--begin::Icon-->
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                            <span class="svg-icon svg-icon-2 ms-n1 me-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--end::Icon-->
                            <!--begin::Subtitle-->
                            <a href="#" class="fw-semibold text-gray-800 text-hover-primary fs-3 m-0">Free
                                Vector Laravel Starter Kit</a>
                            <!--end::Subtitle-->
                        </div>
                        <!--begin::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-6">
                            <!--begin::Icon-->
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                            <span class="svg-icon svg-icon-2 ms-n1 me-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--end::Icon-->
                            <!--begin::Subtitle-->
                            <a href="#" class="fw-semibold text-gray-800 text-hover-primary fs-3 m-0">React
                                Admin Dashboard</a>
                            <!--end::Subtitle-->
                        </div>
                        <!--begin::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-6">
                            <!--begin::Icon-->
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                            <span class="svg-icon svg-icon-2 ms-n1 me-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--end::Icon-->
                            <!--begin::Subtitle-->
                            <a href="#" class="fw-semibold text-gray-800 text-hover-primary fs-3 m-0">HTML
                                Admin Dashboard</a>
                            <!--end::Subtitle-->
                        </div>
                        <!--begin::Item-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-sm-4">
                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-6">
                            <!--begin::Icon-->
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                            <span class="svg-icon svg-icon-2 ms-n1 me-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--end::Icon-->
                            <!--begin::Subtitle-->
                            <a href="#" class="fw-semibold text-gray-800 text-hover-primary fs-3 m-0">Best
                                VueJS Admin Template</a>
                            <!--end::Subtitle-->
                        </div>
                        <!--begin::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-6">
                            <!--begin::Icon-->
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                            <span class="svg-icon svg-icon-2 ms-n1 me-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--end::Icon-->
                            <!--begin::Subtitle-->
                            <a href="#" class="fw-semibold text-gray-800 text-hover-primary fs-3 m-0">Forest
                                Front-end Template</a>
                            <!--end::Subtitle-->
                        </div>
                        <!--begin::Item-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Products Documentations-->


    </AppLayout>
</template>