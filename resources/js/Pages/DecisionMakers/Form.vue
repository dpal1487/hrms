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
import { toast } from "vue3-toastify";
import axios from "axios";
import { Inertia } from "@inertiajs/inertia";
export default defineComponent({
    props: ['decisionmaker', 'industries'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                title: {
                    required,
                },
                order_by: {
                    required,
                },
                industry: {
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
                id: this.decisionmaker?.data?.id || '',
                title: this.decisionmaker?.data?.title || '',
                order_by: this.decisionmaker?.data?.order_by || '',
                industry: this.decisionmaker?.data?.industry?.id || {},
            }),
            options: [
                { value: '1', name: 'Assending' },
                { value: '0', name: 'Desssending' },
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
                this.processing = true
                if (route().current() == 'decision-maker.create') {
                    axios.post(this.route("decision-maker.store"), this.form)
                        .then((response) => {
                            if (response.data.success) {
                                toast.success(response.data.message)
                                this.processing = false
                                Inertia.get('/decision-maker')
                            } else {
                                toast.info(response.data.message)
                            }
                            if (response.data.error) {
                                toast.error(response.data.error)
                            }
                        });

                } else {

                    axios.put(this.route('decision-maker.update', this.form.id), this.form)
                        .then((response) => {
                            if (response.data.success) {
                                toast.success(response.data.message)
                                this.processing = false
                                Inertia.get('/decision-maker')
                            } else {
                                toast.info(response.data.message)
                            }
                            if (response.data.error) {
                                toast.error(response.data.error)
                            }
                        });

                }
            }
        },

    },
    created() {
        if (route().current() == 'decision-maker.edit') {
            this.isEdit = true;
        }
    }
});
</script>
<template>
    <Head :title="isEdit ? 'Decision Maker' : `Add New Decision Maker`" />

    <AppLayout>
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/decision-maker" class="text-muted text-hover-primary">Decision Maker</Link>
            </li>
        </template>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div class="col-12">
                <JetValidationErrors />
                <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Decision Maker Form</h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-5 col-md-12">
                                <!-- {{ v$.form.industry.$model }} -->
                                <div class="fv-row col-6">
                                    <jet-label for="industry" value="Industry" />
                                    <Multiselect :options="industries" label="name" valueProp="id"
                                        class="form-control form-control-lg form-control-solid"
                                        placeholder="Select Industry" v-model="v$.form.industry.$model" track-by="name"
                                        :searchable="true" :class="v$.form.industry.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " />
                                    <div v-for="(error, index) of v$.form.industry.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>

                                </div>

                                <div class="fv-row col-6">
                                    <jet-label for="title" value="Title" />
                                    <jet-input type="text" v-model="v$.form.title.$model" :class="v$.form.title.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Title" />
                                    <div v-for="(error, index) of v$.form.title.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>


                                <div class="fv-row col-6">
                                    <jet-label for="type" value="Order By" />
                                    <Multiselect :options="options" label="name" valueProp="value"
                                        class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                        v-model="v$.form.order_by.$model" track-by="name" :class="v$.form.order_by.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " />
                                    <div v-for="(error, index) of v$.form.order_by.$errors" :key="index">
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
                                <Link href="/decision-maker"
                                    class="btn btn-outline-secondary align-items-center justify-content-center">
                                Discard
                                </Link>
                                <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                                    :data-kt-indicator="(form.processing) ? 'on' : 'off'">
                                    <span class="indicator-label">
                                        <span v-if="route().current() == 'decision-maker.edit'">Save Changes</span>
                                        <span v-if="route().current() == 'decision-maker.create'">Save</span>
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
