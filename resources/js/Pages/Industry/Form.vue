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
import ImageInput from '@/Components/ImageInput.vue';
import { required, email, url, numeric, integer } from "@vuelidate/validators";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import { toast } from "vue3-toastify";
import axios from "axios";
import { Inertia } from "@inertiajs/inertia";


// Vue.use(Datetime);
// import { Datetime } from 'vue-datetime';

export default defineComponent({
    props: ['industry'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                name: {
                    required,
                },
                image: {
                    required,
                }
                ,
                status: {
                    required,
                }
            },
        };
    },
    data() {
        return {
            isEdit: false,
            isUploading: false,
            processing: false,
            form: this.$inertia.form({
                id: this.industry?.data?.id || '',
                name: this.industry?.data?.name || '',
                image: this.industry?.data?.image?.name || '',
                status: this.industry?.data?.status || '',
                image_id: this.industry?.data?.image?.id || '',
                image: this.industry?.data.image || '',


            }),
            url: null,
            value: null,
            status: [
                { id: '1', name: 'Active' },
                { id: '0', name: 'Inactive' },
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
        VueDatePicker,
        ImageInput,
        toast
    },
    methods: {
        submit() {
            this.v$.$touch();

            if (!this.v$.form.$invalid) {
                this.processing = true;
                if (route().current() == 'industry.create') {

                    axios.post(this.route("industry.store"), this.form)
                        .then((response) => {

                            if (response.data.success == true) {
                                toast.success(response.data.message)
                                this.processing = false
                                Inertia.get('/industry')
                            }
                            else {
                                toast.error(response.data.message)
                            }
                        })
                } else {

                    axios.put(this.route('industry.update', this.form.id), this.form)
                        .then((response) => {
                            if (response.data.success == true) {
                                toast.success(response.data.message)
                                this.processing = false
                                Inertia.get('/industry')
                            }
                            else {
                                toast.error(response.data.message)
                            }
                        })
                }
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

            axios.post("/industry/image-upload", formdata, {
                headers: {
                    "Content-Type": "multipart/form-data",
                }
            }).then((response) => {
                console.log(response.data.data.id)
                if (response.data.success) {
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
        if (route().current() == 'industry.edit') {
            this.isEdit = true;
        }
    }
});
</script>
<template>
    <Head :title="isEdit ? 'Edit Industry' : `Add New Industry`" />

    <AppLayout>
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/industry" class="text-muted text-hover-primary">Industry</Link>
            </li>
        </template>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div class="col-12">

                <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10"
                    enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>General</h2>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="row g-5">
                            <div class="col-4">
                                <div class="card p-6">
                                    <div class="fv-row">


                                        <ImageInput :image="this.industry?.data?.image?.medium_path"
                                            :onchange="onFileChange" :remove="removeSelectedAvatar" :selectedImage="url"
                                            :errors="v$.form.image.$errors" :isUploading="isUploading" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-8">
                                <div class="card p-6">
                                    <div class="fv-row mb-6">
                                        <jet-label for="name" value="Name" />
                                        <jet-input id="name" type="text" v-model="v$.form.name.$model" :class="v$.form.name.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Industry name" />
                                        <div v-for="(error, index) of v$.form.name.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                    <div class="fv-row">
                                        <jet-label for="status" value="Status" />
                                        <!-- {{ this.industry?.data?.status }} -->
                                        <Multiselect :options="status" label="name" valueProp="id"
                                            class="form-control form-control-lg form-control-solid" placeholder="Choose One"
                                            v-model="v$.form.status.$model" track-by="name" :class="v$.form.status.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                                " />
                                        <div v-for="(error, index) of v$.form.name.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <!--end::Variations-->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end text-align-center gap-2">

                                <Link href="/industry" class="btn btn-secondary    ">
                                Cancel
                                </Link>

                                <div>
                                    <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                                        :data-kt-indicator="processing ? 'on' : 'off'">
                                        <span v-if="route().current() == 'industry.edit'">Update</span>
                                        <span v-if="route().current() == 'industry.create'">Save</span>
                                        <span class="indicator-progress">
                                            Please wait... <span
                                                class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>
                                </div>
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
