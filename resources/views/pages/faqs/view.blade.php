@section('stylesheet')
    <!--begin::Vendor Stylesheets(used for this page only)-->

    <!--end::Vendor Stylesheets-->
@endsection
<x-app-layout>
    <!--begin::Content-->
    <div id="kt_app_content_container" class="app-container container-fluid py-3 py-lg-6">
        <!--begin::Category-->
        <div class="mb-5">
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header align-items-center">
                    <div class="card-title">
                        <h2>FAQs</h2>
                    </div>

                    {{-- {{dd( $attribute) }} --}}

                </div>
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-6">
                            <div id="project_table_wrapper">
                                <table
                                    class="table text-center align-middle table-striped mb-0 border border-top-0 border-bottom-0 border-left-0">
                                    <tbody>
                                        <tr>
                                            <th>Name </th>
                                            <td class="fs-6 fw-bold text-gray-800">{{ $faq->title }}</td>
                                        </tr>

                                        <tr>
                                            <td>FAQs Image</td>
                                            <td class="fs-6 fw-bold text-gray-800 whitespace-break">
                                                {{ $faq->display_order }}
                                                <p class="symbol symbol-100px">
                                                    <span class="symbol-label"
                                                        style="background-image:url({{ asset('assets/image/faq/original/') }}/{{ @$faq->image->name }} "></span>
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="h-100 d-flex justify-content-center align-items-center">
                                <div class="text-center">
                                    @if ($faq->status == 1)
                                        <div class="badge bg-success">Active</div>
                                    @else
                                        <div class="badge bg-danger">In Active</div>
                                    @endif


                                    <div class="d-flex justify-content-center align-items-center">
                                        {{-- <h1>{{ $faq->models->where('status', 1)->count() }} &nbsp;</h1><span>Out Of</span>
                                         <h1>&nbsp;{{ count($faq->models) }}</h1> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-5">
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse">
                    <div class="card-title d-flex align-items-center justify-content-between w-100">
                        <h3 class="fw-bold m-0">Faq Value</h3>
                        <button type="button" id="add_faq" data-id="{{ $faq->id }}" class="btn btn-primary"
                            data-bs-toggle="modal" data-bs-target="#faqModel">
                            Add
                        </button>
                    </div>
                </div>

                <!-- start form model -->
                <div class="modal fade" tabindex="-1" id="faqModel">
                    <div class="modal-dialog">
                        <div class="modal-content position-absolute">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Faq Value</h5>
                            </div>
                            <form class="form d-flex flex-column flex-lg-row" id="faq_form" action=""
                                method="POST">
                                @csrf
                                <!--begin::Aside column-->
                                @include('pages.faqs.model_fields')
                                <!--end::Main column-->
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end form model -->
                <!--end::Card header-->
                <!--begin::Content-->
                <div class="collapse show">
                    <!--begin::Card body-->
                    <div class="card-body overflow-auto border-top p-9">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="faq_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="w-1px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" />
                                        </div>
                                    </th>
                                    <th class="min-w-100px">faq Name</th>
                                    <th class="min-w-100px">faq Status</th>
                                    <th class="text-end min-w-70px">Actions</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-semibold text-gray-600">
                                <!--begin::Table row-->

                                @foreach ($faq->faqcategorys as $value)
                                    <tr>
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="1" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="ms-5">
                                                    <!--begin::Title-->
                                                    <a href=""
                                                        class="text-gray-800 text-hover-primary fs-5 fw-bold mb-1"
                                                        faq-filter="faq_value">{{ $value->title }}</a>
                                                    <!--end::Title-->


                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="ms-5">
                                                    <!--begin::Title-->
                                                    <a href=""
                                                        class="text-gray-800 text-hover-primary fs-5 fw-bold mb-1"
                                                        faq-filter="faq_value">{{ $value->artical }}</a>
                                                    <!--end::Title-->


                                                </div>
                                            </div>
                                            {{-- @if ($value->status == 1)
                                                <div class="badge badge-light-success">Active</div>
                                            @else
                                                <div class="badge badge-light-info">In Active</div>
                                            @endif --}}
                                        </td>
                                        <td class="text-end">
                                            <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                <span class="svg-icon svg-icon-5 m-0">
                                                    <svg width="24" height="24" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                            </a>
                                            <!--begin::Menu-->
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                data-kt-menu="true">
                                                <!--begin::Menu item-->

                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3 border-0 "
                                                        data-id="{{ $value->id }}" faq-model-edit="edit_row"
                                                        data-bs-toggle="modal" data-bs-target="#faqModelEditmodel">
                                                        Edit
                                                    </a>
                                                </div>
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3"
                                                        data-id="{{ $value->id }}"
                                                        faq-model-table="delete_row">Delete</a>
                                                </div>
                                                <!--end::Menu item-->
                                            </div>
                                            <!--end::Menu-->
                                        </td>
                                        <!--end::Action=-->
                                    </tr>
                                @endforeach

                                <!--end::Table row-->
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <div class="row">
                            <div class="col-sm-12 d-flex align-items-center justify-content-center justify-content-md-end">
                                <div class="dataTables_paginate paging_simple_numbers"
                                    id="kt_ecommerce_category_table_paginate">


                                </div>
                            </div>
                        </div>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Content-->
            </div>

        </div>

    </div>
    <!--end::Content-->
    @section('javascript')
        <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
        <script src="{{ asset('assets/js/custom/pages/faq/index.js') }}"></script>
        <script src="{{ asset('assets/js/custom/pages/faq/valueform.js') }}"></script>
    @endsection
</x-app-layout>
