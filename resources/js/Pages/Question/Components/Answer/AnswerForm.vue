<script>
import { defineComponent } from "vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import PrimaryButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
export default defineComponent({
    emits: ["submitted"],
    props: ["question", "answer"],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                question_name: {
                    required,
                },
                answer: {
                    required,
                },
                order_by: {
                    required,
                }
            },
        };
    },
    data() {
        return {
            is_primary: false,
            form: this.$inertia.form({
                id: this.answer?.id || '',
                question_name: this.question?.question_key || {},
                question: this?.question?.id,
                answer: this.answer?.answer || '',
                order_by: this.answer?.order_by || '',
                questionpage: 'question-page',
            }),
            order_by: [
                { id: '1', name: 'Ascending' },
                { id: '0', name: 'Descending' },
            ],
        };
    },
    components: {
        Link,
        Head,
        Multiselect,
        PrimaryButton,
        JetInput,
        JetLabel,
        InputError,
        JetValidationErrors,
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
        <!--end::Heading-->
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h2>Answer Form</h2>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-5 col-md-12">

                    <div class="fv-row col-6">
                        <jet-label for="question" value="Question" />
                        <jet-input id="question" type="text" v-model="v$.form.question_name.$model" :class="v$.form.question_name.$errors.length > 0
                            ? 'is-invalid'
                            : ''
                            " placeholder="Question" />
                        <div v-for="(error, index) of v$.form.question_name.$errors" :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                    <div class="fv-row col-6">
                        <jet-label for="answer" value="Answer" />
                        <jet-input id="answer" type="text" v-model="v$.form.answer.$model" :class="v$.form.answer.$errors.length > 0
                            ? 'is-invalid'
                            : ''
                            " placeholder="Answer" />
                        <div v-for="(error, index) of v$.form.answer.$errors" :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                    <div class="fv-row col-6">
                        <jet-label for="order_by" value="Order By" />
                        <Multiselect :options="order_by" label="name" valueProp="id"
                            class="form-control form-control-lg form-control-solid" placeholder="Select One"
                            v-model="v$.form.order_by.$model" track-by="name" :searchable="true" :class="v$.form.order_by.$errors.length > 0
                                ? 'is-invalid'
                                : ''
                                " />
                        <div v-for="(error, index) of v$.form.order_by.$errors" :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--begin::Actions-->
        <slot name="action"></slot>
        <!--end::Actions-->
    </form>
</template>
