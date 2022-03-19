<template>
  <b-table-lite
    striped
    :fields="fields"
    :items="items"
    :tbody-tr-class="getRowClass"
  >
    <template #cell(start_time)="data">
      <span :class="getCellClass(data.item)">
        {{ data.value }}
      </span>
    </template>
    <template #cell(race)="data">
      <i
        :class="data.item.country_flag"
        v-v-b-tooltip.hover.left
        :title="data.item.country_local_name"
      />
      {{ data.item.circuit_city }}
    </template>

    <template #cell(details)="data">
      <b-button
        size="sm"
        @click="data.toggleDetails()"
        v-show="showDetailsButton(data.item)"
      >
        <i
          class="fa fa-chevron-down"
          v-show="!data.detailsShowing"
        />
        <i
          class="fa fa-chevron-up"
          v-show="data.detailsShowing"
        />
      </b-button>
    </template>

    <template #row-details="data">
      <race-details
        :country-flag="data.item.country_flag"
        :details="data.item.details"
      />
    </template>
  </b-table-lite>
</template>

<script>
import {
    BButton,
    BTableLite,
    VBTooltip,
} from 'bootstrap-vue';
import { DateTime } from 'luxon';

import RaceDetails from '@/components/Race/Details.vue';

export default {
    directives: {
        VBTooltip,
    },

    components: {
        BButton,
        BTableLite,

        RaceDetails,
    },

    props: {
        headerUrl: {
            type: String,
            default: null,
        },

        footerUrl: {
            type: String,
            default: null,
        },

        items: {
            type: Array,
            default() {
                return [];
            },
        },

        labels: {
            type: Object,
            required: true,
        },

        showLocations: {
            type: Boolean,
            required: true,
        },
    },

    computed: {
        fields() {
            return [
                {
                    key: 'date_short',
                    label: this.labels.date,
                    formatter: this.showDateShort,
                    class: 'text-nowrap d-lg-none col-2',
                },
                {
                    key: 'date_long',
                    label: this.labels.date,
                    formatter: this.showDateLong,
                    class: 'text-nowrap d-none d-lg-table-cell col-2',
                },
                {
                    key: 'start_time',
                    label: this.labels.race_time,
                    formatter: this.showTime,
                    class: 'col-2',
                },
                {
                    key: 'details',
                    label: '',
                    class: 'text-center col-1',
                },
                {
                    key: 'race',
                    label: this.labels.race,
                    class: 'text-nowrap col-5',
                },
                !this.showLocations
                    ? null
                    : {
                        key: 'location_name',
                        label: this.labels.location,
                        class: 'col-2',
                    },
            ];
        },
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

        showTime(value, key, item) {
            return item.status === 'scheduled'
                ? this.getDateTime(item.start_time).toLocaleString(DateTime.TIME_24_SIMPLE)
                : this.labels[item.status];
        },

        getRowClass(item) {
            return item.this_week
                ? 'this-week'
                : '';
        },

        getCellClass(item) {
            if (item.status === 'scheduled') {
                return null;
            }

            return item.status === 'cancelled'
                ? 'text-danger'
                : 'text-warning';
        },

        showDetailsButton(item) {
            return item.status === 'scheduled' && item.details.sessions.length;
        },
    },
};
</script>
