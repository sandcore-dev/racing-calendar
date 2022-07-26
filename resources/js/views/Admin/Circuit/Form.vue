<template>
  <Form :data="data">
    <template #default="{ form, getState }">
      <b-form-group
        :label="labels.name"
        :state="getState(form.errors.name)"
        :invalid-feedback="form.errors.name"
      >
        <b-form-input
          v-model="form.name"
          :state="getState(form.errors.name)"
        />
      </b-form-group>
      <b-form-group
        :label="labels.city"
        :state="getState(form.errors.city)"
        :invalid-feedback="form.errors.city"
      >
        <b-form-input
          v-model="form.city"
          :state="getState(form.errors.city)"
        />
      </b-form-group>
      <b-form-group
        :label="labels.area"
        :state="getState(form.errors.area)"
        :invalid-feedback="form.errors.area"
      >
        <b-form-input
          v-model="form.area"
          :state="getState(form.errors.area)"
        />
      </b-form-group>
      <b-form-group
        :label="labels.country"
        :state="getState(form.errors.country_id)"
        :invalid-feedback="form.errors.country_id"
      >
        <b-form-select
          v-model="form.country_id"
          :state="getState(form.errors.country_id)"
          :options="countries"
          value-field="id"
          text-field="name"
        />
      </b-form-group>
    </template>
  </Form>
</template>

<script>
import {
    BFormGroup,
    BFormInput,
    BFormSelect,
} from 'bootstrap-vue';

import Form from '@/components/Form.vue';

export default {
    components: {
        BFormGroup,
        BFormInput,
        BFormSelect,

        Form,
    },

    props: {
        labels: {
            type: Object,
            required: true,
        },

        countries: {
            type: Array,
            required: true,
        },

        data: {
            type: Object,
            default() {
                return {
                    name: null,
                    city: null,
                    area: null,
                    country_id: null,
                };
            },
        },
    },
};
</script>
