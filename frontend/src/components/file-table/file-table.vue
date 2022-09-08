<template>
  <div class="file-table">
    <ul class="file-table-row file-table-row__header">
      <li class="file-table-item">Имя</li>
      <li class="file-table-item">Размер</li>
      <li class="file-table-item">Владелец</li>
    </ul>
    <ul class="file-table-row" v-for="(file, index) in files" :key="index">
      <li class="file-table-item">{{ file.title }}</li>
      <li class="file-table-item">{{ file.size }}</li>
      <li class="file-table-item">{{ file.owner }}</li>
    </ul>
  </div>
</template>

<style lang="scss" src="./file-table.scss"></style>

<script>
  export default {
    name: "file-table",
    props: {
      files: Array
    }
  }
</script>