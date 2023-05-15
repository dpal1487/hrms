<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import { toast } from 'vue3-toastify';
import axios from "axios";
import Header from "./Components/Header.vue";
import { Inertia } from "@inertiajs/inertia";


export default defineComponent({
    props: ['account', 'supplier'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                bank_name: {
                    required,
                },
                bank_address: {
                    required,
                },
                beneficiary_name: {
                    required,
                },
                account_number: {
                    required,
                },
                routing_number: {
                    required,
                },
                swift_code: {
                    required,
                },
                ifsc_code: {
                    required,
                },
                sort_code: {
                    required,
                },
                pan_number: {
                    required,
                }
            },
        };
    },
    data() {
        return {
            processing: false,
            id: route().params.id,
            form: {
                sup_id: route().params.id,
                id: this.account?.data.id || '',
                bank_name: this.account?.data?.bank_name || '',
                bank_address: this.account?.data?.bank_address || '',
                beneficiary_name: this.account?.data?.beneficiary_name || '',
                account_number: this.account?.data?.account_number || '',
                routing_number: this.account?.data?.routing_number || '',
                swift_code: this.account?.data?.swift_code || '',
                ifsc_code: this.account?.data?.ifsc_code || '',
                sort_code: this.account?.data?.sort_code || '',
                pan_number: this.account?.data?.pan_number || '',
            },
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        Multiselect,
        JetInput,
        JetLabel,
        InputError,
        Header
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.processing = true
                axios.post(this.route("account.update", ['supplier', this.form.id]), this.form)
                    .then((response) => {
                        if (response.data.success) {
                            toast.success(response.data.message)
                            this.processing = false
                            Inertia.get('/supplier/' + this.id + '/account')
                            return;
                        } else {
                            toast.error(response.data.message)
                        }
                    }).finally(() => {
                    });
            }
        },
    },
    created() {
    }
});
</script>
<template>
    <Head title="Supplier Address" />
    <AppLayout>
        <div class="app-content flex-column-fluid ">
            <!--begin::Content container-->
            <div class="app-container container-xxl">
                <Header :supplier="supplier.data" />
                <!--begin::details View-->
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header cursor-pointer">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">Edit Account</h3>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--begin::Card header-->
                    <!--begin::Card body-->
                    <!--begin::Content-->
                    <div>
                        <!--begin::Form-->
                        <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                            <!--begin::Card body-->
                            <div class="card-body border-top p-9">
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Bank Name</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <!--begin::Row-->
                                        <jet-input id="bank_name" type="text" v-model="v$.form.bank_name.$model" :class="v$.form.bank_name.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Bank Name" />
                                        <div v-for="(error, index) of v$.form.bank_name.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                        <!--end::Row-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Bank Address</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <jet-input id="bank_address" type="text" v-model="v$.form.bank_address.$model"
                                            :class="v$.form.bank_address.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                                " placeholder="Bank Address" />
                                        <div v-for="(error, index) of v$.form.bank_address.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>

                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                        <span class="required">Benificiary Name</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <jet-input id="beneficiary_name" type="text"
                                            v-model="v$.form.beneficiary_name.$model" :class="v$.form.beneficiary_name.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                                " placeholder="Benificiary Name" />
                                        <div v-for="(error, index) of v$.form.beneficiary_name.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Account Number</label>
                                    <!--end::Label-->
                                    <div class="col-lg-8">
                                        <jet-input id="account_number" type="text" v-model="v$.form.account_number.$model"
                                            :class="v$.form.account_number.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                                " placeholder="Account Number" />
                                        <div v-for="(error, index) of v$.form.account_number.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-6">


                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                        <span class="required">Routing Number</span>

                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <jet-input id="routing_number" type="text" v-model="v$.form.routing_number.$model"
                                            :class="v$.form.routing_number.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                                " placeholder="Routing Number" />
                                        <div v-for="(error, index) of v$.form.routing_number.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">SWIFT Code</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <jet-input id="swift_code" type="text" v-model="v$.form.swift_code.$model" :class="v$.form.swift_code.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="SWIFT Code" />
                                        <div v-for="(error, index) of v$.form.swift_code.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">IFSC Code</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <jet-input id="ifsc_code" type="text" v-model="v$.form.ifsc_code.$model" :class="v$.form.ifsc_code.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="IFSC Code" />
                                        <div v-for="(error, index) of v$.form.ifsc_code.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Short Code</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <jet-input id="sort_code" type="text" v-model="v$.form.sort_code.$model" :class="v$.form.sort_code.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Short Code" />
                                        <div v-for="(error, index) of v$.form.sort_code.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Pan Card</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <jet-input id="pan_number" type="text" v-model="v$.form.pan_number.$model" :class="v$.form.pan_number.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Pan Nnmber" />
                                        <div v-for="(error, index) of v$.form.pan_number.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Card body-->
                            <!--begin::Actions-->
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <Link :href="`/supplier/${id}/account`" class="btn btn-light btn-active-light-primary me-2">
                                Discard
                                </Link>
                                <!-- <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button> -->
                                <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                                    :data-kt-indicator="processing ? 'on' : 'off'">
                                    <span class="indicator-label">
                                        <span>Account</span>
                                    </span>
                                    <span class="indicator-progress">
                                        Please wait... <span
                                            class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>

                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Content-->
                    <!--end::Card body-->
                </div>
                <!--end::details View-->
            </div>
        </div>

    </AppLayout>
</template>
