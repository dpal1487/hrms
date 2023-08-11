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
            const data = await utils.imageUpload(route('upload.banner'), e, this.form.banner_image)
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
                <span class="text-muted">Banner Form</span>
            </li>
        </template>

        <form @submit.prevent="submit()" class="form d-flex flex-column flex-lg-row gap-5">
            <div class="d-flex flex-column flex-row-fluid">
                <div class="card">
                    <div class="card-header mb-5">
                        <div class="card-title">
                            <h2>Banner Image </h2>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <ImageInput :image="banner?.data?.image?.small_path" :onchange="onBannerChange"
                            :remove="removeSelectedAvatar" :selectedImage="banner_upload?.url"
                            :errors="v$.form.image.$errors" :isUploading="banner_upload?.isLoading" />
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column flex-row-fluid gap-5">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>General</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="fv-row col-10 mb-5">
                            <jet-label for="title" value="Banner Name" />
                            <jet-input id="title" type="text" v-model="v$.form.title.$model" :class="v$.form.title.$errors.length > 0
                                ? 'is-invalid'
                                : ''
                                " placeholder="Banner Name" />
                            <div v-for="(error, index) of v$.form.title.$errors" :key="index">
                                <input-error :message="error.$message" />
                            </div>
                        </div>
                        <div class="fv-row col-10 mb-5">
                            <jet-label for="url" value="Banner URL" />
                            <jet-input id="url" type="text" v-model="v$.form.url.$model" :class="v$.form.url.$errors.length > 0
                                ? 'is-invalid'
                                : ''
                                " placeholder="Banner URL" />
                            <div v-for="(error, index) of v$.form.url.$errors" :key="index">
                                <input-error :message="error.$message" />
                            </div>
                        </div>
                        <div class="fv-row mb-5">
                            <jet-label for="description" value="Description" />
                            <textarea id="description" v-model="v$.form.description.$model"
                                class="form-control form-control-solid" :class="v$.form.description.$errors.length > 0
                                    ? 'is-invalid'
                                    : ''
                                    " placeholder="Text ..." />

                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-5">
                    <Link href="/banners"
                        class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                    Discard
                    </Link>
                    <button type="submit" class="btn btn-primary" :class="{ 'text-white-50': form.processing }">
                        <div v-show="form.processing" class="spinner-border spinner-border-sm">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span v-if="route().current() == 'banner.edit'">Update</span>
                        <span v-if="route().current() == 'banner.create'">Save</span>
                    </button>
                </div>
            </div>
        </form>
    </AppLayout>
</template>
