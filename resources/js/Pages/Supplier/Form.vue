<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required, email, url, numeric, integer } from "@vuelidate/validators";
import { toast } from 'vue3-toastify';
import axios from "axios";
import { Inertia } from "@inertiajs/inertia";


export default defineComponent({
    props: ['supplier', 'company'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                company_id: {
                    required,
                },
                supplier_name: {
                    required,
                },
                display_name: {
                    required,
                },
                website: {
                    required,
                },
                skype_profile: {
                    required,
                },
                linkedIn_profile: {
                    required,
                },
                description: {
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
            processing: false,
            form: this.$inertia.form({
                id: this.supplier?.data?.id || '',
                company_id: this.supplier?.data?.company?.id || '',
                supplier_name: this.supplier?.data?.supplier_name || '',
                display_name: this.supplier?.data?.display_name || '',
                website: this.supplier?.data?.website || '',
                skype_profile: this.supplier?.data?.skype_profile || '',
                linkedIn_profile: this.supplier?.data?.linkedIn_profile || '',
                description: this.supplier?.data?.description || '',
                status: this.supplier?.data?.status || '',
            }),
            status: [
                { name: 'Active', id: '1' },
                { name: 'Inactive', id: '0' },
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
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.processing = true
                if (route().current() == 'supplier.create') {

                    axios.post(this.route("supplier.store"), this.form)
                        .then((response) => {
                            if (response.data.success == true) {
                                this.processing = false,
                                    toast.success(response.data.message)
                                Inertia.get('/supplier')
                            }
                            if (response.data.success == false) {
                                toast.error(response.data.message)
                            }
                        })
                }
                else {

                    axios.put(this.route('supplier.update', this.form.id), this.form)
                        .then((response) => {
                            if (response.data.success == true) {
                                this.processing = false,
                                    toast.success(response.data.message)
                                Inertia.get('/supplier')
                            }
                            if (response.data.success == false) {
                                toast.error(response.data.message)
                            }
                        })
                }
            }
        },

    },
    created() {
        if (route().current() == 'supplier.edit') {
            this.isEdit = true;
        }
    }
});
</script>
<template>
    <Head :title="isEdit ? 'Edit supplier' : `Add New supplier`" />

    <AppLayout>
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/supplier" class="text-muted text-hover-primary">Supplier</Link>
            </li>
        </template>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div class="col-12">
                <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>General</h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-5 col-md-12">

                                <div class="fv-row col-6">
                                    <jet-label for="company_id" value="Company " />
                                    <Multiselect id="company_id" :options="company" label="company_name" valueProp="id"
                                        class="form-control form-control-lg form-control-solid" placeholder="Select Comapny"
                                        v-model="form.company_id" track-by="name" :searchable="true" :class="v$.form.company_id.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " />
                                    <div v-for="(error, index) of v$.form.company_id.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>

                                </div>

                                <div class="fv-row col-6">
                                    <jet-label for="supplier_name" value="Supplier Name" />
                                    <jet-input id="supplier_name" type="supplier_name"
                                        v-model="v$.form.supplier_name.$model" :class="v$.form.supplier_name.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Supplier Name" />
                                    <div v-for="(error, index) of v$.form.supplier_name.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>

                                <div class="fv-row col-6">
                                    <jet-label for="display_name" value="Display Name" />
                                    <jet-input id="display_name" type="text" v-model="v$.form.display_name.$model" :class="v$.form.display_name.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Enter supplier Display Name" />
                                    <div v-for="(error, index) of v$.form.display_name.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="website" value="Website" />
                                    <jet-input id="website" type="text" v-model="v$.form.website.$model" :class="v$.form.website.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Website" />
                                    <div v-for="(error, index) of v$.form.website.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="skype_profile" value="Skype Profile" />
                                    <jet-input id="skype_profile" type="text" v-model="v$.form.skype_profile.$model" :class="v$.form.skype_profile.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Skype Profile" />
                                    <div v-for="(error, index) of v$.form.skype_profile.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>

                                <div class="fv-row col-6">
                                    <jet-label for="linkedIn_profile" value="LinkedIn Profile" />
                                    <jet-input id="linkedIn_profile" type="text" v-model="v$.form.linkedIn_profile.$model"
                                        :class="v$.form.linkedIn_profile.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="LinkedIn Profile" />
                                    <div v-for="(error, index) of v$.form.linkedIn_profile.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="description" value="Description" />
                                    <jet-input id="description" type="text" v-model="v$.form.description.$model" :class="v$.form.description.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Description" />
                                    <div v-for="(error, index) of v$.form.description.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>

                                <div class="fv-row col-6">
                                    <jet-label for="status" value="Status" />
                                    <Multiselect :options="status" label="name" valueProp="id"
                                        class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                        v-model="form.status" track-by="name" :class="v$.form.status.$errors.length > 0
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
                    <div class="row text-align-center">
                        <div class="col-12 gap-5">
                            <div class="d-flex justify-content-end gap-2">
                                <Link href="/supplier"
                                    class="btn btn-outline-secondary align-items-center justify-content-center">
                                Discard
                                </Link>
                                <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                                    :data-kt-indicator="processing ? 'on' : 'off'">
                                    <span class="indicator-label">
                                        <span v-if="route().current() == 'supplier.edit'">Update</span>
                                        <span v-if="route().current() == 'supplier.create'">Save</span>
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
