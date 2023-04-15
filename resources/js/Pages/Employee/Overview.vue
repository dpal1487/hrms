<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import UserLayout from "@/Layouts/UserLayout.vue";
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
import Dropdown from "../../Jetstream/Dropdown.vue";


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
        UserLayout,
        Link,
        Head,
        Multiselect,
        PrimaryButton,
        JetInput,
        JetLabel,
        InputError,
        JetValidationErrors,
        VueDatePicker,
        Dropdown
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
    <Head :title="Overview" />
    <AppLayout>
        <UserLayout :employee="employee">
            <!--begin::details View-->
            <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                <!--begin::Card header-->
                <div class="card-header cursor-pointer">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Profile Details</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->
                <!--begin::Card body-->
                <div class="card-body p-9">
                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Full Name</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ this.employee.data.user.first_name }} {{
                                this.employee.data.user.last_name }}</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Company</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <span class="fw-semibold text-gray-800 fs-6">{{ this.employee?.data?.user?.company_name }}
                                Keenthemes</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Contact Phone
                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                title="Phone number must be active"></i></label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 d-flex align-items-center">
                            <span class="fw-bold fs-6 text-gray-800 me-2">{{ this.employee?.data?.user?.contact }} </span>
                            <span class="badge badge-success">Verified</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Company Site</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <a href="#" class="fw-semibold fs-6 text-gray-800 text-hover-primary">{{
                                this.employee?.data?.user?.compony_url }} </a>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Country
                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                title="Country of origination"></i></label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ this.employee?.data?.user?.country }} </span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Communication</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">Email, Phone</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-10">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Allow Changes</label>
                        <!--begin::Label-->
                        <!--begin::Label-->
                        <div class="col-lg-8">
                            <span class="fw-semibold fs-6 text-gray-800">Yes</span>
                        </div>
                        <!--begin::Label-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::details View-->
        </UserLayout>
    </AppLayout>
</template>
