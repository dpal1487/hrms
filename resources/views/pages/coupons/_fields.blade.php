   <!--start::Card body-->
   <div class="card-body pt-0">
        <div class="row g-3">
            <div class="mb-10 fv-row col-6">
                <label class="required form-label">Code</label>
                <div class="">
                    <input type="text" name="code" class="form-control mb-2" placeholder="Coupon  Code"
                        value="{{ @$coupon->code }}" />
                    <div class="text-muted fs-7">An Coupon  Code is required </div>
                </div>
            </div>

           <div class="mb-10 fv-row col-6">
               <label class="form-label required">Expires In Days </label>
               <div class="">

                   <input  name="expires_in_days" class="form-control mb-2" placeholder="Expires In Days"
                       value="{{ @$coupon->expires_at }}" id="kt_datepicker_1"/>
                       <div class="text-muted fs-7">An Expires In Days field is required.</div>
               </div>
           </div>
       </div>
       <div class="row g-3">
           <div class="mb-10 fv-row col-6">
               <label class="required form-label">Discount </label>
               <div class="">
                   <input type="text" name="discount" class="form-control mb-2" placeholder="Discount"
                       value="{{ @$coupon->discount }}" />
                   <div class="text-muted fs-7">An Discount field is required.</div>
               </div>
           </div>
           <div class="mb-10 fv-row col-6">
               <label class="form-label required">Type </label>
               <div class="">
               <select class="form-select mb-2" name="type" data-control="select2"
                   data-placeholder="Select an option">
                   <option value="">Select an option</option>
                   <option value="percentage" @selected(@$coupon->type == 'percentage')>Percentage</option>
                   <option value="numeric" @selected(@$coupon->type == 'numeric')>Numeric</option>
               </select>
               <div class="text-muted fs-7">Type is required </div>
               </div>

           </div>
       </div>

       <div class="row">
           <div class="fv-row mb-2">
               <label class="form-label required">Description</label>
               <textarea name="description" class="form-control">{{ @$coupon->descriptions }}</textarea>
               <div class="text-muted fs-7 mt-2">Set a Description to the coupon for better visibility.</div>
           </div>
       </div>
   </div>
   <!--end::Card body-->
