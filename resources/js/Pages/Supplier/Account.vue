<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
;
import Multiselect from "@vueform/multiselect";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import { required } from "@vuelidate/validators";
import { toast } from 'vue3-toastify';
import useVuelidate from "@vuelidate/core";
export default defineComponent({
    props: ['supplier', 'account', 'address'],
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
            isEdit: false,
            processing: false,
            form: this.$inertia.form({
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
            }),
        }
    },

    components: {
        AppLayout,
        Header,
        Link,
        Head,
        Multiselect,
        JetInput,
        JetLabel,
        InputError,
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.processing = true
                this.form.transform((data) => ({
                    ...data,
                }))
                    .post(this.route("supplier.account.update", this.form.sup_id),
                        {
                            onSuccess: (data) => {
                                toast.success(this.$page.props.jetstream.flash.message);
                                this.isEdit = false;
                                this.processing = false

                            },
                            onError: (data) => {
                                if (data.message) {
                                    toast.error(data.message);
                                    this.isEdit = false;
                                    this.processing = false

                                }
                            },
                        });
            }
        },
    },
    created() {

    }
});
</script>
<template>
    <Head title="Employee Address" />
    <AppLayout>
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/supplier" class="text-muted text-hover-primary">Supplier</Link>
            </li>
        </template>

      

                <Header :supplier="supplier?.data" :address="address?.data" />
                <!--begin::details View-->
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header cursor-pointer">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">Account</h3>
                        </div>
                        <!--end::Card title-->

                        <button class="btn btn-primary align-self-center"
                            @click="this.isEdit = this.isEdit ? false : true"><i class="bi bi-pencil me-2"></i> Edit
                            Account
                        </button>
                    </div>
                    <!--begin::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body p-9">
                        <div v-if="isEdit">
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
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Bank
                                            Address</label>
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
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Account
                                            Number</label>
                                        <!--end::Label-->
                                        <div class="col-lg-8">
                                            <jet-input id="account_number" type="text"
                                                v-model="v$.form.account_number.$model" :class="v$.form.account_number.$errors.length > 0
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
                                            <jet-input id="routing_number" type="text"
                                                v-model="v$.form.routing_number.$model" :class="v$.form.routing_number.$errors.length > 0
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
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">SWIFT Code</label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8">
                                            <jet-input id="swift_code" type="text" v-model="v$.form.swift_code.$model"
                                                :class="v$.form.swift_code.$errors.length > 0
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
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">IFSC Code</label>
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
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Short Code</label>
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
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Pan Card</label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8">
                                            <jet-input id="pan_number" type="text" v-model="v$.form.pan_number.$model"
                                                :class="v$.form.pan_number.$errors.length > 0
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
                                    <button type="button" class="btn btn-outline-secondary me-5"
                                        @click="this.isEdit = false">Discard</button>
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
                        </div>
                        <!--begin::Row-->
                        <div v-else>
                            <div class="row mb-7">
                                <!--begin::Label-->

                                <label class="col-lg-6 fw-bold fs-5 text-gray-800">Bank Name</label>
                                <!--end::Label-->
                                <!--begin::Col-->

                                <div class="col-lg-6">
                                    <span class="fw-bold fs-6 text-gray-700">{{ this.account?.data?.bank_name
                                    }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-6 fw-bold fs-5 text-gray-800">Bank Address</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <span class="fw-bold fs-6 text-gray-700">{{ this.account?.data?.bank_address
                                    }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-6 fw-bold fs-5 text-gray-800">Benificiary Name</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6 d-flex align-items-center">
                                    <span class="fw-bold fs-6 text-gray-700">{{ this.account?.data?.beneficiary_name
                                    }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-6 fw-bold fs-5 text-gray-800">Account Number</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6 d-flex align-items-center">
                                    <span class="fw-bold fs-6 text-gray-700">{{ this.account?.data?.account_number
                                    }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-6 fw-bold fs-5 text-gray-800">Routing Number
                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6 d-flex align-items-center">
                                    <span class="fw-bold fs-6 text-gray-700">{{
                                        this.account?.data?.routing_number
                                    }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-6 fw-bold fs-5 text-gray-800">SWIFT Code
                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6 d-flex align-items-center">
                                    <span class="fw-bold fs-6 text-gray-700">{{
                                        this.account?.data?.swift_code
                                    }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-6 fw-bold fs-5 text-gray-800">IFSC Code
                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6 d-flex align-items-center">
                                    <span class="fw-bold fs-6 text-gray-700">{{
                                        this.account?.data?.ifsc_code
                                    }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-6 fw-bold fs-5 text-gray-800">Sort Code
                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6 d-flex align-items-center">
                                    <span class="fw-bold fs-6 text-gray-700">{{
                                        this.account?.data?.sort_code
                                    }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-6 fw-bold fs-5 text-gray-800">Pan Number
                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6 d-flex align-items-center">
                                    <span class="fw-bold fs-6 text-gray-700">{{ this.account?.data?.pan_number
                                    }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::details View-->
          
    </AppLayout>
</template>
