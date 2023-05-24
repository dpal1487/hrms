<script>

import { defineComponent } from 'vue';

import AppLayout from '@/Layouts/AppLayout.vue'
import { Head } from '@inertiajs/inertia-vue3';
import UserRoleForm from './Components/UserRoleForm.vue';

export default defineComponent({

    props: ['permissions', 'roles'],
    data() {
        return {
            isEdit: false,
            role: [],
            showModal: false,

        }

    },
    components: {
        AppLayout,
        Head,
        UserRoleForm,
    },
    methods: {
        toggleModal(value, role) {
            if (value, role) {
                this.isEdit = true;
                this.showModal = true;
                this.role = role;
            }
            else if (value) {
                this.showModal = true;
            }
            else {
                this.showModal = false;
            }
        },
    }

})
</script>

<template>
    <Head title="User Role" />
    <AppLayout>
        <!--begin::Row-->
        <UserRoleForm v-if="showModal" :show="showModal" :isEdit="isEdit" @hidemodal="toggleModal(false)"
            :permissions="permissions.data" :role="role" />
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
            <!--begin::Col-->
            <div class="col-md-6" v-for="(role, index) in roles.data" :key="index">
                <!--begin::Card-->
                <div class="card card-flush h-md-100">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title text-uppercase">
                            <h2>{{ role.name }}</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-1">
                        <!--begin::Users-->
                        <div class="fw-bold text-gray-600 mb-5">Total users with this role: 5</div>
                        <!--end::Users-->
                        <!--begin::Permissions-->
                        <div class="d-flex flex-column text-gray-600">
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>All Admin Controls
                            </div>
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>View and Edit Financial
                                Summaries
                            </div>
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>Enabled Bulk Reports
                            </div>
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>View and Edit Payouts
                            </div>
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>View and Edit Disputes
                            </div>
                            <div class='d-flex align-items-center py-2'>
                                <span class='bullet bg-primary me-3'></span>
                                <em>and 7 more...</em>
                            </div>
                        </div>
                        <!--end::Permissions-->
                    </div>
                    <!--end::Card body-->
                    <!--begin::Card footer-->
                    <div class="card-footer flex-wrap pt-0">
                        <a href="/roles/user/view" class="btn btn-light btn-active-primary my-1 me-2">View Role</a>
                        <button type="button" class="btn btn-light btn-active-light-primary my-1"
                            @click="toggleModal(true, role)">Edit Role</button>
                    </div>
                    <!--end::Card footer-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->



            <!--begin::Add new card-->
            <div class="col-md-6">
                <!--begin::Card-->
                <div class="card h-md-100">
                    <!--begin::Card body-->
                    <div class="card-body d-flex flex-center">
                        <!--begin::Button-->
                        <button type="button" class="btn btn-clear d-flex flex-column flex-center" @click=toggleModal(true)>
                            <!--begin::Illustration-->
                            <img src="/assets/media/illustrations/sketchy-1/4.png" alt="" class="mw-100 mh-150px mb-7" />
                            <!--end::Illustration-->
                            <!--begin::Label-->
                            <div class="fw-bold fs-3 text-gray-600 text-hover-primary">Add New Role</div>
                            <!--end::Label-->
                        </button>
                        <!--begin::Button-->
                    </div>
                    <!--begin::Card body-->
                </div>
                <!--begin::Card-->
            </div>
            <!--begin::Add new card-->
        </div>
        <!--end::Row-->
    </AppLayout>
</template>