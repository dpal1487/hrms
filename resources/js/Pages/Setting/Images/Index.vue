<script>
import { defineComponent, ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import { toast } from "vue3-toastify";
import Loading from "vue-loading-overlay";
import 'vue-loading-overlay/dist/css/index.css';
import DropFile from "@/Components/DropFile.vue";
import utils, { parse_json } from "../../utils";
import axios from "axios";
import SettingImage from "./Components/SettingImage.vue"

export default defineComponent({
    props: ['options', 'option'],
    setup() {
        return { parse_json };
    },
    validations() {
        return {
            form: {
                chat_icon: {},
            },
        };
    },
    data() {
        return {
            title: 'Options',
            form: this.$inertia.form({
                option: [{
                    chat_icon: '',
                    auto_load: '',
                    image: this.option_value
                }]
            }),
            image_url: {
                isLoading: false,
            },
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        JetInput,
        JetLabel,
        DropFile,
        Loading,
        SettingImage
    },
    methods: {
        submit(form) {
            this.form = form;
            // console.log(this.form?.option);
            // axios.post(route('option-image.store', this.form))
            //     .then(() => {
            //         console.log(this.form?.option[0].auto_load)
            //     })
        },
        //     {
        //     onSuccess: (data) => {
        //         toast.success(this.$page.props.jetstream.flash.message);
        //         this.isEdit = false;
        //     },
        //     onError: (data) => {
        //         toast.error(data.message);
        //     },
        // });

        async onSettingImage(e) {
            this.image_url.isLoading = true;
            const data = await utils.imageUpload(route('upload.image'), e, this.form.image_url)
            if (data.response.success) {
                this.option_value = data.response.data;
                this.image_name = data.response.data?.name;
            } else {
                toast.error(data.response.message);
            }
            this.image_url.url = URL.createObjectURL(data.file);
            this.image_url.isLoading = false;
        },
    }
});
</script>
<template>
    <app-layout :title="title">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <span class="text-muted">{{ title }}</span>
            </li>
        </template>
        <template #toolbar>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link href="/option-image/create" class="btn btn-sm fw-bold btn-primary">
                <i class="bi bi-plus-circle"></i>Add New Option</Link>
            </div>
        </template>

        <Head :title="title" />
        <div class="card card-flush">
            <div class="card-body pt-0">
                <!-- <form @submit.prevent="submit()" class="form d-flex flex-column flex-lg-row"> -->
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="card">
                        <div class="card-header align-items-center">
                            <div class="card-title">
                                <h2>General</h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <SettingImage @submitted="submit" :options="options?.data">
                                <template #action>
                                    <div class="d-flex justify-content-end m-5 gap-5">
                                        <Link href="/option-images"
                                            class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                                        Discard
                                        </Link>
                                        <button type="submit" class="btn btn-primary"
                                            :class="{ 'text-white-50': form.processing }">
                                            <div v-show="form.processing" class="spinner-border spinner-border-sm">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <span v-if="route().current() == 'option-images.index'">Save</span>
                                        </button>
                                    </div>
                                </template>
                            </SettingImage>
                        </div>
                    </div>

                </div>
                <!-- </form> -->
            </div>
        </div>
    </app-layout>
</template>
