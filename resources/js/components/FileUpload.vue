<template>
  <div @change="fileChosen">
    <slot>
      <label
        :for="name"
        class="btn btn-default"
      >
        {{ label }} <input
          type="file"
          :id="name"
          :name="name"
          style="display: none"
        >
      </label>
    </slot>
    <span
      v-for="file in files"
      :key="file.name"
    >
      {{ file.name }}
    </span>
  </div>
</template>

<script>
export default {
    props: {
        name: {
            type: String,
            required: true,
        },
        label: {
            type: String,
            default: 'Choose file',
        },
    },

    data() {
        return {
            files: [],
        };
    },

    methods: {
        fileChosen(event) {
            const files = [];

            for (let i = 0; i < event.target.files.length; i += 1) {
                files.push(event.target.files.item(i));
            }

            this.files = files;
        },
    },
};
</script>
