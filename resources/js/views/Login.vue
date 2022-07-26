<template>
  <b-card
    :header="title"
    class="col-6 offset-3"
  >
    <b-form @submit.prevent="onSubmit">
      <b-form-group
        :label="labels.email"
        :state="getState(form.errors.email)"
        :invalid-feedback="form.errors.email"
      >
        <b-form-input
          type="email"
          v-model="form.email"
          :state="getState(form.errors.email)"
        />
      </b-form-group>
      <b-form-group
        :label="labels.password"
        :state="getState(form.errors.password)"
        :invalid-feedback="form.errors.password"
      >
        <b-form-input
          type="password"
          v-model="form.password"
          :state="getState(form.errors.password)"
        />
      </b-form-group>
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
    BFormGroup,
    BFormInput,
} from 'bootstrap-vue';

export default {
    components: {
        BButton,
        BCard,
        BForm,
        BFormGroup,
        BFormInput,
    },

    props: {
        title: {
            type: String,
            required: true,
        },

        labels: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            form: this.$inertia.form({
                email: null,
                password: null,
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
            this.form.post('/login');
        },
    },
};
</script>
