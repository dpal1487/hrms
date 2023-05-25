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
import { required, integer } from "@vuelidate/validators";
import Dropdown from "../../Jetstream/Dropdown.vue";
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import axios from "axios";
import { Inertia } from "@inertiajs/inertia";


// Vue.use(Datetime);
// import { Datetime } from 'vue-datetime';

export default defineComponent({
    props: ["questions", 'question', 'industries', 'message'],
    setup() {
        return { v$: useVuelidate() };
        const notify = () => {
            toast.info("Wow so easy !", {
                autoClose: 1000,
            });
        }
        return { notify };
    },
    validations() {
        return {
            form: {
                question_key: {
                    required,
                },
                text: {
                    required,
                },
                language: {
                    required,
                },
                type: {
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
                id: this.question?.data?.id || '',
                question_key: this.question?.data?.question_key || '',
                text: this.question?.data?.text || '',
                type: this.question?.data?.type || '',
                industry: this.question?.data?.industry?.id || {},
                language: this.question?.data?.language || '',
            }),
            options: [
                { name: 'Select', type: 'Select' },
                { name: 'Checkbox', type: 'Checkbox' },
                { name: 'Radio', type: 'Radio' },
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
        Dropdown
    },
    methods: {
        nameWithLang({ name, type }) {
            return `${name} — [${type}]`
        },
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.processing = true
                if (route().current() == 'question.create') {

                    axios.post(this.route("question.store"), this.form)
                        .then((response) => {
                            if (response.data.success) {
                                toast.success(response.data.message)
                                this.processing = false
                                Inertia.get('/question')

                            } else {
                                toast.info(response.data.message)
                            }
                            if (response.data.error) {
                                toast.error(response.data.error)
                            }
                        });

                }
                else {
                    axios.put(this.route('question.update', this.form.id), this.form)
                        .then((response) => {
                            if (response.data.success) {
                                toast.success(response.data.message)
                                this.processing = false
                                Inertia.get('/question')

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
        if (route().current() == 'question.edit') {
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
                <Link href="/questions" class="text-muted text-hover-primary">Question</Link>
            </li>
        </template>

        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div v-if="$page?.props?.flash?.message"
                class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                role="alert">
                <span class="font-medium">
                    {{ $page?.props?.flash?.message }}
                </span>
            </div>
            <div class="col-12">
                <JetValidationErrors />
                <!-- {{ question?.data?.question_key }} -->
                <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>General</h2>
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

                                <!-- <jet-input type="text" v-model="v$.form.id.$model" /> -->
                                <div class="fv-row col-6">

                                    <jet-label for="question_key" value="Question Key" />
                                    <jet-input id="question_key" type="text" v-model="v$.form.question_key.$model" :class="v$.form.question_key.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Question Key" />
                                    <div v-for="(error, index) of v$.form.question_key.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>


                                <div class="fv-row col-6">
                                    <jet-label for="language" value="Language" />
                                    <jet-input id="language" type="text" v-model="v$.form.language.$model" :class="v$.form.language.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Language" />
                                    <div v-for="(error, index) of v$.form.language.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>


                                <div class="fv-row col-6">
                                    <jet-label for="type" value="Type" />
                                    <Multiselect :options="options" label="name" valueProp="name" id="type"
                                        :custom-label="nameWithLang" class="form-control form-control-lg form-control-solid"
                                        placeholder="Choose One" v-model="v$.form.type.$model" track-by="name" :class="v$.form.type.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " />
                                    <div v-for="(error, index) of v$.form.type.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>

                                </div>
                                <div class="fv-row col-12">
                                    <jet-label for="text" value="Text" />
                                    <textarea v-model="v$.form.text.$model" class="form-control form-control-solid" :class="v$.form.text.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Text"></textarea>

                                    <div v-for="(error, index) of v$.form.text.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--end::Variations-->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <Link href="/question" class="btn btn-secondary align-items-center justify-content-center">
                                Cancel
                                </Link>
                                <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                                    :data-kt-indicator="processing ? 'on' : 'off'">
                                    <span class="indicator-label">
                                        <span v-if="route().current() == 'question.edit'">Update</span>
                                        <span v-if="route().current() == 'question.create'">Save</span>
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
