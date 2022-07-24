<template>
  <Form :data="data">
    <template #default="{ form, getState }">
      <b-form-group
        :label="labels.start_time"
        :state="getState(form.errors.start_time)"
        :invalid-feedback="form.errors.start_time"
      >
        <form-date-timepicker
          v-model="form.start_time"
          :state="getState(form.errors.start_time)"
          :min="min"
          :max="max"
          :locale="locale"
          @input="(value) => { form.end_time = value }"
        />
        {{ form.start_time }}
      </b-form-group>
      <b-form-group
        :label="labels.end_time"
        :state="getState(form.errors.end_time)"
        :invalid-feedback="form.errors.end_time"
      >
        <form-date-timepicker
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
} from 'bootstrap-vue';
import { DateTime } from 'luxon';

import Form from '@/components/Form.vue';
import FormDateTimepicker from '@/components/Form/DateTimepicker.vue';

export default {
    components: {
        BFormGroup,
        BFormInput,

        Form,
        FormDateTimepicker,
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

        year: {
            type: Number,
            required: true,
        },

        data: {
            type: Object,
            default() {
                return {
                    start_time: DateTime
                        .fromObject({ year: this.year, hour: 12, minute: 0 })
                        .toJSDate(),
                    end_time: DateTime
                        .fromObject({ year: this.year, hour: 12, minute: 0 })
                        .toJSDate(),
                    name: null,
                };
            },
        },
    },

    computed: {
        min() {
            return DateTime.fromObject({ year: this.year }).startOf('year').toJSDate();
        },

        max() {
            return DateTime.fromObject({ year: this.year }).endOf('year').toJSDate();
        },
    },
};
</script>
