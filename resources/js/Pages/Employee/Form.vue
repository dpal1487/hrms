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
import { required, email, url, numeric, integer } from "@vuelidate/validators";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'


// Vue.use(Datetime);
// import { Datetime } from 'vue-datetime';

export default defineComponent({
    props: ["employees", 'employee'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                first_name: {
                    required,
                },
                last_name: {
                    required,
                },
                date_of_joining: {
                    required,
                },
                number: {
                    required,
                },
                qualification: {
                    required,
                },
                emergency_number: {
                    required, integer,
                },
                pan_number: {
                    required,

                },
                father_name: {
                    required,
                },
                formalities: {
                    required, integer,
                },
                salary: {
                    required,
                },
                offer_acceptance: {
                    required, integer,
                },
                probation_period: {
                    required,
                },
                date_of_confirmation: {
                    required,
                },
                department_id: {
                    required,
                }
            },
        };
    },
    data() {
        return {

            isEdit: false,
            form: this.$inertia.form({
                id: this.employee?.data?.id || '',
                first_name: this.employee?.data?.user?.first_name || '',
                last_name: this.employee?.data?.user?.last_name || '',
                date_of_joining: this.employee?.data?.date_of_joining || '',
                number: this.employee?.data?.number || '',
                qualification: this.employee?.data?.qualification || '',
                emergency_number: this.employee?.data?.emergency_number || '',
                pan_number: this.employee?.data?.pan_number || '',
                father_name: this.employee?.data?.father_name || '',
                formalities: this.employee?.data?.formalities || '',
                salary: this.employee?.data?.salary || '',
                offer_acceptance: this.employee?.data?.offer_acceptance || '',
                probation_period: this.employee?.data?.probation_period || '',
                date_of_confirmation: this.employee?.data?.date_of_confirmation || '',
                department_id: this.employee?.data?.department_id || '',

            }),
            value: null,
            options: [
                { name: 'Vue.js', language: 'JavaScript' },
                { name: 'Rails', language: 'Ruby' },
                { name: 'Sinatra', language: 'Ruby' },
                { name: 'Laravel', language: 'PHP', $isDisabled: true },
                { name: 'Phoenix', language: 'Elixir' }
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
        VueDatePicker
    },
    methods: {
        nameWithLang({ name, language }) {
            return `${name} — [${language}]`
        },
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.form
                    .transform((data) => ({
                        ...data,
                    }))
                    .post(route().current() == 'employees.add' ? this.route("employees.store") : this.route('employees.update', this.form.id));
            }
        },

    },
    created() {
        if (route().current() == 'employees.edit') {
            this.isEdit = true;
        }
    }
});
</script>
<template>
    <Head :title="isEdit ? 'Edit Employee' : `Add New Employee`" />

    <AppLayout>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div class="col-12">
                <JetValidationErrors />
                <!-- {{ form }} -->
                <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>General</h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-5 col-md-12">

                                <!-- <jet-input type="text" v-model="v$.form.id.$model" /> -->
                                <div class="fv-row col-6">
                                    <div>
                                        <jet-label for="first_name" value="Select Department" />
                                        <div>
                                            <multiselect v-model="value" :options="options" :custom-label="nameWithLang"
                                                label="name">
                                            </multiselect>
                                        </div>

                                        <multiselect v-model="value" :options="options" :custom-label="nameWithLang"
                                            placeholder="Select one" label="name" track-by="name"></multiselect>
                                        <pre class="language-json"><code>{{ value }}</code></pre>
                                    </div>
                                    <jet-label for="first_name" value="First Name" />
                                    <jet-input id="first_name" type="text" v-model="v$.form.first_name.$model" :class="
                                        v$.form.first_name.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                    " placeholder="First name" />
                                    <div v-for="(error, index) of v$.form.first_name.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="last_name" value="Last Name" />
                                    <jet-input id="last_name" type="text" v-model="v$.form.last_name.$model" :class="
                                        v$.form.last_name.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                    " placeholder="Last Name" />
                                    <div v-for="(error, index) of v$.form.last_name.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>

                                <div class="fv-row col-6">
                                    <jet-label for="date_of_joining" value="Date Of Joining" />
                                    <VueDatePicker v-model="v$.form.date_of_joining.$model" :enable-time-picker="false"
                                        auto-apply
                                        input-class-name="form-control form-control-lg form-control-solid fs-5 fw-normal"
                                        :class="
                                            v$.form.date_of_joining.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                        " placeholder="Date Of Joining"></VueDatePicker>
                                    <div v-for="(error, index) of v$.form.date_of_joining.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="number" value="Number" />
                                    <jet-input id="number" type="text" v-model="v$.form.number.$model" :class="
                                        v$.form.number.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                    " placeholder="Enter Employee Number" />
                                    <div v-for="(error, index) of v$.form.number.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="qualification" value="Qualification" />
                                    <jet-input id="qualification" type="text" v-model="v$.form.qualification.$model" :class="
                                        v$.form.qualification.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                    " placeholder="Qualification" />
                                    <div v-for="(error, index) of v$.form.qualification.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="emergency_number" value="Emergency Number" />
                                    <jet-input id="emergency_number" type="text" v-model="v$.form.emergency_number.$model"
                                        :class="
                                            v$.form.emergency_number.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                        " placeholder="Emergency Number" />
                                    <div v-for="(error, index) of v$.form.emergency_number.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="pan_number" value="Pan Number" />
                                    <jet-input id="pan_number" type="text" v-model="v$.form.pan_number.$model" :class="
                                        v$.form.pan_number.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                    " placeholder="Pan Number" />
                                    <div v-for="(error, index) of v$.form.pan_number.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="father_name" value="Father Name" />
                                    <jet-input id="father_name" type="text" v-model="v$.form.father_name.$model" :class="
                                        v$.form.father_name.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                    " placeholder="Father Name" />
                                    <div v-for="(error, index) of v$.form.father_name.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="formalities" value="Formalities" />
                                    <jet-input id="formalities" type="text" v-model="v$.form.formalities.$model" :class="
                                        v$.form.formalities.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                    " placeholder="Formalities" />
                                    <div v-for="(error, index) of v$.form.formalities.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="salary" value="Salary" />
                                    <jet-input id="salary" type="text" v-model="v$.form.salary.$model" :class="
                                        v$.form.salary.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                    " placeholder="Salary" />
                                    <div v-for="(error, index) of v$.form.salary.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="offer_acceptance" value="Offer Acceptance" />
                                    <jet-input id="offer_acceptance" type="text" v-model="v$.form.offer_acceptance.$model"
                                        :class="
                                            v$.form.offer_acceptance.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                        " placeholder="Offer Acceptance" />
                                    <div v-for="(error, index) of v$.form.offer_acceptance.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="probation_period" value="Probation Period" />
                                    <jet-input id="probation_period" type="text" v-model="v$.form.probation_period.$model"
                                        :class="
                                            v$.form.probation_period.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                        " placeholder="Probation Period" />
                                    <div v-for="(error, index) of v$.form.probation_period.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="date_of_confirmation" value="Date Of Confirmation" />
                                    <jet-input id="date_of_confirmation" type="text"
                                        v-model="v$.form.date_of_confirmation.$model" :class="
                                            v$.form.date_of_confirmation.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                        " placeholder="Date Of Confirmation" />
                                    <div v-for="(error, index) of v$.form.date_of_confirmation.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>

                                <div class="fv-row col-6">

                                    <jet-label for="department_id" value="Department" />
                                    <jet-input id="department_id" type="text" v-model="v$.form.department_id.$model" :class="
                                        v$.form.department_id.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                    " placeholder="Department" />
                                    <div v-for="(error, index) of v$.form.department_id.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="department_id" value="Department" />

                                    <multiselect v-model="value" :options="options" :custom-label="nameWithLang"
                                        placeholder="Select one" label="name" track-by="name"></multiselect>
                                    <pre class="language-json"><code>{{ value }}</code></pre>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!--end::Variations-->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end">
                                <Link href="/employees" class="btn btn-secondary me-3">
                                Cancel
                                </Link>
                                <button type="submit" class="btn btn-primary">
                                    <span class="indicator-label">
                                        <p v-if="route().current() == 'employees.edit'">Update</p>
                                        <p v-if="route().current() == 'employees.add'">Save</p>
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
