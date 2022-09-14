<template>
  <ul class="pagination" v-if="pages > 1">
    <li class="pagination-item" v-for="index in pages" :key="index">
      <span class="pagination-current" v-if="currentPage === index - 1">
        {{ index }}
      </span>
      <a href="#" class="pagination-link" @click.prevent="this.$emit('select-page', index)" v-else>{{ index }}</a>
    </li>
  </ul>
</template>

<style lang="scss" src="./pagination.scss"></style>

<script>
export default {
  name: "pagination",
  props: {
    pages: Number,
    currentPage: Number
  },
  emits: [
    "select-page"
  ],
}
</script>