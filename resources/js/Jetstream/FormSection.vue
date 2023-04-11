<template>
      <form @submit.prevent="$emit('submitted')">
        <div class="card shadow-sm">
          <div class="card-body">
            <slot name="form"></slot>
          </div>
          <div class="card-footer d-flex justify-content-end" v-if="hasActions">
            <slot name="actions"></slot>
          </div>
        </div>
      </form>
</template>

<script>
  import { defineComponent } from 'vue'
  import JetSectionTitle from './SectionTitle.vue'

  export default defineComponent({
    components: {
      JetSectionTitle,
    },

    emits: ['submitted'],

    computed: {
      hasActions() {
        return !! this.$slots.actions
      }
    }
  })
</script>
