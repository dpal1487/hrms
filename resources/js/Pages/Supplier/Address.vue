<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import { toast } from 'vue3-toastify';
import Multiselect from "@vueform/multiselect";

import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";

export default defineComponent({
    props: ['supplier', 'address', 'countries'],
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
            isEdit: false,
            id: route().params.id,
            processing: false,
            form: this.$inertia.form({
                sup_id: route().params.id,
                id: this.address?.data.id || '',
                address_line_1: this.address?.data?.address_line_1 || '',
                address_line_2: this.address?.data?.address_line_2 || '',
                city: this.address?.data?.city || '',
                state: this.address?.data?.state || '',
                country: this.address?.data?.country?.id || '',
                pincode: this.address?.data?.pincode || '',
            }),
        };

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
                    .post(this.route("supplier.address.update", this.form.sup_id),
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
                    <h3 class="fw-bold m-0">Address</h3>
                </div>
                <!--end::Card title-->

                <button class="btn btn-primary align-self-center" @click="this.isEdit = this.isEdit ? false : true"><i
                        class="bi bi-pencil me-2"></i>Edit Address
                </button>
            </div>
            <!--begin::Card header-->
            <!--begin::Card body-->
            <div class="card-body">
                <div v-if="isEdit">
                    <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <!--begin::Card body-->
                        <div class="card-body">
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-6 fw-bold fs-5 text-gray-800 required">Address Line
                                    1</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6">
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
                                <label class="col-6 fw-bold fs-5 text-gray-800 required">Address Line
                                    2</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6">
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
                                <label class="col-6 fw-bold fs-5 text-gray-800 required">
                                    City
                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6">
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
                                <label class="col-6 fw-bold fs-5 text-gray-800 required">State</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6">
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
                                <label class="col-6 fw-bold fs-5 text-gray-800 required">
                                    Country
                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
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
                                <label class="col-6 fw-bold fs-5 text-gray-800 required">Pincode</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6">
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
                            <div class="col-12">
                                <div class="d-flex justify-content-end mt-4">
                                    <!--begin::Button-->
                                    <button type="button" class="btn btn-outline-secondary me-5"
                                        @click="this.isEdit = false">Discard</button>
                                    <!--begin::Button-->
                                    <button type="submit" class="btn btn-primary"
                                        :class="{ 'text-white-50': form.processing }">
                                        <div v-show="form.processing" class="spinner-border spinner-border-sm">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!--end::Actions-->
                    </form>
                </div>
                <!--begin::Row-->
                <div v-else>
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-6 fw-bold fs-5 text-gray-800">Address Line 1</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-6">
                            <span class="fw-bold fs-6 text-gray-700">{{ this.address?.data?.address_line_1
                            }}</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-6 fw-bold fs-5 text-gray-800">Address Line 2</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-6 fv-row">
                            <span class="fw-bold fs-6 text-gray-700">{{ this.address?.data?.address_line_2
                            }}</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-6 fw-bold fs-5 text-gray-800">City</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-6 d-flex align-items-center">
                            <span class="fw-bold fs-6 text-gray-700">{{ this.address?.data?.city
                            }}</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-6 fw-bold fs-5 text-gray-800">State</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-6 d-flex align-items-center">
                            <span class="fw-bold fs-6 text-gray-700">{{ this.address?.data?.state
                            }}</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-6 fw-bold fs-5 text-gray-800">Country
                        </label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-6 d-flex align-items-center">
                            <span class="fw-bold fs-6 text-gray-700">{{
                                this.address?.data?.country?.name
                            }}</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-6 fw-bold fs-5 text-gray-800">Pincode
                        </label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-6 d-flex align-items-center">
                            <span class="fw-bold fs-6 text-gray-700">{{ this.address?.data?.pincode
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
