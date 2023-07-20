<script>
import { defineComponent, watch } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import JetLabel from "@/Jetstream/Label.vue";
import InputError from "@/jetstream/InputError.vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import { toast } from "vue3-toastify";
import TimePeriodList from "./Components/TimePeriodList.vue";

export default defineComponent({
    props: ['times', 'category', 'timePeriods'],
    setup() {
        return { v$: useVuelidate() };
    },
    validations() {
        return {
            form: {

            },
        };
    },
    data() {
        return {
            rowCount: 1,
            isEdit: false,
            time_periods: [],
            form: this.$inertia.form({
                id: this.category?.data?.id,
                category: this.category?.data?.id,
                time: this.time_period?.data?.time || '',
            }),
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        Multiselect,
        JetLabel,
        InputError,
        TimePeriodList
    },
    methods: {
        validateTimePeriods() {
            this.time_periods = this.time_periods.map(time_period => {
                if (!Object.keys(time_period).includes("time")) {
                    return { ...time_period, error: { message: "This field is required." } }
                }
                return time_period;
            });
        },
        addTimePeriods() {
            this.time_periods = [...this.time_periods, { id: Date.now() }];
        },
        removeTimePeriod(id) {
            if (this.time_periods.length > 1) {
                this.time_periods = this.time_periods.filter(time_period => time_period.id !== id);
            }
            return;
        },
        timePeriodOnChange(time = {}) {
            this.time_periods = this.time_periods.map(time_period => {
                if (time_period.id === time.id) {
                    return {
                        id: time_period.id,
                        time: time.value,
                    };
                }

                return time_period;
            })
        },

        submit() {
            this.validateTimePeriods();

            if (!this.time_periods.find(a => Object.keys(a).includes("error"))) {
                let timePeriods = this.time_periods.map(a => ({ time: a.time }));

                this.v$.$touch();
                if (!this.v$.form.$invalid) {
                    this.form
                        .transform((data) => ({
                            ...data,
                            timePeriods
                        }))
                        .post(route().current() == 'time-period.create' ? this.route("time-period.store") : this.route('time-period.update', this.form.id), {
                            onSuccess: (data) => {
                                toast.success(this.$page.props.jetstream.flash.message);
                                this.isEdit = false;
                            },
                            onError: (data) => {
                                if (data.message) {
                                    toast.error(data.message);
                                }
                            },
                        });
                }
            }
        },
    },

    created() {
        if (route().current() == 'time-period.edit') {
            this.isEdit = true;
        }
        this.time_periods = [{ id: Date.now() }];
    },
    mounted() {
    }
});
</script>
<template>
    <Head :title="isEdit ? 'Edit Time Period' : `Add New Period`" />

    <AppLayout :title="isEdit ? 'Edit Period' : `Add New Period`">
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/time-period" class="text-muted text-hover-primary">Time Period</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <span class="text-muted text-hover-primary">Time Period Form</span>
            </li>
        </template>

        <form @submit.prevent="submit()" class="form d-flex flex-column flex-lg-row gap-5">

            <div class="d-flex col-12 col-lg-4 flex-column flex-row-fluid gap-7 gap-lg-10">
                <div class="card card-flush py-4">
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <div>
                            <!--begin::Form group-->
                            <div class="">

                                <div>
                                    <div class="row align-items-center">
                                        <TimePeriodList @onChange="timePeriodOnChange" :options="times?.data"
                                            @remove="removeTimePeriod" :time_periods="time_periods"
                                            :timePeriods="timePeriods" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-5">
                                <!--begin::Button-->
                                <button type="button" @click="addTimePeriods()" class="btn btn-sm btn-light-primary">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 12 16"
                                        height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-time="evenodd" d="M12 9H7v5H5V9H0V7h5V2h2v5h5v2z"></path>
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
                <div class="d-flex justify-content-end gap-5">
                    <Link href="/time-periods"
                        class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                    Discard
                    </Link>
                    <button type="submit" class="btn btn-primary" :class="{ 'text-white-50': form.processing }">
                        <div v-show="form.processing" class="spinner-border spinner-border-sm">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span v-if="route().current() == 'time-period.edit'">Update</span>
                        <span v-if="route().current() == 'time-period.create'">Save</span>
                    </button>
                   
                    <!--end::Button-->
                </div>
            </div>

        </form>
    </AppLayout>
</template>
