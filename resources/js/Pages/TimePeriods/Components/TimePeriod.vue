<script>
import { defineComponent } from 'vue';

import useVuelidate from '@vuelidate/core';
import { required } from '@vuelidate/validators';
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import { toast } from 'vue3-toastify';
import Modal from '@/Components/Modal.vue';
import Multiselect from "@vueform/multiselect";


export default defineComponent({
    props: ['category', 'isEdit', 'show', 'times'],
    emits: ['hidemodal'],
    setup() {
        return { v$: useVuelidate() }
    },
    validations() {
        return {
            form: {
                time_periods: {
                    required
                }
            }
        }
    },
    data() {
        return {
            processing: false,
            form: this.$inertia.form({
                id: this.category?.id,
                category: this.category?.id,
                time_periods: this.category?.times?.map(t => t.id) || [],
            }),
        }
    },
    components: {
        JetInput,
        InputError,
        Modal,
        JetLabel,
        Multiselect
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.form
                    .transform((data) => ({
                        ...data,
                    }))
                    .post(this.route("time-period.store", this.form.id), {
                        onSuccess: (data) => {
                            this.$emit('hidemodal')
                            toast.success(this.$page.props.jetstream.flash.message);
                        },
                        onError: (data) => {
                            if (data.message) {
                                toast.error(data.message);
                            }
                        },
                    });
            }
        }
    }

})
</script>
<template>
    <Modal :show="show" :title="isEdit ? 'Edit Time Period' : 'Add Time Period'" @onhide="$emit('hidemodal')">
        <form @submit.prevent="submit()" class="form">
            <div class="fv-row mb-2">
                <jet-label for="time-period" value="Time Period" />
                <Multiselect id="project-status" :can-clear="false" :options="times?.data" label="title" valueProp="id"
                    class="form-control form-control-solid" placeholder="Select Time Periods" mode="tags"
                    :close-on-select="true" :create-option="true" :class="v$.form.time_periods.$errors.length > 0
                        ? 'is-invalid'
                        : ''
                        " v-model="form.time_periods" />
                <div v-for="(error, index) of v$.form.time_periods
                    .$errors" :key="index">
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