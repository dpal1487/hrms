<div class="modal-body">
    <!--begin::Form-->
    <!--begin::Card body-->
    <!--begin::Input group-->
    <div class="fv-row mb-5">
        <!--begin::Label-->
        <label class="form-label">Value</label>
        <!--end::Label-->
        <!--begin::Editor-->
        <input type="text" name="attribute_value" id="attribute_value" class="form-control mb-2"
            placeholder="Attribute Value" valur={{ @$attributeValue->attribute_value }} />
        <!--end::Editor-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-5">
        <!--begin::Label-->
        <label class="form-label">Status</label>
        <!--begin::Label-->
        <!--begin::Label-->
        <select class="form-select mb-2" id="status" name="status" data-control="select2"
            data-placeholder="Select an option">
            <option value="">Select an option</option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>
        <!--begin::Label-->
    </div>
    <!--end::Input group-->
    <!--end::Card body-->
    <input type="hidden" name="attribute_id" value="{{ $attribute->id }}" />
    <input type="hidden" name="attribut_value_id" id="attribut_value_id" />
    <div class="modal-footer">
        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
        <button type="button" id="submit" class="btn btn-primary btn-sm">Save changes</button>
    </div>
</div>
