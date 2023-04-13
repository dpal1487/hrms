<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import PrimaryButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import useVuelidate from "@vuelidate/core";
import { required, email, url, numeric, integer } from "@vuelidate/validators";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'


// Vue.use(Datetime);
// import { Datetime } from 'vue-datetime';

export default defineComponent({
    props: ["industries", 'industry'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                name: {
                    required,
                },
                image: {
                    required,
                }
                ,
                status: {
                    required,
                }

            },
        };
    },
    data() {
        return {

            isEdit: false,
            form: this.$inertia.form({
                id: this.industry?.data?.id || '',
                name: this.industry?.data?.name || '',
                image: this.industry?.data?.image || '',
                status: this.industry?.data?.status || '',
            }),
            url: null,

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
        JetValidationErrors,
        VueDatePicker
    },
    methods: {
        submit() {
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }
            this.v$.$touch();


            if (!this.v$.form.$invalid) {
                this.form
                    .transform((data) => {
                        console.log("see submitted data", data);
                        const formdata = new FormData();
                        formdata.append("id", data.id);
                        formdata.append("name", data.name);
                        formdata.append("image", data.image);
                        formdata.append("status", data.status);
                        return formdata;
                    })
                    .post(route().current() == 'industries.add' ? this.route("industries.store") : this.route('industries.update', this.form.id), config);
            }
        },
        onFileChange(e) {
            const file = e.target.files[0];
            console.log("see file", file)
            this.$data.form.image = file;
            this.url = URL.createObjectURL(file);
        }

    },
    created() {
        if (route().current() == 'industries.edit') {
            this.isEdit = true;
        }
    }
});
</script>
<template>
    <Head :title="isEdit ? 'Edit Industry' : `Add New Industry`" />

    <AppLayout>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div class="col-12">
                <JetValidationErrors />
                <!-- {{ form }} -->
                <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10"
                    enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>General</h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-5 col-md-12">

                                <!-- <jet-input type="text" v-model="v$.form.id.$model" /> -->

                                <div class="fv-row col-6">
                                    <jet-label for="image" value="Picture" />
                                    <!-- <label for="description">Picture</label> -->
                                    <input type="file" name="image" placeholder="First image"
                                        class="form-control-file form-control form-control-lg form-control-solid" id="image"
                                        @change="onFileChange" />
                                    <div v-for="(error, index) of v$.form.image.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>

                                    <div id="preview" class="m-3">
                                        <img v-if="url" :src="url" :width="200" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">

                                    <jet-label for="name" value="Name" />
                                    <jet-input id="name" type="text" v-model="v$.form.name.$model" :class="
                                        v$.form.name.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                    " placeholder="Industry name" />
                                    <div v-for="(error, index) of v$.form.name.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>

                                <!-- <div class="fv-row col-6">

                                                                                                                                                                                                                <jet-label for="name" value="Profile Avatar" />
                                                                                                                                                                                                                <jet-input id="image" type="file" v-model="v$.form.image.$model" :class="
                                                                                                                                                                                                                    v$.form.image.$errors.length > 0
                                                                                                                                                                                                                        ? 'is-invalid'
                                                                                                                                                                                                                        : ''
                                                                                                                                                                                                                " placeholder="First image" />
                                                                                                                                                                                                                <div v-for="(error, index) of v$.form.image.$errors" :key="index">
                                                                                                                                                                                                                    <input-error :message="error.$message" />
                                                                                                                                                                                                                </div>
                                                                                                                                                                                                            </div> -->


                                <div class="fv-row col-6">
                                    <jet-label for="status" value="Status" />
                                    <select v-model="v$.form.status.$model"
                                        class="form-control form-control-lg form-control-solid" placeholder="Select One"
                                        track-by="name">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <!-- <Multiselect :options="options" label="name" valueProp="value"
                                                                                                                                                                                                                                                                            :custom-label="nameWithLang" class="form-control form-control-lg form-control-solid"
                                                                                                                                                                                                                                                                            placeholder="Select One" v-model="value" track-by="name" /> -->

                                </div>


                            </div>
                        </div>
                    </div>
                    <!--end::Variations-->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end">
                                <Link href="/industries" class="btn btn-secondary me-3">
                                Cancel
                                </Link>
                                <button type="submit" class="btn btn-primary">
                                    <span class="indicator-label">
                                        <p v-if="route().current() == 'industries.edit'">Update</p>
                                        <p v-if="route().current() == 'industries.add'">Save</p>
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
