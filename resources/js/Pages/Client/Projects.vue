<script>
import { defineComponent } from "vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Header from "./Components//Header.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Pagination from "../../Jetstream/Pagination.vue";
import ProjectList from "../Project/Components/ProjectList.vue";
export default defineComponent({
    props: ["projects", "client", "status"],
    data() {
        return {
            title: "Client Projects",
            tbody: [
                "Project ID",
                "Project Name",
                "Project Type",
                "Sample Size",
                "T Click",
                "Complete",
                "Quotafull",
                "Terminate",
                "Incomplete",
                "IR",
                "Date",
                "Status",
                "Action",
            ],
        };
    },
    components: {
        Link,
        Head,
        Header,
        AppLayout,
        Pagination,
        ProjectList
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
            <li class="breadcrumb-item">
                <Link href="/clients" class="text-muted text-hover-primary">Clients</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                {{ client.data.name }}
            </li>
        </template>
        <!--begin::Navbar-->
        <Header :client="client?.data" />
        <div class="card">
            <div class="card-header align-items-center">
                <div class="card-title">
                    <h2>Projects</h2>
                </div>
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <span class="svg-icon svg-icon-1 position-absolute ms-4">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                    transform="rotate(45 17.0365 15.1223)" fill="currentColor">
                                </rect>
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                        <input type="text" data-links-filter="search" class="form-control form-control-solid ps-14 h-35px"
                            placeholder="Search">
                    </div>

                    <!--end::Search-->
                    <Link href="/project/create" class="btn btn-primary btn-sm"><i
                        class="bi bi-plus-circle"></i>Add A New Project</Link>
                    <!--end::Search-->
                </div>
            </div>
            <div class="card-body p-3">
                <!--begin::Table-->
                <div class="table-responsive">
                    <table class="table text-center align-middle table-row-bordered border dataTable no-footer"
                        id="links_table">
                        <thead class="bg-light">
                            <!--begin::Table row-->
                            <tr class="text-gray-400 fw-bold fs-7 text-uppercase">
                                <th v-for="(th, index) in tbody" :key="index">
                                    {{ th }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <ProjectList :projects="projects.data" :status="status.data" />
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-sm-12 d-flex align-items-center justify-content-center justify-content-md-end">
                        <div class="mt-3">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
