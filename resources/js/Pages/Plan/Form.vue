<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required, numeric } from "@vuelidate/validators";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import axios from "axios";
import { toast } from "vue3-toastify";
import { Inertia } from "@inertiajs/inertia";
import ItemFormList from "./Components/ItemFormList.vue";

export default defineComponent({
    props: ['plan', 'currencies'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                name: {
                    required,
                },
                sort_description: {
                    required,
                },
                start_date: {
                    required,
                },
                end_date: {
                    required,
                },

                status: {
                    required,
                },
                price: {
                    required,
                },
                sort_order: {
                    required, numeric,
                },
                stripe_plan: {
                    required,
                },
                currency: {
                    required,
                }
            },
        };
    },
    data() {
        return {
            rowCount: 1,
            items: 1,
            isEdit: false,
            processing: false,
            description: this.plan?.data?.description,
            form: this.$inertia.form({
                id: this.plan?.data?.id || '',
                name: this.plan?.data?.name || '',
                sort_description: this.plan?.data?.sort_description || '',
                start_date: this.plan?.data?.start_date || '',
                end_date: this.plan?.data?.end_date || '',
                status: this.plan?.data?.is_active || '',
                price: this.plan?.data?.price || '',
                stripe_plan: this.plan?.data?.stripe_plan || '',
                currency: this.plan?.data?.currency?.id || '',
                sort_order: this.plan?.data?.sort_order || '',
                items: this.plan?.data ? JSON.parse(this.plan?.data.description) : [{
                    meta: '',
                    description: '',
                }],
            }),
            status: [
                { id: '1', name: 'Active' },
                { id: '0', name: 'Inactive' },
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
        ItemFormList
    },
    methods: {

        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.processing = true

                if (route().current() == 'plan.create') {
                    this.form.transform((data) => ({
                        ...data
                    }))
                        .post(this.route("plan.store"),
                            {
                                onSuccess: (data) => {
                                    toast.success(this.$page.props.jetstream.flash.message);
                                    this.isEdit = false;
                                    this.isAdd = false;
                                },
                                onError: (data) => {


                                    toast.error(data.message);

                                },
                            })

                } else {
                    this.form.transform((data) => ({
                        ...data
                    }))
                        .put(this.route('plan.update', this.form.id),
                            {
                                onSuccess: (data) => {
                                    toast.success(this.$page.props.jetstream.flash.message);
                                    this.isEdit = false;
                                    this.isAdd = false;
                                },
                                onError: (data) => {

                                    toast.error(data.message);

                                },
                            })

                }
            }
        },
        addItemForm(rowCount) {
            for (var i = 0; i < rowCount; i++) {
                this.form.items.push({
                    meta: '',
                    description: '',
                });
            }
        },
        removeItemForm(index) {
            if (this.form.items.length > 0) {

                console.log(index)
                this.form.items.splice(index, 1)
            }
        },
    },

    created() {
        if (route().current() == 'plan.edit') {
            this.isEdit = true;
        }
    },
});
</script>
<template>
    <Head title="Plan" />
    <AppLayout>
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/plan" class="text-muted text-hover-primary">Plan</Link>
            </li>
        </template>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div class="col-12">
                <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Plan </h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex gap-5 flex-column flex-sm-row mb-5 col-12">
                                <div class="w-100 w-sm-50">
                                    <jet-label for="name" value="Name" />
                                    <jet-input id="name" type="text" v-model="v$.form.name.$model" :class="v$.form.name.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Name" />
                                    <div v-for="(error, index) of v$.form.name.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="w-100 w-sm-50">
                                    <jet-label for="sort_description" value="Sort Description" />
                                    <jet-input id="sort_description" type="text" v-model="v$.form.sort_description.$model"
                                        :class="v$.form.sort_description.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Sort Description" />
                                    <div v-for="(error, index) of v$.form.sort_description.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>

                                <div class="w-100 w-sm-50">
                                    <jet-label for="price" value="Price" />

                                    <jet-input id="price" type="text" v-model="v$.form.price.$model" :class="v$.form.price.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Price" />
                                    <div v-for="(error, index) of v$.form.price.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex gap-5 flex-column flex-sm-row mb-5 col-12">
                                <div class="w-100 w-sm-50">
                                    <jet-label for="start_date" value="Start Date" />
                                    <VueDatePicker v-model="v$.form.start_date.$model" :enable-time-picker="false"
                                        auto-apply
                                        input-class-name="form-control form-control-lg form-control-solid fw-normal" :class="v$.form.start_date.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Start Date"></VueDatePicker>
                                    <div v-for="(error, index) of v$.form.start_date.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>

                                </div>
                                <div class="w-100 w-sm-50">
                                    <jet-label for="end_date" value="End Date" />
                                    <VueDatePicker v-model="v$.form.end_date.$model" :enable-time-picker="false" auto-apply
                                        input-class-name="form-control form-control-lg form-control-solid fw-normal" :class="v$.form.end_date.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="End Date"></VueDatePicker>
                                    <div v-for="(error, index) of v$.form.end_date.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>

                                </div>

                                <div class="w-100 w-sm-50">
                                    <jet-label for="status" value="Currency" />
                                    <Multiselect :options="currencies.data" label="currency_name" valueProp="id"
                                        class="form-control form-control-lg form-control-solid" placeholder="Choose One"
                                        v-model="v$.form.currency.$model" track-by="currency_name" :class="v$.form.currency.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " />
                                    <div v-for="(error, index) of v$.form.name.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>


                            </div>
                            <div class="d-flex gap-5 flex-column flex-sm-row mb-5 col-12">
                                <div class="w-100 w-sm-50">
                                    <jet-label for="stripe_plan" value="Strip Plan" />
                                    <jet-input id="strip_plan" type="text" v-model="v$.form.stripe_plan.$model" :class="v$.form.stripe_plan.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Strip Plan" />
                                    <div v-for="(error, index) of v$.form.stripe_plan.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="w-100 w-sm-50">
                                    <jet-label for="sort_order" value="Sort Order" />
                                    <jet-input id="sort_order" type="text" v-model="v$.form.sort_order.$model" :class="v$.form.sort_order.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Sort Order" />
                                    <div v-for="(error, index) of v$.form.sort_order.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>

                                <div class="w-100 w-sm-50">
                                    <jet-label for="status" value="Status" />
                                    <Multiselect :options="status" label="name" valueProp="id"
                                        class="form-control form-control-lg form-control-solid" placeholder="Choose One"
                                        v-model="v$.form.status.$model" track-by="name" :class="v$.form.status.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " />
                                    <div v-for="(error, index) of v$.form.name.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive mb-10">
                                <!--begin::Table-->
                                <h4>Descriptions</h4>
                                <table class="table g-5 gs-0 mb-0 fw-bold text-gray-700" data-kt-element="items">
                                    <!--begin::Table head-->
                                    <thead>
                                        <tr class="border-bottom fs-7 fw-bold text-gray-700 text-uppercase text-center">
                                            <th>Meta</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody>
                                        <ItemFormList :form="form" @removeSingle="removeItemForm" :plan="plan"
                                            :items="items" :isEdit="isEdit" />
                                    </tbody>
                                    <!--end::Table body-->
                                    <!--begin::Table foot-->
                                    <tfoot>
                                        <tr class="border-top border-top-dashed align-top fs-6 fw-bold text-gray-700">
                                            <th class="text-primary">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    @click="addItemForm(this.rowCount)">Add
                                                    more</button>
                                            </th>
                                        </tr>
                                    </tfoot>
                                    <!--end::Table foot-->
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--end::Variations-->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-5">
                                <Link href="/plan"
                                    class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                                Discard
                                </Link>
                                <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                                    :data-kt-indicator="processing ? 'on' : 'off'">
                                    <span class="indicator-label">
                                        <span v-if="route().current() == 'plan.edit'">Save Changes</span>
                                        <span v-if="route().current() == 'plan.create'">Save</span>
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
