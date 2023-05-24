<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { toast } from "vue3-toastify";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import useVuelidate from "@vuelidate/core";
import { required, email, url } from "@vuelidate/validators";
import Multiselect from "@vueform/multiselect";

export default defineComponent({
    setup() {
        return { v$: useVuelidate() };
    },
    props: ['client', 'countries'],
    components: {
        AppLayout,
        Header,
        Link,
        Head,
        JetInput,
        JetLabel,
        JetValidationErrors,
        InputError,
        Multiselect
    },
    validations() {
        return {
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
                status: {
                    required,
                },
                processing: false,
            },
        };
    },
    data() {
        return {
            form: this.$inertia.form({
                id: this.client.data.id,
                client_name: this.client.data.name,
                display_name: this.client.data.display_name,
                description: this.client.data.description,
                status: this.client.data.status,
            }),
            isEdit: false,
            title: "Client Overview",
        };
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.form.transform((data) => ({
                    ...data,
                }))
                    .post(this.route("client.update", this.form.id),
                        {
                            onSuccess: (data) => {
                                toast.success(this.$page.props.jetstream.flash.message);
                                this.isEdit = false;
                            },
                            onError: (data) => {
                                console.log(data);
                            },
                        });
            }
        },
        changeStatus() {

        }
    },
    created() {
    }
});
</script>
<template>
    <Head :title="title" />
    <app-layout :title="title">

        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/clients" class="text-muted text-hover-primary">Clients</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                {{ client.data.name }}
            </li>
        </template>
        <!--begin::Navbar-->
        <Header :client="client.data" />
        <!--begin::details View-->
        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header cursor-pointer">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Client Details </h3>
                </div>
                <!--end::Card title-->
                <button class="btn btn-primary align-self-center" @click="this.isEdit = this.isEdit ? false : true"><i
                        class="bi bi-pencil me-2"></i>Edit Client
                </button>
            </div>
            <!--begin::Card header-->
            <div class="card-body p-9">
                <div class="row" v-if="isEdit">
                    <div class="col-8">
                        <JetValidationErrors />
                        <form @submit.prevent="submit">
                            <div class="row g-5">
                               <div class="col-12">
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <jet-label for="client-name" class="col-4 required" value="Client Name" />
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                        <jet-input id="client-name" type="text" v-model="v$.form.client_name.$model" :class="v$.form.client_name.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Enter client full name" />
                                        <div v-for="(error, index) of v$.form.client_name.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <jet-label for="display-name" class="col-4 required" value="Display Name" />
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                        <jet-input id="display-name" type="text" v-model="v$.form.display_name.$model"
                                            :class="v$.form.display_name.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                                " placeholder="Enter display name" />
                                        <div v-for="(error, index) of v$.form.display_name.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <jet-label for="client-name" class="col-4 required" value="Description" />
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
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
                            <div class="d-flex justify-content-end mt-4">
                                <!--begin::Button-->
                                <button type="button" class="btn btn-outline-secondary me-5"
                                    @click="this.isEdit = false">Discard</button>
                                <!--begin::Button-->
                                <button type="submit" class="btn btn-primary" :class="{ 'text-white-50': form.processing }">
                                    <div v-show="form.processing" class="spinner-border spinner-border-sm">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div v-else>
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-6 fw-bold fs-5 text-gray-800">Client Name</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-6 fv-row">
                            <span class="fw-bold fs-6 text-gray-700">{{ client.data.name }}
                            </span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-6 fw-bold fs-5 text-gray-800">Display Name</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-6 fv-row">
                            <span class="fw-bold fs-6 text-gray-700">{{ client.data.display_name }}
                            </span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-6 fw-bold fs-5 text-gray-800">Description</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-6 fv-row">
                            <span class="fw-bold fs-6 text-gray-700">{{ client.data.description }}
                            </span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-6 fw-bold fs-5 text-gray-800">Status</label>
                        <!--begin::Label-->
                        <!--begin::Label-->
                        <div class="col-6">
                            <div class="form-switch form-check-solid d-block form-check-custom form-check-success">
                                <input class="form-check-input h-20px w-30px" type="checkbox"
                                    @input="changeStatus($event.target.checked, client.data.id)"
                                    :checked="client.data.status == 1 ? true : false" />
                            </div>
                        </div>
                        <!--begin::Label-->
                    </div>
                </div>
            </div>
            <!--end::Card body-->
        </div>
    </app-layout>
</template>
