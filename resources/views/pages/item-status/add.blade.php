@section('stylesheet')
<!--begin::Vendor Stylesheets(used for this page only)-->
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}"
    rel="stylesheet" type="text/css" />
<!--end::Vendor Stylesheets-->
@endsection
<x-app-layout>

    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar-->

    <!--end::Toolbar-->

        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <form class="form d-flex flex-column flex-lg-row" id="item_status_form" action="{{ url('item-status/store') }}"
                method="POST">
                @csrf

                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <!--begin::General options-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Add Item Status </h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        @include('pages.item-status._fields')
                    </div>
                    <!--end::General options-->

                    <div class="d-flex justify-content-end">
                        <!--begin::Button-->
                        <a href="{{ route('item-status.index') }}" class="btn btn-light me-5">Cancel</a>
                        <!--end::Button-->
                        <button type="submit" class="btn btn-primary" id="submit">
                            <!--begin::Indicator label-->
                            <span class="indicator-label">Save</span>
                            <!--end::Indicator label-->
                            <!--begin::Indicator progress-->
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            <!--end::Indicator progress-->
                        </button>
                        <!--end::Button-->
                    </div>
                </div>


            </form>
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
    @section('javascript')
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/pages/item-status/form.js') }}"></script>
    @endsection
</x-app-layout>
