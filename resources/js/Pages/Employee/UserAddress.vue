<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import PrimaryButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import { toast } from 'vue3-toastify';
import axios from "axios";
import Header from "./Components/Header.vue";
import { Inertia } from "@inertiajs/inertia";


export default defineComponent({
    props: ['countries', 'user', 'address'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                address_line_1: {
                    required,
                },
                address_line_2: {
                    required,
                },
                city: {
                    required,
                },
                state: {
                    required,
                },
                country: {
                    required,
                },
                pincode: {
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
                emp_id: route().params.id,
                id: this.address?.data.id || '',
                address_line_1: this.address?.data?.address_line_1 || '',
                address_line_2: this.address?.data?.address_line_2 || '',
                city: this.address?.data?.city || '',
                state: this.address?.data?.state || '',
                country: this.address?.data?.country?.id || '',
                pincode: this.address?.data?.pincode || '',
            },
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        Multiselect,
        PrimaryButton,
        JetInput,
        JetLabel,
        InputError,
        JetValidationErrors,

        Header
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.processing = true
                axios.post(this.route("address.update", ['employee', this.form.id]), this.form)
                    .then((response) => {
                        if (response.data.success) {
                            toast.success(response.data.message)
                            this.processing = false
                            Inertia.get('/employee/' + this.id + '/address')
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
    <Head title="User Address" />
    <AppLayout title="Employee">
        <div class="app-content flex-column-fluid ">
            <!--begin::Content container-->
            <div class="app-container container-xxl">
                <Header :user="user.data" />

                <!--begin::details View-->
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header cursor-pointer">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">Edit Address</h3>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--begin::Card header-->
                    <!--begin::Card body-->
                    <!--begin::Content-->
                    <div>
                        <JetValidationErrors />
                        <!-- {{ address }} -->

                        <!--begin::Form-->
                        <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                            <!--begin::Card body-->
                            <div class="card-body border-top p-9">
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Address Line 1</label>
                                    <!--end::Label-->
                                    <input type="hidden" v-model="form.address_id">
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <!--begin::Row-->
                                        <jet-input id="address_line_1" type="text" v-model="v$.form.address_line_1.$model"
                                            :class="v$.form.address_line_1.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                                " placeholder="Address Line 1" />
                                        <div v-for="(error, index) of v$.form.address_line_1.$errors" :key="index">
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
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Address Line 2</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <jet-input id="address_line_2" type="text" v-model="v$.form.address_line_2.$model"
                                            :class="v$.form.address_line_2.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                                " placeholder="Address Line 2" />
                                        <div v-for="(error, index) of v$.form.address_line_2.$errors" :key="index">
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
                                        <span class="required">City</span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                            title="Phone number must be active"></i>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <jet-input id="city" type="text" v-model="v$.form.city.$model" :class="v$.form.city.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="City" />
                                        <div v-for="(error, index) of v$.form.city.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">State</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <jet-input id="state" type="text" v-model="v$.form.state.$model" :class="v$.form.state.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="State" />
                                        <div v-for="(error, index) of v$.form.state.$errors" :key="index">
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
                                        <span class="required">Country</span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                            title="Country of origination"></i>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <Multiselect :options="countries" label="name" valueProp="id"
                                            class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                            v-model="v$.form.country.$model" track-by="name" :searchable="true" :class="v$.form.country.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                                " />
                                        <div v-for="(error, index) of v$.form.country.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Pincode</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <jet-input id="pincode" type="text" v-model="v$.form.pincode.$model" :class="v$.form.pincode.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Pincode" />
                                        <div v-for="(error, index) of v$.form.pincode.$errors" :key="index">
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
                                <Link :href="`/employee/${id}/address`"
                                    class="btn btn-light btn-active-light-primary me-2">
                                Discard
                                </Link>
                                <!-- <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button> -->
                                <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                                    :data-kt-indicator="processing ? 'on' : 'off'">
                                    <span class="indicator-label">
                                        <span>Address Add</span>
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
