@section('stylesheet')
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->
@endsection
<x-app-layout>

    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <form class="form d-flex flex-column flex-lg-row gap-5" id="time_period_form" action="{{ url('time-periods/store') }}"
                method="POST">
                @csrf
                @include('pages.time-period._fields')
            </form>
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
    @section('javascript')
        <!--begin::Custom Javascript(used for this page only)-->
        <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
        <script src="{{ asset('assets/js/custom/pages/time-periods/form.js') }}"></script>
        <script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    @endsection
</x-app-layout>
