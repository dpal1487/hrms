<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import ImageInput from '@/Components/ImageInput.vue';
import { required } from "@vuelidate/validators";
import { toast } from "vue3-toastify";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

export default defineComponent({

    props: ['blog'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                title: {
                    required,
                },
                image: {
                },
                content: {
                    required,
                },
                is_published: {
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
                id: this.blog?.data?.id || '',
                title: this.blog?.data?.title || '',
                is_published: this.blog?.data?.is_published || '',
                image_id: this.blog?.data?.image?.id || '',
                content: this.blog?.data.content || '',
            }),
            url: null,
            value: null,
            is_published: [
                { id: '1', name: 'Published' },
                { id: '0', name: 'Unpublished' },
            ],
            editor: ClassicEditor,

        }
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

        ClassicEditor
    },
    methods: {
        submit() {
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                if (route().current() == 'blog.create') {
                    this.form
                    this.form.transform((data) => ({
                        ...data,
                    }))
                        .post(this.route("blog.store"), {
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
                if (route().current() == 'blog.edit') {
                    this.form.put(this.route('blog.update', this.form.id), {
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

            axios.post("/blog/image-upload", formdata, {
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
        if (route().current() == 'blog.edit') {
            this.isEdit = true;
        }
    }
});
</script>
<template>
    <Head :title="isEdit ? 'Edit Blog' : `Add New Blog`" />

    <AppLayout title="Blog Form">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/blog" class="text-muted text-hover-primary">Blog</Link>
            </li>
        </template>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div class="col-12">

                <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10"
                    enctype="multipart/form-data">
                    <div class="card">
                        <!-- <div class="card-header">
                            <div class="card-title">
                                <h2>blog Form</h2>
                            </div>
                        </div> -->
                    </div>
                    <div class="card body">
                        <div class="row g-5">
                            <div class="col-4">
                                <div class="card p-6">
                                    <div class="fv-row">
                                        <ImageInput :image="this.blog?.data?.image?.medium_path" :onchange="onFileChange"
                                            :remove="removeSelectedAvatar" :selectedImage="url"
                                            :errors="v$.form.image.$errors" :isUploading="isUploading" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-8">
                                <div class="card p-6">
                                    <div class="fv-row mb-6">
                                        <jet-label for="title" value="Blog Title" />
                                        <jet-input id="title" type="text" v-model="v$.form.title.$model" :class="v$.form.title.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Blog Title" />
                                        <div v-for="(error, index) of v$.form.title.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                    <div class="fv-row">
                                        <jet-label for="is_published" value="Is Published" />
                                        <!-- {{ this.blog?.data?.is_published }} -->
                                        <Multiselect :options="is_published" label="name" valueProp="id"
                                            class="form-control form-control-lg form-control-solid" placeholder="Choose One"
                                            v-model="v$.form.is_published.$model" track-by="name" :class="v$.form.is_published.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                                " />
                                        <div v-for="(error, index) of v$.form.is_published.$errors" :key="index">
                                            <input-error :message="error.$message" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row col-12">
                                <jet-label for="content" value="Content" />
                                <ckeditor :editor="editor" v-model="v$.form.content.$model"
                                    class="form-control form-control-solid" :class="v$.form.content.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Text" />

                                <div v-for="(error, index) of v$.form.content.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>


                        </div>
                    </div>
                    <!--end::Variations-->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end text-align-center gap-5">

                                <Link href="/blog" class="btn btn-outline-secondary">
                                Discard
                                </Link>

                                <div>
                                    <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                                        :data-kt-indicator="form.processing ? 'on' : 'off'">
                                        <span v-if="route().current() == 'blog.edit'">Save Changes</span>
                                        <span v-if="route().current() == 'blog.create'">Save</span>
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
