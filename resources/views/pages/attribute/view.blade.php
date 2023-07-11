@section('stylesheet')
<!--begin::Vendor Stylesheets(used for this page only)-->

<!--end::Vendor Stylesheets-->
@endsection
<x-app-layout>

    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toast-->

        <!--end::Toast-->
        {{-- <x-header title="Atttributes" /> --}}
        <pre>
    </div>
    <!--end::Toolbar-->
   <!--begin::Content-->
       <div id="kt_app_content_container" class="app-container container-fluid">
        <!--begin::Category-->
        <div class="mb-5">
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header align-items-center">
                    <div class="card-title">
                        <h2>Atttribute</h2>
                    </div>

                    {{-- {{dd( $attribute) }} --}}

                </div>
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-6">
                            <div id="project_table_wrapper">
                                <table class="table text-center align-middle table-striped mb-0 border border-top-0 border-bottom-0 border-left-0">
                                    <tbody>
                                        <tr>
                                            <th>Name </th>
                                            <td class="fs-6 fw-bold text-gray-800">{{ $attribute->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Data Type</th>
                                            <td class="fs-6 fw-bold text-gray-800">{{ $attribute->data_type }}</td>
                                        </tr>
                                                                                <tr>
                                            <th>Category</th>
                                            <td class="fs-6 fw-bold text-gray-800">{{ $attribute->category->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Field</th>
                                            <td class="fs-6 fw-bold text-gray-800">{{ $attribute->field }}</td>
                                        </tr>

                                        <tr>
                                            <th>Type</th>
                                            <td class="fs-6 fw-bold text-gray-800">{{ $attribute->type }}</td>
                                        </tr>
                                        <tr>
                                            <td>Display Order</td>
                                            <td class="fs-6 fw-bold text-gray-800 whitespace-break">{{ $attribute->display_order }}</td>
                                        </tr>
                                        <tr>
                                            <td>Description</td>
                                            <td class="fs-6 fw-bold text-gray-800 whitespace-break">{{ $attribute->description }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="h-100 d-flex justify-content-center align-items-center">
                                <div class="text-center">
@if($attribute->status == 1)
<div class="badge bg-success">Active</div>
@else
<div class="badge bg-danger">In Active</div>
@endif


                                    <div class="d-flex justify-content-center align-items-center">
                                        <h1>{{ $attribute->values->where('status', 1)->count() }} &nbsp;</h1><span>Out Of</span>
                                        <h1>&nbsp;{{ count($attribute->values) }}</h1>
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
                        <h3 class="fw-bold m-0">Attribute Value</h3>
                        <button type="button" id="add_attribute" data-id="{{$attribute->id}}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#attributeModel">
                            Add
                        </button>
                    </div>
                </div>

                <!-- start form model -->
                <div class="modal fade" tabindex="-1" id="attributeModel">
                    <div class="modal-dialog">
                        <div class="modal-content position-absolute">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Attribute Value</h5>
                            </div>
                            <form class="form d-flex flex-column flex-lg-row" id="value_form" action=""
                                method="POST">
                                @csrf
                                <!--begin::Aside column-->
                                @include('pages.attribute.model_fields')
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
                    <div class="card-body border-top p-9">
                          <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="attribute_table">
                    <!--begin::Table head-->
                    <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-1px pe-2">
                                  <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1" />
                                </div>
                            </th>
                            <th class="min-w-100px">Attribute Value</th>
                            <th class="min-w-100px">Attribute Status</th>
                            <th class="text-end min-w-70px">Actions</th>
                        </tr>
                        <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="fw-semibold text-gray-600">
                        <!--begin::Table row-->

@foreach($attribute->values as $value)
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
                                            <a href="" class="text-gray-800 text-hover-primary fs-5 fw-bold mb-1" attribute-filter="attribute_value">{{ $value->attribute_value }}</a>
                                            <!--end::Title-->


                                        </div>
                                    </div>
                                </td>
                                 <td>
@if($value->status == 1)
<div class="badge badge-light-success">Active</div>
@else
<div class="badge badge-light-info">In Active</div>
@endif
                                </td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                    <span class="svg-icon svg-icon-5 m-0">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    </a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                        <!--begin::Menu item-->

                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3 border-0 " data-id="{{ $value->id }}" attribute-value-edit="edit_row" data-bs-toggle="modal" data-bs-target="#attributevalueEditmodel">
                                                Edit
                                            </a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-id="{{ $value->id }}" attribute-value-table="delete_row">Delete</a>
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
                                            <script src="{{ asset('assets/js/custom/pages/attributes/index.js') }}"></script>
                                            <script src="{{ asset('assets/js/custom/pages/attributes/valueform.js') }}"></script>
@endsection
</x-app-layout>
