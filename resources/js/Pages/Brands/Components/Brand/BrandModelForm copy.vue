<script>
import { defineComponent } from "vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import PrimaryButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";

export default defineComponent({
    emits: ["submitted"],
    props: ["brand", "id"],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                name: {
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
                name: this.brand?.name,
                status: this.brand?.status,
                brand_id: this?.id,
                id: this.brand?.id
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

        <div class="row g-5 mb-5">
            <div class="col-6 mb-3">
                <div class="fv-row">
                    <jet-label for="name" value="Name" />
                    <jet-input id="name" type="text" placeholder="Name" v-model="v$.form.name.$model" :class="v$.form.name.$errors.length > 0
                        ? 'is-invalid'
                        : ''
                        " />
                    <div v-for="(error, index) of v$.form.name
                        .$errors" :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
            </div>
            <div class="col-6 mb-3">
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
