@section('stylesheet')
<!--begin::Vendor Stylesheets(used for this page only)-->
<!--end::Vendor Stylesheets-->
@endsection
<x-app-layout>

    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">

        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <form class="form d-flex flex-column flex-lg-row" id="brand_form" action="{{ url('brand/store') }}"
                method="POST">
                @csrf
                <!--begin::Aside column-->
                @include('pages.brand._fields')
                <!--end::Main column-->
            </form>
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
    @section('javascript')
    <script src="{{ asset('assets/js/custom/pages/brand/form.js') }}"></script>
    @endsection
</x-app-layout>
