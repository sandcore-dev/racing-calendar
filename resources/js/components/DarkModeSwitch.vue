<template>
    <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" v-model="enabled" id="dark-mode"/>
        <label class="custom-control-label" for="dark-mode">
            Dark mode
        </label>
    </div>
</template>

<script>
import store2 from 'store2';

export default {
      data() {
            return {
                  enabled: null,
            };
      },

      mounted() {
            this.enabled = this.isDarkModeEnabled();
      },

      watch: {
            enabled(value) {
                  store2.set('dark-mode', value);

                  if (value) {
                        document.body.classList.add('dark');
                        return;
                  }

                  document.body.classList.remove('dark');
            },
      },

      methods: {
            isDarkModeEnabled() {
                  if (store2.has('dark-mode')) {
                        return store2.get('dark-mode');
                  }

                  return window.matchMedia
                      && window.matchMedia('prefers-color-scheme: dark').matches;
            },
      },
};
</script>
