<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import PrimaryButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import axios from "axios";
import { toast } from "vue3-toastify";
import { Inertia } from "@inertiajs/inertia";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";


export default defineComponent({
    props: ['corporationtype'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                title: {
                    required,
                },
                description: {
                    required,
                }
            },
        };
    },
    data() {
        return {

            isEdit: false,
            requesting: false,
            form: this.$inertia.form({
                id: this.corporationtype?.data?.id || '',
                title: this.corporationtype?.data?.title || '',
                description: this.corporationtype?.data?.description || '',

            }),

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
                this.requesting = true;
                if (route().current() == 'corporation-type.create') {
                    axios.post(this.route("corporation-type.store"), this.form)
                        .then((response) => {
                            if (response.data.success == true) {
                                this.requesting = false;
                                toast.success(response.data.message)
                                Inertia.get('/corporation-type')
                            } else {
                                toast.info(response.data.message)
                            }
                            if (response.data.success == false) {
                                toast.error(response.data.error)
                            }
                        })
                } else {
                    axios.put(this.route('corporation-type.update', this.form.id), this.form)
                        .then((response) => {
                            if (response.data.success == true) {
                                this.requesting = false;
                                toast.success(response.data.message)
                                Inertia.get('/corporation-type')
                            } else {
                                toast.info(response.data.message)
                            }
                            if (response.data.success == false) {
                                toast.error(response.data.error)
                            }
                        })
                }
            }
        },

    },
    created() {
        if (route().current() == 'corporation-type.edit') {
            this.isEdit = true;
        }
    }
});
</script>
<template>
    <Head :title="isEdit ? 'Edit Corporation Type' : `Add New Corporation Type`" />
    <AppLayout>
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/corporation-type" class="text-muted text-hover-primary">Conversion Type</Link>
            </li>
        </template>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div class="col-12">
                <JetValidationErrors />

                <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Corporation Type</h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-5 col-md-12 mb-4">
                                <div class="fv-row col-6">
                                    <jet-label for="title" value="Title" />
                                    <jet-input id="title" type="text" v-model="v$.form.title.$model" :class="v$.form.title.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Title" />
                                    <div v-for="(error, index) of v$.form.title.$errors" :key="index">
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
                            </div>
                        </div>
                    </div>
                    <!--end::Variations-->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-5">
                                <Link href="/corporation-type"
                                    class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                                Discard
                                </Link>
                                
                                <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                                    :data-kt-indicator="requesting ? 'on' : 'off'">
                                    <span class="indicator-label">
                                        <span v-if="route().current() == 'corporation-type.edit'">Update</span>
                                        <span v-if="route().current() == 'corporation-type.create'">Save</span>
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
