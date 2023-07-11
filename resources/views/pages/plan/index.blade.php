@section('stylesheet')
    <!--begin::Vendor Stylesheets(used for this page only)-->
    @livewireStyles

    <!--end::Vendor Stylesheets-->
@endsection
<x-app-layout>

    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toast-->

        <!--end::Toast-->
        <x-header title="Plans" />
        <pre>
    </div>
    <!--end::Toolbar-->
   <!--begin::Content-->
   <div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Category-->
        @livewire('plan-livewire')

        <!--end::Category-->
    </div>
    <!--end::Content container-->
</div>
<!--end::Content-->
@livewireScripts

@section('javascript')
<script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
<script src="{{ asset('assets/js/custom/pages/plan/index.js') }}"></script>
<script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
@endsection
</x-app-layout>
