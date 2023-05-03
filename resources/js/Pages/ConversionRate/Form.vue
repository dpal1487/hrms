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
import axios from "axios";
import { toast } from "vue3-toastify";

export default defineComponent({
    props: ["questions", 'conversionrate', 'message'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                currency_name: {
                    required,
                },
                currency_value: {
                    required,
                },
                conversion_rate: {
                    required,
                },
                inr_amount: {
                    required,
                },
                actual_value: {
                    required,
                },
                status: {
                    required,
                }
            },
        };
    },
    data() {
        return {

            isEdit: false,
            form: this.$inertia.form({
                id: this.conversionrate?.data?.id || '',
                currency_name: this.conversionrate?.data?.currency_name || '',
                currency_value: this.conversionrate?.data?.currency_value || '',
                conversion_rate: this.conversionrate?.data?.conversion_rate || '',
                inr_amount: this.conversionrate?.data?.inr_amount || '',
                actual_value: this.conversionrate?.data?.actual_value || '',
                status: this.conversionrate?.data?.status || '',
            }),
            status: [
                { id: 1, name: 'Active' },
                { id: 0, name: 'Inactive' },
            ],

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
    },
    methods: {

        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.form
                    .transform((data) => ({
                        ...data,
                    }))
                    .post(route().current() == 'conversion-rate.add' ? this.route("conversion-rate.store") : this.route('conversion-rate.update', this.form.id))
                // .then((response) => {
                //     if (response.data.success) {
                //         toast.success(response.data.message)
                //     }
                //     else {
                //         toast.warning(response.data.message)
                //     }
                // }).finally(() => {

                // });
            }
        },

    },
    created() {
        if (route().current() == 'conversion-rate.edit') {
            this.isEdit = true;
        }
    }
});
</script>
<template>
    <Head :title="isEdit ? 'Edit Conversion Rate' : `Add New Conversion Rate`" />

    <AppLayout>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">


            <div class="col-12">
                <JetValidationErrors />
                <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>General</h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-5 col-md-12 mb-4">
                                <div class="fv-row col-6">
                                    <jet-label for="currency_name" value="Currency Name" />
                                    <jet-input id="currency_name" type="text" v-model="v$.form.currency_name.$model" :class="v$.form.currency_name.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                        " placeholder="Currency Name" />
                                    <div v-for="(error, index) of v$.form.currency_name.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="currency_value" value="Currency Value" />
                                    <jet-input id="currency_value" type="text" v-model="v$.form.currency_value.$model"
                                        :class="v$.form.currency_value.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                            " placeholder="Currency Value" />
                                    <div v-for="(error, index) of v$.form.currency_value.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                            </div>
                            <div class="row g-5 col-md-12 mb-4">
                                <div class="fv-row col-6">
                                    <jet-label for="conversion_rate" value="Conversion Rate" />
                                    <jet-input id="conversion_rate" type="text" v-model="v$.form.conversion_rate.$model"
                                        :class="v$.form.conversion_rate.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                            " placeholder="Conversion Rate" />
                                    <div v-for="(error, index) of v$.form.conversion_rate.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="inr_amount" value="INR Amount" />
                                    <jet-input id="INR Amount" type="text" v-model="v$.form.inr_amount.$model" :class="v$.form.inr_amount.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                        " placeholder="Currency Name" />
                                    <div v-for="(error, index) of v$.form.inr_amount.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                            </div>
                            <div class="row g-5 col-md-12 mb-4">
                                <div class="fv-row col-6">
                                    <jet-label for="actual_value" value="Actual Value" />
                                    <jet-input id="actual_value" type="text" v-model="v$.form.actual_value.$model" :class="v$.form.actual_value.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                        " placeholder="Actual Value" />
                                    <div v-for="(error, index) of v$.form.actual_value.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="status" value="Order By" />
                                    <Multiselect :options="status" label="name" valueProp="id"
                                        class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                        v-model="v$.form.status.$model" track-by="name" :searchable="true" :class="v$.form.status.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                            " />
                                    <div v-for="(error, index) of v$.form.status.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Variations-->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <Link href="/conversion-rate"
                                    class="btn btn-secondary d-flex align-items-center justify-content-center">
                                Cancel
                                </Link>
                                <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                                    :data-kt-indicator="(form.processing) ? 'on' : 'off'">
                                    <span class="indicator-label">
                                        <span v-if="route().current() == 'conversion-rate.edit'">Update</span>
                                        <span v-if="route().current() == 'conversion-rate.add'">Save</span>
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
