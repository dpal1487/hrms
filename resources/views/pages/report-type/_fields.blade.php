   <!--start::Card body-->
   <div class="card-body pt-0">
        <div class="row g-3">
            <div class="mb-10 fv-row col-6">
                <label class="required form-label">Title</label>
                <div class="">
                    <input type="text" name="title" class="form-control mb-2" placeholder="Title"
                        value="{{ @$reporttype->title }}" />
                    <div class="text-muted fs-7">Title is required </div>
                </div>
            </div>
       </div>

       <div class="row">
           <div class="fv-row mb-2">
               <label class="form-label required">Description</label>
               <textarea name="description" class="form-control">{{ @$reporttype->description }}</textarea>
               <div class="text-muted fs-7 mt-2">Set a Description to the coupon for better visibility.</div>
           </div>
       </div>
   </div>
   <!--end::Card body-->
