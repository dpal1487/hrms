<script>
import { defineComponent } from 'vue';
import AppLayout from '../../Layouts/AppLayout.vue';
import Header from './Components/Header.vue';
import { Link } from '@inertiajs/inertia-vue3';

export default defineComponent({
    props: ['employees'],
    components: {
        AppLayout,
        Header,
        Link
    }
})
</script>


<template>
    <AppLayout>
        <Header :employees="employees.data" />
        <template #breadcrumb>

            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/support" class="text-muted text-hover-primary">Support</Link>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item">
                <Link href="/support/licenses" class="text-muted text-hover-primary">Licenses</Link>
            </li>

        </template>
        <!--begin::About card-->
        <div class="card">
            <!--begin::Body-->
            <div class="card-body p-10 p-lg-15">
                <!--begin::Content main-->
                <div class="mb-14">
                    <!--begin::Heading-->
                    <div class="mb-15">
                        <!--begin::Title-->
                        <h1 class="fs-2x text-dark mb-6">License Comparision</h1>
                        <!--end::Title-->
                        <!--begin::Text-->
                        <div class="fs-5 text-gray-600 fw-semibold">First, a disclaimer – the entire process of writing a
                            blog post often takes more than a couple of hours, even if you can type eighty words as per
                            minute and your writing skills are sharp.</div>
                        <!--end::Text-->
                    </div>
                    <!--end::Heading-->
                    <!--begin::Body-->
                    <!--begin::Table-->
                    <div class="mb-14">
                        <!--begin::Table container-->
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="fw-bold fs-6 text-gray-800 text-center border-0 bg-light">
                                        <th class="min-w-200px rounded-start"></th>
                                        <th class="min-w-140px">Regular</th>
                                        <th class="min-w-120px">Multiple</th>
                                        <th class="min-w-100px rounded-end">Extended</th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="border-bottom border-dashed">
                                    <tr class="fw-semibold fs-6 text-gray-800 text-center">
                                        <td class="text-start ps-6 fs-4">Number of end products or domains</td>
                                        <td>1</td>
                                        <td>Unlimited</td>
                                        <td>1</td>
                                    </tr>
                                    <tr class="text-center">
                                        <td class="text-start ps-6">
                                            <div class="fw-semibold fs-4 text-gray-800">Free end product</div>
                                        </td>
                                        <td>
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr012.svg-->
                                            <span class="svg-icon svg-icon-2x svg-icon-success">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3"
                                                        d="M10 18C9.7 18 9.5 17.9 9.3 17.7L2.3 10.7C1.9 10.3 1.9 9.7 2.3 9.3C2.7 8.9 3.29999 8.9 3.69999 9.3L10.7 16.3C11.1 16.7 11.1 17.3 10.7 17.7C10.5 17.9 10.3 18 10 18Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M10 18C9.7 18 9.5 17.9 9.3 17.7C8.9 17.3 8.9 16.7 9.3 16.3L20.3 5.3C20.7 4.9 21.3 4.9 21.7 5.3C22.1 5.7 22.1 6.30002 21.7 6.70002L10.7 17.7C10.5 17.9 10.3 18 10 18Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--SVG file not found: 0-->
                                        </td>
                                        <td>
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr012.svg-->
                                            <span class="svg-icon svg-icon-2x svg-icon-success">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3"
                                                        d="M10 18C9.7 18 9.5 17.9 9.3 17.7L2.3 10.7C1.9 10.3 1.9 9.7 2.3 9.3C2.7 8.9 3.29999 8.9 3.69999 9.3L10.7 16.3C11.1 16.7 11.1 17.3 10.7 17.7C10.5 17.9 10.3 18 10 18Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M10 18C9.7 18 9.5 17.9 9.3 17.7C8.9 17.3 8.9 16.7 9.3 16.3L20.3 5.3C20.7 4.9 21.3 4.9 21.7 5.3C22.1 5.7 22.1 6.30002 21.7 6.70002L10.7 17.7C10.5 17.9 10.3 18 10 18Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--SVG file not found: 0-->
                                        </td>
                                        <td>
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr012.svg-->
                                            <span class="svg-icon svg-icon-2x svg-icon-success">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3"
                                                        d="M10 18C9.7 18 9.5 17.9 9.3 17.7L2.3 10.7C1.9 10.3 1.9 9.7 2.3 9.3C2.7 8.9 3.29999 8.9 3.69999 9.3L10.7 16.3C11.1 16.7 11.1 17.3 10.7 17.7C10.5 17.9 10.3 18 10 18Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M10 18C9.7 18 9.5 17.9 9.3 17.7C8.9 17.3 8.9 16.7 9.3 16.3L20.3 5.3C20.7 4.9 21.3 4.9 21.7 5.3C22.1 5.7 22.1 6.30002 21.7 6.70002L10.7 17.7C10.5 17.9 10.3 18 10 18Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--SVG file not found: 0-->
                                        </td>
                                    </tr>
                                    <tr class="text-center">
                                        <td class="text-start ps-6">
                                            <div class="fw-semibold fs-4 text-gray-800">End product with paid services</div>
                                        </td>
                                        <td>
                                            <!--SVG file not found: 0-->
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                            <span class="svg-icon svg-icon-2x svg-icon-danger">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                                        transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                        transform="rotate(45 7.41422 6)" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </td>
                                        <td>
                                            <!--SVG file not found: 0-->
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                            <span class="svg-icon svg-icon-2x svg-icon-danger">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                                        transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                        transform="rotate(45 7.41422 6)" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </td>
                                        <td>
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr012.svg-->
                                            <span class="svg-icon svg-icon-2x svg-icon-success">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3"
                                                        d="M10 18C9.7 18 9.5 17.9 9.3 17.7L2.3 10.7C1.9 10.3 1.9 9.7 2.3 9.3C2.7 8.9 3.29999 8.9 3.69999 9.3L10.7 16.3C11.1 16.7 11.1 17.3 10.7 17.7C10.5 17.9 10.3 18 10 18Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M10 18C9.7 18 9.5 17.9 9.3 17.7C8.9 17.3 8.9 16.7 9.3 16.3L20.3 5.3C20.7 4.9 21.3 4.9 21.7 5.3C22.1 5.7 22.1 6.30002 21.7 6.70002L10.7 17.7C10.5 17.9 10.3 18 10 18Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--SVG file not found: 0-->
                                        </td>
                                    </tr>
                                    <tr class="text-center">
                                        <td class="text-start ps-6">
                                            <div class="fw-semibold fs-4 text-gray-800">Use in derivative themes or
                                                “generators”</div>
                                        </td>
                                        <td>
                                            <!--SVG file not found: 0-->
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                            <span class="svg-icon svg-icon-2x svg-icon-danger">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                                        transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                        transform="rotate(45 7.41422 6)" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </td>
                                        <td>
                                            <!--SVG file not found: 0-->
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                            <span class="svg-icon svg-icon-2x svg-icon-danger">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                                        transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                        transform="rotate(45 7.41422 6)" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </td>
                                        <td>
                                            <!--SVG file not found: 0-->
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                            <span class="svg-icon svg-icon-2x svg-icon-danger">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                                        transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                        transform="rotate(45 7.41422 6)" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </td>
                                    </tr>
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Table container-->
                    </div>
                    <!--end::Table-->
                    <!--begin::Block-->
                    <div class="mb-20 pb-lg-20">
                        <!--begin::Title-->
                        <h2 class="fw-bold text-dark mb-8">Regular License:</h2>
                        <!--end::Title-->
                        <!--begin::List-->
                        <ul class="fs-4 fw-semibold mb-6">
                            <li>
                                <span class="text-gray-700">E-commerce site</span>
                            </li>
                            <li class="my-2">
                                <span class="text-gray-700">Company business activity dashboard</span>
                            </li>
                            <li>
                                <span class="text-gray-700">Customer support center</span>
                            </li>
                        </ul>
                        <!--end::List-->
                        <!--begin::Text-->
                        <div class="fs-4 fw-semibold text-gray-700 mb-13">If users can free browse and use your website or
                            Admin Panel is used only as interface(eCommerce site) to sell other's products you can use
                            Regular license.
                            <br />If you are going to use the item on one domain and multiple subdomains, you only require
                            one Licence.(ex: www.
                            <span class="text-dark">domain.com</span>/site1 – site2.
                            <span class="text-dark">domain.com</span>– site.3.
                            <span class="text-dark">domain.com</span>).
                        </div>
                        <!--end::Text-->
                        <!--begin::Title-->
                        <h2 class="fw-bold text-dark mb-7">Multisite License:</h2>
                        <!--end::Title-->
                        <!--begin::List-->
                        <ul>
                            <li>
                                <span class="fs-4 fw-semibold text-gray-700">It works the same as the Standard License, but
                                    you can use it in unlimited count of projects.</span>
                            </li>
                        </ul>
                        <!--end::List-->
                        <!--begin::Text-->
                        <div class="fs-4 fw-semibold text-gray-700 mb-13">If users can free browse and use your website is
                            used only as interface(eCommerce site) to sell other's products you can use Regular license. if
                            you are going to use the item on multiple domains, then you will need to purchase a Licence for
                            each domain or buy Multisite License.
                            <br />(ex: www.domain-site-
                            <span class="text-dark">one.com</span>– www.domain-site.
                            <span class="text-dark">two.com</span>– www.site-three-
                            <span class="text-dark">domain.com</span>).
                        </div>
                        <!--end::Text-->
                        <!--begin::Title-->
                        <h2 class="fw-bold text-dark mb-8">Extended License:</h2>
                        <!--end::Title-->
                        <!--begin::List-->
                        <ul class="fs-4 fw-semibold mb-6">
                            <li>
                                <span class="text-gray-700">SaaS projects</span>
                            </li>
                            <li class="my-2">
                                <span class="text-gray-700">Photo stock with PRO subscription</span>
                            </li>
                            <li>
                                <span class="text-gray-700">Cloud service with paid plans</span>
                            </li>
                        </ul>
                        <!--end::List-->
                        <!--begin::Text-->
                        <div class="fs-4 fw-semibold text-gray-700">E-commerce site Company business activity dashboard
                            Customer support center If users can free browse and use your website is used only as
                            interface(eCommerce site) to sell other's products you can use Regular license. If you are going
                            to use the item on one domain and multiple subdomains, you only require one Licence . (ex:
                            www.domain.com/site1 – site2.domain.com – site.3.domain.com).</div>
                        <!--end::Text-->
                    </div>
                    <!--end::Block-->
                    <!--end::Body-->
                </div>
                <!--end::Content main-->
                <!--begin::Card-->
                <div class="card mb-4 bg-light text-center">
                    <!--begin::Body-->
                    <div class="card-body py-12">
                        <!--begin::Icon-->
                        <a href="#" class="mx-4">
                            <img src="/assets/media/svg/brand-logos/facebook-4.svg" class="h-30px my-2" alt="" />
                        </a>
                        <!--end::Icon-->
                        <!--begin::Icon-->
                        <a href="#" class="mx-4">
                            <img src="/assets/media/svg/brand-logos/instagram-2-1.svg" class="h-30px my-2" alt="" />
                        </a>
                        <!--end::Icon-->
                        <!--begin::Icon-->
                        <a href="#" class="mx-4">
                            <img src="/assets/media/svg/brand-logos/github.svg" class="h-30px my-2" alt="" />
                        </a>
                        <!--end::Icon-->
                        <!--begin::Icon-->
                        <a href="#" class="mx-4">
                            <img src="/assets/media/svg/brand-logos/behance.svg" class="h-30px my-2" alt="" />
                        </a>
                        <!--end::Icon-->
                        <!--begin::Icon-->
                        <a href="#" class="mx-4">
                            <img src="/assets/media/svg/brand-logos/pinterest-p.svg" class="h-30px my-2" alt="" />
                        </a>
                        <!--end::Icon-->
                        <!--begin::Icon-->
                        <a href="#" class="mx-4">
                            <img src="/assets/media/svg/brand-logos/twitter.svg" class="h-30px my-2" alt="" />
                        </a>
                        <!--end::Icon-->
                        <!--begin::Icon-->
                        <a href="#" class="mx-4">
                            <img src="/assets/media/svg/brand-logos/dribbble-icon-1.svg" class="h-30px my-2" alt="" />
                        </a>
                        <!--end::Icon-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::About card-->


    </AppLayout>
</template>