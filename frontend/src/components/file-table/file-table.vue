<template>
  <div class="file-table" v-if="files.length > 0">
    <ul class="file-table-row file-table-row__header">
      <li class="file-table-item">Название</li>
      <li class="file-table-item">Полный путь</li>
      <li class="file-table-item">Дата создания</li>
    </ul>
    <ul class="file-table-row" v-for="(file, index) in files" :key="index">
      <li class="file-table-item">{{ file.name }}</li>
      <li class="file-table-item">{{ file.path }}</li>
      <li class="file-table-item">{{ file.created }}</li>
    </ul>
  </div>
  <div class="alert alert__info" v-else>
    На диске не обнаружено файлов
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