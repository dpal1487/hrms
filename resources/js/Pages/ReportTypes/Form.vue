<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import { toast } from "vue3-toastify";

export default defineComponent({
    props: ['report_type'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                title: {
                    required,
                },
                description: {
                    required,
                }
            },
        };
    },
    data() {
        return {

            isEdit: false,
            form: this.$inertia.form({
                id: this.report_type?.data?.id || '',
                title: this.report_type?.data?.title || '',
                description: this.report_type?.data?.description || '',
            }),
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        JetInput,
        JetLabel,
        InputError,
    },
    methods: {

        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.form
                    .transform((data) => ({
                        ...data,
                    }))
                    .post(route().current() == 'report-type.create' ? this.route("report-type.store") : this.route('report-type.update', this.form.id),
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

    },
    created() {
        if (route().current() == 'report-type.edit') {
            this.isEdit = true;
        }
    }
});
</script>
<template>
    <Head :title="isEdit ? 'Edit Report Type' : `Add New Report Type`" />
    <AppLayout :title="isEdit ? 'Edit Report Type' : `Add New Report Type`">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/report-types" class="text-muted text-hover-primary">Report Types</Link>
            </li>
        </template>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div class="col-12">
                <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-5">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Report Type Form</h2>
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
                            </div>
                            <div class="row mb-5">
                                <jet-label for="descriptions" value="Description" />
                                <div class="">
                                    <textarea id=" descriptions" v-model="v$.form.description.$model"
                                        class="form-control form-control-solid" :class="v$.form.description.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Text ..." />
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-5">
                                <Link href="/report-types"
                                    class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                                Discard
                                </Link>
                                <button type="submit" class="btn btn-primary" :class="{ 'text-white-50': form.processing }">
                                    <div v-show="form.processing" class="spinner-border spinner-border-sm">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <span v-if="route().current() == 'report-type.edit'">Update</span>
                                    <span v-if="route().current() == 'report-type.create'">Save</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
