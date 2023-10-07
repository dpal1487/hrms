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
import Modal from "../../../../Components/Modal.vue";
import { toast } from "vue3-toastify";
import { Inertia } from "@inertiajs/inertia";
export default defineComponent({
    props: ["data", "show", "id"],
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
                name: this.data?.name,
                status: this.data?.status,
                brand_id: this?.id,
                id: this.data?.id
            }),
            status: [
                { id: 1, label: "Active" },
                { id: 0, label: "Inactive" },
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
        Modal
    },
    methods: {
        submit() {
            console.log(this.form)
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                Inertia.post(!(this.data) ? this.route("brand-model.store", this.form) : this.route('brand-model.update', this.form), {
                    onSuccess: (data) => {
                        toast.success(this.$page.props.jetstream.flash.message);
                        this.$emit('hidemodel')
                    },
                    onError: (data) => {
                        toast.error(data.message);
                        console.log(data);
                    },
                });
            }
        },
    },

    watch: {
        data: {
            async handler() {
                this.form = {
                    name: this.data?.name,
                    status: this.data?.status,
                    brand_id: this?.id,
                    id: this.data?.id
                };
            }
        }
    }

});
</script>
<template>
    <Modal :show="show" @onhide="$emit('hidemodal')" title="Brand Model Form">
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
            <div class="d-flex justify-content-end me-5">
                <Link :href="`/brand/${id}`" class="btn btn-outline-secondary me-5">
                Discard
                </Link>
                <button type="submit" class="btn btn-primary" :class="{ 'text-white-50': form.processing }">
                    <div v-show="form.processing" class="spinner-border spinner-border-sm">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span v-if="data">
                        Update
                    </span>
                    <span v-else>
                        Save
                    </span>
                </button>
            </div>
        </form>
    </Modal>
</template>
