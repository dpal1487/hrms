<style>
    .form-select+span+span {
        display: none;
    }
</style>
<div class="d-flex col-12 col-lg-8 flex-column flex-row-fluid gap-7 gap-lg-10">
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        <div class="card-header">
            <div class="card-title">
                <h2>Attribute </h2>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Input group-->
            <div class="row g-3">
                <div class="mb-10 fv-row col-12">
                    <!--begin::Label-->
                    <label class="required form-label">Name</label>
                    <!--end::Label-->
                    <div class="">
                        <!--begin::Input-->
                        <input type="text" name="name" class="form-control mb-2" placeholder="Attribute name"
                            value="{{ @$attribute->name }}" />
                        <!--end::Input-->
                        <!--begin::Description-->
                        <div class="text-muted fs-7">Attribute name is required and recommended to be unique.</div>
                        <!--end::Description-->

                    </div>
                </div>
            </div>

            <!--begin::Input group-->

            <!--begin::Input group-->
            <div class="row g-3">
                <div class="mb-10 fv-row col-6">
                    <!--begin::Label-->
                    <label class="required form-label">Category </label>
                    <!--end::Label-->
                    <div class="">
                        <select class="form-select mb-2" name="category" data-control="select2"
                            data-placeholder="Select an option">
                            <option value="">Select an option</option>

                            @foreach ($category as $val)
                                <option @selected($val->id == @$attribute->category_id) value="{{ $val->id }}">
                                    {{ $val->name }}
                                </option>
                                {{-- <option value="{{ $val->id }}"> {{ $val->name }}</option> --}}
                            @endforeach
                        </select>
                        <div class="text-muted fs-7">Category is required.</div>

                    </div>

                </div>

                <div class="mb-10 fv-row col-6">
                    <label class="required form-label">Input Type </label>
                    <!--end::Label-->
                    <select class="form-select mb-2" name="type" data-control="select2"
                        data-placeholder="Select an option">
                        <option value="">Select an option</option>

                        <option value="input" @selected(@$attribute->type == 'input')>Input</option>
                        <option value="checkbox" @selected(@$attribute->type == 'checkbox')>Checkbox</option>
                        <option value="select" @selected(@$attribute->type == 'select')>Select</option>
                        <option value="radio" @selected(@$attribute->type == 'radio')>Radio</option>
                    </select>
                    <div class="text-muted fs-7">Input Type is required.</div>


                </div>
            </div>
            <div class="row g-3">
                <div class="mb-10 fv-row col-6">
                    <label class="form-label">Data Type </label>
                    <!--end::Label-->
                    <select class="form-select mb-2" name="data_type" data-control="select2"
                        data-placeholder="Select an option">
                        <option value="">Select an option</option>
                        <option value="text" @selected(@$attribute->data_type == 'text')>Text</option>
                        <option value="number" @selected(@$attribute->data_type == 'number')>Number</option>
                    </select>
                    <div class="text-muted fs-7">Data Type is Optional.</div>

                </div>
                <div class="mb-10 fv-row col-6">
                    <!--begin::Label-->
                    <label class="form-label required">Display Order </label>
                    <!--end::Label-->
                    <select class="form-select mb-2" name="display_order" data-control="select2"
                        data-placeholder="Select an option">
                        <option value="">Select an option</option>
                        <option value="1" @selected(@$attribute->display_order == '1')>Yes</option>
                        <option value="0" @selected(@$attribute->display_order == '0')>No</option>
                    </select>
                    <div class="text-muted fs-7">Display is required.</div>
                </div>

            </div>
            <div class="row g-3">

                <div class="mb-10 fv-row col-6">
                    <!--begin::Label-->
                    <label class="required form-label">Field</label>
                    <!--end::Label-->
                    <div class="">
                        <!--begin::Input-->
                        <input type="text" name="field" class="form-control mb-2" placeholder="Attribute field"
                            value="{{ @$attribute->field }}" />
                        <!--end::Input-->
                        <div class="text-muted fs-7">Field is required.</div>

                    </div>
                </div>
                <div class="mb-10 fv-row col-6">
                    <!--begin::Label-->
                    <label class="form-label required">Status </label>
                    <!--end::Label-->
                    <select class="form-select mb-2" name="status" data-control="select2"
                        data-placeholder="Select an option">
                        <option value="">Select an option</option>
                        <option value="1" @selected(@$attribute->status == '1')>Active</option>
                        <option value="0" @selected(@$attribute->status == '0')>In Active</option>
                    </select>
                    <div class="text-muted fs-7">Status is required.</div>
                </div>
            </div>
            <!--begin::Input group-->
            <div class="fv-row mb-5">
                <!--begin::Label-->
                <label class="form-label">Description</label>
                <!--end::Label-->
                <!--begin::Editor-->
                <textarea name="description" class="form-control" placeholder="Attribute Description">{{ @$attribute->description }}</textarea>
                <!--end::Editor-->
                <!--begin::Description-->
                <div class="text-muted fs-7">Set a description to the Attribute for better visibility.</div>
                <!--end::Description-->
            </div>
            <!--end::Input group-->



            <!--end::Card header-->


        </div>
    </div>
</div>
<div class="d-flex col-12 col-lg-4 flex-column flex-row-fluid gap-7 gap-lg-10">
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        <div class="card-header">
            <div class="card-title">
                <h2>Attribute Rule</h2>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <div id="add_rule_conditions" data-select2-id="select2-data-kt_ecommerce_add_category_conditions">
                <!--begin::Form group-->
                <div class="">
                    <div>
                        <div class="row align-items-center">
                            <div data-repeater-list="add_rule_conditions" class="fv-row">
                                <!--begin::Select2-->
                                @if (!empty($attribute))
                                    @foreach ($attribute->rules as $val)
                                        <div data-repeater-item="" class="d-flex align-items-center mb-4">
                                            <select class="form-select" data-control="select2"
                                                name="add_rule_conditions[0][rule]"
                                                data-placeholder="Select an option" data-add-rule="condition_type">
                                                <option value="">Select an option</option>
                                                @foreach (@$rules as $rule)
                                                    <option value="{{ @$rule->id }}" @selected(@$rule->id == @$val->rule_id)>
                                                        {{ @$rule->rule }}</option>
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
                                        <select class="form-select" data-control="select2"
                                            name="add_rule_conditions[0][rule]" data-placeholder="Select an option"
                                            data-add-rule="condition_type">
                                            <option value="">Select an option</option>
                                            @foreach (@$rules as $rule)
                                                <option value="{{ @$rule->id }}">{{ @$rule->rule }}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" data-repeater-delete=""
                                            class="btn btn-sm btn-icon btn-light-danger ms-4">
                                            <svg stroke="currentColor" fill="none" stroke-width="0"
                                                viewBox="0 0 15 15" height="1em" width="1em"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M11.7816 4.03157C12.0062 3.80702 12.0062 3.44295 11.7816 3.2184C11.5571 2.99385 11.193 2.99385 10.9685 3.2184L7.50005 6.68682L4.03164 3.2184C3.80708 2.99385 3.44301 2.99385 3.21846 3.2184C2.99391 3.44295 2.99391 3.80702 3.21846 4.03157L6.68688 7.49999L3.21846 10.9684C2.99391 11.193 2.99391 11.557 3.21846 11.7816C3.44301 12.0061 3.80708 12.0061 4.03164 11.7816L7.50005 8.31316L10.9685 11.7816C11.193 12.0061 11.5571 12.0061 11.7816 11.7816C12.0062 11.557 12.0062 11.193 11.7816 10.9684L8.31322 7.49999L11.7816 4.03157Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                                <!--end::Select2-->

                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-5">
                    <!--begin::Button-->
                    <button type="button" data-repeater-create="" class="btn btn-sm btn-light-primary">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 12 16"
                            height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M12 9H7v5H5V9H0V7h5V2h2v5h5v2z"></path>
                        </svg>
                        Add Rule
                    </button>
                    <!--end::Button-->
                </div>
                <!--end::Form group-->
            </div>
            <!--end::Card header-->
        </div>
    </div>
    <div class="d-flex justify-content-end">
        <!--begin::Button-->
        <a href="{{ route('attribute.index') }}" class="btn btn-light me-5">Cancel</a>
        <!--end::Button-->
        <button type="submit" class="btn btn-primary" id="submit">
            <!--begin::Indicator label-->
            <span class="indicator-label">
                @if ($segments[1] == 'add')
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
