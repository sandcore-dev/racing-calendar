<template>
  <b-row>
    <b-col>
      <b-form-checkbox-group
        v-model="locations"
        :options="currentOptions"
        stacked
        value-field="id"
        text-field="name"
      />
    </b-col>
    <b-col>
      <b-form-input
        v-model="search"
        debounce="500"
        class="mb-3"
      />
      <b-form-checkbox-group
        v-model="checked"
        :options="results"
        stacked
        value-field="id"
        text-field="name"
      />
    </b-col>
  </b-row>
</template>

<script>
import axios from 'axios';
import {
    BRow,
    BCol,
    BFormCheckboxGroup,
    BFormInput,
} from 'bootstrap-vue';

export default {
    components: {
        BRow,
        BCol,
        BFormCheckboxGroup,
        BFormInput,
    },

    props: {
        value: {
            type: Array,
            required: true,
        },

        options: {
            type: Array,
            required: true,
        },
    },

    computed: {
        locations: {
            get() {
                return this.value;
            },

            set(locations) {
                this.$emit('input', locations);
            },
        },
    },

    data() {
        return {
            currentOptions: this.options,
            search: null,
            results: [],
            checked: [],
        };
    },

    watch: {
        search(value) {
            this.load(value);
        },

        checked(values) {
            this.results.forEach((result) => {
                if (values.indexOf(result.id) < 0) {
                    return;
                }

                this.locations.push(result.id);
                this.currentOptions.push(result);
            });

            this.results = this.results.filter((result) => this.checked.indexOf(result.id) < 0);
        },
    },

    methods: {
        load(keywords) {
            axios
                .post('/api/locations/search', {
                    keywords,
                })
                .then(({ data }) => {
                    this.results = data.data;
                });
        },
    },
};
</script>
