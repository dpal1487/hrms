<script>
import { defineComponent } from "vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import ItemFormList from "./ItemFormList.vue";
export default defineComponent({
    emits: ["submitted"],
    props: ["faq"],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {
                faq_cat_title: {
                    required,
                },
                status: {
                    required,
                },

            },
        };
    },
    data() {
        return {
            rowCount: 1,
            items: 1,
            form: this.$inertia.form({
                id: this.faq?.id || '',
                faq_cat_title: this.faq?.title || '',
                status: this.faq?.faq_artical || '',
                items: [{
                    faq_title: '',
                    faq_artical: '',
                }],
            }),
            status: [
                { id: '1', name: 'Active' },
                { id: '0', name: 'Inactive' },
            ]
        };
    },
    components: {
        Link,
        Head,
        Multiselect,
        JetInput,
        JetLabel,
        InputError,
        ItemFormList
    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.$emit('submitted', this.form)
            }
        },
        addItemForm(rowCount) {
            for (var i = 0; i < rowCount; i++) {
                this.form.items.push({
                    faq_cat_title: '',
                    status: '',
                });
            }
        },
        removeItemForm(index) {
            if (this.form.items.length > 0) {
                this.form.items.splice(index, 1)
            }
        },
    },
});
</script>
<template>
    <form @submit.prevent="submit" class="my-auto pb-5">

        <!--end::Heading-->
        <div class="row g-9 mb-5">
            <div class="col-md-6 ">


                <jet-label for="faq-cat-title" value="Title" />
                <jet-input id="faq-cat-title" type="text" v-model="v$.form.faq_cat_title.$model" :class="v$.form.faq_cat_title.$errors.length > 0
                    ? 'is-invalid'
                    : ''
                    " placeholder="Faq Title" />
                <div v-for="(error, index) of v$.form.faq_cat_title.$errors" :key="index">
                    <input-error :message="error.$message" />
                </div>
            </div>
            <div class="col-md-6 ">

                <jet-label for="status" value="Status" />
                <Multiselect :options="status" label="name" valueProp="id"
                    class="form-control form-control-lg form-control-solid" placeholder="Choose One"
                    v-model="v$.form.status.$model" track-by="name" :class="v$.form.status.$errors.length > 0
                        ? 'is-invalid'
                        : ''
                        " />
                <div v-for="(error, index) of v$.form.status.$errors" :key="index">
                    <input-error :message="error.$message" />
                </div>
            </div>


            <div class="table-responsive mb-10">
                <!--begin::Table-->
                <h4>Faq Details</h4>
                <table class="table g-5 gs-0 mb-0 fw-bold text-gray-700" data-kt-element="items">
                    <!--begin::Table head-->
                    <thead>
                        <tr class="border-bottom fs-7 fw-bold text-gray-700 text-uppercase text-center">
                            <th>Title</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                        <ItemFormList :faq="faq" :form="form" @removeSingle="removeItemForm" />
                    </tbody>
                    <!--end::Table body-->
                    <!--begin::Table foot-->
                    <tfoot>
                        <tr class="border-top border-top-dashed align-top fs-6 fw-bold text-gray-700">
                            <th class="text-primary">
                                <button type="button" class="btn btn-primary btn-sm" @click="addItemForm(this.rowCount)">Add
                                    more</button>
                            </th>
                        </tr>
                    </tfoot>
                    <!--end::Table foot-->
                </table>
            </div>
        </div>
        <!--begin::Actions-->
        <slot name="action"></slot>
        <!--end::Actions-->
    </form>
</template>
