<div class="modal-body">
    <!--begin::Form-->
    <!--begin::Card body-->
    <!--begin::Input group-->
    <div class="fv-row mb-5">
        <!--begin::Label-->
        <label class="form-label">Title</label>
        <!--end::Label-->
        <input type="text" name="title" id="title" class="form-control mb-2"
            placeholder="Title"  />
        <!--end::Editor-->
    </div>
    <div class="fv-row mb-5">
        <!--begin::Label-->
        <label class="form-label">Artical</label>
        <!--end::Label-->
        <input type="text" name="actical" id="artical" class="form-control mb-2"
            placeholder="Artical"  />
        <!--end::Editor-->
    </div>
    <!--end::Input group-->

    <!--end::Card body-->
    <input type="hidden" name="faq_category" value="{{ $faq->id }}" />
    <input type="hidden" name="faq_category_id" id="faq_category_id" />
    <div class="modal-footer">
        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
        <button type="button" id="submit" class="btn btn-primary btn-sm">Save changes</button>
    </div>
</div>
