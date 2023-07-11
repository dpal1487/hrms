<script type>
import axios from 'axios';
import { defineComponent } from 'vue';
import Loading from "vue-loading-overlay";
import 'vue-loading-overlay/dist/css/index.css';
import { toast } from 'vue3-toastify';
export default defineComponent({

    props: ['item'],
    data() {
        return {
            loading: false
        }
    },
    methods: {
        statusChange(id, value) {
            this.loading = true;
            axios.post(this.route("item.status"), { id: id, status: value })
                .then((response) => {

                    if (response.data.success == true) {
                        toast.success(response.data.message)
                        this.loading = false
                    }
                    else {
                        toast.error(response.data.message)
                    }
                });

        }
    },
    components: {
        Loading,
    }
});

</script>

<template type>
    <loading v-model:active="loading" :can-cancel="false" :is-full-page="true" />

    <div class="menu-item px-3">
        <button href="#" id="kt_docs_sweetalert_basic" @click="statusChange(item, 1)" data-id="{{ $itemid }}"
            data-status="1" class="menu-link px-3 border-0 bg-transparent statusChange">Active</button>
    </div>
    <div class="menu-item px-3">
        <button href="#" id="kt_docs_sweetalert_basic" @click="statusChange(item, 2)" data-id="{{ $itemid }}"
            data-status="2" class="menu-link px-3 border-0 bg-transparent statusChange">Pending</button>
    </div>
    <div class="menu-item px-3">
        <button href="#" id="kt_docs_sweetalert_basic" @click="statusChange(item, 3)" data-id="{{ $itemid }}"
            data-status="3" class="menu-link px-3 border-0 bg-transparent statusChange">Rejected</button>
    </div>
    <div class="menu-item px-3">
        <button href="#" id="kt_docs_sweetalert_basic" @click="statusChange(item, 4)" data-id="{{ $itemid }}"
            data-status="4" class="menu-link px-3 border-0 bg-transparent statusChange">Featured</button>
    </div>
    <div class="menu-item px-3">
        <button href="#" id="kt_docs_sweetalert_basic" @click="statusChange(item, 5)" data-id="{{ $itemid }}"
            data-status="5" class="menu-link px-3 border-0 bg-transparent statusChange">Deactivated</button>
    </div>
</template>