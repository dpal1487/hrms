<script>
import { defineComponent } from "vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import { toast } from "vue3-toastify";
import Loading from "vue-loading-overlay";
import 'vue-loading-overlay/dist/css/index.css';
import DropFile from "@/Components/DropFile.vue";
import useVuelidate from "@vuelidate/core";
import utils, { parse_json } from "../../../utils";
import axios from "axios";

export default defineComponent({
    props: ['options', 'option'],
    emits: ['submitted'],
    setup() {
        return { parse_json, v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                option_name: {},
            },
        };
    },
    data() {
        return {
            title: 'Options',

            form: this.$inertia.form({
                option: [{
                    option_name: '',
                    auto_load: '',
                    option_value: ''
                }]
            }),
            image_url: {
                isLoading: false,
            },
        };
    },
    components: {
        Link,
        Head,
        JetInput,
        JetLabel,
        DropFile,
        Loading,

    },
    methods: {
        submit() {
            this.$emit('submitted', this.form)
            axios.post(route('option-image.store', this.form))
                .then((response) => {
                    console.log(response)
                })
        },

        async onSettingImage(e) {
            this.image_url.isLoading = true;
            const data = await utils.imageUpload(route('upload.image'), e, this.form.image_url)
            if (data.response.success) {
                this.form.option[0].option_value = data.response.data;
                console.log(this.option_value)
            } else {
                toast.error(data.response.message);
            }
            this.image_url.url = URL.createObjectURL(data.file);
            this.image_url.isLoading = false;
        },
    },
  
    created() {
        this.$watch('options', (newValue, oldValue) => {
            console.log("se this")
        }, { deep: true });
    }
});
</script>
<template>
    <form @submit.prevent="submit" autocomplete="off">
        <div class="row g-0 my-3">
            {{ options }}
            <div class="col-md-5 col-5">
                <div class="fv-row">
                    <DropFile :image="parse_json(option?.data?.image)?.file_path" :isUploading="option?.isLoading"
                        @change="onSettingImage" className="h-150px w-250px" />
                </div>
            </div>
            <div class="col-4 col-sm-4 col-md-4 d-flex align-items-center">
                <jet-input id="title" type="text" v-model="form.option[0].option_name" placeholder="Enter menu title" />
            </div>

            <div class="col-2 col-md-2 d-flex align-items-center">
                <div class="fv-row mx-2">
                    <div class="form-switch form-check-solid d-block form-check-custom form-check-success">
                        <input class="form-check-input h-30px w-50px" type="checkbox" v-model="form.option[0].auto_load" />
                    </div>
                </div>
            </div>
        </div>
        <slot name="action"></slot>
    </form>
</template>
