<template>
  <b-container fluid>
    <b-row class="mb-3">
      <b-col
        cols="2"
        :class="flagColumnClass"
      />
      <b-col
        cols="12"
        lg="8"
      >
        <div class="h4 text-center">
          {{ details.title }}
        </div>
        <div class="h5 text-center">
          {{ details.circuit.name }}
        </div>
        <div class="h5 text-center">
          {{ details.circuit.location }}
        </div>
      </b-col>
      <b-col cols="2" />
    </b-row>
    <b-table-lite
      class="mb-0"
      small
      striped
      borderless
      thead-class="d-none"
      :fields="fields"
      :items="details.sessions"
    >
      <template #cell(times)="data">
        {{ showTime(data.item.start_time) }}-{{ showTime(data.item.end_time) }}
      </template>
    </b-table-lite>
  </b-container>
</template>

<script>
import {
    BCol,
    BContainer,
    BRow,
    BTableLite,
} from 'bootstrap-vue';
import { DateTime } from 'luxon';

export default {
    components: {
        BCol,
        BContainer,
        BRow,
        BTableLite,
    },

    props: {
        countryFlag: {
            type: String,
            required: true,
        },

        details: {
            type: Object,
            required: true,
        },
    },

    computed: {
        flagColumnClass() {
            return `d-none d-lg-table-cell ${this.countryFlag}`;
        },
    },

    data() {
        return {
            fields: [
                {
                    key: 'date_short',
                    label: '',
                    formatter: this.showDateShort,
                    class: 'text-nowrap d-lg-none col-2',
                },
                {
                    key: 'date_long',
                    label: '',
                    formatter: this.showDateLong,
                    class: 'text-nowrap d-none d-lg-table-cell col-2',
                },
                {
                    key: 'times',
                    label: '',
                    class: 'col-2',
                },
                {
                    key: 'empty',
                    label: '',
                    class: 'col-1',
                },
                {
                    key: 'name',
                    label: '',
                    class: 'col-7 pl-2',
                },
            ],
        };
    },

    methods: {
        getDateTime(value) {
            return DateTime.fromISO(value).setLocale('nl');
        },

        showDateShort(value, key, item) {
            return this.getDateTime(item.start_time).toFormat('dd MMM').replace('.', '');
        },

        showDateLong(value, key, item) {
            return this.getDateTime(item.start_time).toFormat('dd MMMM');
        },

        showTime(value) {
            return this.getDateTime(value).toLocaleString(DateTime.TIME_24_SIMPLE);
        },
    },

};
</script>
