<script>
import { defineComponent } from "vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
export default defineComponent({
    emits: ["submitted"],
    props: ["faq_category", "id"],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                title: {
                    required,
                },
                artical: {
                    required,
                }
            },
        };
    },
    data() {
        return {
            form: this.$inertia.form({
                title: this.faq_category?.title,
                artical: this.faq_category?.artical,
                faq_category: this?.id,
                id: this.faq_category?.id
            }),
        };
    },
    components: {
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
                this.$emit('submitted', this.form)
            }
        },
    },
});
</script>
<template>
    <form @submit.prevent="submit" class="my-auto pb-5">

        <div class="row g-5">
            <div class="col-8">
                <div class="fv-row">
                    <jet-label for="title" value="Title" />
                    <jet-input id="title" type="text" placeholder="Title" v-model="v$.form.title.$model" :class="v$.form.title.$errors.length > 0
                        ? 'is-invalid'
                        : ''
                        " />
                    <div v-for="(error, index) of v$.form.title
                        .$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
            </div>
            <div class="col-12 mb-3">
                <div class="fv-row">
                    <jet-label for="artical" value="Artical" />
                    <textarea class="form-control form-control-solid" id="artical" type="text" placeholder="Artical"
                        v-model="v$.form.artical.$model" :class="v$.form.artical.$errors.length > 0
                            ? 'is-invalid'
                            : ''
                            " />
                    <div v-for="(error, index) of v$.form.artical
                        .$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
            </div>
            <slot name="action"></slot>
        </div>
       
    </form>
</template>
