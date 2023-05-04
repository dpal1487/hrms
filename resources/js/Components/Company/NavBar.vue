<script>

import { defineComponent } from 'vue';

import { Link } from '@inertiajs/inertia-vue3';


export default defineComponent({

    components:{
        Link
    }

})

</script>

<template>
    <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
        <!--begin::Nav item-->
        <li class="nav-item mt-2">
            <Link :class="`nav-link text-active-primary ms-0 me-10 py-5 ${route().current('company.overview') && 'active'}`"
                :href="'/company/' + $page.props.ziggy.company.id + '/overview'">Overview
            </Link>
        </li>
        <!--end::Nav item-->

        <!--begin::Nav item-->
        <li class="nav-item mt-2">
            <Link :class="`nav-link text-active-primary ms-0 me-10 py-5 ${route().current('company.address') && 'active'}`"
                :href="'/company/' + $page.props.ziggy.company.id + '/address'">Address
            </Link>
        </li>
        <!--end::Nav item-->
        <!--begin::Nav item-->
        <li class="nav-item mt-2">
            <Link :class="`nav-link text-active-primary ms-0 me-10 py-5 ${route().current('company.accounts') && 'active'}`"
                :href="'/company/' + $page.props.ziggy.company.id + '/accounts'">Account
            </Link>
        </li>
        <!--end::Nav item-->
        <!--begin::Nav item-->
        <li class="nav-item mt-2">
            <Link :class="`nav-link text-active-primary ms-0 me-10 py-5 ${route().current('company.emails') && 'active'}`"
                :href="'/company/' + $page.props.ziggy.company.id + '/emails'">Email
            </Link>
        </li>
        <!--end::Nav item-->
        <!--begin::Nav item-->
        <li class="nav-item mt-2">
            <Link :class="`nav-link text-active-primary ms-0 me-10 py-5 ${route().current('company.invoices') && 'active'}`"
                :href="'/company/' + $page.props.ziggy.company.id + '/invoices'">Invoices
            </Link>
        </li>
        <li class="nav-item mt-2">
            <Link :class="`nav-link text-active-primary ms-0 me-10 py-5 ${route().current('company.projects') && 'active'}`"
                :href="'/company/' + $page.props.ziggy.company.id + '/projects'">Projects
            </Link>
        </li>
        <li class="nav-item mt-2">
            <Link
                :class="`nav-link text-active-primary ms-0 me-10 py-5 ${route().current('company.suppliers') && 'active'}`"
                :href="'/company/' + $page.props.ziggy.company.id + '/suppliers'">Suppliers
            </Link>
        </li>
        <!--end::Nav item-->
    </ul>
</template>