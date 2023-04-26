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
import { required, url, numeric, integer } from "@vuelidate/validators";
import ImageInput from '@/components/ImageInput.vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import Dropdown from "../../Jetstream/Dropdown.vue";
import { toast } from 'vue3-toastify';


export default defineComponent({
    props: ['invoice', 'companies', 'clients'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                // client: {
                //     required,
                // },
                company: {
                    required,
                },
                gst_status: {
                    required,
                },
                invoice_number: {
                    required,
                },
                conversion_rate: {
                    required,
                },
                invoice_date: {
                    required,
                },
                invoice_due_date: {
                    required,
                },
                total_amount_usd: {
                    required,
                },
                total_amount_inr: {
                    required, integer

                },
                notes: {
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

            message: '',
            isEdit: false,
            form: this.$inertia.form({
                id: this.invoice?.data?.id || '',
                client: this.invoice?.data?.client?.name || '',
                company: this.invoice?.data?.company?.id || {},
                gst_status: this.invoice?.data?.gst_status || '',
                invoice_number: this.invoice?.data?.invoice_number || '',
                invoice_date: this.invoice?.data?.invoice_date || '',
                conversion_rate: this.invoice?.data?.conversion_rate || '',
                invoice_due_date: this.invoice?.data?.invoice_due_date || '',
                total_amount_usd: this.invoice?.data?.total_amount_usd || '',
                total_amount_inr: this.invoice?.data?.total_amount_inr || '',
                notes: this.invoice?.data?.notes || '',
                status: this.invoice?.data?.status || '',
            }),
            url: null,
            value: null,
            status: [
                { name: 'New', id: '0' },
                { name: 'Paid', id: '1' },
                { name: 'Cancelled', id: '2' },

            ],
            gst_status: [
                { name: 'New', id: '0' },
                { name: 'Paid', id: '1' },
                { name: 'Cancelled', id: '2' },
            ],
            currency: [
                { name: 'USD - USA dollar', value: 'USD' },
                { name: 'GBP - British pound', value: 'GBP' },
                { name: 'AUD - Australian dollar', value: 'AUD' },
                { name: 'JPY - Japanese yen', value: 'JPY' },
                { name: 'SEK - Swedish krona', value: 'SEK' },
                { name: 'CAD - Canadian dollar', value: 'CAD' },
                { name: 'CHF - Swiss franc', value: 'CHF' },
            ]
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
        VueDatePicker,
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.form
                    .transform((data) => ({
                        ...data,
                    }))
                    .post(route().current() == 'invoices.add' ? this.route("invoices.store") : this.route('invoices.update', this.form.id));
            }
        },
    },
    created() {
        if (route().current() == 'invoices.edit') {
            this.isEdit = true;
        }
    }
});
</script>
<template>
    <Head :title="isEdit ? 'Edit Invoice' : `Add New Invoice`" />
    <AppLayout>
        <!-- {{ invoice }}
        {{ this.invoice?.data?.status }} -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div class="col-12">
                <JetValidationErrors />
                <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Invoice Generate</h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-5 col-md-12">
                                <div class="fv-row col-6">
                                    <jet-label value="Company" />
                                    <Multiselect :options="companies" label="company_name" valueProp="id"
                                        class="form-control form-control-lg form-control-solid" :searchable="true"
                                        v-model="form.company" track-by="company_name" :class="v$.form.company.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                            " placeholder="Select One" />
                                    <div v-for="(error, index) of v$.form.company.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>

                                <!-- <div class="fv-row col-6">
                                    <jet-label for="client" value="Client" />
                                    <Multiselect :options="clients" label="name" valueProp="id"
                                        class="form-control form-control-lg form-control-solid" v-model="form.client"
                                        track-by="name" :class="v$.form.client.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                            " placeholder="Select One" />
                                    <div v-for="(error, index) of v$.form.client.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div> -->
                                <div class="fv-row col-6">
                                    <jet-label value="GST Status" />
                                    <Multiselect :options="gst_status" label="name" valueProp="id"
                                        class="form-control form-control-lg form-control-solid" :searchable="true"
                                        v-model="form.gst_status" :class="v$.form.gst_status.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                            " placeholder="Select One" track-by="name" />
                                    <div v-for="(error, index) of v$.form.gst_status.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label value="Status" />
                                    <Multiselect :options="status" label="name" valueProp="id"
                                        class="form-control form-control-lg form-control-solid" :class="v$.form.status.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                            " placeholder="Select One" v-model="form.status" track-by="name" />
                                    <div v-for="(error, index) of v$.form.status.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>

                                <div class="fv-row col-6">
                                    <jet-label for="invoice_number" value="Invoice Number" />
                                    <jet-input id="invoice_number" type="text" v-model="v$.form.invoice_number.$model"
                                        :class="v$.form.invoice_number.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                            " placeholder="Enter Invoice Number" />
                                    <div v-for="(error, index) of v$.form.invoice_number.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>

                                <div class="fv-row col-6">
                                    <jet-label for="invoice_due_date" value="Invoice Due Date" />
                                    <VueDatePicker v-model="v$.form.invoice_due_date.$model" :enable-time-picker="false"
                                        auto-apply
                                        input-class-name="form-control form-control-lg form-control-solid fw-normal" :class="v$.form.invoice_due_date.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                            " placeholder="Invoice Due Date"></VueDatePicker>
                                    <div v-for="(error, index) of v$.form.invoice_due_date.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="invoice_date" value="Invoice Date" />
                                    <VueDatePicker v-model="v$.form.invoice_date.$model" :enable-time-picker="false"
                                        auto-apply
                                        input-class-name="form-control form-control-lg form-control-solid fw-normal" :class="v$.form.invoice_date.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                            " placeholder="Invoice Date"></VueDatePicker>
                                    <div v-for="(error, index) of v$.form.invoice_date.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>

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
                                    <jet-label for="total_amount_inr" value="Total Amount Inr" />
                                    <jet-input id="total_amount_inr" type="text" v-model="v$.form.total_amount_inr.$model"
                                        :class="v$.form.total_amount_inr.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                            " placeholder="Total Amount Inr" />
                                    <div v-for="(error, index) of v$.form.total_amount_inr.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>

                                <div class="fv-row col-6">
                                    <jet-label for="total_amount_usd" value="Total Amount USD" />
                                    <jet-input id="total_amount_usd" type="text" v-model="v$.form.total_amount_usd.$model"
                                        :class="v$.form.total_amount_usd.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                            " placeholder="Total Amount USD" />
                                    <div v-for="(error, index) of v$.form.total_amount_usd.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="notes" value="Notes" />
                                    <jet-input id="notes" type="text" v-model="v$.form.notes.$model" :class="v$.form.notes.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                        " placeholder="Notes" />
                                    <div v-for="(error, index) of v$.form.notes.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="status" value="Status" />
                                    <Multiselect id="status" :options="status" label="name" valueProp="id"
                                        class="form-control form-control-lg form-control-solid" :class="v$.form.status.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                            " placeholder="Select One" v-model="form.status" track-by="name" />
                                    <div v-for="(error, index) of v$.form.status.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Variations-->
                    <div class="row text-align-center">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <Link href="/invoices" class="btn btn-secondary align-items-center justify-content-center">
                                Cancel
                                </Link>
                                <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                                    :data-kt-indicator="form.processing ? 'on' : 'off'">
                                    <span class="indicator-label">
                                        <span v-if="route().current() == 'invoices.edit'">Update</span>
                                        <span v-if="route().current() == 'invoices.add'">Save</span>
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
