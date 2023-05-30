<script>
import { defineComponent } from 'vue';
import AppLayout from '../../Layouts/AppLayout.vue';
import Header from './Components/Header.vue';
import { Link } from '@inertiajs/inertia-vue3';
import Pagination from '../../Jetstream/Pagination.vue';

export default defineComponent({
    props: ['employees', 'tickets'],
    components: {
        AppLayout,
        Header,
        Link,
        Pagination
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
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/support/tickets" class="text-muted text-hover-primary">Tickets</Link>
            </li>

        </template>
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Layout-->
                <div class="d-flex flex-column flex-xl-row p-7">
                    <!--begin::Content-->
                    <div class="flex-lg-row-fluid me-xl-15 mb-20 mb-xl-0">
                        <!--begin::Tickets-->
                        <div class="mb-0">
                            <!--begin::Search form-->
                            <form method="post" action="#" class="form mb-15">
                                <!--begin::Input wrapper-->
                                <div class="position-relative">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                    <span
                                        class="svg-icon svg-icon-1 svg-icon-primary position-absolute top-50 translate-middle ms-9">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                                transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                            <path
                                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <input type="text" class="form-control form-control-lg form-control-solid ps-14"
                                        name="search" value="" placeholder="Search" />
                                </div>
                                <!--end::Input wrapper-->
                            </form>
                            <!--end::Search form-->
                            <!--begin::Heading-->
                            <h1 class="text-dark mb-10">Tickets</h1>
                            <!--end::Heading-->
                            <!--begin::Tickets List-->
                            <div class="mb-10">
                                <!--begin::Ticket-->
                                <div class="d-flex mb-10" v-for="(ticket, index) in tickets.data" :key="index">
                                    <!--begin::Symbol-->
                                    <!--begin::Svg Icon | path: icons/duotune/files/fil008.svg-->
                                    <span class="svg-icon svg-icon-2x me-5 ms-n1 mt-2 svg-icon-success">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3"
                                                d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM11.7 17.7L16 14C16.4 13.6 16.4 12.9 16 12.5C15.6 12.1 15.4 12.6 15 13L11 16L9 15C8.6 14.6 8.4 14.1 8 14.5C7.6 14.9 8.1 15.6 8.5 16L10.3 17.7C10.5 17.9 10.8 18 11 18C11.2 18 11.5 17.9 11.7 17.7Z"
                                                fill="currentColor" />
                                            <path
                                                d="M10.4343 15.4343L9.25 14.25C8.83579 13.8358 8.16421 13.8358 7.75 14.25C7.33579 14.6642 7.33579 15.3358 7.75 15.75L10.2929 18.2929C10.6834 18.6834 11.3166 18.6834 11.7071 18.2929L16.25 13.75C16.6642 13.3358 16.6642 12.6642 16.25 12.25C15.8358 11.8358 15.1642 11.8358 14.75 12.25L11.5657 15.4343C11.2533 15.7467 10.7467 15.7467 10.4343 15.4343Z"
                                                fill="currentColor" />
                                            <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <!--end::Symbol-->
                                    <!--begin::Section-->
                                    <div class="d-flex flex-column">
                                        <!--begin::Content-->
                                        <div class="d-flex align-items-center mb-2">
                                            <!--begin::Title-->
                                            <a href="/support/view-tickets"
                                                class="text-dark text-hover-primary fs-4 me-3 fw-semibold">{{ ticket.subject
                                                }}</a>
                                            <!--end::Title-->
                                            <!--begin::Label-->
                                            <span class="badge badge-light my-1">{{ ticket.project }}</span>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Content-->
                                        <!--begin::Text-->
                                        <span class="text-muted fw-semibold fs-6">{{ ticket.description }}
                                        </span>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Section-->
                                </div>
                                <!--end::Ticket-->
                            </div>
                            <!--end::Tickets List-->
                            <!--begin::Pagination-->
                            <div class="d-flex align-items-center justify-content-center justify-content-md-end"
                                v-if="tickets.meta">
                                <Pagination :links="tickets.meta.links" />
                            </div>
                            <!--end::Pagination-->
                        </div>
                        <!--end::Tickets-->
                    </div>
                    <!--end::Content-->
                    <!--begin::Sidebar-->
                    <div class="flex-column flex-lg-row-auto w-100 mw-lg-300px mw-xxl-350px">
                        <!--begin::More channels-->
                        <div class="card-rounded bg-primary bg-opacity-5 p-10 mb-15">
                            <!--begin::Title-->
                            <h2 class="text-dark fw-bold mb-11">More Channels</h2>
                            <!--end::Title-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-10">
                                <!--begin::Icon-->
                                <i class="bi bi-file-earmark-text text-primary fs-1 me-5"></i>
                                <!--end::SymIconbol-->
                                <!--begin::Info-->
                                <div class="d-flex flex-column">
                                    <h5 class="text-gray-800 fw-bold">Project Briefing</h5>
                                    <!--begin::Section-->
                                    <div class="fw-semibold">
                                        <!--begin::Desc-->
                                        <span class="text-muted">Check out our</span>
                                        <!--end::Desc-->
                                        <!--begin::Link-->
                                        <a href="#" class="link-primary">Support Policy</a>
                                        <!--end::Link-->
                                    </div>
                                    <!--end::Section-->
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-10">
                                <!--begin::Icon-->
                                <i class="bi bi-chat-square-text-fill text-primary fs-1 me-5"></i>
                                <!--end::SymIconbol-->
                                <!--begin::Info-->
                                <div class="d-flex flex-column">
                                    <h5 class="text-gray-800 fw-bold">More to discuss?</h5>
                                    <!--begin::Section-->
                                    <div class="fw-semibold">
                                        <!--begin::Desc-->
                                        <span class="text-muted">Email us to</span>
                                        <!--end::Desc-->
                                        <!--begin::Link-->
                                        <a href="#" class="link-primary">support@keenthemes.com</a>
                                        <!--end::Link-->
                                    </div>
                                    <!--end::Section-->
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-10">
                                <!--begin::Icon-->
                                <i class="bi bi-twitter text-primary fs-1 me-5"></i>
                                <!--end::SymIconbol-->
                                <!--begin::Info-->
                                <div class="d-flex flex-column">
                                    <h5 class="text-gray-800 fw-bold">Latest News</h5>
                                    <!--begin::Section-->
                                    <div class="fw-semibold">
                                        <!--begin::Desc-->
                                        <span class="text-muted">Follow us at</span>
                                        <!--end::Desc-->
                                        <!--begin::Link-->
                                        <a href="#" class="link-primary">KeenThemes Twitter</a>
                                        <!--end::Link-->
                                    </div>
                                    <!--end::Section-->
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center">
                                <!--begin::Icon-->
                                <i class="bi bi-github text-primary fs-1 me-5"></i>
                                <!--end::SymIconbol-->
                                <!--begin::Info-->
                                <div class="d-flex flex-column">
                                    <h5 class="text-gray-800 fw-bold">Github Access</h5>
                                    <!--begin::Section-->
                                    <div class="fw-semibold">
                                        <!--begin::Desc-->
                                        <span class="text-muted">Our github repo</span>
                                        <!--end::Desc-->
                                        <!--begin::Link-->
                                        <a href="#" class="link-primary">KeenThemes Github</a>
                                        <!--end::Link-->
                                    </div>
                                    <!--end::Section-->
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Item-->
                        </div>
                        <!--end::More channels-->
                        <!--begin::Documentations-->
                        <div class="card-rounded bg-primary bg-opacity-5 p-10 mb-15">
                            <!--begin::Title-->
                            <h1 class="fw-bold text-dark mb-9">Documentation</h1>
                            <!--end::Title-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-6">
                                <!--begin::Icon-->
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                                <span class="svg-icon svg-icon-2 ms-n1 me-3">
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
                                <a href="#" class="fw-semibold text-gray-800 text-hover-primary fs-5 m-0">Angular Admin</a>
                                <!--end::Subtitle-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-6">
                                <!--begin::Icon-->
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                                <span class="svg-icon svg-icon-2 ms-n1 me-3">
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
                                <a href="#" class="fw-semibold text-gray-800 text-hover-primary fs-5 m-0">React Admin</a>
                                <!--end::Subtitle-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-6">
                                <!--begin::Icon-->
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                                <span class="svg-icon svg-icon-2 ms-n1 me-3">
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
                                <a href="#" class="fw-semibold text-gray-800 text-hover-primary fs-5 m-0">Vue Dashboard</a>
                                <!--end::Subtitle-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-6">
                                <!--begin::Icon-->
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                                <span class="svg-icon svg-icon-2 ms-n1 me-3">
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
                                <a href="#" class="fw-semibold text-gray-800 text-hover-primary fs-5 m-0">Niche Theme</a>
                                <!--end::Subtitle-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-6">
                                <!--begin::Icon-->
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                                <span class="svg-icon svg-icon-2 ms-n1 me-3">
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
                                <a href="#" class="fw-semibold text-gray-800 text-hover-primary fs-5 m-0">Dashboard
                                    Admin</a>
                                <!--end::Subtitle-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-6">
                                <!--begin::Icon-->
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                                <span class="svg-icon svg-icon-2 ms-n1 me-3">
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
                                <a href="#" class="fw-semibold text-gray-800 text-hover-primary fs-5 m-0">Dorsey
                                    Front-end</a>
                                <!--end::Subtitle-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-6">
                                <!--begin::Icon-->
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                                <span class="svg-icon svg-icon-2 ms-n1 me-3">
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
                                <a href="#" class="fw-semibold text-gray-800 text-hover-primary fs-5 m-0">CRM Admin</a>
                                <!--end::Subtitle-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-6">
                                <!--begin::Icon-->
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                                <span class="svg-icon svg-icon-2 ms-n1 me-3">
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
                                <a href="#" class="fw-semibold text-gray-800 text-hover-primary fs-5 m-0">Admin
                                    Dashbaord</a>
                                <!--end::Subtitle-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center">
                                <!--begin::Icon-->
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                                <span class="svg-icon svg-icon-2 ms-n1 me-3">
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
                                <a href="#" class="fw-semibold text-gray-800 text-hover-primary fs-5 m-0">Intranet Admin</a>
                                <!--end::Subtitle-->
                            </div>
                            <!--end::Item-->
                        </div>
                        <!--end::Documentations-->
                    </div>
                    <!--end::Sidebar-->
                </div>
                <!--end::Layout-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->


    </AppLayout>
</template>