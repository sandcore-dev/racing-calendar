<template>
  <Form :data="data">
    <template #default="{ form, getState }">
      <b-form-group
        :label="labels.days"
        :state="getState(form.errors.days)"
        :invalid-feedback="form.errors.days"
      >
        <b-form-input
          type="number"
          v-model="form.days"
          :state="getState(form.errors.days)"
          :min="0"
        />
      </b-form-group>
      <b-form-group
        :label="labels.start_time"
        :state="getState(form.errors.start_time)"
        :invalid-feedback="form.errors.start_time"
      >
        <b-form-timepicker
          v-model="form.start_time"
          :state="getState(form.errors.start_time)"
          :locale="locale"
          @input="(value) => { form.end_time = value }"
        />
      </b-form-group>
      <b-form-group
        :label="labels.end_time"
        :state="getState(form.errors.end_time)"
        :invalid-feedback="form.errors.end_time"
      >
        <b-form-timepicker
          v-model="form.end_time"
          :state="getState(form.errors.end_time)"
          :locale="locale"
        />
      </b-form-group>
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
    </template>
  </Form>
</template>

<script>
import {
    BFormGroup,
    BFormInput,
    BFormTimepicker,
} from 'bootstrap-vue';

import Form from '@/components/Form.vue';

export default {
    components: {
        BFormGroup,
        BFormInput,
        BFormTimepicker,

        Form,
    },

    props: {
        labels: {
            type: Object,
            required: true,
        },

        locale: {
            type: String,
            required: true,
        },

        data: {
            type: Object,
            default() {
                return {
                    days: 0,
                    start_time: '12:00',
                    end_time: '12:00',
                    name: null,
                };
            },
        },
    },
};
</script>
