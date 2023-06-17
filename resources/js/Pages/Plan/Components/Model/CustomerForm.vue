<script>
import { defineComponent } from 'vue';
import Modal from '@/Components/Modal.vue';
import { toast } from 'vue3-toastify';
import axios from 'axios';

export default defineComponent({
    props: ['users', 'show'],
    validations() {
        return {

        }
    },
    data() {
        return {
            s: '',
            processing: false,

        }
    },
    components: {
        Modal
    },
    methods: {

        hideCreateTicketModal() {
            console.log(this.isModalOpen)
            this.isModalOpen = false;
        }

    },
});
</script>
<template>
    <Modal :show="show" @onhide="$emit('hidemodal')" title="Search Customers">
        <!--begin::Modal body-->

        <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-10">
            <!-- <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15"> -->
            <!--begin::Content-->
            <div class="text-center mb-12">
                <div class="text-gray-400 fw-semibold fs-5">Add a customer to a subscription</div>
            </div>
            <!--end::Content-->
            <!--begin::Search-->
            <!--begin::Form-->

            <form data-kt-search-element="form" class="w-100 position-relative mb-5" autocomplete="off">
                <!--begin::Hidden input(Added to disable form autocomplete)-->
                <input type="hidden" />
                <!--end::Hidden input-->
                <!--begin::Icon-->
                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->

                <!--end::Svg Icon-->
                <!--end::Icon-->
                <!--begin::Input-->
                <input type="text" class="form-control form-control-lg form-control-solid px-15" v-model="s"
                    placeholder="Search by username, full name or email..." data-kt-search-element="input" />
                <!--end::Input-->
                <!--begin::Spinner-->
                <span class="position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5"
                    data-kt-search-element="spinner">
                    <span class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
                </span>
                <!--end::Spinner-->
                <!--begin::Reset-->
                <span
                    class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 me-5 d-none"
                    data-kt-search-element="clear">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-2 svg-icon-lg-1 me-0">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <!--end::Reset-->
            </form>
            <!--end::Form-->
            <!--begin::Wrapper-->
            <div class="py-5">
                <!--begin::Suggestions-->
                <div data-kt-search-element="suggestions">
                    <!--begin::Illustration-->
                    <div class="text-center px-4 pt-10">
                        <img src="/assets/media/illustrations/sketchy-1/4.png" alt="" class="mw-100 mh-200px" />
                    </div>
                    <!--end::Illustration-->
                </div>
                <!--end::Suggestions-->
                <!--begin::Results-->
                <div data-kt-search-element="results" class="d-none">
                    <!--begin::Users-->
                    <div class="mh-300px scroll-y me-n5 pe-5">
                        <!--begin::User-->
                        <div class="d-flex align-items-center p-3 rounded-3 border-hover border border-dashed border-gray-300 cursor-pointer mb-1"
                            data-kt-search-element="customer">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-35px symbol-circle me-5">
                                <img alt="Pic" src="/assets/media/avatars/300-6.jpg" />
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Info-->
                            <div class="fw-semibold">
                                <span class="fs-6 text-gray-800 me-2">Emma Smith</span>
                                <span class="badge badge-light">Art Director</span>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                        <!--begin::User-->
                        <div class="d-flex align-items-center p-3 rounded-3 border-hover border border-dashed border-gray-300 cursor-pointer mb-1"
                            data-kt-search-element="customer">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-35px symbol-circle me-5">
                                <span class="symbol-label bg-light-danger text-danger fw-semibold">M</span>
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Info-->
                            <div class="fw-semibold">
                                <span class="fs-6 text-gray-800 me-2">Melody Macy</span>
                                <span class="badge badge-light">Marketing Analytic</span>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                        <!--begin::User-->
                        <div class="d-flex align-items-center p-3 rounded-3 border-hover border border-dashed border-gray-300 cursor-pointer mb-1"
                            data-kt-search-element="customer">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-35px symbol-circle me-5">
                                <img alt="Pic" src="/assets/media/avatars/300-1.jpg" />
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Info-->
                            <div class="fw-semibold">
                                <span class="fs-6 text-gray-800 me-2">Max Smith</span>
                                <span class="badge badge-light">Software Enginer</span>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                        <!--begin::User-->
                        <div class="d-flex align-items-center p-3 rounded-3 border-hover border border-dashed border-gray-300 cursor-pointer mb-1"
                            data-kt-search-element="customer">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-35px symbol-circle me-5">
                                <img alt="Pic" src="/assets/media/avatars/300-5.jpg" />
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Info-->
                            <div class="fw-semibold">
                                <span class="fs-6 text-gray-800 me-2">Sean Bean</span>
                                <span class="badge badge-light">Web Developer</span>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                        <!--begin::User-->
                        <div class="d-flex align-items-center p-3 rounded-3 border-hover border border-dashed border-gray-300 cursor-pointer mb-1"
                            data-kt-search-element="customer">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-35px symbol-circle me-5">
                                <img alt="Pic" src="/assets/media/avatars/300-25.jpg" />
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Info-->
                            <div class="fw-semibold">
                                <span class="fs-6 text-gray-800 me-2">Brian Cox</span>
                                <span class="badge badge-light">UI/UX Designer</span>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                        <!--begin::User-->
                        <div class="d-flex align-items-center p-3 rounded-3 border-hover border border-dashed border-gray-300 cursor-pointer mb-1"
                            data-kt-search-element="customer">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-35px symbol-circle me-5">
                                <span class="symbol-label bg-light-warning text-warning fw-semibold">C</span>
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Info-->
                            <div class="fw-semibold">
                                <span class="fs-6 text-gray-800 me-2">Mikaela Collins</span>
                                <span class="badge badge-light">Head Of Marketing</span>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                        <!--begin::User-->
                        <div class="d-flex align-items-center p-3 rounded-3 border-hover border border-dashed border-gray-300 cursor-pointer mb-1"
                            data-kt-search-element="customer">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-35px symbol-circle me-5">
                                <img alt="Pic" src="/assets/media/avatars/300-9.jpg" />
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Info-->
                            <div class="fw-semibold">
                                <span class="fs-6 text-gray-800 me-2">Francis Mitcham</span>
                                <span class="badge badge-light">Software Arcitect</span>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                        <!--begin::User-->
                        <div class="d-flex align-items-center p-3 rounded-3 border-hover border border-dashed border-gray-300 cursor-pointer mb-1"
                            data-kt-search-element="customer">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-35px symbol-circle me-5">
                                <span class="symbol-label bg-light-danger text-danger fw-semibold">O</span>
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Info-->
                            <div class="fw-semibold">
                                <span class="fs-6 text-gray-800 me-2">Olivia Wild</span>
                                <span class="badge badge-light">System Admin</span>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                        <!--begin::User-->
                        <div class="d-flex align-items-center p-3 rounded-3 border-hover border border-dashed border-gray-300 cursor-pointer mb-1"
                            data-kt-search-element="customer">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-35px symbol-circle me-5">
                                <span class="symbol-label bg-light-primary text-primary fw-semibold">N</span>
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Info-->
                            <div class="fw-semibold">
                                <span class="fs-6 text-gray-800 me-2">Neil Owen</span>
                                <span class="badge badge-light">Account Manager</span>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                        <!--begin::User-->
                        <div class="d-flex align-items-center p-3 rounded-3 border-hover border border-dashed border-gray-300 cursor-pointer mb-1"
                            data-kt-search-element="customer">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-35px symbol-circle me-5">
                                <img alt="Pic" src="/assets/media/avatars/300-23.jpg" />
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Info-->
                            <div class="fw-semibold">
                                <span class="fs-6 text-gray-800 me-2">Dan Wilson</span>
                                <span class="badge badge-light">Web Desinger</span>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                    </div>
                    <!--end::Users-->
                </div>
                <!--end::Results-->
                <!--begin::Empty-->
                <div data-kt-search-element="empty" class="text-center d-none">
                    <!--begin::Message-->
                    <div class="fw-semibold py-0 mb-10">
                        <div class="text-gray-600 fs-3 mb-2">No users found</div>
                        <div class="text-gray-400 fs-6">Try to search by username, full name or email...</div>
                    </div>
                    <!--end::Message-->
                    <!--begin::Illustration-->
                    <div class="text-center px-4">
                        <img src="/assets/media/illustrations/sketchy-1/9.png" alt="user" class="mw-100 mh-200px" />
                    </div>
                    <!--end::Illustration-->
                </div>
                <!--end::Empty-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Search-->
        <!--end::Modal body-->

    </Modal>
</template>