@section('stylesheet')
    <!--begin::Vendor Stylesheets(used for this page only)-->
@livewireStyles()
<style>
    .btn:focus {
        outline: none !important;
    }
</style>
    <!--end::Vendor Stylesheets-->
@endsection
<x-app-layout>



   <!--begin::Toolbar-->
   <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <x-header title="Item Details" />
    <pre>
</div>
<!--end::Toolbar-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Navbar-->
            @livewire('item-livewire')

            {{-- <div class="card mb-5 mb-xxl-5 bg-transparent">
                @foreach ($items as $item)
                    <x-item-card :item="$item" />
                    <hr>
                @endforeach
                @if ($items->links()->paginator->hasPages())
                    <div class="mt-4 p-4 box has-text-centered w-fit mx-auto">
                        {{ $items->links() }}
                    </div>
                @endif
            </div> --}}
            <!--end::Navbar-->
        </div>
        <!--end::Content container-->
    </div>
    @section('javascript')
    @livewireScripts()
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>
            const button = document.getElementById('kt_docs_sweetalert_basic');
            // import * as axios from 'axios';
            $(document).ready(function() {
                // alert( "this.value" );
                $('.statusChange').on('click', async function() {
                    // alert( this.value )
                    // let ItemId = $(this).data('id');
                    // let itemStatusId = $(this).data('value');
                    const {
                        id: ItemId,
                        status: itemStatusId
                    } = $(this)[0].dataset;
                    console.log("id", ItemId, "value", itemStatusId);
                    // console.log("Item Status Id", axios.get )

                        blockUI.block();


                    const res = await axios.post('{{ route('item.status') }}', {
                            'item_id': ItemId,
                            'itemstatus_id': itemStatusId
                        })
                        .then((res) => {
                            //   assign state posts with response data
                            //  posts.value = res.data.data;
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
                            window.location.reload()
                            blockUI.release()
                        })
                });
            });
        </script>
    @endsection
</x-app-layout>
