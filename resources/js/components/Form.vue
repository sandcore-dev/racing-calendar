<template>
  <b-card
    :header="header"
    class="col-12 col-lg-6 offset-lg-3"
  >
    <b-form @submit.prevent="onSubmit">
      <slot
        :form="form"
        :get-state="getState"
        :submit="onSubmit"
      />
      <b-button
        v-if="!hideSubmitButton"
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

        hideSubmitButton: {
            type: Boolean,
            default: false,
        },

        containsUpload: {
            type: Boolean,
            default: false,
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
            form: this.$inertia.form({
                _method: null,
                ...this.data,
            }),
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
                if (this.containsUpload) {
                    // eslint-disable-next-line no-underscore-dangle
                    this.form._method = 'PUT';
                    this.form.post(this.url);
                } else {
                    this.form.put(this.url);
                }
                return;
            }

            this.form.post(this.url);
        },
    },
};
</script>
