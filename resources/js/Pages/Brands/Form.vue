<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required, url } from "@vuelidate/validators";
import { toast } from "vue3-toastify";
import ImageInput from '@/components/ImageInput.vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import utils from "../utils.js";

export default defineComponent({
    props: ['brand', 'categories'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                image: {},
                name: { required },
                category: { required },
                status: { required },
                description: {},
            },
        };
    },
    data() {
        return {
            title: 'brand',
            isEdit: false,
            brand_upload: {
                isLoading: false,
                url: null,
            },
            editor: ClassicEditor,
            requesting: false,
            form: this.$inertia.form({
                id: this.brand?.data?.id || '',
                image: this.brand?.data?.image?.medium_path || '',
                name: this.brand?.data?.name || '',
                description: this.brand?.data?.description || '',
                status: this.brand?.data?.status ? 1 : 0,
                category: this.brand?.data?.category?.id || '',
                brand_image: this.form?.brand_image || '',
            }),
            status: [
                { value: 1, label: 'Active', },
                { value: 0, label: 'Inactive', },
            ],
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        Multiselect,
        JetInput,
        JetLabel,
        InputError,
        ImageInput,
        ClassicEditor,
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.form
                    .transform((data) => ({
                        ...data,
                    }))
                    .post(route().current() == 'brand.create' ? this.route("brand.store") : this.route('brand.update', this.form.id), {
                        onSuccess: (data) => {
                            console.log(data);
                            toast.success(this.$page.props.jetstream.flash.message);
                            this.isEdit = false;
                        },
                        onError: (data) => {
                            if (data.message) {
                                toast.error(data.message);
                            }
                        },
                    });
            }
        },
        async onbrandChange(e) {
            this.brand_upload.isLoading = true;
            const data = await utils.imageUpload(route('upload.brand'), e)
            if (data.response.success) {
                this.form.brand_image = data.response.data.id;
            } else {
                toast.error(data.response.message);
            }
            this.brand_upload.url = URL.createObjectURL(data.file);

            this.brand_upload.isLoading = false;
        },

        removeSelectedAvatar() {
            this.brand_upload.url = null;
        }

    },
    created() {
        if (route().current() == 'brand.edit') {
            this.isEdit = true;
        }
    }
});
</script>
<template>
    <Head :title="isEdit ? 'Edit brand' : `Add New brand`" />
    <AppLayout :title="isEdit ? 'Edit brand' : `Add New brand`">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/brands" class="text-muted text-hover-primary">Brands</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <span class="text-muted text-hover-primary">Brand</span>
            </li>
        </template>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div class="col-12">
                <form @submit.prevent="submit()" class="form d-flex flex-column flex-lg-row">
                    <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">

                        <!--begin::brand settings-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header mb-5">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>Brand Image </h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body text-center pt-0">
                                <!--begin::Image input-->
                                <ImageInput :image="this.brand?.data?.image?.medium_path" :onchange="onbrandChange"
                                    :remove="removeSelectedAvatar" :selectedImage="brand_upload?.url"
                                    :errors="v$.form.image.$errors" :isUploading="brand_upload?.isLoading" />
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Thumbnail settings-->
                    </div>
                    <!--end::Aside column-->
                    <!--begin::Main column-->
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <!--begin::General options-->

                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>General</h2>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body">
                                <!--begin::Input group-->
                                <div class="row col-10 mb-5">
                                    <!--begin::Label-->
                                    <jet-label for="name" value="brand Name" />
                                    <jet-input id="name" type="text" v-model="v$.form.name.$model" :class="v$.form.name.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="brand Name" />
                                    <div v-for="(error, index) of v$.form.name.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row ">
                                    <div class="col-6 mb-5">
                                        <jet-label for="category" value="Category" class="required" />
                                        <Multiselect :options="categories?.data" label="name" valueProp="id"
                                            class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                            v-model="v$.form.category.$model" track-by="label" :class="v$.form.category.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                                " />
                                        <div v-for="(error, index) of v$.form.category.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                    <!--begin::Label-->

                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="col-6 mb-5">
                                        <jet-label value="Status" class="required" />
                                        <Multiselect :options="status" label="label" valueProp="value"
                                            class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                            v-model="v$.form.status.$model" :class="v$.form.status.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                                " />
                                        <div v-for="(error, index) of v$.form.status.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                        <!--begin::Label-->
                                    </div>
                                </div>
                                <!--end::Input group-->
                                <div class="row mb-5">
                                    <jet-label for="description" value="Description" />
                                    <ckeditor id="description" :editor="editor" v-model="v$.form.description.$model"
                                        class="form-control form-control-solid" :class="v$.form.description.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Text ..." />

                                </div>
                                <!--end::Input group-->

                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::Meta options-->
                        <div class="d-flex justify-content-end gap-5">
                            <Link href="/brands"
                                class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                            Discard
                            </Link>
                            <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                                :data-kt-indicator="form.processing ? 'on' : 'off'">
                                <span class="indicator-label">

                                    <span v-if="route().current() == 'brand.edit'">Save Changes</span>
                                    <span v-if="route().current() == 'brand.create'">Save</span>
                                </span>
                                <span class="indicator-progress">
                                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                            <!--end::Button-->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
