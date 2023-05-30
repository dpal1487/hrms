<script>
import { defineComponent } from 'vue';
import AppLayout from '../../Layouts/AppLayout.vue';
import Header from './Components/Header.vue';
import { Link } from '@inertiajs/inertia-vue3';
export default defineComponent({
    props: ['employees', 'faqs'],
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
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/support/faq" class="text-muted text-hover-primary">Faq</Link>
            </li>

        </template>
        <!--begin::FAQ card-->
        <div class="card">
            <!--begin::Body-->
            <div class="card-body p-10 p-lg-15">
                <!--begin::Classic content-->
                <div class="mb-13">
                    <!--begin::Intro-->
                    <div class="mb-15">
                        <!--begin::Title-->
                        <h4 class="fs-2x text-gray-800 w-bolder mb-6">Frequesntly Asked Questions</h4>
                        <!--end::Title-->
                        <!--begin::Text-->
                        <p class="fw-semibold fs-4 text-gray-600 mb-2">First, a disclaimer – the entire process of writing a
                            blog post often takes more than a couple of hours, even if you can type eighty words as per
                            minute and your writing skills are sharp.</p>
                        <!--end::Text-->
                    </div>
                    <!--end::Intro-->
                    <!--begin::Row-->
                    <div class="row mb-12">
                        <!--begin::Col-->
                        <div class="col-md-6 pe-md-10 mb-10 mb-md-0" v-for="(faq, index) in faqs?.data" :key="index">
                            <!--begin::Title-->
                            <h2 class="text-gray-800 fw-bold mb-4 text-capitalize">{{ faq?.title }}</h2>
                            <!--end::Title-->
                            <!--begin::Accordion-->

                            <!--begin::Section-->
                            <div class="m-0">
                                <!--begin::Heading-->
                                <div class="d-flex align-items-center collapsible py-3 toggle mb-0"
                                    data-bs-toggle="collapse" data-bs-target="#kt_job_4_1">
                                    <!--begin::Icon-->
                                    <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen036.svg-->
                                        <span class="svg-icon toggle-on svg-icon-primary svg-icon-1">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5"
                                                    fill="currentColor" />
                                                <rect x="6.0104" y="10.9247" width="12" height="2" rx="1"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                                        <span class="svg-icon toggle-off svg-icon-1">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5"
                                                    fill="currentColor" />
                                                <rect x="10.8891" y="17.8033" width="12" height="2" rx="1"
                                                    transform="rotate(-90 10.8891 17.8033)" fill="currentColor" />
                                                <rect x="6.01041" y="10.9247" width="12" height="2" rx="1"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </div>
                                    <!--end::Icon-->
                                    <!--begin::Title-->
                                    <h4 class="text-gray-700 fw-bold cursor-pointer mb-0">{{ faq.category.title }}</h4>
                                    <!--end::Title-->
                                </div>
                                <!--end::Heading-->
                                <!--begin::Body-->
                                <div id="kt_job_4_1" class="collapse show fs-6 ms-1">
                                    <!--begin::Text-->
                                    <div class="mb-4 text-gray-600 fw-semibold fs-6 ps-10">{{ faq.artical }}</div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Content-->
                                <!--begin::Separator-->
                                <div class="separator separator-dashed"></div>
                                <!--end::Separator-->
                            </div>
                            <!--end::Section-->
                            <!--begin::Section-->
                            <div class="m-0">
                                <!--begin::Heading-->
                                <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0"
                                    data-bs-toggle="collapse" data-bs-target="#kt_job_4_2">
                                    <!--begin::Icon-->
                                    <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen036.svg-->
                                        <span class="svg-icon toggle-on svg-icon-primary svg-icon-1">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5"
                                                    fill="currentColor" />
                                                <rect x="6.0104" y="10.9247" width="12" height="2" rx="1"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                                        <span class="svg-icon toggle-off svg-icon-1">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5"
                                                    fill="currentColor" />
                                                <rect x="10.8891" y="17.8033" width="12" height="2" rx="1"
                                                    transform="rotate(-90 10.8891 17.8033)" fill="currentColor" />
                                                <rect x="6.01041" y="10.9247" width="12" height="2" rx="1"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </div>
                                    <!--end::Icon-->
                                    <!--begin::Title-->
                                    <h4 class="text-gray-700 fw-bold cursor-pointer mb-0">Do I need a designer to use Admin
                                        Theme ?</h4>
                                    <!--end::Title-->
                                </div>
                                <!--end::Heading-->
                                <!--begin::Body-->
                                <div id="kt_job_4_2" class="collapse fs-6 ms-1">
                                    <!--begin::Text-->
                                    <div class="mb-4 text-gray-600 fw-semibold fs-6 ps-10">First, a disclaimer – the entire
                                        process of writing a blog post often takes more than a couple of hours, even if you
                                        can type eighty words as per minute and your writing skills are sharp.</div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Content-->
                                <!--begin::Separator-->
                                <div class="separator separator-dashed"></div>
                                <!--end::Separator-->
                            </div>
                            <!--end::Section-->
                            <!--end::Accordion-->
                        </div>
                        <!--end::Col-->

                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Classic content-->
                <!--begin::Section-->
                <div class="mb-17">
                    <!--begin::Content-->
                    <div class="d-flex flex-stack mb-5">
                        <!--begin::Title-->
                        <h3 class="text-dark">Video Tutorials</h3>
                        <!--end::Title-->
                        <!--begin::Link-->
                        <a href="#" class="fs-6 fw-semibold link-primary">View All Videos</a>
                        <!--end::Link-->
                    </div>
                    <!--end::Content-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed mb-9"></div>
                    <!--end::Separator-->
                    <!--begin::Row-->
                    <div class="row g-10">
                        <!--begin::Col-->
                        <div class="col-md-4">
                            <!--begin::Feature post-->
                            <div class="card-xl-stretch me-md-6">
                                <!--begin::Image-->
                                <a class="d-block bgi-no-repeat bgi-size-cover bgi-position-center card-rounded position-relative min-h-175px mb-5"
                                    style="background-image:url('../../assets/media/stock/600x400/img-73.jpg')"
                                    data-fslightbox="lightbox-video-tutorials"
                                    href="https://www.youtube.com/embed/btornGtLwIo">
                                    <img src="/assets/media/svg/misc/video-play.svg"
                                        class="position-absolute top-50 start-50 translate-middle" alt="" />
                                </a>
                                <!--end::Image-->
                                <!--begin::Body-->
                                <div class="m-0">
                                    <!--begin::Title-->
                                    <a href="/pages/user-profile/overview.html"
                                        class="fs-4 text-dark fw-bold text-hover-primary text-dark lh-base">Admin Panel -
                                        How To Started the Dashboard Tutorial</a>
                                    <!--end::Title-->
                                    <!--begin::Text-->
                                    <div class="fw-semibold fs-5 text-gray-600 text-dark my-4">We’ve been focused on making
                                        a the from also not been afraid to and step away been focused create eye</div>
                                    <!--end::Text-->
                                    <!--begin::Content-->
                                    <div class="fs-6 fw-bold">
                                        <!--begin::Author-->
                                        <a href="/pages/user-profile/overview.html"
                                            class="text-gray-700 text-hover-primary">Jane Miller</a>
                                        <!--end::Author-->
                                        <!--begin::Date-->
                                        <span class="text-muted">on Mar 21 2021</span>
                                        <!--end::Date-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Feature post-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-4">
                            <!--begin::Feature post-->
                            <div class="card-xl-stretch mx-md-3">
                                <!--begin::Image-->
                                <a class="d-block bgi-no-repeat bgi-size-cover bgi-position-center card-rounded position-relative min-h-175px mb-5"
                                    style="background-image:url('../../assets/media/stock/600x400/img-74.jpg')"
                                    data-fslightbox="lightbox-video-tutorials"
                                    href="https://www.youtube.com/embed/btornGtLwIo">
                                    <img src="/assets/media/svg/misc/video-play.svg"
                                        class="position-absolute top-50 start-50 translate-middle" alt="" />
                                </a>
                                <!--end::Image-->
                                <!--begin::Body-->
                                <div class="m-0">
                                    <!--begin::Title-->
                                    <a href="/pages/user-profile/overview.html"
                                        class="fs-4 text-dark fw-bold text-hover-primary text-dark lh-base">Admin Panel -
                                        How To Started the Dashboard Tutorial</a>
                                    <!--end::Title-->
                                    <!--begin::Text-->
                                    <div class="fw-semibold fs-5 text-gray-600 text-dark my-4">We’ve been focused on making
                                        the from v4 to v5 but we have also not been afraid to step away been focused</div>
                                    <!--end::Text-->
                                    <!--begin::Content-->
                                    <div class="fs-6 fw-bold">
                                        <!--begin::Author-->
                                        <a href="/pages/user-profile/overview.html"
                                            class="text-gray-700 text-hover-primary">Cris Morgan</a>
                                        <!--end::Author-->
                                        <!--begin::Date-->
                                        <span class="text-muted">on Apr 14 2021</span>
                                        <!--end::Date-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Feature post-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-4">
                            <!--begin::Feature post-->
                            <div class="card-xl-stretch ms-md-6">
                                <!--begin::Image-->
                                <a class="d-block bgi-no-repeat bgi-size-cover bgi-position-center card-rounded position-relative min-h-175px mb-5"
                                    style="background-image:url('/assets/media/stock/600x400/img-47.jpg')"
                                    data-fslightbox="lightbox-video-tutorials"
                                    href="https://www.youtube.com/embed/TWdDZYNqlg4">
                                    <img src="/assets/media/svg/misc/video-play.svg"
                                        class="position-absolute top-50 start-50 translate-middle" alt="" />
                                </a>
                                <!--end::Image-->
                                <!--begin::Body-->
                                <div class="m-0">
                                    <!--begin::Title-->
                                    <a href="/pages/user-profile/overview.html"
                                        class="fs-4 text-dark fw-bold text-hover-primary text-dark lh-base">Admin Panel -
                                        How To Started the Dashboard Tutorial</a>
                                    <!--end::Title-->
                                    <!--begin::Text-->
                                    <div class="fw-semibold fs-5 text-gray-600 text-dark my-4">We’ve been focused on making
                                        the from v4 to v5 but we’ve also not been afraid to step away been focused</div>
                                    <!--end::Text-->
                                    <!--begin::Content-->
                                    <div class="fs-6 fw-bold">
                                        <!--begin::Author-->
                                        <a href="/pages/user-profile/overview.html"
                                            class="text-gray-700 text-hover-primary">Carles Nilson</a>
                                        <!--end::Author-->
                                        <!--begin::Date-->
                                        <span class="text-muted">on May 14 2021</span>
                                        <!--end::Date-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Feature post-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Section-->
                <!--begin::Card-->
                <div class="card mb-4 bg-light text-center">
                    <!--begin::Body-->
                    <div class="card-body py-12">
                        <!--begin::Icon-->
                        <a href="#" class="mx-4">
                            <img src="/assets/media/svg/brand-logos/facebook-4.svg" class="h-30px my-2" alt="" />
                        </a>
                        <!--end::Icon-->
                        <!--begin::Icon-->
                        <a href="#" class="mx-4">
                            <img src="/assets/media/svg/brand-logos/instagram-2-1.svg" class="h-30px my-2" alt="" />
                        </a>
                        <!--end::Icon-->
                        <!--begin::Icon-->
                        <a href="#" class="mx-4">
                            <img src="/assets/media/svg/brand-logos/github.svg" class="h-30px my-2" alt="" />
                        </a>
                        <!--end::Icon-->
                        <!--begin::Icon-->
                        <a href="#" class="mx-4">
                            <img src="/assets/media/svg/brand-logos/behance.svg" class="h-30px my-2" alt="" />
                        </a>
                        <!--end::Icon-->
                        <!--begin::Icon-->
                        <a href="#" class="mx-4">
                            <img src="/assets/media/svg/brand-logos/pinterest-p.svg" class="h-30px my-2" alt="" />
                        </a>
                        <!--end::Icon-->
                        <!--begin::Icon-->
                        <a href="#" class="mx-4">
                            <img src="/assets/media/svg/brand-logos/twitter.svg" class="h-30px my-2" alt="" />
                        </a>
                        <!--end::Icon-->
                        <!--begin::Icon-->
                        <a href="#" class="mx-4">
                            <img src="/assets/media/svg/brand-logos/dribbble-icon-1.svg" class="h-30px my-2" alt="" />
                        </a>
                        <!--end::Icon-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::FAQ card-->
    </AppLayout>
</template>