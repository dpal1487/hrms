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
import ImageInput from '@/Components/ImageInput.vue';
import utils from "../utils.js";

export default defineComponent({
    props: ['faqs_category'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                image: {},
                title: { required },
                status: { required },
            },
        };
    },
    data() {
        return {
            title: 'FAQs Category',
            isEdit: false,
            faqs_category_upload: {
                isLoading: false,
                url: null,
            },
            requesting: false,
            form: this.$inertia.form({
                id: this.faqs_category?.data?.id || '',

                title: this.faqs_category?.data?.title || '',
                status: this.faqs_category?.data?.status ? 0 : 1,
                image_id: this.form?.image_id || this.faqs_category?.data?.image?.id,
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
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.form
                    .transform((data) => ({
                        ...data,
                    }))
                    .post(route().current() == 'faqs-category.create' ? this.route("faqs-category.store") : this.route('faqs-category.update', this.form.id), {
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
        async onfaqs_categoryChange(e) {
            this.faqs_category_upload.isLoading = true;
            const data = await utils.imageUpload(route('upload.faqs_category'), e)
            if (data.response.success) {
                this.form.image_id = data.response.data.id;
            } else {
                toast.error(data.response.message);
            }
            this.faqs_category_upload.url = URL.createObjectURL(data.file);

            this.faqs_category_upload.isLoading = false;
        },

        removeSelectedAvatar() {
            this.faqs_category_upload.url = null;
        }

    },
    created() {
        if (route().current() == 'faqs_category.edit') {
            this.isEdit = true;
        }
    }
});
</script>
<template>
    <Head :title="isEdit ? 'Edit FAQs Category' : `Add New FAQs Category`" />
    <AppLayout :title="title">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/faqs-categories" class="text-muted text-hover-primary">FAQs Category</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <span class="text-muted">FAQs Category</span>
            </li>
        </template>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div class="col-12">
                <form @submit.prevent="submit()" class="form d-flex flex-column flex-lg-row">
                    <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">

                        <div class="card">
                            <div class="card-header mb-5">
                                <div class="card-title">
                                    <h2>FAQs Category Image </h2>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <ImageInput :image="this.faqs_category?.data?.image?.medium_path"
                                    :onchange="onfaqs_categoryChange" :remove="removeSelectedAvatar"
                                    :selectedImage="faqs_category_upload?.url" :errors="v$.form.image.$errors"
                                    :isUploading="faqs_category_upload?.isLoading" />
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>FAQs Category Form</h2>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-5">
                                    <div class="col-6">
                                        <jet-label for="title" value="FAQs Category Title" />
                                        <jet-input id="title" type="text" v-model="v$.form.title.$model" :class="v$.form.title.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="FAQs Category Title" />
                                        <div v-for="(error, index) of v$.form.title.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                    <div class="col-6">
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
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-5">
                            <Link href="/faqs-categories"
                                class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                            Discard
                            </Link>
                            <button type="submit" class="btn btn-primary" :class="{ 'text-white-50': form.processing }">
                                <div v-show="form.processing" class="spinner-border spinner-border-sm">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <span v-if="route().current() == 'faqs-category.edit'">Update</span>
                                <span v-if="route().current() == 'faqs-category.create'">Save</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
