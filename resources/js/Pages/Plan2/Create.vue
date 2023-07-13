<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import PlanDescriptionForm from "./Components/PlanDescriptionForm.vue";
import PlanForm from "./Components/PlanForm.vue";
import { toast } from 'vue3-toastify';

export default defineComponent({
    props: ["categories"],

    components: {
        AppLayout,
        Link,
        Head,
        PlanDescriptionForm,
        PlanForm,
    },
    data() {
        return {
            plan_descriptions: [],
            title: "Add Plan",
            isEdit: false,
            form: {},
            paln: {}
        }
    },
    methods: {

        validatePlanDescriptions() {
            this.plan_descriptions = this.plan_descriptions.map(description => {
                if (!Object.keys(description).includes("plan")) {
                    return { ...description, error: { message: "This field is required." } }
                }
                return description;
            });
        },
        addPlanDescription() {

            this.plan_descriptions = [...this.plan_descriptions, { id: Date.now() }];
            console.log(this.plan_descriptions)
        },
        removePlanDescription(id) {
            if (this.plan_descriptions.length > 1) {
                this.plan_descriptions = this.plan_descriptions.filter(description => description.id !== id);
            }
            return;
        },
        PlanDescriptionOnChange(plan = {}) {
            console.log("see this too", plan)
            this.plan_descriptions = this.plan_descriptions.map(description => {
                if (description.id === plan.id) {
                    return {
                        id: description.id,
                        plan: plan.plan,
                    };
                }

                return description;
            })
        },

        submit(form) {

            this.validatePlanDescriptions();

            if (!this.plan_descriptions.find(a => Object.keys(a).includes("error"))) {
                let PlanDescriptionValue = this.plan_descriptions.map(a => ({ id: a.plan }));

                this.form = form;
                this.form
                    .transform((data) => ({
                        ...data,
                        PlanDescriptionValue
                    }))
                    .post(this.route('plan.store'), {
                        onSuccess: (data) => {
                            toast.success(this.$page.props.jetstream.flash.message);
                        },
                        onError: (data) => {

                        },
                    });
            }
        },
    },
    created() {
        this.plan_descriptions = [{ id: Date.now() }];
    },
});
</script>
<template>
    <Head :title="title" />
    <app-layout :title="title">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                <a href="/plans" class="text-muted text-hover-primary">Plans</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                Plan
            </li>
        </template>
        <div class="row mb-5">
            <div class="col-8">
                <div class="card">
                    <div class="card-header align-items-center">
                        <div class="card-title">
                            <h2>Add New Plan</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- end page title -->
                        <plan-form @submitted="submit" :categories="categories?.data">
                            <template #action>
                                <div class="d-flex justify-content-end">
                                    <!--begin::Button-->
                                    <Link type="button" class="btn btn-outline-secondary me-5" href="/plans">Discard
                                    </Link>
                                    <!--begin::Button-->
                                    <button type="submit" class="btn btn-primary"
                                        :class="{ 'text-white-50': form.processing }">
                                        <div v-show="form.processing" class="spinner-border spinner-border-sm">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        Save
                                    </button>
                                </div>
                            </template>
                        </plan-form>

                        <!-- end row -->
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card card-flush py-4">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Plan Description</h2>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <div>
                            <!--begin::Form group-->
                            <div class="">
                                <div>
                                    <div class="row align-items-center">
                                        <PlanDescriptionForm @remove="removePlanDescription"
                                            @onChange="PlanDescriptionOnChange" :plans="plan_descriptions" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-5">
                                <!--begin::Button-->
                                <button type="button" @click="addPlanDescription()" class="btn btn-sm btn-light-primary">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 12 16"
                                        height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M12 9H7v5H5V9H0V7h5V2h2v5h5v2z"></path>
                                    </svg>
                                    Add More
                                </button>
                                <!--end::Button-->
                            </div>
                            <!--end::Form group-->
                        </div>
                        <!--end::Card header-->
                    </div>

                </div>
            </div>
        </div>

    </app-layout>
</template>
