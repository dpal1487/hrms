import { defineComponent } from "vue";
import useVuelidate from "@vuelidate/core";
import { toast } from "vue3-toastify";
import utils from "../utils.js";

export default defineComponent({
    props: ['option'],
    setup() {
        return { v$: useVuelidate() };
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
                id: this.setting?.data?.id || '',
                option_name: this.setting?.data?.option_name || '',
                auto_load: this.setting?.data?.auto_load || '',
                option_value: this.setting?.data?.image?.id ? this.setting?.data?.image?.id : this.option_value,
                image_name: this.setting?.data?.image?.id ? this.setting?.data?.image?.id : this.image_name,
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
        Loading,
        DropFile
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.form
                    .transform((data) => ({
                        ...data,
                    }))
                    .post(route().current() == 'option.create' ? this.route("option.store") : this.route('option.update', this.form.id),
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
            const data = await utils.imageUpload(route('upload.image'), e, this.form.image_url);
            if (data.response.success) {
                this.form.option_value = data.response.data?.file_path;
                this.form.option_value = data.response.data?.file_path;
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
