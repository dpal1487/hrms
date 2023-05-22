<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import PrimaryButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";


import axios from "axios";
import { toast } from "vue3-toastify";
import { Inertia } from "@inertiajs/inertia";

export default defineComponent({
    props: ['plan', 'message'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                name: {
                    required,
                },
                description: {
                    required,
                },
                status: {
                    required,
                },
                price: {
                    required,
                },
                sort_order: {
                    required,
                },
                stripe_id: {
                    required,
                },
                currency: {
                    required,
                }
            },
        };
    },
    data() {
        return {

            isEdit: false,
            processing: false,
            form: this.$inertia.form({
                id: this.plan?.data?.id || '',
                name: this.plan?.data?.name || '',
                description: this.plan?.data?.description || '',
                status: this.plan?.data?.status || '',
                price: this.plan?.data?.price || '',
                stripe_id: this.plan?.data?.stripe_id || '',
                currency: this.plan?.data?.currency || '',
                sort_order: this.plan?.data?.sort_order || '',
            }),
            status: [
                { id: '1', name: 'Active' },
                { id: '0', name: 'Inactive' },
            ]
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        Multiselect,
        PrimaryButton,
        JetInput,
        JetLabel,
        InputError,
        JetValidationErrors
    },
    methods: {

        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.processing = true
                if (route().current() == 'plan.create') {
                    axios.post(this.route("plan.store"), this.form)
                        .then((response) => {
                            if (response.data.success) {
                                toast.success(response.data.message)
                                this.processing = false
                                Inertia.get('/plan')

                            } else {
                                toast.warning(response.data.message)
                            }
                            if (response.data.error) {
                                toast.error(response.data.error)
                            }
                        })
                } else {
                    axios.put(this.route('plan.update', this.form.id), this.form)
                        .then((response) => {
                            if (response.data.success) {
                                toast.success(response.data.message)
                                this.processing = false;
                                Inertia.get('/plan')
                            } else {
                                toast.error(response.data.message)
                            }

                        }).catch((error) => {
                            if (error.response.status == 400) {
                                toast.error(error.response.data.message);
                            }
                        });
                }
            }
        },

    },
    created() {
        if (route().current() == 'plan.edit') {
            this.isEdit = true;
        }
    }
});
</script>
<template>
    <Head title="Plan" />
        <AppLayout title="Plan">

        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div class="col-12">
                <JetValidationErrors />
                <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Plan </h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex gap-5 flex-column flex-sm-row mb-5 col-12">
                                <div class="w-100 w-sm-50">
                                    <jet-label for="name" value="Name" />
                                    <jet-input id="name" type="text" v-model="v$.form.name.$model" :class="v$.form.name.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Name" />
                                    <div v-for="(error, index) of v$.form.name.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>

                                <div class="w-100 w-sm-50">
                                    <jet-label for="price" value="Price" />

                                    <jet-input id="price" type="text" v-model="v$.form.price.$model" :class="v$.form.price.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Price" />
                                    <div v-for="(error, index) of v$.form.price.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex gap-5 flex-column flex-sm-row mb-5 col-12">
                                <div class="w-100 w-sm-50">
                                    <jet-label for="currency" value="Currency" />
                                    <jet-input id="currency" type="text" v-model="v$.form.currency.$model" :class="v$.form.currency.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Currency" />
                                    <div v-for="(error, index) of v$.form.currency.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="w-100 w-sm-50">
                                    <jet-label for="sort_order" value="Sort Order" />
                                    <jet-input id="sort_order" type="text" v-model="v$.form.sort_order.$model" :class="v$.form.sort_order.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Sort Order" />
                                    <div v-for="(error, index) of v$.form.sort_order.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex gap-5 flex-column flex-sm-row mb-5 col-12">
                                <div class="w-100 w-sm-50">
                                    <jet-label for="description" value="Strip ID" />
                                    <jet-input id="strip_id" type="text" v-model="v$.form.stripe_id.$model" :class="v$.form.stripe_id.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Strip ID" />
                                    <div v-for="(error, index) of v$.form.stripe_id.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>

                                <div class="w-100 w-sm-50">
                                    <jet-label for="status" value="Status" />
                                    <Multiselect :options="status" label="name" valueProp="id"
                                        class="form-control form-control-lg form-control-solid" placeholder="Choose One"
                                        v-model="v$.form.status.$model" track-by="name" :class="v$.form.status.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " />
                                    <div v-for="(error, index) of v$.form.name.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex gap-5 flex-column flex-sm-row mb-5 col-12">
                                <div class="w-100">
                                    <jet-label for="description" value="Description" />
                                    <jet-input id="description" type="text" v-model="v$.form.description.$model" :class="v$.form.description.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Description" />
                                    <div v-for="(error, index) of v$.form.description.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Variations-->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <Link href="/plan"
                                    class="btn btn-secondary d-flex align-items-center justify-content-center">
                                Cancel
                                </Link>

                                <button type="submit" class="btn btn-primary align-items-center justify-content-center"
                                    :data-kt-indicator="processing ? 'on' : 'off'">
                                    <span class="indicator-label">
                                        <span v-if="route().current() == 'plan.edit'">Update</span>
                                        <span v-if="route().current() == 'plan.create'">Save</span>
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
