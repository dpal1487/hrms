<template>
  <input class="form-control form-control-lg form-control-solid" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="input">
</template>

<script>
  import { defineComponent } from 'vue'

  export default defineComponent({
    props: ['modelValue'],

    emits: ['update:modelValue'],

    methods: {
      focus() {
        this.$refs.input.focus()
      }
    }
  })
</script>

