<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import AppHeader from "./AppHeader.vue";
import AppSidebar from "./AppSidebar.vue";

export default {
    props: {
        title: String,
        breadcrumb: Object,
    },

    components: {
        Head,
        Link,
        AppHeader,
        AppSidebar,
    },

    data() {
        return {
            showingNavigationDropdown: false,
            hideSidebarOn: []
        };
    },

    methods: {
        switchToTeam(team) {
            this.$inertia.put(
                route("current-team.update"),
                {
                    team_id: team.id,
                },
                {
                    preserveState: false,
                }
            );
        },

        logout() {
            this.$inertia.post(route("logout"));
        },
    },

    computed: {
        path() {
            return window.location.pathname;
        },
    },
};
</script>


<template>
    <div>

        <Head :title="title" />
        <AppHeader />
        <AppSidebar v-if="true" />
        <!-- Page Content -->
        <main class="app-wrapper flex-column flex-row-fluid">
            <div class="app-main flex-column flex-row-fluid">
                <div class="d-flex flex-column flex-column-fluid">
                    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                        <!--begin::Toolbar container-->
                        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                            <!--begin::Page title-->
                            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                                <!--begin::Title-->
                                <h1
                                    class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                                    {{ title }}
                                </h1>
                                <!--end::Title-->
                                <!--begin::Breadcrumb-->
                                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-muted">
                                        <a href="/" class="text-muted text-hover-primary">Home</a>
                                    </li>
                                    <!--end::Item-->
                                    <slot name="breadcrumb" />
                                </ul>
                                <!--end::Breadcrumb-->
                            </div>
                            <!--end::Page title-->
                        </div>
                        <!--end::Toolbar container-->
                    </div>

                    <div class="app-content flex-column-fluid">
                        <!--begin::Content container-->
                        <div class="app-container container-fluid">
                            <slot></slot>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>


