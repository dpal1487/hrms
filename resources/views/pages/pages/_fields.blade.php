   <!--start::Card body-->
   <div class="card-body pt-0">
        <div class="row g-3">
            <div class="mb-10 fv-row col-6">
                <label class="required form-label">Title</label>
                <div class="">
                    <input type="text" name="title" class="form-control mb-2" placeholder="Title"
                        value="{{ @$page->title }}" />
                    <div class="text-muted fs-7">Title is required </div>
                </div>
            </div>

           <div class="mb-10 fv-row col-6">
               <label class="form-label required">Heading </label>
               <div class="">

                   <input  name="heading" class="form-control mb-2" placeholder="Heading"
                       value="{{ @$page->heading }}" />
                       <div class="text-muted fs-7">Heading field is required.</div>
               </div>
           </div>
       </div>
       <div class="row g-3">
        <div class="mb-10 fv-row col-6">
            <label class="required form-label">Meta </label>
            <div class="">
                <select class="form-select mb-2" name="meta" data-control="select2"
                    data-placeholder="Select an option">
                    <option value="">Select an option</option>

                    @foreach ($metas as $val)
                        <option @selected($val->id == @$page->meta_id) value="{{ $val->id }}">
                            {{ $val->description }}
                        </option>
                    @endforeach
                </select>
                <div class="text-muted fs-7">Select Meta For Page</div>

            </div>
        </div>
           <div class="mb-10 fv-row col-6">
               <label class="form-label required">Status </label>
               <div class="">
               <select class="form-select mb-2" name="status" data-control="select2"
                   data-placeholder="Select an option">
                   <option value="">Select an option</option>
                   <option value="1" @selected(@$page->status == '1')>Active</option>
                   <option value="0" @selected(@$page->status == '0')>Inactive</option>
               </select>
               <div class="text-muted fs-7">Status is required </div>
               </div>

           </div>
       </div>
   </div>
   <!--end::Card body-->
