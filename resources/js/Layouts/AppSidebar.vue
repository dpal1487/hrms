<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

export default defineComponent({
    props: ["projects", "status", "isMobile", "isSidebarActive"],
    emits: ["setSidebar"],
    components: {
        Link,
    },
    data() {
        return {
            isExpanded: true,
            q: "",
        };
    },
    methods: {
        search() {
            console.log(this.q);
        },
        updateSelected(id, e) {

        },
        logout() {
            Inertia.post(route('logout'));
        },
    },
    created() {
    },
});

</script>
<template>
    <div id="sidebar"
        :class="`app-sidebar flex-column ${isMobile ? 'drawer drawer-start' : ''} ${isSidebarActive ? 'drawer-on' : ''}`"
        data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}"
        data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start"
        data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
        <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
            <Link href="/dashboard">
            <img alt="Logo" src="/assets/media/logos/logo.png" class="h-25px app-sidebar-logo-default" />
            <img alt="Logo" src="/assets/media/logos/logo.png" class="h-20px app-sidebar-logo-minimize" />
            </Link>
            <div id="kt_app_sidebar_toggle"
                class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate">
                <span class="svg-icon svg-icon-2 rotate-180">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.5"
                            d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                            fill="currentColor"></path>
                        <path
                            d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                            fill="currentColor"></path>
                    </svg>
                </span>
            </div>
        </div>
        <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
            <div class="app-sidebar-wrapper hover-scroll-overlay-y h-650px">
                <div class="menu menu-column menu-rounded menu-sub-indention px-5" id="#kt_app_sidebar_menu"
                    data-kt-menu="true" data-kt-menu-expand="false">
                    <div class="menu-item">
                        <span class="menu-link fs-2">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor"></rect>
                                        <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="currentColor">
                                        </rect>
                                        <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="currentColor">
                                        </rect>
                                        <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="currentColor">
                                        </rect>
                                    </svg>
                                </span>
                            </span>
                            <Link class="menu-link" href="/dashboard">
                                <span class="menu-title">Dashboard</span>
                            </Link>
                            <span class="menu-arrow"></span>
                        </span>
                    </div>
                    <div class="menu menu-column menu-rounded menu-sub-indention px-3"
                        v-for="(menu, index) in $page.props.ziggy.menus.data" :key="index">
                        <div class="menu-item pt-5">
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">{{ menu.name }}</span>
                            </div>
                        </div>
                        <div class="menu-item" v-for="(item, index) in menu.items" :key="index">
                            <Link class="menu-link" :href="item.url">
                            <i :class="item.icon_class"></i>
                            <span class="ms-2">{{ item.title }}</span>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6">
            <form method="post" @submit.prevent="logout">
                <button type="submit"
                    class="btn btn-flex flex-center btn-custom btn-primary overflow-hidden text-nowrap px-0 h-40px w-100">
                    <span class="btn-label">Logout</span>
                    <span class="svg-icon btn-icon svg-icon-2 m-0">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.3"
                                d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM12.5 18C12.5 17.4 12.6 17.5 12 17.5H8.5C7.9 17.5 8 17.4 8 18C8 18.6 7.9 18.5 8.5 18.5L12 18C12.6 18 12.5 18.6 12.5 18ZM16.5 13C16.5 12.4 16.6 12.5 16 12.5H8.5C7.9 12.5 8 12.4 8 13C8 13.6 7.9 13.5 8.5 13.5H15.5C16.1 13.5 16.5 13.6 16.5 13ZM12.5 8C12.5 7.4 12.6 7.5 12 7.5H8C7.4 7.5 7.5 7.4 7.5 8C7.5 8.6 7.4 8.5 8 8.5H12C12.6 8.5 12.5 8.6 12.5 8Z"
                                fill="currentColor"></path>
                            <rect x="7" y="17" width="6" height="2" rx="1" fill="currentColor"></rect>
                            <rect x="7" y="12" width="10" height="2" rx="1" fill="currentColor"></rect>
                            <rect x="7" y="7" width="6" height="2" rx="1" fill="currentColor"></rect>
                            <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor"></path>
                        </svg>
                    </span>
                </button>
            </form>
        </div>
    </div>
</template>
