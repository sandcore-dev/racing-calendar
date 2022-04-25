<template>
  <b-card
    :header="header"
    class="col-6 offset-3"
  >
    <b-form @submit.prevent="onSubmit">
      <slot
        :form="form"
        :get-state="getState"
      />
      <b-button
        type="submit"
        variant="primary"
      >
        {{ labels.submit }}
      </b-button>
    </b-form>
  </b-card>
</template>

<script>
import {
    BButton,
    BCard,
    BForm,
} from 'bootstrap-vue';

export default {
    components: {
        BButton,
        BCard,
        BForm,
    },

    props: {
        data: {
            type: Object,
            required: true,
        },
    },

    computed: {
        header() {
            return this.$page.props.header;
        },

        labels() {
            return this.$page.props.labels || {};
        },

        edit() {
            return !!this.$page.props.edit;
        },

        url() {
            return this.$page.props.url;
        },
    },

    data() {
        return {
            form: this.$inertia.form(this.data),
        };
    },

    methods: {
        getState(error) {
            return error == null
                ? null
                : false;
        },

        onSubmit() {
            if (this.edit) {
                this.form.put(this.url);
                return;
            }

            this.form.post(this.url);
        },
    },
};
</script>
