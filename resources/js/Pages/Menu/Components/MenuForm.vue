<script>
import { defineComponent } from 'vue';

import useVuelidate from '@vuelidate/core';
import { required } from '@vuelidate/validators';
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import { toast } from 'vue3-toastify';
import Modal from '@/Components/Modal.vue';
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";

export default defineComponent({
    props: ['menu', 'isEdit', 'show'],
    emits: ['hidemodal'],
    setup() {
        return { v$: useVuelidate() }
    },
    validations() {
        return {
            form: {
                name: {
                    required
                },
            }
        }

    },

    data() {
        return {
            processing: false,
            form: this.$inertia.form({
                id: this.menu?.id || '',
                name: this.menu?.name || '',
            }),
        }
    },
    components: {
        JetInput,
        InputError,
        Modal,
        JetLabel,
        JetValidationErrors
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.form
                    .transform((data) => ({
                        ...data,
                    }))
                    .post(this.isEdit ? this.route("menu.update", this.form.id) : this.route("menu.store"), {
                        onSuccess: (data) => {
                            this.$emit('hidemodal')
                            toast.success(this.$page.props.jetstream.flash.message);
                        },
                        onError: (data) => {

                        },
                    });
            }
        }
    }

})
</script>
<template>
    <Modal :show="show" :title="isEdit ? 'Edit Menu' : 'Add Menu'" @onhide="$emit('hidemodal')">
        <JetValidationErrors />
        <form @submit.prevent="submit()" class="form">
            <div class="fv-row mb-2">
                <jet-label for="menu-name" value="Menu Name" />
                <jet-input id="menu-name" type="text" v-model="v$.form.name.$model" :class="v$.form.name.$errors.length > 0
                    ? 'is-invalid'
                    : ''
                    " placeholder="Enter menu name" />
                <div v-for="(error, index) of v$.form.name.$errors" :key="index">
                    <input-error :message="error.$message" />
                </div>
            </div>
            <div class="text-center pt-15">
                <button type="reset" class="btn btn-light me-3" @click="$emit('hidemodal', false)">Discard</button>
                <button type="submit" class="btn btn-primary" :data-kt-indicator="processing ? 'on' : 'off'">
                    <span class="indicator-label">Save</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </form>
    </Modal>
</template>