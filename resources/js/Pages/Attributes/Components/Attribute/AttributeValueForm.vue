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
    props: ["attribute", "id", "categories"],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                value: {
                    required,
                },
                category: {
                    required,
                },
                status: {
                    required,
                }
            },
        };
    },
    data() {
        return {
            form: this.$inertia.form({
                value: this.attribute?.attribute_value,
                category: this.attribute?.category?.id || '',
                status: this.attribute?.status,
                attribute: this?.id,
                id: this.attribute?.id
            }),
            status: [
                { id: 1, label: "Active" },
                { id: 0, label: "Inactive" },
            ]
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
        <div class="row mb-5">
            <div class="col-4 mb-3">
                <div class="fv-row">
                    <jet-label for="value" value="Value" />
                    <jet-input id="value" type="text" placeholder="Value" v-model="v$.form.value.$model" :class="v$.form.value.$errors.length > 0
                        ? 'is-invalid'
                        : ''
                        " />
                    <div v-for="(error, index) of v$.form.value
                        .$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
            </div>
            <div class="col-4 mb-3">
                <div class="fv-row">
                    <jet-label for="status" value="Category" />
                    <Multiselect :canClear="false" id="status" :options="categories" label="name" valueProp="id"
                        class="form-control form-control-solid" placeholder="Category" :searchable="true" :class="v$.form.category.$errors.length > 0
                            ? 'is-invalid'
                            : ''
                            " v-model="form.category" />
                    <div v-for="(error, index) of v$.form.category
                        .$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
            </div>
            <div class="col-4 mb-3">
                <div class="fv-row">
                    <jet-label for="status" value="Status" />
                    <Multiselect :canClear="false" id="status" :options="status" label="label" valueProp="id"
                        class="form-control form-control-solid" placeholder="Status" :searchable="true" :class="v$.form.status.$errors.length > 0
                            ? 'is-invalid'
                            : ''
                            " v-model="form.status" />
                    <div v-for="(error, index) of v$.form.status
                        .$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
            </div>
        </div>
        <slot name="action"></slot>
    </form>
</template>
