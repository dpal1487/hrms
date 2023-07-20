<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import useVuelidate from "@vuelidate/core";
import { required, integer } from "@vuelidate/validators";
import { toast } from "vue3-toastify";
import { Inertia } from "@inertiajs/inertia";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

export default defineComponent({
    props: ['coupon'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                code: {
                    required,
                },
                description: {
                    required,
                },
                type: {
                    required,
                },
                discount: {
                    required, integer,
                },
                expires: {
                    required,
                }

            },
        };
    },
    data() {
        return {
            editor: ClassicEditor,

            isEdit: false,
            requesting: false,
            form: this.$inertia.form({
                id: this.coupon?.data?.id || '',
                code: this.coupon?.data?.code || '',
                description: this.coupon?.data?.descriptions || '',
                type: this.coupon?.data?.type || '',
                discount: this.coupon?.data?.discount || '',
                expires: this.coupon?.data?.expires_at || '',
            }),
            type: [
                {
                    value: 'numeric',
                    name: 'Numeric'
                },
                {
                    value: 'percentage',
                    name: 'Percentage'
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
        VueDatePicker,
        ClassicEditor
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
                    .post(route().current() == 'coupon.create' ? this.route("coupon.store") : this.route('coupon.update', this.form.id),
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
        if (route().current() == 'coupon.edit') {
            this.isEdit = true;
        }
    }
});
</script>
<template>
    <Head :title="isEdit ? 'Edit Coupon' : `Add New Coupon`" />
    <AppLayout :title="isEdit ? 'Edit Coupon' : `Add New Coupon`">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/coupons" class="text-muted text-hover-primary">Coupons</Link>
            </li>
        </template>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div class="col-12">
                <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Coupon Form</h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-5 col-md-12 mb-4">
                                <div class="fv-row col-6">
                                    <jet-label for="code" value="Code" />
                                    <jet-input id="code" type="text" v-model="v$.form.code.$model" :class="v$.form.code.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Code" />
                                    <div v-for="(error, index) of v$.form.code.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="expires-at" value="Expires At" />
                                    <VueDatePicker id="expires-at" v-model="v$.form.expires.$model"
                                        :enable-time-picker="false" auto-apply
                                        input-class-name="form-control form-control-lg form-control-solid fw-normal" :class="v$.form.expires.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Expires At"></VueDatePicker>
                                    <div v-for="(error, index) of v$.form.expires.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="dicsount" value="Discount" />
                                    <jet-input id="dicsount" type="text" v-model="v$.form.discount.$model" :class="v$.form.discount.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Discount" />
                                    <div v-for="(error, index) of v$.form.discount.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label for="type" value="Type" />
                                    <Multiselect :options="type" label="name" valueProp="value"
                                        class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                        v-model="form.type" track-by="name" :class="v$.form.type.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " />
                                    <div v-for="(error, index) of v$.form.type.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>

                                </div>
                            </div>
                            <div class="row mb-5">
                                <jet-label for="descriptions" value="Description" />
                                <div class="">
                                    <ckeditor id=" descriptions" :editor="editor" v-model="v$.form.description.$model"
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
                                <Link href="/coupons"
                                    class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                                Discard
                                </Link>
                                <button type="submit" class="btn btn-primary" :class="{ 'text-white-50': form.processing }">
                                    <div v-show="form.processing" class="spinner-border spinner-border-sm">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <span v-if="route().current() == 'coupon.edit'">Update</span>
                                    <span v-if="route().current() == 'coupon.create'">Save</span>
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
