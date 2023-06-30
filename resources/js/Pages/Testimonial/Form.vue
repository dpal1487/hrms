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
    props: ['testimonial'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                name: {
                    required,
                },
                testimonial: {
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
            editor: ClassicEditor,
            form: this.$inertia.form({
                id: this.testimonial?.data?.id || '',
                name: this.testimonial?.data?.name || '',
                is_published: this.testimonial?.data?.is_published || '',
                testimonial: this.testimonial?.data.testimonial || '',
            }),
            is_published: [
                { id: '1', name: 'Published' },
                { id: '0', name: 'Unpublished' },
            ]

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
        ClassicEditor
    },
    methods: {
        submit() {
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }
            this.v$.$touch();

            if (!this.v$.form.$invalid) {

                if (route().current() == 'testimonial.create') {
                    this.form.transform((data) => ({
                        ...data,
                    }))
                        .post(this.route("testimonial.store"), {
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
                if (route().current() == 'testimonial.edit') {
                    this.form.transform((data) => ({
                        ...data,
                    }))
                        .put(this.route('testimonial.update', this.form.id), {
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

    },
    created() {
        if (route().current() == 'testimonial.edit') {
            this.isEdit = true;
        }
    }
});
</script>
<template>
    <Head :title="isEdit ? 'Edit Testimonial' : `Add New Testimonial`" />

    <AppLayout title="Testimonial Form">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/testimonial" class="text-muted text-hover-primary">Testimonial</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <span class="text-muted">Testimonial Form</span>
            </li>
        </template>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div class="col-12">

                <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10"
                    enctype="multipart/form-data">
                    <div class="">
                        <div class="row g-5">

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
                            <div class="col-6">
                                <jet-label for="is_published" value="Published" />
                                <!-- {{ this.testimonial?.data?.is_published }} -->
                                <Multiselect :options="is_published" label="name" valueProp="id"
                                    class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                    v-model="v$.form.is_published.$model" track-by="name" :class="v$.form.is_published.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " />
                                <div v-for="(error, index) of v$.form.is_published.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>
                            <div class="fv-row col-12">
                                <jet-label for="testimonial" value="Testimonial" />
                                <ckeditor :editor="editor" v-model="v$.form.testimonial.$model"
                                    class="form-control form-control-solid" :class="v$.form.testimonial.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Text" />

                                <div v-for="(error, index) of v$.form.testimonial.$errors" :key="index">
                                    <input-error :message="error.$message" />
                                </div>
                            </div>


                        </div>
                    </div>
                    <!--end::Variations-->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end text-align-center gap-5">

                                <Link href="/testimonial" class="btn btn-outline-secondary">
                                Discard
                                </Link>

                                <div>
                                    <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                                        :data-kt-indicator="form.processing ? 'on' : 'off'">
                                        <span v-if="route().current() == 'testimonial.edit'">Save Changes</span>
                                        <span v-if="route().current() == 'testimonial.create'">Save</span>
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
