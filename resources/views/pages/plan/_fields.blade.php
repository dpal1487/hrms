   <!--start::Card body-->
   <div class="col-12 col-lg-8 d-flex flex-column flex-row-fluid gap-5 mb-4">
       <div class="card card-flush py-4">
           <div class="card-body pt-0">
               <div class="row g-3">
                   <div class="mb-10 fv-row col-6">
                       <label class="required form-label">Name</label>
                       <div class="">
                           <input type="text" name="name" class="form-control mb-2" placeholder="Plan name"
                               value="{{ @$plan->name }}" />
                           <div class="text-muted fs-7">Plan name is required </div>
                       </div>
                   </div>
                   <div class="mb-10 fv-row col-6">
                       <label class="required form-label">Price</label>
                       <div class="">
                           <input type="text" name="price" class="form-control mb-2" placeholder="Price"
                               value="{{ @$plan->price }}" />
                           <div class="text-muted fs-7">Price Price is required Only Number Allowd.</div>
                       </div>
                   </div>
               </div>
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
                                   <option @selected($val->id == @$plan->category_id) value="{{ $val->id }}">
                                       {{ $val->name }}
                                   </option>
                                   {{-- <option value="{{ $val->id }}"> {{ $val->name }}</option> --}}
                               @endforeach
                           </select>
                           <div class="text-muted fs-7">Category is required.</div>

                       </div>

                   </div>
                   <div class="mb-10 fv-row col-6">
                       <label class="required form-label">Number Of Adds</label>
                       <div class="">
                           <input type="text" name="no_of_ads" class="form-control mb-2" placeholder="Number Of Adds"
                               value="{{ @$plan->no_of_ads }}" />
                           <div class="text-muted fs-7">Number Of Ads is required Only Number Allowd.</div>
                       </div>
                   </div>
               </div>

               <div class="row g-3">

                   <div class="mb-10 fv-row col-6">
                       <label class="required form-label">Currency </label>
                       <div class="">
                           <input type="text" name="currency" class="form-control mb-2" placeholder="Currency"
                               value="{{ @$plan->currency }}" />
                           <div class="text-muted fs-7">Currency field is required Only Number Allowd.</div>
                       </div>
                   </div>
                   <div class="mb-10 fv-row col-6">
                       <label class="required form-label">Sign Up Fee</label>
                       <div class="">
                           <input type="text" name="sign_up_fee" class="form-control mb-2" placeholder="Sign Up Fee"
                               value="{{ @$plan->no_of_ads }}" />
                           <div class="text-muted fs-7">Sign Up Fee is required Only Number Allowd </div>
                       </div>
                   </div>
               </div>

               <div class="row g-3">
                   <div class="mb-10 fv-row col-6">
                       <label class="form-label required">Trial Period</label>
                       <div class="">
                           <input type="text" name="trial_period" class="form-control mb-2"
                               placeholder="Trial Period" value="{{ @$plan->trial_period }}" />
                           <div class="text-muted fs-7">Trial Period is required Only Number Allowd</div>

                       </div>
                   </div>
                   <div class="mb-10 fv-row col-6">
                       <label class="form-label required">Trial Interval</label>
                       <div class="">
                           <input type="text" name="trial_interval" class="form-control mb-2"
                               placeholder="Trial Interval" value="{{ @$plan->trial_interval }}" />
                           <div class="text-muted fs-7">Trial Interval is required </div>

                       </div>
                   </div>
               </div>

               <div class="row g-3">
                   <div class="mb-10 fv-row col-6">
                       <label class="form-label required">Invoice Period</label>
                       <div class="">
                           <input type="text" name="invoice_period" class="form-control mb-2"
                               placeholder="Invoice Period" value="{{ @$plan->invoice_period }}" />
                           <div class="text-muted fs-7">Invoice Period is required Only Number Allowd</div>

                       </div>
                   </div>
                   <div class="mb-10 fv-row col-6">
                       <label class="form-label required">Invoice Interval</label>
                       <div class="">
                           <input type="text" name="invoice_interval" class="form-control mb-2"
                               placeholder="Invoice Interval" value="{{ @$plan->invoice_interval }}" />
                           <div class="text-muted fs-7">Invoice Interval is required </div>

                       </div>
                   </div>
               </div>

               <div class="row g-3">
                   <div class="mb-10 fv-row col-6">
                       <label class="form-label required">Grace Period</label>
                       <div class="">
                           <input type="text" name="grace_period" class="form-control mb-2"
                               placeholder="Grace Period" value="{{ @$plan->grace_period }}" />
                           <div class="text-muted fs-7">Grace Period is required Only Number Allowd</div>

                       </div>
                   </div>
                   <div class="mb-10 fv-row col-6">
                       <label class="form-label required">Grace Interval</label>
                       <div class="">
                           <input type="text" name="grace_interval" class="form-control mb-2"
                               placeholder="Grace Interval" value="{{ @$plan->grace_interval }}" />
                           <div class="text-muted fs-7">Grace Interval is required </div>

                       </div>
                   </div>
               </div>

               <div class="row g-3">
                   <div class="mb-10 fv-row col-6">
                       <label class="form-label">Prorate Day</label>
                       <div class="">
                           <input type="text" name="prorate_day" class="form-control mb-2"
                               placeholder="Prorate Day" value="{{ @$plan->prorate_day }}" />
                           <div class="text-muted fs-7">Prorate Day Only Number Allowd </div>


                       </div>
                   </div>
                   <div class="mb-10 fv-row col-6">
                       <label class="form-label">Prorate Period</label>
                       <div class="">
                           <input type="text" name="prorate_period" class="form-control mb-2"
                               placeholder="Prorate Period" value="{{ @$plan->prorate_period }}" />
                           <div class="text-muted fs-7">Prorate Period Only Number Allowd </div>

                       </div>
                   </div>
               </div>
               <div class="row g-3">
                   <div class="mb-10 fv-row col-6">
                       <label class="form-label">Prorate Extend Due</label>
                       <div class="">
                           <input type="text" name="prorate_extend_due" class="form-control mb-2"
                               placeholder="Prorate Extend Due" value="{{ @$plan->prorate_extend_due }}" />
                           <div class="text-muted fs-7">Prorate Extend Due Only Number Allowd </div>

                       </div>
                   </div>
                   <div class="mb-10 fv-row col-6">
                       <label class="form-label">Active Subscribers Limit</label>
                       <div class="">
                           <input type="text" name="active_subscribers_limit" class="form-control mb-2"
                               placeholder="Active Subscribers Limit"
                               value="{{ @$plan->active_subscribers_limit }}" />
                           <div class="text-muted fs-7">Active Subscribers Limit Only Number Allowd </div>

                       </div>
                   </div>
               </div>


               <div class="row g-3">
                   <div class="mb-10 fv-row col-6">
                       <label class="form-label required">Sort Order</label>
                       <div class="">
                           <input type="text" name="sort_order" class="form-control mb-2"
                               placeholder="Sort Order" value="{{ @$plan->sort_order }}" />
                           <div class="text-muted fs-7">Sort Order is required </div>

                       </div>
                   </div>
                   <div class="mb-10 fv-row col-6">
                       <label class="form-label required">Status </label>
                       <div class="">
                           <select class="form-select mb-2" name="status" data-control="select2"
                               data-placeholder="Select an option">
                               <option value="">Select an option</option>
                               <option value="1" @selected(@$plan->is_active == '1')>Active</option>
                               <option value="0" @selected(@$plan->is_active == '0')>In Active</option>
                           </select>
                           <div class="text-muted fs-7">Status is required </div>
                       </div>

                   </div>
               </div>

               <div class="row">
                   <div class="fv-row mb-2">
                       <label class="form-label required">Sort Description</label>
                       <textarea name="sort_description" class="form-control">{{ @$plan->sort_description }}</textarea>
                       <div class="text-muted fs-7">Set a description to the plan for better visibility.</div>
                   </div>
               </div>
           </div>
           <!--end::Card body-->
       </div>
   </div>
   <div class="col-12 col-lg-4 d-flex flex-column flex-row-fluid gap-7">
       <div class="card card-flush py-4">
           <!--begin::Card header-->
           <div class="card-header">
               <div class="card-title">
                   <h2>Plan Description</h2>
               </div>
           </div>
           <!--end::Card header-->
           <!--begin::Card body-->
           <div class="card-body pt-0">
               <div id="plan_conditions">
                   <!--begin::Form group-->
                   <div class="form-group">
                       <div class="row align-items-center">
                           <div data-repeater-list="plan_conditions" class="d-flex flex-column gap-3">
                               <!--begin::Select2-->
                               @if (@$plan->description)
                                   @if (is_countable(json_decode($plan->description)) && count(json_decode($plan->description)) > 0)
                                       @foreach (json_decode($plan->description) as $plan)
                                           <div data-repeater-item=""
                                               class="fv-row col-10 d-flex align-items-center mb-4">
                                               <input type="text" name="description" class="form-control"
                                                   placeholder="Plan Description"
                                                   value="{{ @$plan->description }}" />
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
                                       @endforeach
                                   @endif
                               @else
                                   <div data-repeater-item="" class="fv-row col-10 d-flex align-items-center mb-4">
                                       <input type="text" name="description" class="form-control"
                                           placeholder="Plan Description" />
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

                   <div class="form-group mt-5">
                       <!--begin::Button-->
                       <button type="button" data-repeater-create="" class="btn btn-sm btn-light-primary">
                           Add More
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
           <a href="{{ route('plan.index') }}" class="btn btn-light me-5">Cancel</a>
           <!--end::Button-->
           <button type="submit" class="btn btn-primary" id="submit">
               <!--begin::Indicator label-->
               <span class="indicator-label">
                @if ($segments[1] == "add")
                    Save
                @elseif ($segments[1] = "edit")
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
