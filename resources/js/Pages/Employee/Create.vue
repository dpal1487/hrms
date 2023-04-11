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
import { required, email, url, numeric } from "@vuelidate/validators";
export default defineComponent({
    props: ["employees"],
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
                    required,
                },
                pan_number: {
                    required,
                },
                father_name: {
                    required,
                },
                formalities: {
                    required,
                },
                salary: {
                    required,
                },
                offer_acceptance: {
                    required,
                },
                probation_period: {
                    required,
                },
                date_of_confirmation: {
                    required,
                },
                notice_period: {
                    required,
                },
                last_working_day: {
                    required,
                },
                full_final: {
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
            form: this.$inertia.form({
                first_name: "",
                last_name: "",
                date_of_joining: "",
                number: "",
                qualification: "",
                emergency_number: "",
                pan_number: "",
                father_name: "",
                formalities: "",
                salary: "",
                offer_acceptance: "",
                probation_period: "",
                date_of_confirmation: "",
                notice_period: "",
                last_working_day: "",
                full_final: "",
                department_id: "",
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
                this.form
                    .transform((data) => ({
                        ...data,
                    }))
                    .post(this.route("employees.store"));
            }
        },
    },
});
</script>
<template>
    <Head title="Add New Employee" />
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

                                <div class="fv-row col-6">
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
                                    <jet-input id="date_of_joining" type="text" v-model="v$.form.date_of_joining.$model"
                                        :class="
                                            v$.form.date_of_joining.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                        " placeholder="Date Of Joining" />
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
                                    <jet-label for="notice_period" value="Notice Period" />
                                    <jet-input id="notice_period" type="text" v-model="v$.form.notice_period.$model" :class="
                                        v$.form.notice_period.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                    " placeholder="Notice Period" />
                                    <div v-for="(error, index) of v$.form.notice_period.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="last_working_day" value="Last Working Day" />
                                    <jet-input id="last_working_day" type="text" v-model="v$.form.last_working_day.$model"
                                        :class="
                                            v$.form.last_working_day.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                        " placeholder="Last Working Day" />
                                    <div v-for="(error, index) of v$.form.last_working_day.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="full_final" value="Full Final" />
                                    <jet-input id="full_final" type="text" v-model="v$.form.full_final.$model" :class="
                                        v$.form.full_final.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                    " placeholder="Full Final" />
                                    <div v-for="(error, index) of v$.form.full_final.$errors" :key="index">
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
                                        Save
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
