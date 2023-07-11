<style>
    .form-select+span+span {
        display: none;
    }
</style>

<div class="d-flex flex-column flex-row-fluid gap-5 gap-lg-10">
    <div class="card card-flush py-4">
        <div class="card-body pt-0">
            <div class="fv-row">
                <div class="">
                    <input type="hidden" value="{{ @$category->id }}" name="category">
                </div>
            </div>
            <div class="row g-3">


                <div id="add_time_conditions" data-select2-id="select2-data-kt_ecommerce_add_category_conditions">
                    <!--begin::Form group-->
                    <div class="">
                        <label class="required form-label">Time </label>
                        <div>
                            <div class="row align-items-center">
                                <!--begin::Select2-->
                                <div data-repeater-list="add_time_conditions" class="fv-row col-10 col-lg-6">
                                    @if (!empty($timePeriod))
                                        @foreach ($timePeriod as $val)
                                            <div data-repeater-item="" class="d-flex align-items-center mb-4">
                                                <select class="form-select" data-control="select2" name="time"
                                                    data-placeholder="Select an option" data-add-time="condition_type">
                                                    <option value="">Select an option</option>
                                                    @foreach (@$times as $time)
                                                        {{ $time->id }}
                                                        <option value="{{ @$time->id }}"
                                                            @selected(@$time->id == @$val->time->id)>
                                                            {{ @$time->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button type="button" data-repeater-delete=""
                                                    class="btn btn-sm btn-icon btn-light-danger ms-4">
                                                    <svg stroke="currentColor" fill="none" stroke-width="0"
                                                        viewBox="0 0 15 15" height="1em" width="1em"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-time="evenodd" clip-time="evenodd"
                                                            d="M11.7816 4.03157C12.0062 3.80702 12.0062 3.44295 11.7816 3.2184C11.5571 2.99385 11.193 2.99385 10.9685 3.2184L7.50005 6.68682L4.03164 3.2184C3.80708 2.99385 3.44301 2.99385 3.21846 3.2184C2.99391 3.44295 2.99391 3.80702 3.21846 4.03157L6.68688 7.49999L3.21846 10.9684C2.99391 11.193 2.99391 11.557 3.21846 11.7816C3.44301 12.0061 3.80708 12.0061 4.03164 11.7816L7.50005 8.31316L10.9685 11.7816C11.193 12.0061 11.5571 12.0061 11.7816 11.7816C12.0062 11.557 12.0062 11.193 11.7816 10.9684L8.31322 7.49999L11.7816 4.03157Z"
                                                            fill="currentColor"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    @else
                                        <div data-repeater-item="" class="d-flex align-items-center mb-4">
                                            <select class="form-select" data-control="select2" name="time"
                                                data-placeholder="Select an option" data-add-time="condition_type">
                                                <option value="">Select an option</option>
                                                @foreach (@$times as $time)
                                                    {{ $time->id }}
                                                    <option value="{{ @$time->id }}">
                                                        {{ @$time->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="button" data-repeater-delete=""
                                                class="btn btn-sm btn-icon btn-light-danger ms-4">
                                                <svg stroke="currentColor" fill="none" stroke-width="0"
                                                    viewBox="0 0 15 15" height="1em" width="1em"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-time="evenodd" clip-time="evenodd"
                                                        d="M11.7816 4.03157C12.0062 3.80702 12.0062 3.44295 11.7816 3.2184C11.5571 2.99385 11.193 2.99385 10.9685 3.2184L7.50005 6.68682L4.03164 3.2184C3.80708 2.99385 3.44301 2.99385 3.21846 3.2184C2.99391 3.44295 2.99391 3.80702 3.21846 4.03157L6.68688 7.49999L3.21846 10.9684C2.99391 11.193 2.99391 11.557 3.21846 11.7816C3.44301 12.0061 3.80708 12.0061 4.03164 11.7816L7.50005 8.31316L10.9685 11.7816C11.193 12.0061 11.5571 12.0061 11.7816 11.7816C12.0062 11.557 12.0062 11.193 11.7816 10.9684L8.31322 7.49999L11.7816 4.03157Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endif

                                </div>
                                <!--end::Select2-->
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-5">
                        <!--begin::Button-->
                        <button type="button" data-repeater-create="" class="btn btn-sm btn-light-primary">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 12 16"
                                height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path fill-time="evenodd" d="M12 9H7v5H5V9H0V7h5V2h2v5h5v2z"></path>
                            </svg>
                            Add Time
                        </button>
                        <!--end::Button-->
                    </div>
                    <!--end::Form group-->
                </div>
            </div>
        </div>
        <!--end::Card body-->
    </div>
    <div class="d-flex justify-content-end">
        <!--begin::Button-->
        <a href="{{ route('time-periods.index') }}" class="btn btn-light me-5">Cancel</a>
        <!--end::Button-->
        <button type="submit" class="btn btn-primary" id="submit">
            <!--begin::Indicator label-->
            <span class="indicator-label">
                @if ($segments[2] == 'add')
                    Save
                @elseif ($segments[2] = 'edit')
                    Update
                @endif
            </span>
            <!--end::Indicator label-->
            <!--begin::Indicator progress-->
            <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            <!--end::Indicator progress-->
        </button>
        <!--end::Button-->
    </div>
</div>
