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
        :label="labels.code"
        :state="getState(form.errors.code)"
        :invalid-feedback="form.errors.code"
      >
        <b-form-input
          v-model="form.code"
          :state="getState(form.errors.code)"
        />
      </b-form-group>
    </template>
  </Form>
</template>

<script>
import {
    BFormGroup,
    BFormInput,
} from 'bootstrap-vue';

import Form from '@/components/Form.vue';

export default {
    components: {
        BFormGroup,
        BFormInput,

        Form,
    },

    props: {
        labels: {
            type: Object,
            required: true,
        },

        data: {
            type: Object,
            default() {
                return {
                    name: null,
                    code: null,
                };
            },
        },
    },
};
</script>
