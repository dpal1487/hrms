<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import { toast } from "vue3-toastify";
export default defineComponent({
    props: ['rule'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                rule: {
                    required,
                },
                value: {
                    required,
                },
                message: {
                    required,
                }
            },
        };
    },
    data() {
        return {
            isEdit: false,
            requesting: false,
            form: this.$inertia.form({
                id: this.rule?.data?.id || '',
                rule: this.rule?.data?.rule || '',
                value: this.rule?.data?.value || '',
                message: this.rule?.data?.message || '',
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
    },
    methods: {

        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.requesting = true;
                this.form
                    .transform((data) => ({
                        ...data,
                    }))
                    .post(route().current() == 'rule.create' ? this.route("rule.store") : this.route('rule.update', this.form.id),
                        {
                            onSuccess: (data) => {
                                toast.success(this.$page.props.jetstream.flash.message);
                                this.requesting = false;

                            },
                            onError: (data) => {
                                if (data.message) {
                                    toast.error(data.message);
                                }
                            },
                        })

            }
        },

    },
    created() {
        if (route().current() == 'rule.edit') {
            this.isEdit = true;
        }
    }
});
</script>
<template>
    <Head :title="isEdit ? 'Edit Rule' : `Add New Rule`" />
    <AppLayout :title="isEdit ? 'Edit Rule' : `Add New Rule`">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/rules" class="text-muted text-hover-primary">Rules</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <span class="text-muted">Rule Form</span>
            </li>
        </template>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
            <div class="col-12">
                <form @submit.prevent="submit()" class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Rule Form</h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-5 col-md-12 mb-4">
                                <div class="fv-row col-6">
                                    <jet-label value="Rule" />
                                    <jet-input type="text" v-model="v$.form.rule.$model" :class="v$.form.rule.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Rule" />
                                    <div v-for="(error, index) of v$.form.rule.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>
                                <div class="fv-row col-6">
                                    <jet-label value="Value" />
                                    <jet-input type="text" v-model="v$.form.value.$model" :class="v$.form.value.$errors.length > 0
                                        ? 'is-invalid'
                                        : ''
                                        " placeholder="Value" />
                                    <div v-for="(error, index) of v$.form.value.$errors" :key="index">
                                        <input-error :message="error.$message" />
                                    </div>
                                </div>


                            </div>
                            <div class="row mb-5">
                                <jet-label value="Message" />
                                <div class="">
                                    <textarea v-model="v$.form.message.$model" class="form-control form-control-solid"
                                        :class="v$.form.message.$errors.length > 0
                                            ? 'is-invalid'
                                            : ''
                                            " placeholder="Text ..." />
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-5">
                                <Link href="/rules"
                                    class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                                Discard
                                </Link>
                                <button type="submit" class="btn btn-primary" :class="{ 'text-white-50': form.processing }">
                                    <div v-show="form.processing" class="spinner-border spinner-border-sm">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <span v-if="route().current() == 'rule.edit'">Update</span>
                                    <span v-if="route().current() == 'rule.create'">Save</span>
                                </button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
