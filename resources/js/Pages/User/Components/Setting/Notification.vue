<script>

import { defineComponent } from 'vue';
import useVuelidate from '@vuelidate/core';

import { Link } from '@inertiajs/inertia-vue3';

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
    <!--begin::Notifications-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
            data-bs-target="#kt_account_notifications" aria-expanded="true" aria-controls="kt_account_notifications">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Notifications</h3>
            </div>
            <button v-if="isDisabled == true" type="button" @click="enable"
                class="btn btn-primary align-self-center">Enable Notification</button>
            <button v-if="isDisabled == false" type="button" @click="disabled"
                class="btn btn-primary align-self-center">Disable Notification</button>

        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <!--begin::Form-->
        <form class="form">
            <!--begin::Card body-->
            <div class="card-body border-top px-9 pt-3 pb-4">
                <!--begin::Table-->
                <div class="table-responsive">
                    <table class="table table-row-dashed border-gray-300 align-middle gy-6">
                        <tbody class="fs-6 fw-semibold">
                            <!--begin::Table row-->
                            <tr>
                                <td class="min-w-250px fs-4 fw-bold">Notifications</td>
                                <td class="w-125px">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input :disabled="isDisabled" class="form-check-input" type="checkbox" value=""
                                            id="notification_email" checked="checked" data-kt-check="true" />
                                        <label class="form-check-label ps-2" for="notification_email">Email</label>
                                    </div>
                                </td>
                                <td class="w-125px">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input :disabled="isDisabled" class="form-check-input" type="checkbox" value=""
                                            id="notification_phone" checked="checked" data-kt-check="true" />
                                        <label class="form-check-label ps-2" for="notification_phone">Phone</label>
                                    </div>
                                </td>
                            </tr>
                            <!--begin::Table row-->
                            <!--begin::Table row-->
                            <tr>
                                <td>Billing Updates</td>
                                <td>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input :disabled="isDisabled" class="form-check-input" type="checkbox" value="1"
                                            id="billing1" checked="checked" />
                                        <label class="form-check-label ps-2" for="billing1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input :disabled="isDisabled" class="form-check-input" type="checkbox" value=""
                                            id="billing2" checked="checked" />
                                        <label class="form-check-label ps-2" for="billing2"></label>
                                    </div>
                                </td>
                            </tr>
                            <!--begin::Table row-->
                            <!--begin::Table row-->
                            <tr>
                                <td>New Team Members</td>
                                <td>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input :disabled="isDisabled" class="form-check-input" type="checkbox" value=""
                                            id="team1" checked="checked" />
                                        <label class="form-check-label ps-2" for="team1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input :disabled="isDisabled" class="form-check-input" type="checkbox" value=""
                                            id="team2" />
                                        <label class="form-check-label ps-2" for="team2"></label>
                                    </div>
                                </td>
                            </tr>
                            <!--begin::Table row-->
                            <!--begin::Table row-->
                            <tr>
                                <td>Completed Projects</td>
                                <td>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input :disabled="isDisabled" class="form-check-input" type="checkbox" value=""
                                            id="project1" />
                                        <label class="form-check-label ps-2" for="project1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input :disabled="isDisabled" class="form-check-input" type="checkbox" value=""
                                            id="project2" checked="checked" />
                                        <label class="form-check-label ps-2" for="project2"></label>
                                    </div>
                                </td>
                            </tr>
                            <!--begin::Table row-->
                            <!--begin::Table row-->
                            <tr>
                                <td class="border-bottom-0">Newsletters</td>
                                <td class="border-bottom-0">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input :disabled="isDisabled" class="form-check-input" type="checkbox" value=""
                                            id="newsletter1" />
                                        <label class="form-check-label ps-2" for="newsletter1"></label>
                                    </div>
                                </td>
                                <td class="border-bottom-0">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input :disabled="isDisabled" class="form-check-input" type="checkbox" value=""
                                            id="newsletter2" />
                                        <label class="form-check-label ps-2" for="newsletter2"></label>
                                    </div>
                                </td>
                            </tr>
                            <!--begin::Table row-->
                        </tbody>
                    </table>
                </div>
                <!--end::Table-->
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
        <!--end::Content-->
    </div>
    <!--end::Notifications-->
</template>