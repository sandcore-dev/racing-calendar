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
      <b-form-group
        :label="labels.circuit_id"
        :state="getState(form.errors.circuit_id)"
        :invalid-feedback="form.errors.circuit_id"
      >
        <b-form-select
          v-model="form.circuit_id"
          :state="getState(form.errors.circuit_id)"
          :options="circuits"
          value-field="id"
          text-field="name"
        />
      </b-form-group>
      <b-form-group>
        <b-form-checkbox
          v-model="form.has_sprint"
          :value="true"
          :unchecked-value="false"
        >
          {{ labels.has_sprint }}
        </b-form-checkbox>
      </b-form-group>
      <b-form-group
        :label="labels.remarks"
        :state="getState(form.errors.remarks)"
        :invalid-feedback="form.errors.remarks"
      >
        <b-form-textarea
          v-model="form.remarks"
          :state="getState(form.errors.remarks)"
        />
      </b-form-group>
      <b-form-group
        :label="labels.status"
        :state="getState(form.errors.status)"
        :invalid-feedback="form.errors.status"
      >
        <b-form-select
          v-model="form.status"
          :state="getState(form.errors.status)"
          :options="statuses"
        />
      </b-form-group>
      <b-form-group
        v-show="edit"
        :label="labels.location"
        :state="getState(form.errors.location_id)"
        :invalid-feedback="form.errors.location_id"
      >
        <b-form-select
          v-model="form.location_id"
          :state="getState(form.errors.location_id)"
          :options="locations"
          value-field="id"
          text-field="name"
        />
      </b-form-group>
    </template>
  </Form>
</template>

<script>
import {
    BFormCheckbox,
    BFormGroup,
    BFormInput,
    BFormSelect,
    BFormTextarea,
} from 'bootstrap-vue';
import { DateTime } from 'luxon';

import Form from '@/components/Form.vue';
import FormDateTimepicker from '@/components/Form/DateTimepicker.vue';

export default {
    components: {
        BFormCheckbox,
        BFormGroup,
        BFormInput,
        BFormSelect,
        BFormTextarea,

        Form,
        FormDateTimepicker,
    },

    props: {
        labels: {
            type: Object,
            required: true,
        },

        edit: {
            type: Boolean,
            required: true,
        },

        year: {
            type: Number,
            required: true,
        },

        locale: {
            type: String,
            required: true,
        },

        circuits: {
            type: Array,
            required: true,
        },

        statuses: {
            type: Array,
            required: true,
        },

        locations: {
            type: Array,
            required: true,
        },

        data: {
            type: Object,
            default() {
                return {
                    start_time: DateTime.now().toJSDate(),
                    name: null,
                    circuit_id: null,
                    remarks: null,
                    status: 'scheduled',
                    location_id: null,
                    has_sprint: null,
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
