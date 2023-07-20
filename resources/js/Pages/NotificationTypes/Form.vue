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
    props: ['notification_type'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                label: {
                    required,
                },
                description: {
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
                id: this.notification_type?.data?.id || '',
                label: this.notification_type?.data?.label || '',
                description: this.notification_type?.data?.description || '',
                status: this.notification_type?.data?.status || '',
            }),
            status: [
                {
                    value: '1',
                    name: 'Active'
                },
                {
                    value: '0',
                    name: 'Inactive'
                },
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
                    .post(route().current() == 'notification-type.create' ? this.route("notification-type.store") : this.route('notification-type.update', this.form.id),
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
        if (route().current() == 'notification-type.edit') {
            this.isEdit = true;
        }
    }
});
</script>
<template>
    <Head :title="isEdit ? 'Edit Notification' : `Add New Notification`" />
    <AppLayout :title="isEdit ? 'Edit Notification' : `Add New Notification`">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/notification-types" class="text-muted text-hover-primary">Notification Types</Link>
            </li>
        </template>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div class="col-12">
                <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Notification Form</h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-5 col-md-12 mb-4">
                                <div class="fv-row col-6">
                                    <jet-label for="label" value="Label" />
                                    <jet-input id="label" type="text" v-model="v$.form.label.$model" :class="v$.form.label.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Label" />
                                    <div v-for="(error, index) of v$.form.label.$errors" :key="index">
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
                            <div class="row mb-5">
                                <jet-label for="descriptions" value="Description" />
                                <div class="">
                                    <textarea id=" descriptions" :editor="editor" v-model="v$.form.description.$model"
                                        class="form-control form-control-solid" :class="v$.form.description.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Text ..." />
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--end::Variations-->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-5">
                                <Link href="/notification-types"
                                    class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                                Discard
                                </Link>
                                <button type="submit" class="btn btn-primary" :class="{ 'text-white-50': form.processing }">
                                    <div v-show="form.processing" class="spinner-border spinner-border-sm">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <span v-if="route().current() == 'notification-type.edit'">Update</span>
                                    <span v-if="route().current() == 'notification-type.create'">Save</span>
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
