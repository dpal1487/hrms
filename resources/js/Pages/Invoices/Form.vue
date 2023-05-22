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
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import ItemFormList from "./Components/ItemFormList.vue";
import { toast } from 'vue3-toastify';
import axios from 'axios';

export default defineComponent({
    props: ['invoice', 'companies', 'clients', 'address', 'conversionrates'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                company:
                {
                    required,
                },
                client: {
                    required,
                },
                invoice_number: {
                    required,
                },
                invoice_date: {
                    required,
                },
                invoice_due_date: {
                    required
                },
                notes: {
                    required,
                },
                status: {
                    required,
                },
                currency:
                {
                    required,
                },
                paymentTerm: {
                    required,
                }
            },
        };
    },
    data() {
        return {
            message: '',
            i: null,
            isEdit: false,
            clientAddress: {},
            companyAddress: [],
            ConversionRate: '',
            items: 1,
            rowCount: 1,
            total: 0,

            form: {
                id: this.invoice?.data?.id || '',
                client: this.invoice?.data?.client?.c_id || '',
                company: this.invoice?.data?.company?.id || '',
                invoice_number: this.invoice?.data?.invoice_number || '20202023',
                invoice_date: this.invoice?.data.invoice_date || '',
                invoice_due_date: this.invoice?.data?.invoice_due_date || '',
                conversion_rate: this.invoice?.data?.conversion_rate || '',
                total_amount_usd: '',
                total_amount: 0,
                notes: this.invoice?.data?.notes || '',
                status: this.invoice?.data?.status || '',
                taxcharge: 18,
                currency: this.invoice?.data?.currency?.id || '',
                paymentTerm: 0,
                items: [{
                    name: '',
                    description: '',
                    cpi: '',
                    quantity: '',
                }],
            },
            status: [
                { name: 'New', id: '0' },
                { name: 'Paid', id: '1' },
                { name: 'Cancelled', id: '2' },
            ]
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
        VueDatePicker,
        ItemFormList,
    },
    inputFormat: {
        type: String,
        required: false,
        default: 'yyyy-MM-dd',
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                // this.form
                //     .transform((data) => ({
                //         ...data,
                //     }))
                axios.post(route().current() == 'invoices.add' ? this.route("invoices.store") : this.route('invoices.update', this.form.id), this.form);
            }
        },
        addItemForm(rowCount) {
            for (var i = 0; i < rowCount; i++) {
                this.form.items.push({
                    name: '',
                    cpi: '',
                    quantity: '',
                    price: ''
                });
            }
        },
        removeItemForm(index) {
            if (this.form.items.length > 0) {
                this.form.items.splice(index, 1)
            }
        },
        async getClientDetails(c_id) {
            await axios
                .get(c_id + '/client-address/')
                .then((response) => {
                    if (response.data.success = true) {
                        this.clientAddress = response?.data?.data?.client_address || {}
                        return;
                    }
                })
        },
        async getCompanyDetails(id) {
            await axios
                // .get(`${id}/company-address/`)
                .get(`${id}/company-address/`)
                .then((response) => {
                    if (response.data.success = true) {
                        this.companyAddress = response?.data?.data?.company_addresss || {}
                        return;
                    }
                })
        },
        async getConversionRate(id) {
            await axios
                .get(id + '/conversion-value/')
                .then((response) => {
                    if (response.data.success = true) {
                        this.ConversionRate = response?.data?.data || {}
                        return;
                    }
                })
        }


    },
    created() {
        if (route().current() == 'invoices.edit') {
            this.isEdit = true;
        }

    },
    watch: {
        form: {
            deep: true,
            // We have to move our method to a handler field
            handler() {
                let total = 0;
                for (var i = 0; i < this.form.items.length; i++) {
                    total += parseInt(this.form.items[i].cpi) * parseInt(this.form.items[i].quantity);
                }
                this.form.total = total;
                if (this.invoice?.data?.currency?.inr_amount) {
                    this.form.total_amount = total * this.invoice?.data?.currency?.inr_amount;

                }
                this.form.total_amount = total * this.ConversionRate?.inr_amount;
                this.form.gstAmount = parseFloat(this.form.total_amount / 100 * this.form.taxcharge).toFixed(2);
                this.form.afterGST = (Number(this.form.total_amount) + Number(this.form.gstAmount)).toFixed(2);
                // this.form.beforGST = (parseFloat(total - this.form.gstAmount)).toFixed(2);
            }
        }
    }
});

</script>

<template>
    <Head :title="isEdit ? 'Edit Invoice' : `Add New Invoice`" />
    <AppLayout title="Invoice">

        <div class="app-content flex-column-fluid">
            <!-- {{ invoice }} -->
            <!--begin::Content container-->
            <div class="app-container container-xxl">
                
                <form @submit.prevent="submit()" class="d-flex flex-column flex-lg-row">
                    <!--begin::Content-->
                    <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
                        <!--begin::Card-->
                        <div class="card">
                            <!--begin::Card body-->
                            <div class="card-body p-12">
                                <!--begin::Form-->
                                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-column align-items-start flex-xxl-row gap-2">
                                        <!--begin::Input group-->
                                        <div class="d-flex align-items-center flex-equal fw-row me-4 order-2 gap-4"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" title="Specify invoice date">
                                            <!--begin::Date-->
                                            <div class="fs-6 fw-bold text-gray-700 text-nowrap">Issue Date:</div>
                                            <!--end::Date-->
                                            <!--begin::Input-->
                                            <div class="position-relative d-flex align-items-center w-150px ">
                                                <!--begin::Datepicker-->
                                                <VueDatePicker v-model="v$.form.invoice_date.$model"
                                                    :enable-time-picker="false" auto-apply
                                                    input-class-name="form-control form-control-solid fw-bold pe-5" :class="v$.form.invoice_date.$errors.length > 0
                                                        ? 'is-invalid'
                                                        : ''
                                                        " placeholder="Select date">
                                                </VueDatePicker>
                                                <!--end::Datepicker-->
                                                <!--begin::Icon-->

                                                <!--end::Icon-->
                                            </div>
                                            <div v-for="(error, index) of v$.form.invoice_date.$errors" :key="index">
                                                <input-error :message="error.$message" />
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" title="Enter invoice number">
                                            <span class="fs-2x fw-bold text-gray-800">Invoice #</span>
                                            <input type="text"
                                                class="form-control form-control-flush fw-bold text-muted fs-3 w-125px"
                                                v-model="v$.form.invoice_number.$model" :class="v$.form.invoice_number.$errors.length > 0
                                                    ? 'is-invalid'
                                                    : ''
                                                    " placeholder="..." />
                                            <div v-for="(error, index) of v$.form.invoice_number.$errors" :key="index">
                                                <input-error :message="error.$message" />
                                            </div>
                                        </div>
                                        <!--end::Input group-->


                                        <!--begin::Input group-->
                                        <div class="d-flex align-items-center flex-equal fw-row me-4 order-2 gap-4"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" title="Specify invoice date">
                                            <!--begin::Date-->
                                            <div class="fs-6 fw-bold text-gray-700 text-nowrap">Due Date:</div>
                                            <!--end::Date-->
                                            <!--begin::Input-->
                                            <div class="position-relative d-flex align-items-center w-150px ">
                                                <!--begin::Datepicker-->
                                                <VueDatePicker v-model="v$.form.invoice_due_date.$model"
                                                    :enable-time-picker="false" auto-apply
                                                    input-class-name="form-control form-control-solid fw-bold pe-5" :class="v$.form.invoice_due_date.$errors.length > 0
                                                        ? 'is-invalid'
                                                        : ''
                                                        " placeholder="Select date">
                                                </VueDatePicker>
                                                <!--end::Datepicker-->
                                                <!--begin::Icon-->

                                                <!--end::Icon-->
                                            </div>
                                            <div v-for="(error, index) of v$.form.invoice_due_date.$errors" :key="index">
                                                <input-error :message="error.$message" />
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Top-->
                                    <!--begin::Separator-->
                                    <div class="separator separator-dashed my-10"></div>
                                    <!--end::Separator-->
                                    <!--begin::Wrapper-->
                                    <div class="mb-0">
                                        <!-- {{ companies }} -->
                                        <!--begin::Row-->
                                        <div class="d-flex flex-wrap gap-6 justify-content-between">
                                            <!--begin::Col-->
                                            <div class="w-100">
                                                <div class="form-label fs-5 fw-bold text-gray-700">Billiing Address</div>
                                                <div class="mb-1">
                                                    <!--begin::Select-->
                                                    <Multiselect :options="companies" label="company_name" valueProp="id"
                                                        class="form-control form-control-lg form-control-solid"
                                                        :searchable="true" v-model="v$.form.company.$model" :class="v$.form.company.$errors.length > 0
                                                            ? 'is-invalid'
                                                            : ''
                                                            " track-by="company_name" placeholder="Select Company"
                                                        @change="getCompanyDetails" />
                                                    <!--end::Select-->
                                                </div>
                                                <div v-for="(error, index) of v$.form.company.$errors" :key="index">
                                                    <input-error :message="error.$message" />
                                                </div>
                                                <!--end::Input group-->
                                                <div v-if="(invoice?.data?.company_address)"
                                                    class="d-flex mt-6 flex-column gap-2 text-gray-600 fs-5">
                                                    <span> {{ invoice?.data?.company_address?.address_line_1 }} </span>
                                                    <span> {{ invoice?.data?.company_address?.address_line_2 }} </span>
                                                    <span> {{ invoice?.data?.company_address?.city }} </span>
                                                    <span> {{ invoice?.data?.company_address?.state }} </span>
                                                    <span> {{ invoice?.data?.company_address?.pincode }} </span>
                                                    <span> {{ invoice?.data?.company_address?.country?.name }} </span>
                                                </div>

                                                <div class="d-flex mt-6 flex-column gap-2 text-gray-600 fs-5">
                                                    <span> {{ this.companyAddress[0]?.['address_line_1'] }} </span>
                                                    <span> {{ this.companyAddress[0]?.['address_line_2'] }}</span>
                                                    <span> {{ this.companyAddress[0]?.['city'] }}</span>
                                                    <span> {{ this.companyAddress[0]?.['state'] }}</span>
                                                    <span> {{ this.companyAddress[0]?.['country']['name'] }}</span>
                                                    <!-- <span>GSTIN : 07CAYPR9267G1ZN</span>
                                                    <span>+91-7503876258</span> -->
                                                </div>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="w-100">
                                                <div class="form-label fs-5 fw-bold text-gray-700">Bill To</div>
                                                <div class="mb-1">
                                                    <!--begin::Select-->
                                                    <Multiselect :options="clients" label="name" valueProp="c_id"
                                                        class="form-control form-control-lg form-control-solid"
                                                        :searchable="true" v-model="v$.form.client.$model" :class="v$.form.client.$errors.length > 0
                                                            ? 'is-invalid'
                                                            : ''
                                                            " track-by="name" placeholder="Select Client"
                                                        @change="getClientDetails" />
                                                    <!--end::Select-->
                                                </div>
                                                <div v-for="(error, index) of v$.form.client.$errors" :key="index">
                                                    <input-error :message="error.$message" />
                                                </div>
                                                <!--end::Input group-->
                                                <div v-if="(invoice?.data?.client_address)"
                                                    class="d-flex mt-6 flex-column gap-2 text-gray-600 fs-5">
                                                    <span> {{ invoice?.data?.client_address?.address_line_1 }} </span>
                                                    <span> {{ invoice?.data?.client_address?.address_line_2 }} </span>
                                                    <span> {{ invoice?.data?.client_address?.city }} </span>
                                                    <span> {{ invoice?.data?.client_address?.state }} </span>
                                                    <span> {{ invoice?.data?.client_address?.pincode }} </span>
                                                    <span> {{ invoice?.data?.client_address?.country?.name }} </span>
                                                </div>
                                                <div class="d-flex mt-6 flex-column gap-2 text-gray-600 fs-5">
                                                    <span> {{ this.clientAddress?.address_line_1 }} </span>
                                                    <span> {{ this.clientAddress?.address_line_2 }}</span>
                                                    <span> {{ this.clientAddress?.city }}</span>
                                                    <span> {{ this.clientAddress?.state }}</span>
                                                    <span> {{ this.clientAddress?.country?.name }}</span>
                                                </div>
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->
                                        <!--begin::Table wrapper-->
                                        <div class="table-responsive mb-10">
                                            <!--begin::Table-->
                                            <table class="table g-5 gs-0 mb-0 fw-bold text-gray-700"
                                                data-kt-element="items">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <tr
                                                        class="border-bottom fs-7 fw-bold text-gray-700 text-uppercase text-center">
                                                        <th>Item</th>
                                                        <th>Description</th>
                                                        <th>CPI</th>
                                                        <th>Quantity</th>
                                                        <th>Total</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody>
                                                    <ItemFormList :invoice="invoice" :form="form"
                                                        @removeSingle="removeItemForm" />
                                                </tbody>
                                                <!--end::Table body-->
                                                <!--begin::Table foot-->
                                                <tfoot>
                                                    <tr
                                                        class="border-top border-top-dashed align-top fs-6 fw-bold text-gray-700">
                                                        <input type="number" class="form-control mt-4" v-model="rowCount"
                                                            min="1">
                                                        <th class="text-primary">
                                                            <button type="button" class="btn btn-primary btn-sm"
                                                                @click="addItemForm(this.rowCount)">Add
                                                                more</button>
                                                        </th>
                                                        <th colspan="4" class="border-bottom border-bottom-dashed ps-0">
                                                            <div class="d-flex align-items-start justify-content-between">
                                                                <div class="fs-5 h-40px">Net payable amount <span
                                                                        class="fs-6" v-if="(this.form.total)">${{
                                                                            this.form.total }} </span> <span v-else>$00</span> X
                                                                    <span class="fs-6"
                                                                        v-if="(this.ConversionRate?.inr_amount)">{{
                                                                            this.ConversionRate?.inr_amount }} INR</span>
                                                                    <span class="fs-6"
                                                                        v-if="(this.invoice?.data?.currency?.inr_amount)">{{
                                                                            this.invoice?.data?.currency?.inr_amount }}
                                                                        INR</span> <span v-else>00 INR</span>
                                                                </div>
                                                                <div class="fs-6 text-gray-800">INR {{
                                                                    this.form.total_amount }}</div>
                                                            </div>
                                                            <div
                                                                class="d-flex align-items-start justify-content-between mb-2">
                                                                <div class="text-grey py-1 fs-6">Invoice value before GST :
                                                                </div>
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <div class="fs-6 text-gray-800">INR {{
                                                                        this.form.total_amount }}</div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="d-flex align-items-start justify-content-between mb-1">
                                                                <div class="text-grey py-1 fs-6">GST value at {{
                                                                    this.form.taxcharge }}%</div>
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <div>
                                                                        <input type="text" v-model="form.taxcharge"
                                                                            class="w-50px form-control form-control-solid fs-6 text-gray-700 h-35px form-control-transparent" />
                                                                    </div>
                                                                    <div class="fs-6 text-gray-800">%</div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-start justify-content-between">
                                                                <div class="text-grey py-1 fs-6"> Invoice value with GST :
                                                                </div>
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <div class="fs-6 text-gray-800">INR {{
                                                                        this.form.afterGST }}</div>
                                                                </div>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </tfoot>
                                                <!--end::Table foot-->
                                            </table>
                                        </div>
                                        <!--end::Table-->
                                        <!--begin::Notes-->
                                        <div class="mb-0">
                                            <label class="form-label fs-6 fw-bold text-gray-700">Notes</label>
                                            <textarea name="notes" class="form-control form-control-solid" rows="3"
                                                placeholder="Thanks for your business" v-model="v$.form.notes.$model"
                                                :class="v$.form.notes.$errors.length > 0
                                                    ? 'is-invalid'
                                                    : ''
                                                    "></textarea>
                                        </div>
                                        <div v-for="(error, index) of v$.form.notes.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                        <!--end::Notes-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>

                                <!--end::Form-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Content-->
                    <!--begin::Sidebar-->
                    <div class="flex-lg-auto min-w-lg-300px position-relative">
                        <!--begin::Card-->
                        <div class="card position-sticky top-0">
                            <!--begin::Card body-->
                            <div class="card-body p-10">
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bold fs-6 text-gray-700">Currency</label>
                                    <!--end::Label-->
                                    <!--begin::Select-->
                                    <Multiselect :options="conversionrates" label="currency_name" valueProp="id"
                                        class="form-control form-control-lg form-control-solid mb-2" :searchable="true"
                                        v-model="v$.form.currency.$model" :class="v$.form.currency.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Select Currency" track-by="currency_name"
                                        @change="getConversionRate" />

                                    <div v-for="(error, index) of v$.form.currency.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                    <!-- {{ this.ConversionRate?.inr_amount }} -->
                                    <!--end::Select-->
                                    <jet-input v-if="(this.invoice?.data?.currency?.inr_amount)" type="text"
                                        :value="this.invoice?.data?.currency?.inr_amount" placeholder="Conversion Rate"
                                        readonly />
                                    <jet-input v-else type="text" :value="this.ConversionRate?.inr_amount"
                                        placeholder="Conversion Rate" readonly />

                                </div>
                                <!--end::Input group-->
                                <div class="mb-4">
                                    <label class="form-label fw-bold fs-6 text-gray-700">Status</label>
                                    <Multiselect :options="status" label="name" valueProp="id"
                                        class="form-control form-control-lg form-control-solid" :class="v$.form.status.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Select One" v-model="v$.form.status.$model"
                                        track-by="name" />
                                    <div v-for="(error, index) of v$.form.status.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <!--begin::Separator-->
                                <div class="separator separator-dashed mb-8"></div>
                                <!--end::Separator-->
                                <!--begin::Actions-->
                                <div class="mb-0">
                                    <!--begin::Row-->
                                    <div class="row mb-5">

                                        <!--begin::Col-->
                                        <div class="col">
                                            <a href="#" class="btn btn-light btn-active-light-primary w-100">Download</a>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                    <button type="submit" href="#" class="btn btn-primary w-100"
                                        id="kt_invoice_submit_button">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen016.svg-->
                                        <span class="svg-icon svg-icon-3">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M15.43 8.56949L10.744 15.1395C10.6422 15.282 10.5804 15.4492 10.5651 15.6236C10.5498 15.7981 10.5815 15.9734 10.657 16.1315L13.194 21.4425C13.2737 21.6097 13.3991 21.751 13.5557 21.8499C13.7123 21.9488 13.8938 22.0014 14.079 22.0015H14.117C14.3087 21.9941 14.4941 21.9307 14.6502 21.8191C14.8062 21.7075 14.9261 21.5526 14.995 21.3735L21.933 3.33649C22.0011 3.15918 22.0164 2.96594 21.977 2.78013C21.9376 2.59432 21.8452 2.4239 21.711 2.28949L15.43 8.56949Z"
                                                    fill="currentColor" />
                                                <path opacity="0.3"
                                                    d="M20.664 2.06648L2.62602 9.00148C2.44768 9.07085 2.29348 9.19082 2.1824 9.34663C2.07131 9.50244 2.00818 9.68731 2.00074 9.87853C1.99331 10.0697 2.04189 10.259 2.14054 10.4229C2.23919 10.5869 2.38359 10.7185 2.55601 10.8015L7.86601 13.3365C8.02383 13.4126 8.19925 13.4448 8.37382 13.4297C8.54839 13.4145 8.71565 13.3526 8.85801 13.2505L15.43 8.56548L21.711 2.28448C21.5762 2.15096 21.4055 2.05932 21.2198 2.02064C21.034 1.98196 20.8409 1.99788 20.664 2.06648Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->Send Invoice</button>
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Sidebar-->
                </form>
                <!--end::Layout-->
            </div>
            <!--end::Content container-->
        </div>
    </AppLayout>
</template>
