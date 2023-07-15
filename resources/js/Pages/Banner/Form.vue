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
import Loading from "vue-loading-overlay";
import 'vue-loading-overlay/dist/css/index.css';
import utils from "../utils.js";

export default defineComponent({
    props: ['banner'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                image: {},
                title: { required },
                url: { required, url },
                description: { required },
            },
        };
    },
    data() {
        return {
            title: 'Banner',
            isEdit: false,
            banner_upload: {
                isLoading: false,
                url: null,
            },
            editor: ClassicEditor,
            form: this.$inertia.form({
                id: this.banner?.data?.id || '',
                title: this.banner?.data?.title || '',
                description: this.banner?.data?.description || '',
                url: this.banner?.data?.url || '',
                banner_image: this.banner?.data?.image?.id ? this.banner?.data?.image?.id : this.form?.banner_image,
            }),
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
        Loading
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.form
                    .transform((data) => ({
                        ...data,
                    }))
                    .post(route().current() == 'banner.create' ? this.route("banner.store") : this.route('banner.update', this.form.id),
                        {
                            onSuccess: (data) => {
                                toast.success(this.$page.props.jetstream.flash.message);
                                this.isEdit = false;
                            },
                            onError: (data) => {
                                toast.error(data.message);
                            },
                        });
            }
        },

        async onBannerChange(e) {
            this.banner_upload.isLoading = true;
            const data = await utils.imageUpload(route('upload.banner'), e)
            if (data.response.success) {

                this.form.banner_image = data.response.data.id;
            } else {
                toast.error(data.response.message);
            }
            this.banner_upload.url = URL.createObjectURL(data.file);

            this.banner_upload.isLoading = false;
        },

        removeSelectedAvatar() {
            this.banner_upload.url = null;
        }

    },
    created() {
        if (route().current() == 'banner.edit') {
            this.isEdit = true;
        }
    }
});

</script>
<template>
    <Head :title="isEdit ? 'Edit Banner' : `Add New Banner`" />
    <AppLayout :title="isEdit ? 'Edit Banner' : `Add New Banner`">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/banners" class="text-muted text-hover-primary">Banners</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <span class="text-muted text-hover-primary">Banner Form</span>
            </li>
        </template>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div class="col-12">
                <form @submit.prevent="submit()" class="form d-flex flex-column flex-lg-row">
                    <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">

                        <!--begin::Banner settings-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header mb-5">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>Banner Image </h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body text-center pt-0">
                                <!--begin::Image input-->
                                <ImageInput :image="this.banner?.data?.image?.medium_path" :onchange="onBannerChange"
                                    :remove="removeSelectedAvatar" :selectedImage="banner_upload?.url"
                                    :errors="v$.form.image.$errors" :isUploading="banner_upload?.isLoading" />
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
                                    <jet-label for="title" value="Banner Name" />
                                    <jet-input id="title" type="text" v-model="v$.form.title.$model" :class="v$.form.title.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Banner Name" />
                                    <div v-for="(error, index) of v$.form.title.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row col-10 mb-5">
                                    <jet-label for="url" value="Banner URL" />
                                    <jet-input id="url" type="text" v-model="v$.form.url.$model" :class="v$.form.url.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Banner URL" />
                                    <div v-for="(error, index) of v$.form.url.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                    <!--begin::Label-->
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
                            <Link href="/banners"
                                class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                            Discard
                            </Link>
                            <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                                :data-kt-indicator="form.processing ? 'on' : 'off'">
                                <span class="indicator-label">

                                    <span v-if="route().current() == 'banner.edit'">Save Changes</span>
                                    <span v-if="route().current() == 'banner.create'">Save</span>
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
