@section('stylesheet')
@endsection
<x-app-layout>

 <!--begin::Toolbar-->
 <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <x-header :title="$title" />
    <pre>
</div>
<!--end::Toolbar-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">

            <div class="row g-5 g-xl-10 mb-5 mb-xl-10 position: relative;">
                <div class="col-sm-12 col-md-5" style="position: sticky; top: 0">
                    <div class="row col-md-12">
                        <div class="col-md-3">
                            <div class="">
                                <img alt="user image" src="{{ asset('assets/media/avatars/300-1.jpg') }}"
                                    class="rounded h-100 w-100">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="fs-3 fw-bold text-theme-primary">
                                <span>{{ $itemreview->category->name}} </span><br>

                                <span>Cusmtomer Reviews</span>
                                <span class="badge badge-light-info fs-6 fw-bold">
                                    @if ($itemreview->review == null)
                                    0 Reviews
                                    @else
                                    {{ $itemreview->review->review->rating}}  Reviews
                                    @endif
                                </span></span>
                            </div>
                            <div class="rating">
                                <div class="d-flex">
                                    @if ($itemreview->review != null)

                                        <div class="rating">
                                            <div class="rating-label checked">
                                                <?php
                                                $unselected = 5 - $itemreview->review->review->rating;
                                                $selected_stars = '';
                                                for ($i = 0; $i < $itemreview->review->review->rating; $i++) {
                                                    $selected_stars .= '<span class="svg-icon svg-icon-2"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"></path></svg></span>';
                                                }
                                                echo $selected_stars;
                                                ?>
                                            </div>
                                            <?php
                                            $unselected_stars = '';
                                            if(!is_nan($unselected)){
                                                for ($i = 0; $i < $unselected; $i++) {
                                                    $unselected_stars .= '<span class="svg-icon svg-icon-2"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"></path></svg></span>';
                                                }
                                            }
                                            echo $unselected_stars;
                                            ?>
                                        </div>
                                        @endif
                                </div>
                                <span class="mx-10 mt-2 fs-5 fw-bold">
                                    @if ($itemreview->review == null)
                                    0  Out Of 5
                                    @else
                                    {{ $itemreview->review->reviews[0]['rating'] }}  Out Of 5
                                    @endif
                                </span>
                            </div>
                            <div class="">
                                <div class="d-flex align-items-center mt-2">
                                    <span style="color:#777777 ; width: 6rem">5 Stars</span>
                                    <div class='ms-4 position-relative bg-secondary rounded-pill'
                                        style="width:12rem;height:1rem;">
                                        <div class="position-absolute bg-warning rounded-pill top-0 start-0 end-0 h-100"
                                            style=" width: 90%";></div>
                                    </div>
                                    <span class='ms-4' style="color:#202020 ;width: 9rem">15 Reviews</span>
                                </div>

                                <div class="d-flex align-items-center mt-2">
                                    <span style="color:#777777 ; width: 6rem">4 Stars</span>
                                    <div class='ms-4 position-relative bg-secondary rounded-pill'
                                        style="width:12rem;height:1rem;">
                                        <div class="position-absolute bg-warning rounded-pill top-0 start-0 end-0 h-100"
                                            style="width: 66%"></div>
                                    </div>
                                    <span class='ms-4' style="color:#202020 ;width: 9rem">10 Reviews</span>
                                </div>

                                <div class="d-flex align-items-center mt-2">
                                    <span style="color:#777777 ; width: 6rem">3 Stars</span>
                                    <div class='ms-4 position-relative bg-secondary rounded-pill'
                                        style="width:12rem;height:1rem;">
                                        <div class="position-absolute bg-warning rounded-pill top-0 start-0 end-0 h-100"
                                            style="width:40%;"></div>
                                    </div>
                                    <span class='ms-4' style="color:#202020 ;width: 9rem">8 Reviews</span>
                                </div>

                                <div class="d-flex align-items-center mt-2">
                                    <span style="color:#777777 ; width: 6rem">2 Stars</span>
                                    <div class='ms-4 position-relative bg-secondary rounded-pill'
                                        style="width:12rem;height:1rem;">
                                        <div class="position-absolute bg-warning rounded-pill top-0 start-0 end-0 h-100"
                                            style="width:20%;"></div>
                                    </div>
                                    <span class='ms-4' style="color:#202020 ;width: 9rem">5 Reviews</span>
                                </div>

                                <div class="d-flex align-items-center mt-2">
                                    <span style="color:#777777 ; width: 6rem">1 Stars</span>
                                    <div class='ms-4 position-relative bg-secondary rounded-pill'
                                        style="width:12rem;height:1rem;">
                                        <div class="position-absolute bg-warning rounded-pill top-0 start-0 end-0 h-100"
                                            style="width:10%;"></div>
                                    </div>
                                    <span class='ms-4' style="color:#202020 ;width: 9rem">2 Reviews</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-7 overflow-auto" style="height: 100vh;">
                    @foreach ( $itemreview->reviews as $itemreview)
                    <div class="card mb-3 mt-4 rounded shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-stretch justify-content-between">
                                <div class="d-flex align-items-stretch">
                                    <div class="me-4" style="height: 4rem;">
                                        <img alt="user image" src="{{ asset('assets/media/avatars/300-1.jpg') }}"
                                            style="width: 4rem;" class="rounded h-100" />
                                    </div>
                                    <div class="">
                                        <h4>
                                            @if ($itemreview == null)
                                            John Doe
                                            @else
                                            {{ $itemreview->user->first_name}}
                                            {{ $itemreview->user->last_name}}
                                            @endif
                                        </h4>
                                        <div class="rating">
                                            <div class="d-flex">
                                                <x-rating :itemreview="$itemreview"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-fit">
                                    @if ($itemreview->review == null)
                                    @else
                                    {{ $itemreview->user->created_at->format('d M Y')}}
                                    @endif
                                </div>
                            </div>
                            <div class="mt-2">
                                @if ($itemreview->review == null)
                                @else
                                {{ $itemreview->review->title}}<br>
                                {{ $itemreview->review->content}}
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!--end::Content container-->
    </div>
    @section('javascript')
    @endsection
</x-app-layout>
