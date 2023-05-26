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
import { required, url, integer } from "@vuelidate/validators";
import ImageInput from '@/components/ImageInput.vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import Dropdown from "../../Jetstream/Dropdown.vue";
import { toast } from 'vue3-toastify';
import axios from "axios";
import { Inertia } from "@inertiajs/inertia";

// Vue.use(Datetime);
// import { Datetime } from 'vue-datetime';

export default defineComponent({
    props: ['employee', 'user', 'departments'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                image: {
                    required,
                },
                first_name: {
                    required,
                },
                last_name: {
                    required,
                },
                email: {
                    required,
                },
                password: {
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
                department: {
                    required,
                }
            },
        };
    },
    data() {
        return {

            message: '',
            isEdit: false,
            processing: false,
            isUploading: false,
            form: this.$inertia.form({
                id: this.employee?.data?.id || '',
                image: this.employee?.data?.image?.medium_path || '',
                image_id: this.employee?.data?.image_id || '',
                first_name: this.employee?.data?.first_name || '',
                last_name: this.employee?.data?.last_name || '',
                email: this.user?.data?.email || '',
                password: this.user?.data?.password || '',
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
                department: this.employee?.data?.department?.id || '',
            }),
            url: null,
            value: null,
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
        VueDatePicker,
        Dropdown,
        ImageInput,
    },
    methods: {
        submit() {
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.form.transform((data) => ({
                    ...data,
                }))
                    .post(route().current() == 'employee.add' ? this.route("employee.store") : this.route('employee.update', this.form.id), {
                        onSuccess: (data) => {
                            toast.success(this.$page.props.jetstream.flash.message);
                            this.isEdit = false;
                        },
                        onError: (data) => {
                            if (data.message) {
                                toast.error(data.message);
                            }
                        },
                    })

            }
        },
        onFileChange(e) {
            const file = e.target.files[0];
            this.$data.form.image = file;
            this.selectedFilename = file?.name;
            this.url = URL.createObjectURL(file);

            const formdata = new FormData();
            formdata.append("image", file)

            this.isUploading = true;
            axios.post("/employee/image-upload", formdata, {
                headers: {
                    "Content-Type": "multipart/form-data",
                }
            }).then((response) => {
                if (response.data.success) {
                    // toast.success(response.data.message);
                    this.form.image_id = response.data.data.id;
                } else {
                    toast.error(response.data.message);
                }
            }).finally(() => {
                this.isUploading = false;
            })



        },
        removeSelectedAvatar() {
            this.url = null;
        }

    },
    created() {
        if (route().current() == 'employee.edit') {
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
                <Link href="/employees" class="text-muted text-hover-primary">Employee</Link>
            </li>
        </template>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div class="col-12">
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
                                    <ImageInput :image="this.employee?.data?.image?.medium_path" :onchange="onFileChange"
                                        :remove="removeSelectedAvatar" :selectedImage="url" :errors="v$.form.image.$errors"
                                        :isUploading="isUploading" />
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="first_name" value="First Name" />
                                    <jet-input id="first_name" type="text" v-model="v$.form.first_name.$model" :class="v$.form.first_name.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="First name" />
                                    <div v-for="(error, index) of v$.form.first_name.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>

                                    <jet-label for="last_name" value="Last Name" />
                                    <jet-input id="last_name" type="text" v-model="v$.form.last_name.$model" :class="v$.form.last_name.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Last Name" />
                                    <div v-for="(error, index) of v$.form.last_name.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>


                                <div class="fv-row col-6">
                                    <jet-label for="email" value="Email" />
                                    <jet-input id="email" type="email" v-model="v$.form.email.$model" :class="v$.form.email.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Email" />
                                    <div v-for="(error, index) of v$.form.email.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6" v-if="!isEdit">
                                    <jet-label for="password" value="Password" />
                                    <jet-input id="password" type="password" v-model="v$.form.password.$model" :class="v$.form.password.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Password" />
                                    <div v-for="(error, index) of v$.form.password.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="date_of_joining" value="Date Of Joining" />
                                    <VueDatePicker v-model="v$.form.date_of_joining.$model" :enable-time-picker="false"
                                        auto-apply
                                        input-class-name="form-control form-control-lg form-control-solid fw-normal" :class="v$.form.date_of_joining.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Date Of Joining"></VueDatePicker>
                                    <div v-for="(error, index) of v$.form.date_of_joining.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="number" value="Number" />
                                    <jet-input id="number" type="text" v-model="v$.form.number.$model" :class="v$.form.number.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Enter Employee Number" />
                                    <div v-for="(error, index) of v$.form.number.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="emergency_number" value="Emergency Number" />
                                    <jet-input id="emergency_number" type="text" v-model="v$.form.emergency_number.$model"
                                        :class="v$.form.emergency_number.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Emergency Number" />
                                    <div v-for="(error, index) of v$.form.emergency_number.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="qualification" value="Qualification" />
                                    <jet-input id="qualification" type="text" v-model="v$.form.qualification.$model" :class="v$.form.qualification.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Qualification" />
                                    <div v-for="(error, index) of v$.form.qualification.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>

                                <div class="fv-row col-6">
                                    <jet-label for="pan_number" value="Pan Number" />
                                    <jet-input id="pan_number" type="text" v-model="v$.form.pan_number.$model" :class="v$.form.pan_number.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Pan Number" />
                                    <div v-for="(error, index) of v$.form.pan_number.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="father_name" value="Father Name" />
                                    <jet-input id="father_name" type="text" v-model="v$.form.father_name.$model" :class="v$.form.father_name.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Father Name" />
                                    <div v-for="(error, index) of v$.form.father_name.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="formalities" value="Formalities" />
                                    <jet-input id="formalities" type="text" v-model="v$.form.formalities.$model" :class="v$.form.formalities.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Formalities" />
                                    <div v-for="(error, index) of v$.form.formalities.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="salary" value="Salary" />
                                    <jet-input id="salary" type="text" v-model="v$.form.salary.$model" :class="v$.form.salary.$errors.length > 0
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
                                        :class="v$.form.offer_acceptance.$errors.length > 0
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
                                        :class="v$.form.probation_period.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Probation Period" />
                                    <div v-for="(error, index) of v$.form.probation_period.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="date_of_confirmation" value="Date Of Confirmation" />
                                    <VueDatePicker v-model="v$.form.date_of_confirmation.$model" :enable-time-picker="false"
                                        auto-apply
                                        input-class-name="form-control form-control-lg form-control-solid fw-normal" :class="v$.form.date_of_confirmation.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Date Of Confirmation"></VueDatePicker>

                                    <div v-for="(error, index) of v$.form.date_of_confirmation.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="department_id" value="Department" />
                                    <Multiselect :options="departments.data" label="name" valueProp="id"
                                        class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                        v-model="form.department" track-by="name" />
                                    <div v-for="(error, index) of v$.form.department.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--end::Variations-->
                    <div class="row text-align-center">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <Link href="/employees" class="btn btn-secondary align-items-center justify-content-center">
                                Cancel
                                </Link>
                                <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                                    :data-kt-indicator="processing ? 'on' : 'off'">
                                    <span class="indicator-label">
                                        <span v-if="route().current() == 'employee.edit'">Update</span>
                                        <span v-if="route().current() == 'employee.add'">Save</span>
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
