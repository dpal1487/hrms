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
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import ItemFormList from "../../Components/invoices/ItemFormList.vue";
import { toast } from 'vue3-toastify';
import AppendItem from "../../Components/invoices/AppendItem.vue";
import axios from 'axios';

export default defineComponent({
    props: ['invoice', 'companies', 'clients'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {

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
                },
                currnecy:
                {
                    required,
                }
            },
        };
    },
    data() {

        return {
            items: [{ id: 0 }],
            message: '',
            isEdit: false,
            clientAddress: {},
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
                currnecy: '',
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
            currnecy: [
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
        ItemFormList,
        AppendItem
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
        appendItemForm(rowCount) {
            let prevId = this.items[this.items.length - 1].id;
            let newItems = [];

            if (rowCount > 0) {
                for (let i = 1; i <= rowCount; i++) {
                    newItems.push({ id: prevId + i })
                }
            }
            this.items = [...this.items, ...newItems];
        },
        removeItemForm(id) {
            if (this.items.length > 1) this.items = this.items.filter(i => i.id !== id);
            return;
        },
        getClientDetails(e) {
            let client = e.target.value;
            console.log("see the selected client", client);
            axios
                .get(client + '/client-address/')
                .then((response) => {
                    if (response.data.success) {
                        this.clientAddress = response?.data?.data?.address || {}
                        return;
                    }
                })
        }
    },
    created() {
        if (route().current() == 'invoices.edit') {
            this.isEdit = true;
        }

        // const el = document.querySelector(".sidepane");

        // const observer = new IntersectionObserver(
        //     ([e]) => e.target.classList.toggle("is-pinned", e.intersectionRatio < 1),
        //     { threshold: [1] }
        // );

        // console.log(el);

        // // observer.observe(el);
    }
});



</script>

<template>
    <Head :title="isEdit ? 'Edit Invoice' : `Add New Invoice`" />
    <AppLayout>
        <div class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div class="app-container container-xxl">
                <!--begin::Layout-->
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
                                    <div class="d-flex flex-column align-items-start flex-xxl-row">
                                        <!--begin::Input group-->
                                        <div class="d-flex align-items-center flex-equal fw-row me-4 order-2"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" title="Specify invoice date">
                                            <!--begin::Date-->
                                            <div class="fs-6 fw-bold text-gray-700 text-nowrap">Date:</div>
                                            <!--end::Date-->
                                            <!--begin::Input-->
                                            <div class="position-relative d-flex align-items-center w-150px">
                                                <!--begin::Datepicker-->
                                                <VueDatePicker v-model="v$.form.invoice_date.$model"
                                                    :enable-time-picker="false" auto-apply
                                                    input-class-name="form-control form-control-transparent fw-bold pe-5"
                                                    :class="v$.form.invoice_due_date.$errors.length > 0
                                                            ? 'is-invalid'
                                                            : ''
                                                        " placeholder="Select date">
                                                </VueDatePicker>
                                                <div v-for="(error, index) of v$.form.invoice_due_date.$errors"
                                                    :key="index">
                                                    <input-error :message="error.$message" />
                                                </div>
                                                <!--end::Datepicker-->
                                                <!--begin::Icon-->
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                <span class="svg-icon svg-icon-2 position-absolute ms-4 end-0">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <!--end::Icon-->
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
                                                value="2021001" placehoder="..." />
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="d-flex align-items-center justify-content-end flex-equal order-3 fw-row"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover"
                                            title="Specify invoice due date">
                                            <!--begin::Date-->
                                            <div class="fs-6 fw-bold text-gray-700 text-nowrap">Due Date:</div>
                                            <!--end::Date-->
                                            <!--begin::Input-->
                                            <div class="position-relative d-flex align-items-center w-150px">
                                                <!--begin::Datepicker-->
                                                <VueDatePicker v-model="v$.form.invoice_due_date.$model"
                                                    :enable-time-picker="false" auto-apply
                                                    input-class-name="form-control form-control-transparent fw-bold pe-5"
                                                    :class="v$.form.invoice_date.$errors.length > 0
                                                            ? 'is-invalid'
                                                            : ''
                                                        " placeholder="Select Date"></VueDatePicker>
                                                <!--end::Datepicker-->
                                                <!--begin::Icon-->
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                <span class="svg-icon svg-icon-2 position-absolute end-0 ms-4">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <!--end::Icon-->
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
                                        <!--begin::Row-->
                                        <div class="row gx-10 mb-5">
                                            <!--begin::Col-->
                                            <div class="col-lg-6">
                                                <label class="form-label fs-6 fw-bold text-gray-700">Bill From</label>
                                                <!--begin::Input group-->
                                                <div class="mb-0">
                                                    <input type="text" class="form-control fs-5 form-control-transparent"
                                                        value="A.R Solution" readonly />
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="mb-0">
                                                    <input type="text" class="form-control fs-7 form-control-transparent"
                                                        value="RZ - 121 Prajapati Colony Uttam Nagar" readonly />
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="mb-0">
                                                    <input type="text" class="form-control fs-7 form-control-transparent"
                                                        value="Delhi,India 110059" readonly />
                                                    <input type="text" class="form-control fs-7 form-control-transparent"
                                                        value="GSTIN : 07CAYPR9267G1ZN" readonly />
                                                    <input type="text" class="form-control fs-7 form-control-transparent"
                                                        value="+91-7503876258" readonly />
                                                </div>
                                                <!--end::Input group-->
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-lg-6">
                                                <div class="mb-10">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bold fs-6 text-gray-700">Client</label>
                                                    <!--end::Label-->
                                                    <!--begin::Select-->
                                                    <select @change="getClientDetails"
                                                        class="form-control form-control-lg form-control-solid mb-2"
                                                        placeholder="Select One">
                                                        <option value="">-- Select One --</option>
                                                        <option v-for="client in clients.data" :value="client.id">{{
                                                           ( client.id)
                                                        }}</option>
                                                    </select>


                                                    <!--end::Select-->

                                                </div>
                                                <label class="form-label fs-6 fw-bold text-gray-700 mb-3">Bill To</label>
                                                <!--begin::Input group-->
                                                <div class="mb-5">
                                                    <input type="text" :value="clientAddress.address_line_1"
                                                        class="form-control form-control-solid" placeholder="Name" />
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="mb-5">
                                                    <input type="text" :value="clientAddress.address_line_2"
                                                        class="form-control form-control-solid" placeholder="Email" />
                                                </div>
                                                <div class="mb-5">
                                                    <input type="text" :value="clientAddress.city"
                                                        class="form-control form-control-solid" placeholder="Email" />
                                                </div>
                                                <div class="mb-5">
                                                    <input type="text" :value="clientAddress.state"
                                                        class="form-control form-control-solid" placeholder="Email" />
                                                </div>
                                                <div class="mb-5">
                                                    <input type="text" :value="clientAddress.pincode"
                                                        class="form-control form-control-solid" placeholder="Email" />
                                                </div>
                                                <div class="mb-5">
                                                    <input type="text" :value="clientAddress.country?.name"
                                                        class="form-control form-control-solid" placeholder="Email" />
                                                </div>
                                                <!--end::Input group-->
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
                                                    <tr class="border-bottom fs-7 fw-bold text-gray-700 text-uppercase">
                                                        <th class="min-w-150px w-150px">Item</th>
                                                        <th class="min-w-150px w-100px">CPI</th>
                                                        <th class="min-w-150px w-150px">Quantity</th>
                                                        <th class="min-w-150px w-150px text-end">Total</th>
                                                        <th class="min-w-75px w-75px text-end">Action</th>
                                                    </tr>
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody>
                                                    <ItemFormList :items="items" @removeSingle="removeItemForm" />
                                                </tbody>
                                                <!--end::Table body-->
                                                <!--begin::Table foot-->
                                                <tfoot>
                                                    <AppendItem @addItemForm="appendItemForm" />
                                                    <tr class="align-top fw-bold text-gray-700">
                                                        <th></th>
                                                        <th colspan="2" class="fs-4 ps-0">Total</th>
                                                        <th colspan="2" class="text-end fs-4 text-nowrap">$
                                                            <span data-kt-element="grand-total">0.00</span>
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
                                                placeholder="Thanks for your business"></textarea>
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
                                    <Multiselect :options="currnecy" label="name" valueProp="value"
                                        class="form-control form-control-lg form-control-solid mb-2" :searchable="true"
                                        v-model="form.currnecy" :class="v$.form.currnecy.$errors.length > 0
                                                    ? 'is-invalid'
                                                    : ''
                                                " placeholder="Select One" track-by="name" />
                                    <div v-for="(error, index) of v$.form.currnecy.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                    <!--end::Select-->
                                    <jet-input id="conversion_rate" type="text" v-model="v$.form.conversion_rate.$model"
                                        :class="v$.form.conversion_rate.$errors.length > 0
                                                    ? 'is-invalid'
                                                    : ''
                                                " placeholder="Conversion Rate" />
                                    <div v-for="(error, index) of v$.form.conversion_rate.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Separator-->
                                <div class="separator separator-dashed mb-8"></div>
                                <!--end::Separator-->

                                <!--begin::Separator-->
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
