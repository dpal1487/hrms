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
    <div class="" data-kt-element="apps">
        <!--begin::Heading-->
        <!--end::Heading-->
        <!--begin::Description-->
        <div class="text-gray-500 fw-semibold fs-6 mb-10">Using an authenticator app like
            <a href="https://support.google.com/accounts/answer/1066447?hl=en" target="_blank">Google
                Authenticator</a>,
            <a href="https://www.microsoft.com/en-us/account/authenticator" target="_blank">Microsoft
                Authenticator</a>,
            <a href="https://authy.com/download/" target="_blank">Authy</a>, or
            <a href="https://support.1password.com/one-time-passwords/" target="_blank">1Password</a>, scan
            the QR code. It will generate a 6 digit code for you to enter below.
            <!--begin::QR code image-->
            <div class="pt-5 text-center">
                <img src="/assets/media/misc/qr.png" alt="" class="mw-150px" />
            </div>
            <!--end::QR code image-->
        </div>
        <!--end::Description-->
        <!--begin::Notice-->
        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-10 p-6">
            <!--begin::Icon-->
            <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
            <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                    <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor" />
                    <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor" />
                </svg>
            </span>
            <!--end::Svg Icon-->
            <!--end::Icon-->
            <!--begin::Wrapper-->
            <div class="d-flex flex-stack flex-grow-1">
                <!--begin::Content-->
                <div class="fw-semibold">
                    <div class="fs-6 text-gray-700">If you having trouble using the QR code, select manual
                        entry on your app, and enter your username and the code:
                        <div class="fw-bold text-dark pt-2">KBSS3QDAAFUMCBY63YCKI5WSSVACUMPN</div>
                    </div>
                </div>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Notice-->
        <!--begin::Form-->
        <form class="form" action="#">
            <!--begin::Input group-->
            <div class="mb-10 fv-row">
                <input type="text" class="form-control form-control-lg form-control-solid"
                    placeholder="Enter authentication code" name="code" />
            </div>
            <!--end::Input group-->
            <!--begin::Actions-->
            <div class="d-flex flex-center gap-5">
                <button type="reset" @click="resetForm" class="btn btn-outline-secondary">Discard</button>
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
