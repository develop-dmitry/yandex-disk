<template>
  <div class="edit-wrapper">
    <input type="text" v-model="currentValue" class="edit-input" :readonly="!isEdit">
    <button class="edit-icon" v-if="isEdit" @click="submit">
      <svg class="edit-icon_image" xmlns="http://www.w3.org/2000/svg" width="12" height="12" focusable="false" viewBox="0 0 12 12">
        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 7l3 3 7-7"/>
      </svg>
    </button>
    <button class="edit-icon" @click="isEdit = true" v-else>
      <svg
          class="edit-icon_image"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round">
        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
      </svg>

    </button>

  </div>
</template>

<style lang="scss" src="./edit-input.scss"></style>

<script>
export default {
  data: () => {
    return {
      currentValue: "",
      isEdit: false
    }
  },

  emits: [
    "submit"
  ],

  props: {
    value: {
      type: String
    },
    fileIndex: {
      type: Number,
      required: true
    },
    reset: {
      type: Boolean
    }
  },

  methods: {
    submit() {
      this.isEdit = false;
      this.$emit("submit", {
        index: this.fileIndex,
        value: this.currentValue
      });
    },

    resetName() {
      this.currentValue = this.value;
    }
  },

  watch: {
    value: function () {
      this.currentValue = this.value;
    },

    reset: function () {
      console.log(this.reset)
      if (this.reset) {
        this.resetName();
      }
    }
  },

  created() {
    this.resetName();
  },
}
</script>