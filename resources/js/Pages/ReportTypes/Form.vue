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

export default defineComponent({
    props: ['page', 'metas'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                title: {
                    required,
                },
                heading: {
                    required,
                },
                meta: {
                    required,
                },
                status: {
                    required,
                }
            },
        };
    },
    data() {
        return {

            isEdit: false,
            requesting: false,
            form: this.$inertia.form({
                id: this.page?.data?.id || '',
                title: this.page?.data?.title || '',
                heading: this.page?.data?.heading || '',
                meta: this.page?.data?.meta?.id || '',
                status: this.page?.data?.status || '',
            }),
            status: [
                { value: '1', name: 'Active' },
                { value: '0', name: 'Inactive' },
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
    },
    methods: {

        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.requesting = true;
                this.form
                    .transform((data) => ({
                        ...data,
                    }))
                    .post(route().current() == 'page.create' ? this.route("page.store") : this.route('page.update', this.form.id),
                        {
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
                        })

            }
        },

    },
    created() {
        if (route().current() == 'page.edit') {
            this.isEdit = true;
        }
    }
});
</script>
<template>
    <Head :title="isEdit ? 'Edit Page' : `Add New Page`" />
    <AppLayout :title="isEdit ? 'Edit Page' : `Add New Page`">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/pages" class="text-muted text-hover-primary">Pages</Link>
            </li>
        </template>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div class="col-12">
                <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Page Form</h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-5 col-md-12 mb-4">
                                <div class="fv-row col-6">
                                    <jet-label for="title" value="Title" />
                                    <jet-input id="title" type="text" v-model="v$.form.title.$model" :class="v$.form.title.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Title" />
                                    <div v-for="(error, index) of v$.form.title.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="heading" value="Heading" />
                                    <jet-input id="heading" type="text" v-model="v$.form.heading.$model" :class="v$.form.heading.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Heading" />
                                    <div v-for="(error, index) of v$.form.heading.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="meta" value="meta" />
                                    <Multiselect :options="metas?.data" label="tag" valueProp="id"
                                        class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                        v-model="form.meta" track-by="name" :class="v$.form.meta.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " />
                                    <div v-for="(error, index) of v$.form.meta.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>

                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="status" value="Status" />
                                    <Multiselect :options="status" label="name" valueProp="value"
                                        class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                        v-model="form.status" track-by="name" :class="v$.form.status.$errors.length > 0
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
                    <!--end::Variations-->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-5">
                                <Link href="/pages"
                                    class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                                Discard
                                </Link>
                                <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                                    :data-kt-indicator="requesting ? 'on' : 'off'">
                                    <span class="indicator-label">
                                        <span v-if="route().current() == 'page.edit'">Save Changes</span>
                                        <span v-if="route().current() == 'page.create'">Save</span>
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
