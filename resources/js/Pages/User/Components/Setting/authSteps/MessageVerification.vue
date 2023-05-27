<script>
import { defineComponent } from 'vue';

export default defineComponent({
    props: [],
    methods: {
        resetForm() {
            // reset logic....
            this.$emit('oncancel');
        }
    }
})

</script>



<template>
    <div class="">
        <!--begin::Heading-->

        <!--end::Heading-->
        <!--begin::Notice-->
        <div class="text-muted fw-semibold mb-10">Enter your mobile phone number with country code and we
            will send you a verification code upon request.</div>
        <!--end::Notice-->
        <!--begin::Form-->
        <form class="form" action="#">
            <!--begin::Input group-->
            <div class="mb-10 fv-row">
                <input type="text" class="form-control form-control-lg form-control-solid"
                    placeholder="Mobile number with country code..." name="mobile" />
            </div>
            <!--end::Input group-->
            <!--begin::Actions-->
            <div class="d-flex flex-center gap-5">
                <button type="reset" class="btn btn-outline-secondary" @click="resetForm">Discard</button>
                <button type="submit" class="btn btn-primary">
                    <span class="indicator-label">Submit</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
</template>
