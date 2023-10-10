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
    props: ['general'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                site_title: {
                    required,
                },
                value: {
                    required,
                },
                auto_load: {

                }
            },
        };
    },
    data() {
        return {
            isEdit: false,
            requesting: false,
            form: this.$inertia.form({
                id: this.general?.data?.id || '',
                site_title: this.general?.data?.option_name || '',
                value: this.general?.data?.value || '',
                auto_load: this.general?.data?.auto_load || '',
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
                this.requesting = true;
                this.form
                    .transform((data) => ({
                        ...data,
                    }))
                    .post(route().current() == 'general.create' ? this.route("general.store") : this.route('general.update', this.form.id),
                        {
                            onSuccess: (data) => {
                                toast.success(this.$page.props.jetstream.flash.message);
                                this.requesting = false;
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
        if (route().current() == 'general.edit') {
            this.isEdit = true;
        }
    }
});
</script>
<template>
    <Head :title="isEdit ? 'Edit General' : `Add New General`" />
    <AppLayout :title="isEdit ? 'Edit General' : `Add New General`">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/generals" class="text-muted text-hover-primary">Generals</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <span class="text-muted">General Form</span>
            </li>
        </template>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div class="col-12">
                <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>General Form</h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-5 col-md-12 mb-4">
                                <div class="fv-row col-6">
                                    <jet-label value="Site Title" />
                                    <jet-input type="text" v-model="v$.form.site_title.$model" :class="v$.form.site_title.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Site Title" />
                                    <div v-for="(error, index) of v$.form.site_title.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label value="Value" />
                                    <jet-input type="text" v-model="v$.form.value.$model" :class="v$.form.value.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Value" />
                                    <div v-for="(error, index) of v$.form.value.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="fv-row m-5">
                                    <jet-label for="title" value="Auto Load " />
                                    <div class="form-switch form-check-solid d-block form-check-custom form-check-success">
                                        <input class="form-check-input h-30px w-50px" type="checkbox"
                                            :checked="general?.auto_load == 1 ? true : false"
                                            v-model="v$.form.auto_load.$model" />
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-5">
                                <Link href="/generals"
                                    class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                                Discard
                                </Link>
                                <button type="submit" class="btn btn-primary" :class="{ 'text-white-50': form.processing }">
                                    <div v-show="form.processing" class="spinner-border spinner-border-sm">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <span v-if="route().current() == 'general.edit'">Update</span>
                                    <span v-if="route().current() == 'general.create'">Save</span>
                                </button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
