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
            <form class="form row" id="plan_form" action="{{ url('plan/store') }}"
                method="POST">
                @csrf
                @include('pages.plan._fields')
            </form>
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
    @section('javascript')
        <!--begin::Custom Javascript(used for this page only)-->
        <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
        <script src="{{ asset('assets/js/custom/pages/plan/form.js') }}"></script>
        <script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    @endsection
</x-app-layout>
