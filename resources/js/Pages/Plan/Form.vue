<script>
import { defineComponent, watch } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required, integer } from "@vuelidate/validators";
import { toast } from "vue3-toastify";
export default defineComponent({
    props: ['plan', 'categories', 'currencies', 'times'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                name: { required },
                price: { required },
                category: { required },
                no_of_ads: { required, integer },
                currency: { required },
                status: { required },
                period: { required },
                description: {},
                sort_description: {},
                sort_order: { required },
            },
        };
    },
    data() {
        return {
            rowCount: 1,
            plan_descriptions: 1,
            isEdit: false,
            requesting: false,
            form: this.$inertia.form({
                id: this.plan?.data?.id || '',
                name: this.plan?.data?.name || '',
                category: this.plan?.data?.category?.id || '',
                period: this.plan?.data?.period || '',
                no_of_ads: this.plan?.data?.no_of_ads || '',
                sort_description: this.plan?.data?.sort_description || '',
                status: this.plan?.data?.status || '',
                price: this.plan?.data?.price || '',
                currency: this.plan?.data?.currency || '',
                sort_order: this.plan?.data?.sort_order || '',
                plan_descriptions: this.plan?.data?.description ? JSON.parse(this.plan?.data?.description) : [],
            }),
            status: [
                { value: '1', label: 'Active' },
                { value: '0', label: 'Inactive' },
            ],
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
    },
    methods: {

        addPlanDescriptionForm(rowCount) {
            for (var i = 0; i < rowCount; i++) {
                this.form.plan_descriptions.push({
                    description: '',
                });
            }
        },
        removePlanDescriptionForm(index) {
            if (this.form.plan_descriptions.length > 1) {
                this.form.plan_descriptions.splice(index, 1)
            }
        },
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.form
                    .transform((data) => ({
                        ...data,
                    }))
                    .post(route().current() == 'plan.create' ? this.route("plan.store") : this.route('plan.update', this.form.id), {
                        onSuccess: (data) => {
                            toast.success(this.$page.props.jetstream.flash.message);
                            this.isEdit = false;
                        },
                        onError: (data) => {
                            if (data.message) {
                                toast.error(data.message);
                            }
                        },
                    });
            }

        },
    },
    created() {
        if (route().current() == 'plan.edit') {
            this.isEdit = true;
        }
        else {
            this.form.plan_descriptions = [{
                description: '',
            }]
        }
    },
});
</script>
<template>
    <Head :title="isEdit ? 'Edit Plan' : `Add New Plan`" />
    <AppLayout :title="isEdit ? 'Edit Plan' : `Add New Plan`">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/plans" class="text-muted text-hover-primary">Plans</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <span class="text-muted">Plan Form</span>
            </li>
        </template>
        <form @submit.prevent="submit()" class="form d-flex flex-column flex-lg-row gap-5 ">
            <div class="d-flex col-12 col-lg-8 col-md-12 flex-column flex-row-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Plan</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-5 mb-5">
                            <div class="col-6">
                                <jet-label for="name" value="Name" class="required" />
                                <jet-input id="name" type="text" v-model="v$.form.name.$model" :class="v$.form.name.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " placeholder="Name" />
                                <div v-for="(error, index) of v$.form.name.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                            <div class="col-6">
                                <jet-label for="price" value="Price" class="required" />
                                <jet-input id="price" type="text" v-model="v$.form.price.$model" :class="v$.form.price.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " placeholder="Price" />
                                <div v-for="(error, index) of v$.form.price.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                            <div class="col-6">
                                <jet-label for="category_id" value="Category" class="required" />
                                <Multiselect :canClear="false" :options="categories?.data" label="name" valueProp="id"
                                    class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                    v-model="v$.form.category.$model" track-by="name" :searchable="true" :class="v$.form.category.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " />
                                <div v-for="(error, index) of v$.form.category.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                            <div class="col-6">
                                <jet-label for="time_id" value="Time Period" class="required" />
                                <Multiselect :canClear="false" id="time_id" :options="times?.data" label="title"
                                    valueProp="title" class="form-control form-control-lg form-control-solid"
                                    placeholder="Select One" v-model="v$.form.period.$model" track-by="name"
                                    :searchable="true" :class="v$.form.period.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " />
                                <div v-for="(error, index) of v$.form.period.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                            <div class="col-6">
                                <jet-label for="no_of_ads" value="Number Of Adds" class="required" />
                                <jet-input id="no_of_ads" type="text" v-model="v$.form.no_of_ads.$model" :class="v$.form.no_of_ads.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " placeholder="Number Of Adds" />
                                <div v-for="(error, index) of v$.form.no_of_ads.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                            <div class="col-6">
                                <jet-label for="currency-id" value="Currency" class="required" />
                                <Multiselect :canClear="false" id="currency-id" :options="currencies?.data" label="name"
                                    valueProp="code" class="form-control form-control-lg form-control-solid"
                                    placeholder="Select One" v-model="v$.form.currency.$model" track-by="name"
                                    :searchable="true" :class="v$.form.currency.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " />
                                <div v-for="(error, index) of v$.form.currency.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                            <div class="col-6">
                                <jet-label for="sort_order" value="Sort Order" class="required" />
                                <div class="">
                                    <jet-input id="sort_order" type="text" v-model="v$.form.sort_order.$model" :class="v$.form.sort_order.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Sort Order" />
                                    <div v-for="(error, index) of v$.form.sort_order.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <jet-label value="Status" class="required" />
                                <Multiselect :canClear="false" :options="status" label="label" valueProp="value"
                                    class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                    v-model="v$.form.status.$model" track-by="label" :class="v$.form.status.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " />
                                <div v-for="(error, index) of v$.form.status.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                        </div>
                        <div class="fv-row mb-5">
                            <jet-label for="description" value="Description" />
                            <textarea id="description" v-model="v$.form.sort_description.$model"
                                class="form-control form-control-solid" :class="v$.form.sort_description.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " placeholder="Text ..." />
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex col-lg-4 col-6 flex-column flex-row-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Plan Description</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div v-for="(plan, index) in form.plan_descriptions" :key="index"
                                class="d-flex align-items-center mb-6">
                                <div class="fv-row col-10">
                                    <jet-input id="name" type="text" v-model="plan.description"
                                        placeholder="Plan Description" />
                                </div>
                                <button type="button" @click="removePlanDescriptionForm(index)"
                                    class="btn btn-sm btn-icon btn-light-danger ms-4">
                                    <svg stroke="currentColor" fill="none" stroke-width="0" viewBox="0 0 15 15" height="1em"
                                        width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-time="evenodd" clip-time="evenodd"
                                            d="M11.7816 4.03157C12.0062 3.80702 12.0062 3.44295 11.7816 3.2184C11.5571 2.99385 11.193 2.99385 10.9685 3.2184L7.50005 6.68682L4.03164 3.2184C3.80708 2.99385 3.44301 2.99385 3.21846 3.2184C2.99391 3.44295 2.99391 3.80702 3.21846 4.03157L6.68688 7.49999L3.21846 10.9684C2.99391 11.193 2.99391 11.557 3.21846 11.7816C3.44301 12.0061 3.80708 12.0061 4.03164 11.7816L7.50005 8.31316L10.9685 11.7816C11.193 12.0061 11.5571 12.0061 11.7816 11.7816C12.0062 11.557 12.0062 11.193 11.7816 10.9684L8.31322 7.49999L11.7816 4.03157Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="form-group mt-5">
                            <button type="button" @click="addPlanDescriptionForm(this.rowCount)"
                                class="btn btn-sm btn-light-primary">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 12 16"
                                    height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M12 9H7v5H5V9H0V7h5V2h2v5h5v2z"></path>
                                </svg>
                                Add More
                            </button>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-5 mt-5">
                    <Link href="/plans" class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                    Discard
                    </Link>
                    <button type="submit" class="btn btn-primary" :class="{ 'text-white-50': form.processing }">
                        <div v-show="form.processing" class="spinner-border spinner-border-sm">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span v-if="route().current() == 'plan.edit'">Update</span>
                        <span v-if="route().current() == 'plan.create'">Save</span>
                    </button>
                </div>
            </div>
        </form>
    </AppLayout>
</template>
