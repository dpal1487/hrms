<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required, url, integer } from "@vuelidate/validators";
import ImageInput from '@/components/ImageInput.vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import { toast } from 'vue3-toastify';

export default defineComponent({
    props: ['employee', 'user', 'departments', 'address'],
    setup() {

        return { v$: useVuelidate() }
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
                page: "employeeOverview",
            }),
            url: null,
            value: null,
        };
    },
    components: {
        AppLayout,
        Header,
        Link,
        Head,
        Multiselect,
        JetInput,
        JetLabel,
        InputError,
        VueDatePicker,
        ImageInput,
    },
    methods: {

        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.form.transform((data) => ({
                    ...data,
                }))
                    .post(this.route('employee.update', this.form.id),
                        {
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

});
</script>
<template>
    <Head title="Employee Overview" />
    <AppLayout>
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/employees" class="text-muted text-hover-primary">Employee</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                {{ employee.data.first_name }}
            </li>
        </template>

        <div class="app-content flex-column-fluid ">
            <!--begin::Content container-->
            <div class="app-container container-xxl">
                <!--begin::Navbar-->
                <Header :user="user.data" :employee="employee.data" :address="address?.data" />
                <!-- {{ $page }} -->
                <!--begin::details View-->
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header cursor-pointer">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">Manage Profile </h3>
                            <!-- {{ employee }} -->
                        </div>
                        <!--end::Card title-->
                        <button class="btn btn-primary align-self-center"
                            @click="this.isEdit = this.isEdit ? false : true"><i class="bi bi-pencil me-2"></i>Edit Company
                        </button>
                        <!-- <a href="settings.html" class="btn btn-primary align-self-center">Edit Profile</a> -->
                    </div>
                    <!--begin::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body p-9">
                        <div class="row" v-if="isEdit">
                            <div class="col-12">
                                <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row g-5 col-md-12">
                                                <div class="fv-row col-6">
                                                    <input type="hidden" v-model="form.image_id" />
                                                    <ImageInput :image="this.employee?.data?.image?.medium_path"
                                                        :onchange="onFileChange" :remove="removeSelectedAvatar"
                                                        :selectedImage="url" :errors="v$.form.image.$errors"
                                                        :isUploading="isUploading" />
                                                </div>
                                                <div class="fv-row col-6">
                                                    <jet-label for="first_name" value="First Name" />
                                                    <jet-input id="first_name" type="text"
                                                        v-model="v$.form.first_name.$model" :class="v$.form.first_name.$errors.length > 0
                                                            ? 'is-invalid'
                                                            : ''
                                                            " placeholder="First name" />
                                                    <div v-for="(error, index) of v$.form.first_name.$errors" :key="index">
                                                        <input-error :message="error.$message" />
                                                    </div>

                                                    <jet-label for="last_name" value="Last Name" />
                                                    <jet-input id="last_name" type="text" v-model="v$.form.last_name.$model"
                                                        :class="v$.form.last_name.$errors.length > 0
                                                            ? 'is-invalid'
                                                            : ''
                                                            " placeholder="Last Name" />
                                                    <div v-for="(error, index) of v$.form.last_name.$errors" :key="index">
                                                        <input-error :message="error.$message" />
                                                    </div>
                                                </div>
                                                <div class="fv-row col-6">
                                                    <jet-label for="email" value="Email" />
                                                    <jet-input id="email" type="email" v-model="v$.form.email.$model"
                                                        :class="v$.form.email.$errors.length > 0
                                                            ? 'is-invalid'
                                                            : ''
                                                            " placeholder="Email" />
                                                    <div v-for="(error, index) of v$.form.email.$errors" :key="index">
                                                        <input-error :message="error.$message" />
                                                    </div>
                                                </div>

                                                <div class="fv-row col-6">
                                                    <jet-label for="date_of_joining" value="Date Of Joining" />
                                                    <VueDatePicker v-model="v$.form.date_of_joining.$model"
                                                        :enable-time-picker="false" auto-apply
                                                        input-class-name="form-control form-control-lg form-control-solid fw-normal"
                                                        :class="v$.form.date_of_joining.$errors.length > 0
                                                            ? 'is-invalid'
                                                            : ''
                                                            " placeholder="Date Of Joining"></VueDatePicker>
                                                    <div v-for="(error, index) of v$.form.date_of_joining.$errors"
                                                        :key="index">
                                                        <input-error :message="error.$message" />
                                                    </div>
                                                </div>
                                                <div class="fv-row col-6">
                                                    <jet-label for="number" value="Number" />
                                                    <jet-input id="number" type="text" v-model="v$.form.number.$model"
                                                        :class="v$.form.number.$errors.length > 0
                                                            ? 'is-invalid'
                                                            : ''
                                                            " placeholder="Enter Employee Number" />
                                                    <div v-for="(error, index) of v$.form.number.$errors" :key="index">
                                                        <input-error :message="error.$message" />
                                                    </div>
                                                </div>
                                                <div class="fv-row col-6">
                                                    <jet-label for="qualification" value="Qualification" />
                                                    <jet-input id="qualification" type="text"
                                                        v-model="v$.form.qualification.$model" :class="v$.form.qualification.$errors.length > 0
                                                            ? 'is-invalid'
                                                            : ''
                                                            " placeholder="Qualification" />
                                                    <div v-for="(error, index) of v$.form.qualification.$errors"
                                                        :key="index">
                                                        <input-error :message="error.$message" />
                                                    </div>
                                                </div>
                                                <div class="fv-row col-6">
                                                    <jet-label for="emergency_number" value="Emergency Number" />
                                                    <jet-input id="emergency_number" type="text"
                                                        v-model="v$.form.emergency_number.$model" :class="v$.form.emergency_number.$errors.length > 0
                                                            ? 'is-invalid'
                                                            : ''
                                                            " placeholder="Emergency Number" />
                                                    <div v-for="(error, index) of v$.form.emergency_number.$errors"
                                                        :key="index">
                                                        <input-error :message="error.$message" />
                                                    </div>
                                                </div>
                                                <div class="fv-row col-6">
                                                    <jet-label for="pan_number" value="Pan Number" />
                                                    <jet-input id="pan_number" type="text"
                                                        v-model="v$.form.pan_number.$model" :class="v$.form.pan_number.$errors.length > 0
                                                            ? 'is-invalid'
                                                            : ''
                                                            " placeholder="Pan Number" />
                                                    <div v-for="(error, index) of v$.form.pan_number.$errors" :key="index">
                                                        <input-error :message="error.$message" />
                                                    </div>
                                                </div>
                                                <div class="fv-row col-6">
                                                    <jet-label for="father_name" value="Father Name" />
                                                    <jet-input id="father_name" type="text"
                                                        v-model="v$.form.father_name.$model" :class="v$.form.father_name.$errors.length > 0
                                                            ? 'is-invalid'
                                                            : ''
                                                            " placeholder="Father Name" />
                                                    <div v-for="(error, index) of v$.form.father_name.$errors" :key="index">
                                                        <input-error :message="error.$message" />
                                                    </div>
                                                </div>
                                                <div class="fv-row col-6">
                                                    <jet-label for="formalities" value="Formalities" />
                                                    <jet-input id="formalities" type="text"
                                                        v-model="v$.form.formalities.$model" :class="v$.form.formalities.$errors.length > 0
                                                            ? 'is-invalid'
                                                            : ''
                                                            " placeholder="Formalities" />
                                                    <div v-for="(error, index) of v$.form.formalities.$errors" :key="index">
                                                        <input-error :message="error.$message" />
                                                    </div>
                                                </div>
                                                <div class="fv-row col-6">
                                                    <jet-label for="salary" value="Salary" />
                                                    <jet-input id="salary" type="text" v-model="v$.form.salary.$model"
                                                        :class="v$.form.salary.$errors.length > 0
                                                            ? 'is-invalid'
                                                            : ''
                                                            " placeholder="Salary" />
                                                    <div v-for="(error, index) of v$.form.salary.$errors" :key="index">
                                                        <input-error :message="error.$message" />
                                                    </div>
                                                </div>
                                                <div class="fv-row col-6">
                                                    <jet-label for="offer_acceptance" value="Offer Acceptance" />
                                                    <jet-input id="offer_acceptance" type="text"
                                                        v-model="v$.form.offer_acceptance.$model" :class="v$.form.offer_acceptance.$errors.length > 0
                                                            ? 'is-invalid'
                                                            : ''
                                                            " placeholder="Offer Acceptance" />
                                                    <div v-for="(error, index) of v$.form.offer_acceptance.$errors"
                                                        :key="index">
                                                        <input-error :message="error.$message" />
                                                    </div>
                                                </div>
                                                <div class="fv-row col-6">
                                                    <jet-label for="probation_period" value="Probation Period" />
                                                    <jet-input id="probation_period" type="text"
                                                        v-model="v$.form.probation_period.$model" :class="v$.form.probation_period.$errors.length > 0
                                                            ? 'is-invalid'
                                                            : ''
                                                            " placeholder="Probation Period" />
                                                    <div v-for="(error, index) of v$.form.probation_period.$errors"
                                                        :key="index">
                                                        <input-error :message="error.$message" />
                                                    </div>
                                                </div>
                                                <div class="fv-row col-6">
                                                    <jet-label for="date_of_confirmation" value="Date Of Confirmation" />
                                                    <VueDatePicker v-model="v$.form.date_of_confirmation.$model"
                                                        :enable-time-picker="false" auto-apply
                                                        input-class-name="form-control form-control-lg form-control-solid fw-normal"
                                                        :class="v$.form.date_of_confirmation.$errors.length > 0
                                                            ? 'is-invalid'
                                                            : ''
                                                            " placeholder="Date Of Confirmation"></VueDatePicker>
                                                    <div v-for="(error, index) of v$.form.date_of_confirmation.$errors"
                                                        :key="index">
                                                        <input-error :message="error.$message" />
                                                    </div>
                                                </div>
                                                <div class="fv-row col-6">
                                                    <jet-label value="Department" />
                                                    <Multiselect :options="departments?.data" label="name" valueProp="id"
                                                        class="form-control form-control-lg form-control-solid"
                                                        placeholder="Select One" v-model="form.department"
                                                        track-by="name" />
                                                    <div v-for="(error, index) of v$.form.department.$errors" :key="index">
                                                        <input-error :message="error.$message" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Variations-->
                                    <div class="row text-align-center p-3">
                                        <div class="col-12">

                                            <div class="d-flex justify-content-end mt-4">
                                                <!--begin::Button-->
                                                <button type="button" class="btn btn-outline-secondary me-5"
                                                    @click="this.isEdit = false">Discard</button>
                                                <!--begin::Button-->
                                                <button type="submit" class="btn btn-primary"
                                                    :class="{ 'text-white-50': form.processing }">
                                                    <div v-show="form.processing" class="spinner-border spinner-border-sm">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                    Save Changes
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Actions-->
                                </form>
                            </div>
                        </div>
                        <div class="row" v-else>
                            <!--begin::Row-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-bold fs-5 text-gray-800">Full Name</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-6 text-gray-800 text-capitalize">{{
                                        this.employee?.data?.first_name }} {{
        this.employee?.data?.last_name }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-bold fs-5 text-gray-800">Employee Code</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <span class="fw-semibold text-gray-800 fs-6 text-uppercase">{{ this.employee?.data?.code
                                    }}
                                    </span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-bold fs-5 text-gray-800">Contact Phone
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                        title="Phone number must be active"></i></label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 d-flex align-items-center">
                                    <span class="fw-bold fs-6 text-gray-800 me-2">{{ this.employee?.data?.number }} </span>
                                    <span class="badge badge-success">Verified</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-bold fs-5 text-gray-800">Emergency Number</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <a href="#" class="fw-semibold fs-6 text-gray-800 text-hover-primary">{{
                                        this.employee?.data?.emergency_number }} </a>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-bold fs-5 text-gray-800">Date Of Joining</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-6 text-gray-800">{{ this.employee?.data?.date_of_joining
                                    }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-bold fs-5 text-gray-800">Pan Number</label>
                                <!--begin::Label-->
                                <!--begin::Label-->
                                <div class="col-lg-8">
                                    <span class="fw-semibold fs-6 text-gray-800">{{ this.employee?.data?.pan_number
                                    }}</span>
                                </div>
                                <!--begin::Label-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-bold fs-5 text-gray-800">Salary</label>
                                <!--begin::Label-->
                                <!--begin::Label-->
                                <div class="col-lg-8">
                                    <span class="fw-semibold fs-6 text-gray-800">{{ this.employee?.data?.salary }}</span>
                                </div>
                                <!--begin::Label-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-bold fs-5 text-gray-800">Offer Acceptance</label>
                                <!--begin::Label-->
                                <!--begin::Label-->
                                <div class="col-lg-8">
                                    <span class="fw-semibold fs-6 text-gray-800">{{ this.employee?.data?.offer_acceptance
                                    }}</span>
                                </div>
                                <!--begin::Label-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-bold fs-5 text-gray-800">Probation Period</label>
                                <!--begin::Label-->
                                <!--begin::Label-->
                                <div class="col-lg-8">
                                    <span class="fw-semibold fs-6 text-gray-800">{{ this.employee?.data?.probation_period
                                    }}</span>
                                </div>
                                <!--begin::Label-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-bold fs-5 text-gray-800">Date Of Conformation</label>
                                <!--begin::Label-->
                                <!--begin::Label-->
                                <div class="col-lg-8">
                                    <span class="fw-semibold fs-6 text-gray-800">{{
                                        this.employee?.data?.date_of_confirmation
                                    }}</span>
                                </div>
                                <!--begin::Label-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-bold fs-5 text-gray-800">Department</label>
                                <!--begin::Label-->
                                <!--begin::Label-->
                                <div class="col-lg-8">
                                    <span class="fw-semibold fs-6 text-gray-800">{{ this.employee?.data?.department?.name
                                    }}</span>
                                </div>
                                <!--begin::Label-->
                            </div>
                            <!--end::Input group-->

                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
            </div>
        </div>
        <!--end::details View-->
    </AppLayout>
</template>
