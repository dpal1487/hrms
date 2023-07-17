<script type>
import axios from 'axios';
import { defineComponent } from 'vue';
import Loading from "vue-loading-overlay";
import 'vue-loading-overlay/dist/css/index.css';
import { toast } from 'vue3-toastify';
import { Inertia } from "@inertiajs/inertia";

export default defineComponent({
    props: ['id'],
    data() {
        return {
            loading: false,
            statusToggle: false,
        }
    },
    methods: {
        statusChange(id, value) {
            this.loading = true;
            axios.post(this.route("item.status"), { id: this.id, status: value })
                .then((response) => {
                    if (response.data.success == true) {
                        Inertia.get(
                            "/items",
                        );
                    }
                    else {
                        toast.error(response.data.message)
                    }
                });

        },
        toggleStatus() {
            this.statusToggle = !this.statusToggle;
        },
        params() {
            function getUrlVars() {
                var vars = {};
                var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,
                    function (m, key, value) {
                        vars[key] = value;
                    });
                return vars;
            }
        }
    },
    components: {
        Loading,
    },
    created() {
        // var fType = getUrlVars()["type"];
        // console.log(fType);
    }
});
</script>
<template type>
    <loading v-model:active="loading" :can-cancel="false" :is-full-page="true" />
    <div class="card-toolbar position-absolute w-fit top-0 end-0 p-5">
        <!--begin::Menu-->
        <button class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end" @click="toggleStatus">
            <span class="svg-icon svg-icon-1 svg-icon-gray-300 me-n1">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="4" fill="currentColor" />
                    <rect x="11" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                    <rect x="15" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                    <rect x="7" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                </svg>
            </span>
        </button>
        <!--begin::Menu 2-->
        <div v-if="statusToggle"
            class="toggle menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px show position-absolute end-0 "
            data-kt-menu="true">
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <button href="#" id="kt_docs_sweetalert_basic" @click="statusChange(item, 1)"
                    class="menu-link px-3 border-0 bg-transparent statusChange">Active</button>
            </div>
            <div class="menu-item px-3">
                <button href="#" id="kt_docs_sweetalert_basic" @click="statusChange(item, 2)"
                    class="menu-link px-3 border-0 bg-transparent statusChange">Pending</button>
            </div>
            <div class="menu-item px-3">
                <button href="#" id="kt_docs_sweetalert_basic" @click="statusChange(item, 3)"
                    class="menu-link px-3 border-0 bg-transparent statusChange">Rejected</button>
            </div>
            <div class="menu-item px-3">
                <button href="#" id="kt_docs_sweetalert_basic" @click="statusChange(item, 4)"
                    class="menu-link px-3 border-0 bg-transparent statusChange">Featured</button>
            </div>
            <div class="menu-item px-3">
                <button href="#" id="kt_docs_sweetalert_basic" @click="statusChange(item, 5)" data-id="{{ $itemid }}"
                    data-status="5" class="menu-link px-3 border-0 bg-transparent statusChange">Deactivated</button>
            </div>
            <!-- <x-item-cart-status :itemid="item?.id" /> -->
            <!--end::Menu item-->
        </div>
    </div>
</template>