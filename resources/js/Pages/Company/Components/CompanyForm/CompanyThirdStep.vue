<script>
import { defineComponent } from 'vue';


export default defineComponent({
    props: ["form"],
    data() {
        return {
        }
    },
    methods: {

    }
})
</script>

<template>
    <div class="">
        <!--begin::Wrapper-->
        <div class="w-100">
            <!--begin::Heading-->
            <div class="pb-10 pb-lg-12">
                <!--begin::Title-->
                <h2 class="fw-bold text-dark">Company Details</h2>
                <!--end::Title-->
                <!--begin::Notice-->
                <div class="text-muted fw-semibold fs-6">If you need more info, please check out
                    <a href="#" class="link-primary fw-bold">Help Page</a>.
                </div>
                <!--end::Notice-->
            </div>
            <!--end::Heading-->
            <!--begin::Input group-->
            <div class="fv-row mb-10">
                <!--begin::Label-->
                <label class="form-label required">Company Name</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input v-model="form.company_name" class="form-control form-control-lg form-control-solid"
                     />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
             <!--begin::Input group-->
                <div class="fv-row mb-10">
                    <!--begin::Label-->
                    <label class="form-label required">Company Website</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input v-model="form.company_website" class="form-control form-control-lg form-control-solid"
                         />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="form-label required">Company Domain</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input v-model="form.company_domain" class="form-control form-control-lg form-control-solid"
                             />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-10">
                <!--begin::Label-->
                <label class="d-flex align-items-center form-label">
                    <span class="required">Shortened Descriptor</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input v-model="form.sorted_description" class="form-control form-control-lg form-control-solid"
                     />
                <!--end::Input-->
                <!--begin::Hint-->
                <div class="form-text">Customers will see this shortened version of your
                    statement descriptor</div>
                <!--end::Hint-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-10">
                <!--begin::Label-->
                <label class="form-label required">Corporation Type</label>
                <!--end::Label-->
                <!--begin::Input-->
                <select v-model="form.corporate_type" class="form-select form-select-lg form-select-solid" data-control="select2"
                    data-placeholder="Select..." data-allow-clear="true" data-hide-search="true">
                    <option></option>
                    <option value="1">S Corporation</option>
                    <option value="1">C Corporation</option>
                    <option value="2">Sole Proprietorship</option>
                    <option value="3">Non-profit</option>
                    <option value="4">Limited Liability</option>
                    <option value="5">General Partnership</option>
                </select>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-10">
                <!--end::Label-->
                <label class="form-label">Business Description</label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea v-model="form.description" class="form-control form-control-lg form-control-solid"
                    rows="3"></textarea>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-0">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold form-label required">Contact Email</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input v-model="form.company_email" class="form-control form-control-lg form-control-solid"
                     />
                <!--end::Input-->
            </div>
            <!--end::Input group-->

            <!--begin::Input group-->
                <div class="fv-row mb-0">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold form-label required">Contact Number</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input v-model="form.company_number" class="form-control form-control-lg form-control-solid" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->

        </div>
        <!--end::Wrapper-->
    </div>
</template>
