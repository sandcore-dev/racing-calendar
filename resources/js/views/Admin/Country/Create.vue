<template>
  <Form :data="data">
    <template #default="{ form, getState }">
      <b-form-group
        :label="labels.code"
        :state="getState(form.errors.code)"
        :invalid-feedback="form.errors.code"
      >
        <b-form-select
          v-model="form.code"
          :state="getState(form.errors.code)"
          :options="codes"
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
    BFormSelect,
} from 'bootstrap-vue';

import Form from '@/components/Form.vue';

export default {
    components: {
        BFormGroup,
        BFormSelect,

        Form,
    },

    props: {
        labels: {
            type: Object,
            required: true,
        },

        codes: {
            type: Array,
            required: true,
        },

        data: {
            type: Object,
            default() {
                return {
                    code: null,
                };
            },
        },
    },
};
</script>
