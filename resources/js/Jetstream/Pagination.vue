<template>
    <ul class="pagination" v-if="links.length > 3">
        <template v-for="(link, key) in links" :key="key">
            <li v-if="link.url === null" class="page-item disabled">
                <span class="page-link" aria-hidden="true" v-html="link.label"></span>
            </li>

            <Link v-else class="page-item" :class="{ 'active': link.active }" :href="link.url">
            <span class="page-link" aria-hidden="true" v-html="link.label"></span>
            </Link>
        </template>
    </ul>
</template>

<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
export default defineComponent({
    components: {
        Link,
    },
    props: {
        links: Array,
    },
});
</script>
