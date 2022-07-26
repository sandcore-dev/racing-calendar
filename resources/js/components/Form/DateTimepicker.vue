<template>
  <b-form-row>
    <b-col cols="7">
      <b-form-datepicker
        v-model="currentDate"
        :state="state"
        :min="min"
        :max="max"
        :locale="locale"
        value-as-date
      />
    </b-col>
    <b-col cols="5">
      <b-form-timepicker
        v-model="currentTime"
        :state="state"
        :locale="locale"
      />
    </b-col>
  </b-form-row>
</template>

<script>
import {
    BCol,
    BFormDatepicker,
    BFormTimepicker,
    BFormRow,
} from 'bootstrap-vue';
import { DateTime } from 'luxon';

export default {
    components: {
        BCol,
        BFormDatepicker,
        BFormTimepicker,
        BFormRow,
    },

    props: {
        value: {
            type: [Date, String],
            default: null,
        },

        state: {
            type: Boolean,
            default: false,
        },

        min: {
            type: Date,
            default: null,
        },

        max: {
            type: Date,
            default: null,
        },

        locale: {
            type: String,
            default: 'nl',
        },
    },

    computed: {
        currentDate: {
            get() {
                return this.value instanceof Date
                    ? this.value
                    : DateTime.fromISO(this.value).toJSDate();
            },

            set(value) {
                this.$emit('input', DateTime.fromJSDate(value).set({ hour: this.currentHour, minute: this.currentMinute }).toJSDate());
            },
        },

        currentTime: {
            get() {
                return DateTime.fromJSDate(this.currentDate).toFormat('HH:mm');
            },

            set(value) {
                let hour = 0;
                let minute = 0;

                [hour, minute] = value.split(':');

                this.$emit('input', DateTime.fromJSDate(this.currentDate).set({ hour, minute }).toJSDate());
            },
        },

        currentHour() {
            return this.currentTime.split(':')[0];
        },

        currentMinute() {
            return this.currentTime.split(':')[1];
        },
    },
};
</script>
