<script>
import { defineComponent } from 'vue';
import Multiselect from '@vueform/multiselect';
import useVuelidate from '@vuelidate/core';
import { required } from '@vuelidate/validators';
import Modal from '@/Components/Modal.vue'

import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import { toast } from 'vue3-toastify';
import axios from 'axios';

export default defineComponent({
    props: ['users', 'show', 'employees'],

    setup() {
        return { v$: useVuelidate() }
    },
    validations() {
        return {
            form: {
                subject: {
                    required
                },
                project: {
                    required
                },
                assign: {
                    required
                },
                due_date: {
                    required
                },
                description: {
                    required
                },
                priority: {
                    required
                },
                status: {
                    required
                },

            }
        }
    },
    data() {
        return {
            processing: false,
            form: this.$inertia.form({
                assign: '',
                subject: '',
                project: '',
                due_date: '',
                description: '',
                status: '',
                priority: '',
            }),
            projects: [
                { name: 'HTML Theme', id: "1" },
                { name: 'Angular App', id: "2" },
                { name: 'Vue App', id: "3" },
                { name: 'React Theme', id: "4" },
                { name: 'Figma UI Kit', id: "5" },
                { name: 'Laravel App', id: "6" },
                { name: 'Blazor App', id: "7" },
                { name: 'Django App', id: "8" },
            ],
            status: [
                { name: 'Open', id: "1" },
                { name: 'Pending', id: "2" },
                { name: 'Resolved', id: "3" },
                { name: 'Closed', id: "4" },
            ],
            priority: [
                { name: 'Low', id: "1" },
                { name: 'Medium', id: "2" },
                { name: 'High', id: "3" },
            ]
        }
    },
    components: {
        Multiselect,
        JetInput,
        JetLabel,
        InputError,
        VueDatePicker,
        Modal

    },
    methods: {
        submit() {
            this.v$.$touch();
            if (!this.v$.form.$invalid) {
                this.processing = true
                // this.form.transform((data) => ({
                //     ...data,
                // }))
                axios.post(this.route("support.store"), this.form)
                    .then((response) => {
                        if (response.data.success) {
                            this.processing = false
                            this.isModalOpen = false
                            toast.success(response.data.message)
                            return
                        } else {
                            toast.error(response.data.message)
                        }
                    }).finally({
                    })

            }
        },
        hideCreateTicketModal() {
            console.log(this.isModalOpen)
            this.isModalOpen = false;
        }

    },
});
</script>
<template>
    <Modal :show="show" @onhide="$emit('hidemodal')" title="Create Ticket">
        <!--begin::Modal body-->
        <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-10">
            <!--begin:Form-->
            <form class="form" @submit.prevent="submit()">
                <!--begin::Heading-->
                <div class="mb-13 text-center">
                    <!--begin::Title-->
                    <h1 class="mb-3">Create Ticket</h1>
                    <!--end::Title-->
                    <!--begin::Description-->
                    <div class="text-gray-400 fw-semibold fs-5">If you need more info, please
                        check
                        <a href="#" class="fw-bold link-primary">Support Guidelines</a>.
                    </div>
                    <!--end::Description-->
                </div>
                <!--end::Heading-->
                <!--begin::Input group-->
                <div class="d-flex flex-column mb-8 fv-row">
                    <!--begin::Label-->
                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                        <span class="required">Subject</span>
                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                            title="Specify a subject for your issue"></i>
                    </label>
                    <!--end::Label-->
                    <jet-input id="name" type="text" v-model="v$.form.subject.$model" :class="v$.form.subject.$errors.length > 0
                        ? 'is-invalid'
                        : ''
                        " placeholder="Enter your ticket subject" />
                    <div v-for="(    error, index    ) of     v$.form.subject.$errors    " :key="index">
                        <input-error :message="error.$message" />
                    </div>


                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row g-9 mb-8">
                    <!--begin::Col-->
                    <div class="col-md-6 fv-row">
                        <label class="required fs-6 fw-semibold mb-2">Project</label>
                        <Multiselect :options="projects" label="name" valueProp="id"
                            class="form-control form-control-lg form-control-solid" placeholder="Select Project"
                            v-model="form.project" track-by="name" :class="v$.form.project.$errors.length > 0
                                ? 'is-invalid'
                                : ''
                                " />
                        <div v-for="(    error, index    ) of     v$.form.project.$errors    " :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-6 fv-row">
                        <label class="required fs-6 fw-semibold mb-2">Assign</label>
                        <Multiselect :options="employees" label="first_name" valueProp="id"
                            class="form-control form-control-lg form-control-solid" placeholder="Select Employee"
                            v-model="form.assign" track-by="name" :class="v$.form.assign.$errors.length > 0
                                ? 'is-invalid'
                                : ''
                                " />
                        <div v-for="(    error, index    ) of     v$.form.assign.$errors    " :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row g-9 mb-8">
                    <!--begin::Col-->
                    <div class="col-md-4 fv-row">
                        <label class="required fs-6 fw-semibold mb-2">Status</label>
                        <Multiselect :options="status" label="name" valueProp="id"
                            class="form-control form-control-lg form-control-solid" placeholder="Status"
                            v-model="form.status" track-by="name" :class="v$.form.status.$errors.length > 0
                                ? 'is-invalid'
                                : ''
                                " />
                        <div v-for="(    error, index    ) of     v$.form.status.$errors    " :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-4 fv-row">
                        <label class="required fs-6 fw-semibold mb-2">Priority</label>
                        <Multiselect :options="priority" label="name" valueProp="id"
                            class="form-control form-control-lg form-control-solid" placeholder="Select"
                            v-model="form.priority" track-by="name" :class="v$.form.priority.$errors.length > 0
                                ? 'is-invalid'
                                : ''
                                " />
                        <div v-for="(    error, index    ) of     v$.form.priority.$errors    " :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-4 fv-row">
                        <jet-label for="due_date" value="Due Date" />
                        <VueDatePicker v-model="v$.form.due_date.$model" :enable-time-picker="false" auto-apply
                            input-class-name="form-control form-control-lg form-control-solid fw-normal" :class="v$.form.due_date.$errors.length > 0
                                ? 'is-invalid'
                                : ''
                                " placeholder="Due Date"></VueDatePicker>
                        <div v-for="(    error, index    ) of     v$.form.due_date.$errors    " :key="index">
                            <input-error :message="error.$message" />
                        </div>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="d-flex flex-column mb-8 fv-row">
                    <label class="fs-6 fw-semibold mb-2">Description</label>
                    <textarea class="form-control form-control-solid" rows="4" v-model="v$.form.description.$model" :class="v$.form.description.$errors.length > 0
                        ? 'is-invalid'
                        : ''
                        " placeholder="Type your ticket description"></textarea>
                    <div v-for="(    error, index    ) of     v$.form.description.$errors    " :key="index">
                        <input-error :message="error.$message" />
                    </div>
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="mb-15 fv-row">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack">
                        <!--begin::Label-->
                        <div class="fw-semibold me-5">
                            <label class="fs-6">Notifications</label>
                            <div class="fs-7 text-gray-400">Allow Notifications by Phone or
                                Email</div>
                        </div>
                        <!--end::Label-->
                        <!--begin::Checkboxes-->
                        <div class="d-flex align-items-center">
                            <!--begin::Checkbox-->
                            <label class="form-check form-check-custom form-check-solid me-10">
                                <input class="form-check-input h-20px w-20px" type="checkbox" name="notifications[]"
                                    value="email" checked="checked" />
                                <span class="form-check-label fw-semibold">Email</span>
                            </label>
                            <!--end::Checkbox-->
                            <!--begin::Checkbox-->
                            <label class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input h-20px w-20px" type="checkbox" name="notifications[]"
                                    value="phone" />
                                <span class="form-check-label fw-semibold">Phone</span>
                            </label>
                            <!--end::Checkbox-->
                        </div>
                        <!--end::Checkboxes-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Input group-->
                <!--begin::Actions-->
                <div class="text-center">
                    <button type="reset" @hidemodal="hideCreateTicketModal"
                        class="btn btn-outline-secondary me-3">Discard</button>
                    <button type="submit" class="btn btn-primary" :data-kt-indicator="processing ? 'on' : 'off'">
                        <span class="indicator-label">Submit</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
                <!--end::Actions-->
            </form>
            <!--end:Form-->
        </div>
        <!--end::Modal body-->

    </Modal>
</template>