<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "./Components/Header.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import useVuelidate from "@vuelidate/core";
import AnswerForm from "./Components/Answer/AnswerForm.vue";
import { toast } from "vue3-toastify";
import Pagination from "../../Jetstream/Pagination.vue";
import Swal from "sweetalert2";


export default defineComponent({
    props: ['question', 'answers'],
    setup() {
        return { v$: useVuelidate() }
    },
    validations() {
        return {
            form: {

            }
        }
    },
    data() {
        return {
            isEdit: false,
            isAdd: false,
            form: {
                processing: false,
            },
            title: 'Question Overview',
            tbody: [
                "Question",
                "Answer",
                "Order By",
                "Action",
            ],
            checkbox: [],
        }
    },
    components: {
        AppLayout,
        Header,
        Link,
        Head,
        AnswerForm,
        Pagination
    },
    methods: {
        submit(form) {
            this.form = form;
            console.log(this.form.id)
            this.form
                .transform((data) => ({
                    ...data,
                }))
                .post(this.isEdit ? this.route("answer.update", this.form.id) : this.route("answer.store"), {
                    onSuccess: (data) => {
                        toast.success(this.$page.props.jetstream.flash.message);
                        this.isEdit = false;
                        this.isAdd = false;
                    },
                    onError: (data) => {
                        console.log(data);
                    },
                });
        },
        toggleModal(isEdit, answer) {
            this.isEdit = isEdit;
            this.form = answer;
        },
        confirmDelete(id, index) {
            const name = this.answers.data[index].question?.question_key;

            Swal.fire({
                title: "Are you sure you want to delete " + name + " ?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete("/answer/" + id)
                        .then((response) => {
                            toast.success(response.data.message)
                            if (response.data.success) {
                                this.answers.data.splice(index, 1);
                                return;
                            }
                        })

                        .catch((error) => {
                            if (error.response.status == 400) {
                                toast.error(error.response.data.message);
                            }
                        });
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: name + " was not deleted.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    });
                }

            });
        },

    }

});
</script>
<template>
    <Head :title="isEdit ? 'Edit Answer' : `Add New Answer`" />

    <AppLayout>
        <template #breadcrumb>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/question" class="text-muted text-hover-primary">Question</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                {{ question?.data?.question_key }}
            </li>
        </template>

        <!--begin::Navbar-->
        <Header :question="question?.data" :answers="answers" />
        <!-- {{ $page }} -->
        <!--begin::details View-->
        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header cursor-pointer">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Manage Question </h3>
                    <!-- {{ question }} -->
                </div>
                <!--end::Card title-->
                <button class="btn btn-primary align-self-center" v-if="!isEdit"
                    @click="this.isAdd = true, this.form = {}"><i class="bi bi-plus-circle"></i>Add A New Answer
                </button>
                <!-- <a href="settings.html" class="btn btn-primary align-self-center">Edit Profile</a> -->
            </div>
            <!--begin::Card header-->
            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Form-->
                <div class="row" v-if="isEdit || isAdd">
                    <div class="col-12">

                        <AnswerForm @submitted="submit" :answer="form" :question="question.data">
                            <template #action>
                                <div class="d-flex justify-content-end">
                                    <!--begin::Button-->
                                    <button type="button" class="btn btn-outline-secondary me-5"
                                        @click="this.isEdit = false, this.isAdd = false">Discard</button>
                                    <!--begin::Button-->
                                    <button type="submit" class="btn btn-primary"
                                        :class="{ 'text-white-50': form.processing }">
                                        <div v-show="form.processing" class="spinner-border spinner-border-sm">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <span v-if="isEdit">Save Changes</span>
                                        <span v-if="!isEdit">Save</span>
                                    </button>
                                </div>
                            </template>
                        </AnswerForm>
                    </div>
                </div>
                <div class="row" v-else>
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5 text-center">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-gray-900 fw-bold fs-6 text-uppercase">

                                    <th v-for="(th, index) in tbody" :key="index">
                                        {{ th }}
                                    </th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-semibold text-gray-600">
                                <tr v-for="(answer, index) in answers.data" :key="index">

                                    <td class="text-gray-800 fs-5 fw-bold mb-1">
                                        {{ answer.question?.question_key }}
                                    </td>
                                    <td>{{ answer.answer }}</td>
                                    <td v-if="(answer.order_by == 1)">Ascending</td>
                                    <td v-else="( answer.order_by == 0 )">Descending</td>

                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                                :id="`dropdown-${answer.id}`" data-bs-toggle="dropdown"
                                                aria-expanded="false">Actions
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                <span class="svg-icon svg-icon-5 m-0">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                            fill="currentColor"></path>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>

                                            <ul class="dropdown-menu text-small menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                :aria-labelled:by="`dropdown-${answer.id}`">
                                                <li class="menu-item px-3">
                                                    <button
                                                        class="btn btn-sm dropdown-item align-items-center justify-content-center"
                                                        @click="toggleModal(true, answer)">Edit
                                                    </button>
                                                </li>

                                                <li class="menu-item px-3">
                                                    <button @click="confirmDelete(answer.id, index)"
                                                        class="btn btn-sm dropdown-item align-items-center justify-content-center">
                                                        Delete
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <!--end::Table body-->
                        </table>
                    </div>
                    <div class="d-flex align-items-center justify-content-center justify-content-md-end"
                        v-if="answers.meta">
                        <Pagination :links="answers.meta.links" />
                    </div>
                </div>
            </div>

            <!--end::Card body-->
        </div>

        <!--end::details View-->
    </AppLayout>
</template>
