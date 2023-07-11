   <!--start::Card body-->
   <div class="card-body pt-0">
        <div class="row g-3">
            <div class="mb-10 fv-row col-6">
                <label class="required form-label">Label</label>
                <div class="">
                    <input type="text" name="label" class="form-control mb-2" placeholder="Label"
                        value="{{ @$notificationType->label }}" />
                    <div class="text-muted fs-7">Label is required </div>
                </div>
            </div>
            <div class="mb-10 fv-row col-6">
                <label class="form-label required">Status </label>
                <div class="">
                <select class="form-select mb-2" name="status" data-control="select2"
                    data-placeholder="Select an option">
                    <option value="">Select an option</option>
                    <option value="1" @selected(@$notificationType->status == '1')>Active</option>
                    <option value="0" @selected(@$notificationType->status == '0')>Inactive</option>
                </select>
                <div class="text-muted fs-7">Status is required </div>
                </div>

            </div>
       </div>

       <div class="row">
           <div class="fv-row mb-2">
               <label class="form-label required">Description</label>
               <textarea name="description" class="form-control">{{ @$notificationType->description }}</textarea>
               <div class="text-muted fs-7 mt-2">Set a Description to the coupon for better visibility.</div>
           </div>
       </div>
   </div>
   <!--end::Card body-->
