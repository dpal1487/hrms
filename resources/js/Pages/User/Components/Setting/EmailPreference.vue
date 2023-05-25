<script>
import { Link } from '@inertiajs/inertia-vue3';
import useVuelidate from '@vuelidate/core';
import { defineComponent } from 'vue';

export default defineComponent({
    props: [],

    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {

            }
        }
    },
    data() {
        return {
            processing: false,
            isDisabled: true,
        }
    },
    components: { Link },


    methods: {
        enable() {
            this.isDisabled = false
        },
        disabled() {
            this.isDisabled = true
        },
        submit() {
            this.v$.$touch();
            if (!this.form.$invalid) {

            }

        },

    },

})
</script>

<template>
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Email Preferences</h3>
            </div>
            <button v-if="isDisabled == true" type="button" @click="enable" class="btn btn-primary align-self-center">Enable
                Preferences</button>
            <button v-if="isDisabled == false" type="button" @click="disabled"
                class="btn btn-primary align-self-center">Disable
                Preferences</button>
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div>
            <!--begin::Form-->
            <form class="form" @submit.prevent="submit()">
                <!--begin::Card body   v-if="isEdit"  -->
                <div class="card-body border-top px-9 py-9">
                    <!--begin::Option-->
                    <label class="form-check form-check-custom form-check-solid align-items-start">
                        <!--begin::Input-->
                        <input class="form-check-input me-3" :disabled="isDisabled" type="checkbox"
                            name="email-preferences[]" value="1" />
                        <!--end::Input-->
                        <!--begin::Label-->
                        <span class="form-check-label d-flex flex-column align-items-start">
                            <span class="fw-bold fs-5 mb-0">Successful Payments</span>
                            <span class="text-muted fs-6">Receive a notification for every successful payment.</span>
                        </span>
                        <!--end::Label-->
                    </label>
                    <!--end::Option-->
                    <!--begin::Option-->
                    <div class="separator separator-dashed my-6"></div>
                    <!--end::Option-->
                    <!--begin::Option-->
                    <label class="form-check form-check-custom form-check-solid align-items-start">
                        <!--begin::Input-->
                        <input class="form-check-input me-3" :disabled="isDisabled" type="checkbox"
                            name="email-preferences[]" checked="checked" value="1" />
                        <!--end::Input-->
                        <!--begin::Label-->
                        <span class="form-check-label d-flex flex-column align-items-start">
                            <span class="fw-bold fs-5 mb-0">Payouts</span>
                            <span class="text-muted fs-6">Receive a notification for every initiated payout.</span>
                        </span>
                        <!--end::Label-->
                    </label>
                    <!--end::Option-->
                    <!--begin::Option-->
                    <div class="separator separator-dashed my-6"></div>
                    <!--end::Option-->
                    <!--begin::Option-->
                    <label class="form-check form-check-custom form-check-solid align-items-start">
                        <!--begin::Input-->
                        <input class="form-check-input me-3" :disabled="isDisabled" type="checkbox"
                            name="email-preferences[]" value="1" />
                        <!--end::Input-->
                        <!--begin::Label-->
                        <span class="form-check-label d-flex flex-column align-items-start">
                            <span class="fw-bold fs-5 mb-0">Fee Collection</span>
                            <span class="text-muted fs-6">Receive a notification each time you collect a fee from
                                sales</span>
                        </span>
                        <!--end::Label-->
                    </label>
                    <!--end::Option-->
                    <!--begin::Option-->
                    <div class="separator separator-dashed my-6"></div>
                    <!--end::Option-->
                    <!--begin::Option-->
                    <label class="form-check form-check-custom form-check-solid align-items-start">
                        <!--begin::Input-->
                        <input class="form-check-input me-3" :disabled="isDisabled" type="checkbox"
                            name="email-preferences[]" checked="checked" value="1" />
                        <!--end::Input-->
                        <!--begin::Label-->
                        <span class="form-check-label d-flex flex-column align-items-start">
                            <span class="fw-bold fs-5 mb-0">Customer Payment Dispute</span>
                            <span class="text-muted fs-6">Receive a notification if a payment is disputed by a customer and
                                for dispute purposes.</span>
                        </span>
                        <!--end::Label-->
                    </label>
                    <!--end::Option-->
                    <!--begin::Option-->
                    <div class="separator separator-dashed my-6"></div>
                    <!--end::Option-->
                    <!--begin::Option-->
                    <label class="form-check form-check-custom form-check-solid align-items-start">
                        <!--begin::Input-->
                        <input class="form-check-input me-3" :disabled="isDisabled" type="checkbox"
                            name="email-preferences[]" value="1" />
                        <!--end::Input-->
                        <!--begin::Label-->
                        <span class="form-check-label d-flex flex-column align-items-start">
                            <span class="fw-bold fs-5 mb-0">Refund Alerts</span>
                            <span class="text-muted fs-6">Receive a notification if a payment is stated as risk by the
                                Finance Department.</span>
                        </span>
                        <!--end::Label-->
                    </label>
                    <!--end::Option-->
                    <!--begin::Option-->
                    <div class="separator separator-dashed my-6"></div>
                    <!--end::Option-->
                    <!--begin::Option-->
                    <label class="form-check form-check-custom form-check-solid align-items-start">
                        <!--begin::Input-->
                        <input class="form-check-input me-3" :disabled="isDisabled" type="checkbox"
                            name="email-preferences[]" checked="checked" value="1" />
                        <!--end::Input-->
                        <!--begin::Label-->
                        <span class="form-check-label d-flex flex-column align-items-start">
                            <span class="fw-bold fs-5 mb-0">Invoice Payments</span>
                            <span class="text-muted fs-6">Receive a notification if a customer sends an incorrect amount to
                                pay their invoice.</span>
                        </span>
                        <!--end::Label-->
                    </label>
                    <!--end::Option-->
                    <!--begin::Option-->
                    <div class="separator separator-dashed my-6"></div>
                    <!--end::Option-->
                    <!--begin::Option-->
                    <label class="form-check form-check-custom form-check-solid align-items-start">
                        <!--begin::Input-->
                        <input class="form-check-input me-3" :disabled="isDisabled" type="checkbox"
                            name="email-preferences[]" value="1" />
                        <!--end::Input-->
                        <!--begin::Label-->
                        <span class="form-check-label d-flex flex-column align-items-start">
                            <span class="fw-bold fs-5 mb-0">Webhook API Endpoints</span>
                            <span class="text-muted fs-6">Receive notifications for consistently failing webhook API
                                endpoints.</span>
                        </span>
                        <!--end::Label-->
                    </label>
                    <!--end::Option-->
                </div>
                <!--end::Card body-->
                <!--begin::Card footer-->
                <div :class="`card-footer d-flex justify-content-end gap-2 ${isDisabled == true ? 'd-none' : ''}`">
                    <button type="button" @click="disabled"
                        class="btn btn-secondary align-items-center justify-content-center">Disable</button>

                    <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                        :data-kt-indicator="processing ? 'on' : 'off'">
                        <span class="indicator-label">
                            <span>Save Changes</span>
                        </span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
                <!--end::Card footer-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Content-->
    </div>
</template>