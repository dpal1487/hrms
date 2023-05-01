<script>
import { defineComponent } from 'vue';
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head } from '@inertiajs/inertia-vue3';


export default defineComponent({
    props: ['images'],

    data() {
        return {

        }

    },
    components: {
        AppLayout,
        Head
    }

})
</script>

<template>
    <AppLayout>

        <Head title="Images" />
        <!--begin:Col-->
        <div class="col-lg-6 mb-3">
            <!--begin:Menu item-->
            <div class="menu-item p-0 m-0">
                <!--begin:Menu link-->
                <a href="pos.html" class="menu-link active">
                    <span class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px me-3">
                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs043.svg-->
                        <span class="svg-icon svg-icon-danger svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3"
                                    d="M22 8H8L12 4H19C19.6 4 20.2 4.39999 20.5 4.89999L22 8ZM3.5 19.1C3.8 19.7 4.4 20 5 20H12L16 16H2L3.5 19.1ZM19.1 20.5C19.7 20.2 20 19.6 20 19V12L16 8V22L19.1 20.5ZM4.9 3.5C4.3 3.8 4 4.4 4 5V12L8 16V2L4.9 3.5Z"
                                    fill="currentColor" />
                                <path d="M22 8L20 12L16 8H22ZM8 16L4 12L2 16H8ZM16 16L12 20L16 22V16ZM8 8L12 4L8 2V8Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="d-flex flex-column">
                        <span class="fs-6 fw-bold text-gray-800">POS System</span>
                        <span class="fs-7 fw-semibold text-muted">Campaings & conversions</span>
                    </span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->
        </div>
        <!--end:Col-->
        <!--begin::Main-->
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <!--begin::Content wrapper-->
            <div class="d-flex flex-column flex-column-fluid">
                <!--begin::Toolbar-->
                <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                    <!--begin::Toolbar container-->
                    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                        <!--begin::Page title-->
                        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                            <!--begin::Title-->
                            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                                POS System</h1>
                            <!--end::Title-->
                            <!--begin::Breadcrumb-->
                            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-muted">
                                    <a href="/index.html" class="text-muted text-hover-primary">Home</a>
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="breadcrumb-item">
                                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-muted">Dashboards</li>
                                <!--end::Item-->
                            </ul>
                            <!--end::Breadcrumb-->
                        </div>
                        <!--end::Page title-->
                        <!--begin::Actions-->
                        <div class="d-flex align-items-center gap-2 gap-lg-3">
                            <!--begin::Secondary button-->
                            <a href="/apps/ecommerce/sales/listing.html"
                                class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary">Recent
                                Orders</a>
                            <!--end::Secondary button-->
                            <!--begin::Primary button-->
                            <a href="/apps/ecommerce/catalog/add-product.html" class="btn btn-sm fw-bold btn-primary">New
                                Product</a>
                            <!--end::Primary button-->
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Toolbar container-->
                </div>
                <!--end::Toolbar-->
                <!--begin::Content-->
                <div id="kt_app_content" class="app-content flex-column-fluid">
                    <!--begin::Content container-->
                    <div id="kt_app_content_container" class="app-container container-xxl">
                        <!--begin::Layout-->
                        <div class="d-flex flex-column flex-xl-row">
                            <!--begin::Content-->
                            <div class="d-flex flex-row-fluid me-xl-9 mb-10 mb-xl-0">
                                <!--begin::Pos food-->
                                <div class="card card-flush card-p-0 bg-transparent border-0">
                                    <!--begin::Body-->
                                    <div class="card-body">
                                        <!--begin::Nav-->
                                        <ul
                                            class="nav nav-pills d-flex justify-content-between nav-pills-custom gap-3 mb-6">
                                            <!--begin::Item-->
                                            <li class="nav-item mb-3 me-0">
                                                <!--begin::Nav link-->
                                                <a class="nav-link nav-link-border-solid btn btn-outline btn-flex btn-active-color-primary flex-column flex-stack pt-9 pb-7 page-bg show active"
                                                    data-bs-toggle="pill" href="#kt_pos_food_content_1"
                                                    style="width: 138px;height: 180px">
                                                    <!--begin::Icon-->
                                                    <div class="nav-icon mb-3">
                                                        <!--begin::Food icon-->
                                                        <img src="/assets/media/svg/food-icons/spaghetti.svg" class="w-50px"
                                                            alt="" />
                                                        <!--end::Food icon-->
                                                    </div>
                                                    <!--end::Icon-->
                                                    <!--begin::Info-->
                                                    <div class="">
                                                        <span class="text-gray-800 fw-bold fs-2 d-block">Lunch</span>
                                                        <span class="text-gray-400 fw-semibold fs-7">8 Options</span>
                                                    </div>
                                                    <!--end::Info-->
                                                </a>
                                                <!--end::Nav link-->
                                            </li>
                                            <!--end::Item-->
                                            <!--begin::Item-->
                                            <li class="nav-item mb-3 me-0">
                                                <!--begin::Nav link-->
                                                <a class="nav-link nav-link-border-solid btn btn-outline btn-flex btn-active-color-primary flex-column flex-stack pt-9 pb-7 page-bg"
                                                    data-bs-toggle="pill" href="#kt_pos_food_content_2"
                                                    style="width: 138px;height: 180px">
                                                    <!--begin::Icon-->
                                                    <div class="nav-icon mb-3">
                                                        <!--begin::Food icon-->
                                                        <img src="/assets/media/svg/food-icons/salad.svg" class="w-50px"
                                                            alt="" />
                                                        <!--end::Food icon-->
                                                    </div>
                                                    <!--end::Icon-->
                                                    <!--begin::Info-->
                                                    <div class="">
                                                        <span class="text-gray-800 fw-bold fs-2 d-block">Salad</span>
                                                        <span class="text-gray-400 fw-semibold fs-7">14 Salads</span>
                                                    </div>
                                                    <!--end::Info-->
                                                </a>
                                                <!--end::Nav link-->
                                            </li>
                                            <!--end::Item-->
                                            <!--begin::Item-->
                                            <li class="nav-item mb-3 me-0">
                                                <!--begin::Nav link-->
                                                <a class="nav-link nav-link-border-solid btn btn-outline btn-flex btn-active-color-primary flex-column flex-stack pt-9 pb-7 page-bg"
                                                    data-bs-toggle="pill" href="#kt_pos_food_content_3"
                                                    style="width: 138px;height: 180px">
                                                    <!--begin::Icon-->
                                                    <div class="nav-icon mb-3">
                                                        <!--begin::Food icon-->
                                                        <img src="/assets/media/svg/food-icons/cheeseburger.svg"
                                                            class="w-50px" alt="" />
                                                        <!--end::Food icon-->
                                                    </div>
                                                    <!--end::Icon-->
                                                    <!--begin::Info-->
                                                    <div class="">
                                                        <span class="text-gray-800 fw-bold fs-2 d-block">Burger</span>
                                                        <span class="text-gray-400 fw-semibold fs-7">5 Burgers</span>
                                                    </div>
                                                    <!--end::Info-->
                                                </a>
                                                <!--end::Nav link-->
                                            </li>
                                            <!--end::Item-->
                                            <!--begin::Item-->
                                            <li class="nav-item mb-3 me-0">
                                                <!--begin::Nav link-->
                                                <a class="nav-link nav-link-border-solid btn btn-outline btn-flex btn-active-color-primary flex-column flex-stack pt-9 pb-7 page-bg"
                                                    data-bs-toggle="pill" href="#kt_pos_food_content_4"
                                                    style="width: 138px;height: 180px">
                                                    <!--begin::Icon-->
                                                    <div class="nav-icon mb-3">
                                                        <!--begin::Food icon-->
                                                        <img src="/assets/media/svg/food-icons/coffee.svg" class="w-50px"
                                                            alt="" />
                                                        <!--end::Food icon-->
                                                    </div>
                                                    <!--end::Icon-->
                                                    <!--begin::Info-->
                                                    <div class="">
                                                        <span class="text-gray-800 fw-bold fs-2 d-block">Coffee</span>
                                                        <span class="text-gray-400 fw-semibold fs-7">7 Beverages</span>
                                                    </div>
                                                    <!--end::Info-->
                                                </a>
                                                <!--end::Nav link-->
                                            </li>
                                            <!--end::Item-->
                                            <!--begin::Item-->
                                            <li class="nav-item mb-3 me-0">
                                                <!--begin::Nav link-->
                                                <a class="nav-link nav-link-border-solid btn btn-outline btn-flex btn-active-color-primary flex-column flex-stack pt-9 pb-7 page-bg"
                                                    data-bs-toggle="pill" href="#kt_pos_food_content_5"
                                                    style="width: 138px;height: 180px">
                                                    <!--begin::Icon-->
                                                    <div class="nav-icon mb-3">
                                                        <!--begin::Food icon-->
                                                        <img src="/assets/media/svg/food-icons/cheesecake.svg"
                                                            class="w-50px" alt="" />
                                                        <!--end::Food icon-->
                                                    </div>
                                                    <!--end::Icon-->
                                                    <!--begin::Info-->
                                                    <div class="">
                                                        <span class="text-gray-800 fw-bold fs-2 d-block">Dessert</span>
                                                        <span class="text-gray-400 fw-semibold fs-7">8 Desserts</span>
                                                    </div>
                                                    <!--end::Info-->
                                                </a>
                                                <!--end::Nav link-->
                                            </li>
                                            <!--end::Item-->
                                        </ul>
                                        <!--end::Nav-->
                                        <!--begin::Tab Content-->
                                        <div class="tab-content">
                                            <!--begin::Tap pane-->
                                            <div class="tab-pane fade show active" id="kt_pos_food_content_1">
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-wrap d-grid gap-5 gap-xxl-9">
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-2.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">T-Bone
                                                                        Stake</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$16.50$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-7.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Chef’s
                                                                        Salmon</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$12.40$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-8.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Ramen</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$14.90$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-4.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Chicken
                                                                        Breast</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$9.00$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-10.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Tenderlion
                                                                        Steak</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$19.00$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-9.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Soup
                                                                        of the Day</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$7.50$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-3.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Pancakes</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$6.50$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-5.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Breakfast</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$8.20$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-11.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Sweety</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$11.40$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::Tap pane-->
                                            <!--begin::Tap pane-->
                                            <div class="tab-pane fade" id="kt_pos_food_content_2">
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-wrap d-grid gap-5 gap-xxl-9">
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-11.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Sweety</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$11.40$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-5.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Breakfast</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$8.20$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-4.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Chicken
                                                                        Breast</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$9.00$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-8.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Ramen</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$14.90$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-10.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Tenderlion
                                                                        Steak</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$19.00$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-9.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Soup
                                                                        of the Day</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$7.50$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-3.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Pancakes</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$6.50$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-7.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Chef’s
                                                                        Salmon</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$12.40$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-2.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">T-Bone
                                                                        Stake</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$16.50$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::Tap pane-->
                                            <!--begin::Tap pane-->
                                            <div class="tab-pane fade" id="kt_pos_food_content_3">
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-wrap d-grid gap-5 gap-xxl-9">
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-5.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Breakfast</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$8.20$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-11.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Sweety</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$11.40$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-2.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">T-Bone
                                                                        Stake</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$16.50$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-7.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Chef’s
                                                                        Salmon</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$12.40$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-4.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Chicken
                                                                        Breast</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$9.00$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-8.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Ramen</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$14.90$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-9.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Soup
                                                                        of the Day</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$7.50$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-10.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Tenderlion
                                                                        Steak</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$19.00$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-3.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Pancakes</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$6.50$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::Tap pane-->
                                            <!--begin::Tap pane-->
                                            <div class="tab-pane fade" id="kt_pos_food_content_4">
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-wrap d-grid gap-5 gap-xxl-9">
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-3.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Pancakes</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$6.50$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-5.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Breakfast</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$8.20$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-4.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Chicken
                                                                        Breast</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$9.00$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-8.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Ramen</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$14.90$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-9.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Soup
                                                                        of the Day</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$7.50$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-11.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Sweety</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$11.40$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-3.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Pancakes</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$6.50$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-7.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Chef’s
                                                                        Salmon</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$12.40$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-10.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Tenderlion
                                                                        Steak</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$19.00$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::Tap pane-->
                                            <!--begin::Tap pane-->
                                            <div class="tab-pane fade" id="kt_pos_food_content_5">
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-wrap d-grid gap-5 gap-xxl-9">
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-10.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Tenderlion
                                                                        Steak</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$19.00$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-5.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Breakfast</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$8.20$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-4.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Chicken
                                                                        Breast</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$9.00$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-3.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Pancakes</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$6.50$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-2.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">T-Bone
                                                                        Stake</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$16.50$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-7.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Chef’s
                                                                        Salmon</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$12.40$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-8.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Ramen</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$14.90$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-9.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Soup
                                                                        of the Day</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$7.50$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                    <!--begin::Card-->
                                                    <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                        <!--begin::Body-->
                                                        <div class="card-body text-center">
                                                            <!--begin::Food img-->
                                                            <img src="/assets/media/stock/food/img-11.jpg"
                                                                class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                alt="" />
                                                            <!--end::Food img-->
                                                            <!--begin::Info-->
                                                            <div class="mb-2">
                                                                <!--begin::Title-->
                                                                <div class="text-center">
                                                                    <span
                                                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Sweety</span>
                                                                    <span
                                                                        class="text-gray-400 fw-semibold d-block fs-6 mt-n1">16
                                                                        mins to cook</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Total-->
                                                            <span class="text-success text-end fw-bold fs-1">$11.40$</span>
                                                            <!--end::Total-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Card-->
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::Tap pane-->
                                        </div>
                                        <!--end::Tab Content-->
                                    </div>
                                    <!--end: Card Body-->
                                </div>
                                <!--end::Pos food-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Layout-->
                    </div>
                    <!--end::Content container-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Content wrapper-->
            <!--begin::Footer-->
            <div id="kt_app_footer" class="app-footer">
                <!--begin::Footer container-->
                <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
                    <!--begin::Copyright-->
                    <div class="text-dark order-2 order-md-1">
                        <span class="text-muted fw-semibold me-1">2022&copy;</span>
                        <a href="https://keenthemes.com/" target="_blank"
                            class="text-gray-800 text-hover-primary">Keenthemes</a>
                    </div>
                    <!--end::Copyright-->
                    <!--begin::Menu-->
                    <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
                        <li class="menu-item">
                            <a href="https://keenthemes.com/" target="_blank" class="menu-link px-2">About</a>
                        </li>
                        <li class="menu-item">
                            <a href="https://devs.keenthemes.com/" target="_blank" class="menu-link px-2">Support</a>
                        </li>
                        <li class="menu-item">
                            <a href="https://1.envato.market/EA4JP" target="_blank" class="menu-link px-2">Purchase</a>
                        </li>
                    </ul>
                    <!--end::Menu-->
                </div>
                <!--end::Footer container-->
            </div>
            <!--end::Footer-->
        </div>
        <!--end:::Main-->

        <div class="d-flex flex-wrap flex-stack mb-6">
            <!--begin::Title-->
            <h3 class="fw-bold my-2">Images

            </h3>
            <!--end::Title-->
        </div>
        <!--begin::Row-->
        <div class="row g-6 g-xl-9 mb-6 mb-xl-9">
            <!--begin::Col-->
            <div class="col-md-6 col-lg-4 col-xl-3" v-for="(image, index) in images">
                <!--begin::Card-->
                <div class="card h-100">
                    <!--begin::Card body-->
                    <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                        <!--begin::Name-->
                        <!-- {{ image }} -->
                        <a href="#" class="text-gray-800 text-hover-primary d-flex flex-column">
                            <!--begin::Image-->
                            <div class="symbol symbol-75px mb-5">
                                <img :src="image.medium_path" class="theme-light-show" alt="" />
                                <img :src="image.medium_path" class="theme-dark-show" alt="" />
                            </div>
                            <!--end::Image-->
                            <!--begin::Title-->
                            <div class="fs-5 fw-bold mb-2">{{ image?.small_path?.split("/images/")[1] }}</div>
                            <!--end::Title-->
                        </a>
                        <!--end::Name-->
                        <!--begin::Description-->
                        <!-- <div class="fs-7 fw-semibold text-gray-400">7 files</div> -->
                        <!--end::Description-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->
        </div>
        <!--end:Row-->

    </AppLayout>
</template>