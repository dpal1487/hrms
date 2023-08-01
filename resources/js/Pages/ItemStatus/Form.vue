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
    props: ['item_status'],
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
                text: {
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
                id: this.item_status?.data?.id || '',
                label: this.item_status?.data?.label || '',
                description: this.item_status?.data?.description || '',
                text: this.item_status?.data?.text || '',
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
                    .post(route().current() == 'item-status.create' ? this.route("item-status.store") : this.route('item-status.update', this.form.id),
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
        if (route().current() == 'item-status.edit') {
            this.isEdit = true;
        }
    }
});
</script>
<template>
    <Head :title="isEdit ? 'Edit Item Status' : `Add New Item Status`" />
    <AppLayout :title="isEdit ? 'Edit Item Status' : `Add New Item Status`">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/item-status" class="text-muted text-hover-primary">Item Status</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <span class="text-muted">Item Status Form</span>
            </li>
        </template>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div class="col-12">
                <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Item Status Form</h2>
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
                                    <jet-label for="text" value="Text" />
                                    <jet-input id="text" type="text" v-model="v$.form.text.$model" :class="v$.form.text.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Text" />
                                    <div v-for="(error, index) of v$.form.text.$errors" :key="index">
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
                                <Link href="/item-status"
                                    class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                                Discard
                                </Link>
                                <button type="submit" class="btn btn-primary" :class="{ 'text-white-50': form.processing }">
                                    <div v-show="form.processing" class="spinner-border spinner-border-sm">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <span v-if="route().current() == 'item-status.edit'">Update</span>
                                    <span v-if="route().current() == 'item-status.create'">Save</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
