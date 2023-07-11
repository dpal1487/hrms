@section('stylesheet')
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    @livewireStyles()
    <!--end::Vendor Stylesheets-->
@endsection
<x-app-layout>

    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <x-header title="Enquires" />
        <pre>
    </div>
    <!--end::Toolbar-->
   <!--begin::Content-->
   <div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Category-->
        @livewire('enquire-livewire')
        <!--end::Category-->
    </div>
    <!--end::Content container-->
</div>
<!--end::Content-->
    @section('javascript')
    @livewireScripts()
        <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
        <script src="{{ asset('assets/js/custom/pages/enquires/index.js') }}"></script>
        <script src="{{ asset('assets/js/custom/pages/enquires/form.js') }}"></script>
    <script>
        // import * as axios from 'axios';
        $(document).ready(function() {
            // alert( "this.value" );
            $('.statusChange').on('change', async function() {
                const {
                    id: EnquireId,
                    status: enquireStatusId
                } = $(this)[0].dataset;
                console.log("id", EnquireId, "value", enquireStatusId);
                blockUI.block();
                const res = await axios.post('{{ route('enquire.status') }}', {
                        'enquire_id': EnquireId,
                        'enquirestatus_id': enquireStatusId
                    })
                    .then((res) => {
                        if (res.status === 200) {
                            let resp = JSON.parse(res.request.response);
                            Swal.fire({
                                text: resp.success,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        } else {
                            Swal.fire({
                                text: "Something Went Wrong !",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-warning"
                                }
                            });
                        }
                    })
                    .catch((error) => {
                        console.log(error.res.data);
                    }).finally(() => {
                        // window.location.reload()
                        blockUI.release()
                    })
            });
        });
    </script>
@endsection
</x-app-layout>
