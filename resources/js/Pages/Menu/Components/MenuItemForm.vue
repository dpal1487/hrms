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
import Multiselect from "@vueform/multiselect";

export default defineComponent({
    props: ['item','menu_lists','parents'],
    emits: ['hidemodal','submitted'],
    setup() {
        return { v$: useVuelidate() }
    },
    validations() {
        return {
            form: {
                menu: {
                    required
                },
                title: {
                    required
                },
                url: {
                    required
                },
                target: {
                    
                },
                icon: {
                    required
                },
                color: {
                    required
                },
                parent: {
                },
                order_by: {
                    required
                },
                route: {
                    required
                },
                parameters: {
                    
                }
            }
        }

    },
    data() {
        return {
            processing: false,
            form: this.$inertia.form({
                id: this.item?.id || '',
                menu: this.item?.menu_id || '',
                title: this.item?.title || '',
                url: this.item?.url || '',
                target: this.item?.target || '',
                icon: this.item?.icon_class || '',
                color: this.item?.color || '',
                parent: this.item?.parent_id || '',
                order_by: this.item?.order_by || '',
                route: this.item?.route || '',
                parameters: this.item?.parameters || '',
            }),
        }
    },
    components: {
        JetInput,
        InputError,
        Modal,
        JetLabel,
        JetValidationErrors,
        Multiselect
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.$emit('submitted', this.form)
            }
        }
    }
})
</script>
<template>
    <JetValidationErrors />
    <form @submit.prevent="submit" autocomplete="off">
        <!--begin::Input group-->
        <div class="row mb-6">
            
            <div class="fv-row col-6 mb-3">
                <jet-label for="menu" value="Menu List" />
                <Multiselect :options="menu_lists" label="name" valueProp="id"
                    class="form-control form-control-lg form-control-solid" placeholder="Select One"
                    v-model="v$.form.menu.$model" track-by="name" />
                <div v-for="(error, index) of v$.form.menu.$errors" :key="index">
                    <input-error :message="error.$message" />
                </div>
            </div> <div class="fv-row col-6 mb-3">
                <jet-label for="parent" value="Parent" />
                <Multiselect :canClear="false" :options="parents" label="title" valueProp="id"
                    class="form-control form-control-lg form-control-solid" placeholder="Select One"
                    v-model="v$.form.parent.$model" track-by="title" />
                <div v-for="(error, index) of v$.form.parent.$errors" :key="index">
                    <input-error :message="error.$message" />
                </div>
            </div>
            <div class="fv-row col-6 mb-3">
                <jet-label for="title" value="Title" />
                <jet-input id="title" type="text" v-model="v$.form.title.$model" :class="v$.form.title.$errors.length > 0
                    ? 'is-invalid'
                    : ''
                    " placeholder="Enter menu title" />
                <div v-for="(error, index) of v$.form.title.$errors" :key="index">
                    <input-error :message="error.$message" />
                </div>
            </div>
            <div class="fv-row col-6 mb-3">
                <jet-label for="url" value="Menu Url" />
                <jet-input id="url" type="text" v-model="v$.form.url.$model" :class="v$.form.url.$errors.length > 0
                    ? 'is-invalid'
                    : ''
                    " placeholder="Enter menu url" />
                <div v-for="(error, index) of v$.form.url.$errors" :key="index">
                    <input-error :message="error.$message" />
                </div>
            </div>
            <div class="fv-row col-6 mb-3">
                <jet-label for="target" value="Target" />
                <jet-input id="target" type="text" v-model="v$.form.target.$model" :class="v$.form.target.$errors.length > 0
                    ? 'is-invalid'
                    : ''
                    " placeholder="Enter menu target" />
                <div v-for="(error, index) of v$.form.target.$errors" :key="index">
                    <input-error :message="error.$message" />
                </div>
            </div>
            <div class="fv-row col-6 mb-3">
                <jet-label for="icon" value="Icon Class" />
                <jet-input id="icon" type="text" v-model="v$.form.icon.$model" :class="v$.form.icon.$errors.length > 0
                    ? 'is-invalid'
                    : ''
                    " placeholder="Enter menu icon" />
                <div v-for="(error, index) of v$.form.icon.$errors" :key="index">
                    <input-error :message="error.$message" />
                </div>
            </div>
            <div class="fv-row col-6 mb-3">
                <jet-label for="color" value="Menu Color" />
                <jet-input id="color" type="color" v-model="v$.form.color.$model" :class="v$.form.color.$errors.length > 0
                    ? 'is-invalid'
                    : ''
                    " placeholder="Enter menu color" />
                <div v-for="(error, index) of v$.form.color.$errors" :key="index">
                    <input-error :message="error.$message" />
                </div>
            </div>
            <div class="fv-row col-6 mb-3">
                <jet-label for="order-by" value="Order By" />
                <jet-input id="order-by" type="number" v-model="v$.form.order_by.$model" :class="v$.form.order_by.$errors.length > 0
                    ? 'is-invalid'
                    : ''
                    " placeholder="Enter order by" />
                <div v-for="(error, index) of v$.form.order_by.$errors" :key="index">
                    <input-error :message="error.$message" />
                </div>
            </div>
            <div class="fv-row col-6 mb-3">
                <jet-label for="route" value="Route Name" />
                <jet-input id="route" type="text" v-model="v$.form.route.$model" :class="v$.form.route.$errors.length > 0
                    ? 'is-invalid'
                    : ''
                    " placeholder="Enter route name" />
                <div v-for="(error, index) of v$.form.route.$errors" :key="index">
                    <input-error :message="error.$message" />
                </div>
            </div>
            <div class="fv-row col-6 mb-3">
                <jet-label for="parameters" value="Parameters Name" />
                <jet-input id="parameters" type="text" v-model="v$.form.parameters.$model" :class="v$.form.parameters.$errors.length > 0
                    ? 'is-invalid'
                    : ''
                    " placeholder="Enter parameters name" />
                <div v-for="(error, index) of v$.form.parameters.$errors" :key="index">
                    <input-error :message="error.$message" />
                </div>
            </div>
        </div>
        <slot name="action"></slot>
    </form>
</template>