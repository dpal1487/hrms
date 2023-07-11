   <!--start::Card body-->
   <div class="card-body pt-0">
        <div class="row g-3">
            <div class="mb-10 fv-row col-6">
                <label class="required form-label">Text</label>
                <div class="">
                    <input type="text" name="text" class="form-control mb-2" placeholder="Text"
                        value="{{ @$ItemStatus->label }}" />
                    <div class="text-muted fs-7">Text is required </div>
                </div>
            </div>

            <div class="mb-10 fv-row col-6">
                <label class="required form-label">Label</label>
                <div class="">
                    <input type="text" name="label" class="form-control mb-2" placeholder="Label"
                        value="{{ @$ItemStatus->label }}" />
                    <div class="text-muted fs-7">Label is required </div>
                </div>
            </div>

       </div>

       <div class="row">
           <div class="fv-row mb-2">
               <label class="form-label required">Description</label>
               <textarea name="description" class="form-control">{{ @$ItemStatus->description }}</textarea>
               <div class="text-muted fs-7 mt-2">Set a Description to the coupon for better visibility.</div>
           </div>
       </div>
   </div>
   <!--end::Card body-->
