<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import useVuelidate from "@vuelidate/core";
import { required, email, url } from "@vuelidate/validators";
export default defineComponent({
    props: ["countries"],
    setup() {
        return { v$: useVuelidate() };
    },
    emits: ["submitted"],
    validations() {
        return {
            states: [],
            form: {
                client_name: {
                    required,
                },
                display_name: {
                    required,
                },
                description: {
                    required,
                },
                address_line_1: {
                    required,
                },
                address_line_2: {
                },
                country: {
                    required,
                },
                state: {
                    required,
                },
                city: {
                    required,
                },
                pincode: {
                    required,
                },
                primary_address: {
                },
                contact_name: {
                    required,
                },
                contact_email: {
                    required,
                },
                contact_mobile: {
                    required,
                },
                contact_country: {
                    required,
                },
                primary_contact: {
                },
            },
        };
    },
    data() {
        return {
            form: this.$inertia.form({
                client_name: "",
                display_name: "",
                description: "",
                address_line_1: "",
                address_line_2: "",
                country: "",
                state: "",
                city: "",
                pincode: "",
                primary_address: 1,
                contact_name: "",
                contact_email: "",
                contact_mobile: "",
                contact_country: "",
                primary_contact: 1,
            }),
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
        JetValidationErrors,
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.form
                    .transform((data) => ({
                        ...data,
                    }))
                    .post(this.route("client.store"));
            }
        },
    },
});
</script>
<template>
    <Head title="Add New Client" />
    <AppLayout>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div class="col-8">
                <JetValidationErrors />
                <form @submit.prevent="submit()" autocomplete="off"
                    class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>General</h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-5">
                                <div class="fv-row col-12">
                                    <jet-label for="client-name" value="Client Name" />
                                    <jet-input id="client-name" type="text" v-model="v$.form.client_name.$model" :class="v$.form.client_name.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Enter client full name" />
                                    <div v-for="(error, index) of v$.form.client_name.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6 mb-3">
                                    <jet-label for="display-name" value="Display Name" />
                                    <jet-input id="display-name" type="text" v-model="v$.form.display_name.$model" :class="v$.form.display_name.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Enter display name" />
                                    <div v-for="(error, index) of v$.form.display_name.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row mb-3">
                                    <jet-label for="description" value="Description" />
                                    <textarea class="form-control form-control-lg form-control-solid" id="description"
                                        type="text" v-model="v$.form.description.$model" :class="v$.form.description.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Enter description" />
                                    <div v-for="(error, index) of v$.form.description.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Address</h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-5">
                                <div class="fv-row">
                                    <jet-label for="address_line_1" value="Address Line 1" />
                                    <jet-input id="address_line_1" type="text" v-model="v$.form.address_line_1.$model"
                                        :class="v$.form.address_line_1.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Enter address line 1" />
                                    <div v-for="(error, index) of v$.form.address_line_1.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row">
                                    <jet-label for="address_line_2" value="Address Line 2" />
                                    <jet-input id="address_line_2" type="text" v-model="v$.form.address_line_2.$model"
                                        placeholder="Enter address line 2" />
                                </div>
                                <div class="col-md-6 fv-row">
                                    <div class="fv-row fv-plugins-icon-container">
                                        <jet-label for="country" value="Country" />
                                        <Multiselect :options="countries.data" label="label" valueProp="id"
                                            class="form-control form-control-solid" placeholder="Select country"
                                            :searchable="true" v-model="v$.form.country.$model" :class="v$.form.country.$errors.length >
                                                0
                                                ? 'is-invalid'
                                                : ''
                                                " />
                                        <div v-for="(error, index) of v$.form
                                            .country.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 fv-row">
                                    <jet-label for="state" value="State" />
                                    <jet-input id="state" type="text" v-model="v$.form.state.$model" :class="v$.form.state.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Enter state name" />
                                    <div v-for="(error, index) of v$.form.state.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="col-md-6 fv-row">
                                    <jet-label for="city" value="City" />
                                    <jet-input id="city" type="text" v-model="v$.form.city.$model" :class="v$.form.city.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Enter city name" />
                                    <div v-for="(error, index) of v$.form.city.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="col-md-6 fv-row">
                                    <jet-label for="post-code" value="Pincode / Postal Code" />
                                    <jet-input id="post-code" type="text" v-model="v$.form.pincode.$model" :class="v$.form.pincode.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Enter pincode / postal code" />
                                    <div v-for="(error, index) of v$.form.pincode.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row mt-5">
                                <div class="d-flex flex-stack">
                                    <div class="me-5">
                                        <label class="fs-5 fw-semibold">Use as a billing address?</label>
                                    </div>
                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" v-model="v$.form.primary_address.$model"
                                            type="checkbox" />
                                        <span class="form-check-label fw-semibold text-muted">
                                            Yes
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Contact Details</h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-5">
                                <div class="fv-row col-md-6">
                                    <jet-label for="contact_name" value="Name" />
                                    <jet-input id="contact_name" type="text" v-model="v$.form.contact_name.$model" :class="v$.form.contact_name.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Enter contact person name" />
                                    <div v-for="(error, index) of v$.form.contact_name.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="col-md-6 fv-row">
                                    <jet-label for="contact_email" value="Email" />
                                    <jet-input id="contact_email" type="text" v-model="v$.form.contact_email.$model" :class="v$.form.contact_email.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Enter email address" />
                                    <div v-for="(error, index) of v$.form.contact_email.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="col-md-6 fv-row">
                                    <jet-label for="contact_mobile" value="Mobile" />
                                    <jet-input id="contact_mobile" type="text" v-model="v$.form.contact_mobile.$model"
                                        :class="v$.form.contact_mobile.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Enter mobile number" />
                                    <div v-for="(error, index) of v$.form.contact_mobile.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="col-md-6 fv-row">
                                    <jet-label for="contact_country" value="Country" />
                                    <Multiselect :options="countries" label="label" valueProp="id"
                                        class="form-control form-control-solid" placeholder="Select country"
                                        :searchable="true" v-model="v$.form.contact_country.$model" :class="v$.form.contact_country.$errors.length >
                                            0
                                            ? 'is-invalid'
                                            : ''
                                            " />
                                    <div v-for="(error, index) of v$.form
                                        .contact_country.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row mt-5">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-stack">
                                    <!--begin::Label-->
                                    <div class="me-5">
                                        <!--begin::Label-->
                                        <label class="fs-5 fw-semibold">Use as a primary contact?</label>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Label-->
                                    <!--begin::Switch-->
                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                        <!--begin::Input-->
                                        <input class="form-check-input" v-model="v$.form.primary_contact.$model"
                                            :checked="v$.form.primary_contact.$model == 1 ? 'checked' : ''"
                                            type="checkbox" />
                                        <!--end::Input-->
                                        <!--begin::Label-->
                                        <span class="form-check-label fw-semibold text-muted">
                                            Yes
                                        </span>
                                        <!--end::Label-->
                                    </label>
                                    <!--end::Switch-->
                                </div>
                                <!--begin::Wrapper-->
                            </div>
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Variations-->
                    <div class="row">
                        <div class="col-12 gap-5">
                            <div class="d-flex justify-content-end">
                                <Link href="/clients" class="btn btn-outline-secondary">
                                Discard
                                </Link>
                                <button type="submit" class="btn btn-primary">
                                    <span class="indicator-label">
                                        Save
                                    </span>
                                    <span class="indicator-progress">
                                        Please wait... <span
                                            class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                                <!--end::Button-->
                            </div>
                        </div>
                    </div>
                    <!--end::Actions-->
                </form>
            </div>
        </div>
    </AppLayout>
</template>
