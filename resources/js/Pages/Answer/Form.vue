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
import { Inertia } from "@inertiajs/inertia";

export default defineComponent({
    props: ["questions", 'answer', 'message'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                question: {
                    required,
                },
                answer: {
                    required,
                },
                order_by: {
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
                id: this.answer?.data?.id || '',
                question: this.answer?.data?.question?.id || {},
                answer: this.answer?.data?.answer || '',
                order_by: this.answer?.data?.order_by || '',
            }),
            value: null,
            order_by: [
                { id: '1', name: 'Ascending' },
                { id: '0', name: 'Descending' },
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
                if (route().current() == 'answer.create') {
                    axios.post(this.route("answer.store"), this.form)
                        .then((response) => {
                            if (response.data.success) {
                                toast.success(response.data.message)
                                this.processing = false
                                Inertia.get('/answer')
                            } else {
                                toast.info(response.data.message)
                            }
                            if (response.data.error) {
                                toast.error(response.data.error)
                            }
                        })
                }
                else {
                    axios.put(this.route('answer.update', this.form.id), this.form)
                        .then((response) => {
                            if (response.data.success == true) {
                                toast.success(response.data.message)
                                this.processing = false
                                Inertia.get('/answer')
                            } else if (response.data.success == false) {

                                toast.info(response.data.message)
                            }
                            if (response.data.error) {
                                toast.error(response.data.error)
                            }
                        })
                }
            }
        },

    },
    created() {
        if (route().current() == 'answer.edit') {
            this.isEdit = true;
        }
    }
});
</script>
<template>
    <Head :title="isEdit ? 'Edit Employee' : `Add New Employee`" />

    <AppLayout>
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/answers" class="text-muted text-hover-primary">Answer</Link>
            </li>
        </template>

        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            {{ this.message }}

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
                            <div class="row g-5 col-md-12">

                                <div class="fv-row col-6">
                                    <jet-label for="question" value="Question" />
                                    <Multiselect :options="questions" label="question_key" valueProp="id"
                                        class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                        v-model="v$.form.question.$model" track-by="question_key" :searchable="true" :class="v$.form.question.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " />
                                    <div v-for="(error, index) of v$.form.question.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="answer" value="Answer" />
                                    <jet-input id="answer" type="text" v-model="v$.form.answer.$model" :class="v$.form.answer.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Answer" />
                                    <div v-for="(error, index) of v$.form.answer.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="order_by" value="Order By" />
                                    <Multiselect :options="order_by" label="name" valueProp="id"
                                        class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                        v-model="v$.form.order_by.$model" track-by="name" :searchable="true" :class="v$.form.order_by.$errors.length > 0
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
                                <Link href="/answer"
                                    class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                                Discard
                                </Link>
                                <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                                    :data-kt-indicator="processing ? 'on' : 'off'">
                                    <span class="indicator-label">
                                        <span v-if="route().current() == 'answer.edit'">Save Changes</span>
                                        <span v-if="route().current() == 'answer.create'">Save</span>
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
