<script>
import { ref, defineComponent } from "vue";
import { required } from "@vuelidate/validators";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { toast } from "vue3-toastify";
import utils, { parse_json } from "../../utils.js";
import IconPicker from "../../../Components/IconPicker/index.vue";

export default defineComponent({
    props: ['option'],
    setup() {
        const icon1 = ref('far fa-check-circle')
        return { v$: useVuelidate(), parse_json, icon1, };
    },
    validations() {
        return {
            form: {
                option_name: { required },
                auto_load: {},
            },
        };
    },
    data() {
        return {
            title: 'Options',
            isEdit: false,
            image_url: {
                isLoading: false,
            },
            form: this.$inertia.form({
                id: this.option?.data?.id || '',
                option_name: this.option?.data?.option_name || '',
                auto_load: this.option?.data?.auto_load || '',
                option_value: this.icon1,
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
        IconPicker
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.form
                    .transform((data) => ({
                        ...data,
                    }))
                    .post(route().current() == 'setting-icon.create' ? this.route("setting-icon.store") : this.route('setting-icon.update', this.form.id),
                        {
                            onSuccess: (data) => {
                                toast.success(this.$page.props.jetstream.flash.message);
                                this.isEdit = false;
                            },
                            onError: (data) => {
                                toast.error(data.message);
                            },
                        });
            }
        },

        async onSettingImage(e) {
            this.image_url.isLoading = true;
            const data = await utils.imageUpload(route('upload.image'), e, this.form.image_url)
            if (data.response.success) {
                this.form.option_value = data.response.data;
                this.form.image_name = data.response.data?.name;
            } else {
                toast.error(data.response.message);
            }
            this.image_url.url = URL.createObjectURL(data.file);
            this.image_url.isLoading = false;
        },
    },
    created() {
        if (route().current() == 'option.edit') {
            this.isEdit = true;
        }
    }
});
</script>
<template>
    <Head :title="isEdit ? 'Edit Option' : `Add New Option`" />
    <AppLayout :title="isEdit ? 'Edit Option' : `Add New Option`">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/options" class="text-muted text-hover-primary">{{ title }}</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <span class="text-muted">Option Form</span>
            </li>
        </template>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div class="col-12">
                <form @submit.prevent="submit()" class="form d-flex flex-column flex-lg-row">
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <div class="card">
                            <div class="card-header align-items-center">
                                <div class="card-title">
                                    <h2>General</h2>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row col-md-12">
                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <jet-label for="title" value="Name" />
                                            <jet-input id="title" type="text" v-model="v$.form.option_name.$model" :class="v$.form.option_name.$errors.length > 0
                                                ? 'is-invalid'
                                                : ''
                                                " placeholder="Name" />
                                            <div v-for="(error, index) of v$.form.option_name.$errors" :key="index">
                                                <input-error :message="error.$message" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-5">
                                        <div class="fv-row mx-15">
                                            <IconPicker v-model="icon1" class="fs-50" />
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="fv-row m-5">
                                            <jet-label for="title" value="Auto Load " />

                                            <div
                                                class="form-switch form-check-solid d-block form-check-custom form-check-success">
                                                <input class="form-check-input h-30px w-50px" type="checkbox"
                                                    :checked="option?.auto_load == 1 ? true : false"
                                                    v-model="v$.form.auto_load.$model" />
                                            </div>
                                            <div v-for="(error, index) of v$.form.auto_load.$errors" :key="index">
                                                <input-error :message="error.$message" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end m-5 gap-5">
                            <Link href="/setting-icons"
                                class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                            Discard
                            </Link>
                            <button type="submit" class="btn btn-primary" :class="{ 'text-white-50': form.processing }">
                                <div v-show="form.processing" class="spinner-border spinner-border-sm">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <span v-if="route().current() == 'setting-icon.edit'">Update</span>
                                <span v-if="route().current() == 'setting-icon.create'">Save</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
