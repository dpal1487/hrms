<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import { toast } from "vue3-toastify";
import ImageInput from '@/Components/ImageInput.vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import utils from "../utils.js";
import DropFile from "@/Components/DropFile.vue";

export default defineComponent({
    props: ['category', 'category_parent'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                thumbnail: {},
                banner_image: { required },
                name: { required },
                parent_id: {},
                description: {},
                keyword: { required },
                meta_tag: { required },
                meta_description: {},
                meta_keyword: { required },
            },
        };
    },
    data() {
        return {
            isEdit: false,
            thumbnail: {
                isLoading: false,
                url: null,
            },
            banner: {
                isLoading: false,
                url: null,
            },
            editor: ClassicEditor,
            requesting: false,
            form: this.$inertia.form({
                id: this.category?.data?.id || '',
                name: this.category?.data?.name || '',
                image_id: this.category?.data?.image?.id ? this.category?.data?.image?.id : this.form?.image_id,
                status: this.category?.data?.status || '',
                banner_image: this.category?.data?.banner?.id ? this.category?.data?.banner?.id : this.form?.banner_image,
                parent_id: this.category?.data?.parent?.id || '',
                description: this.category?.data?.description || '',
                keyword: this.category?.data?.keywords || '',
                meta_tag: this.category?.data?.meta?.tag || '',
                meta_description: this.category?.data?.meta?.description || '',
                meta_keyword: this.category?.data?.meta?.keywords || '',
                add_more: false,
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
        DropFile
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.form
                    .transform((data) => ({
                        ...data,
                    }))
                    .post(route().current() == 'category.create' ? this.route("category.store") : this.route('category.update', this.form.id), {
                        onSuccess: (data) => {
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
        async onThumbnailChange(e) {
            this.thumbnail.isLoading = true;
            const data = await utils.imageUpload(route('category.thumbnail'), e, this.form.image_id)

            if (data.response.success) {
                this.form.image_id = data.response.data.id;
            } else {
                toast.error(data.response.message);
            }

            this.thumbnail.url = URL.createObjectURL(data.file);

            this.thumbnail.isLoading = false;
        },

        async onBannerChange(files) {
            this.banner.isLoading = true;
            const data = await utils.imageUpload(route('category.banner'), files, this.form.banner_image)
            if (data.response.success) {
                this.form.banner_image = data.response.data.id;
            } else {
                toast.error(data.response.message);
            }
            this.banner.url = URL.createObjectURL(data.file);

            this.banner.isLoading = false;
        },

        removeSelectedAvatar() {
            this.url = null;
        }

    },
    created() {
        if (route().current() == 'category.edit') {
            this.isEdit = true;
        }
    }
});
</script>
<template>
    <Head :title="isEdit ? 'Edit category' : `Add New category`" />
    <AppLayout title="Category Form">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/categories" class="text-muted text-hover-primary"> Categories</Link>
            </li>
        </template>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div class="col-12">
                <form @submit.prevent="submit()" class="form d-flex flex-column flex-lg-row">
                    <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                        <div class="card">
                            <div class="card-header mb-5">
                                <div class="card-title">
                                    <h2>Thumbnail</h2>
                                </div>
                            </div>

                            <div class="card-body text-center">
                                <ImageInput :image="this.category?.data?.image?.small_path" :onchange="onThumbnailChange"
                                    :remove="removeSelectedAvatar" :selectedImage="thumbnail.url"
                                    :errors="v$.form.thumbnail.$errors" :isUploading="thumbnail.isLoading" />
                            </div>
                        </div>

                    </div>
                    <div class="d-flex flex-column flex-row-fluid gap-5">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Category</h2>
                                </div>
                            </div>
                            <div class="card-body pt-5">
                                <div class="row mb-5">
                                    <div class="col-6">
                                        <jet-label for="name" value="Name" />
                                        <jet-input id="name" type="text" v-model="v$.form.name.$model" :class="v$.form.name.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Name" />
                                        <div v-for="(error, index) of v$.form.name.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                    <div class="col-6 mb-5">
                                        <jet-label for="department_id" value="Category Parent" />
                                        <Multiselect :can-clear="false" :options="category_parent?.data" label="name"
                                            valueProp="id" class="form-control form-control-lg form-control-solid"
                                            placeholder="Select Category" v-model="v$.form.parent_id.$model" track-by="name"
                                            :searchable="true" />
                                        <div v-for="(error, index) of v$.form.parent_id.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                    <div class="">
                                        <jet-label for="keywords" value="Keyword" />
                                        <jet-input id="keywords" type="text" v-model="v$.form.keyword.$model" :class="v$.form.keyword.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Keyword" />
                                        <div v-for="(error, index) of v$.form.keyword.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                </div>
                                <div class="fv-row mb-5">
                                    <jet-label for="description" value="Description" />
                                    <ckeditor :editor="editor" v-model="v$.form.description.$model"
                                        class="form-control form-control-solid" :class="v$.form.description.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Text" />
                                </div>

                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Meta Options</h2>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-5">
                                    <div class="col-6">
                                        <jet-label for="meta_tag" value="Tag" />
                                        <jet-input id="meta_tag" type="text" v-model="v$.form.meta_tag.$model" :class="v$.form.meta_tag.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Tag" />
                                        <div v-for="(error, index) of v$.form.meta_tag.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <jet-label for="keywords" value="Keyword" />
                                        <jet-input id="keywords" type="text" v-model="v$.form.meta_keyword.$model" :class="v$.form.meta_keyword.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Keywords" />
                                        <div v-for="(error, index) of v$.form.meta_keyword.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                </div>
                                <div class="fv-row mb-5">
                                    <jet-label for="description" value="Description" />
                                    <ckeditor id="description" :editor="editor" v-model="v$.form.meta_description.$model"
                                        class="form-control form-control-solid" :class="v$.form.meta_description.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Text" />
                                </div>
                                <div class="form-check" v-if="route().current() == 'category.create'">
                                    <input class="form-check-input" type="checkbox" id="new-link" v-model="form.add_more" />
                                    <label class="form-check-label" for="new-link">
                                        Add More Category
                                    </label>
                                </div>


                            </div>
                        </div>

                        <div class="card">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Banner Image </h2>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-5">
                                <!--begin::Input group-->
                                <div class="fv-row mb-2">
                                    <DropFile :image="this.category?.data?.banner?.file_path"
                                        :isUploading="banner.isLoading" @change="onBannerChange" />
                                </div>
                                <!--end::Input group-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7 mx-2">Set the category banner image.</div>
                                <!--end::Description-->
                            </div>
                            <!--end::Card header-->
                        </div>

                        <div class="d-flex justify-content-end gap-5">
                            <Link href="/categories"
                                class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                            Discard
                            </Link>
                            <button type="submit" class="btn btn-primary" :class="{ 'text-white-50': form.processing }">
                                <div v-show="form.processing" class="spinner-border spinner-border-sm">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <span v-if="route().current() == 'category.edit'">Update</span>
                                <span v-if="route().current() == 'category.create'">Save</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
