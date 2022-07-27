<template>
  <b-table-lite
    class="table-sm-y"
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
      <span :class="cityClass">
        {{ data.item.circuit_city }}
      </span>
    </template>

    <template #cell(details)="data">
      <b-button
        size="sm"
        @click="data.toggleDetails()"
        v-show="showDetailsButton(data.item)"
      >
        <b-icon-chevron-down v-show="!data.detailsShowing" />
        <b-icon-chevron-up v-show="data.detailsShowing" />
      </b-button>
    </template>

    <template #cell(location_name)="data">
      <template v-if="data.item.is_scheduled">
        <template v-if="data.item.is_past">
          {{ data.value }}
        </template>
        <template v-else>
          <Link :href="data.item.location_edit_url">
            <template v-if="!!data.value">
              {{ data.value }}
            </template>
            <template v-else>
              <b-icon-plus-lg />
            </template>
          </Link>
        </template>
      </template>
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
    BIconChevronDown,
    BIconChevronUp,
    BIconPlusLg,
    BTableLite,
    VBTooltip,
} from 'bootstrap-vue';
import { DateTime } from 'luxon';
import { Link } from '@inertiajs/inertia-vue';

import RaceDetails from '@/components/Race/Details.vue';

export default {
    directives: {
        VBTooltip,
    },

    components: {
        BButton,
        BIconChevronDown,
        BIconChevronUp,
        BIconPlusLg,
        BTableLite,
        Link,

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
        cityClass() {
            return this.showLocations
                ? 'd-none d-md-inline'
                : '';
        },

        fields() {
            return [
                {
                    key: 'date_short',
                    label: this.labels.date,
                    formatter: this.showDateShort,
                    class: 'text-nowrap d-lg-none pl-2',
                },
                {
                    key: 'date_long',
                    label: this.labels.date,
                    formatter: this.showDateLong,
                    class: 'text-nowrap d-none d-lg-table-cell pl-2',
                },
                {
                    key: 'start_time',
                    label: this.labels.race_time,
                    formatter: this.showTime,
                },
                {
                    key: 'details',
                    label: '',
                    class: 'text-center',
                },
                {
                    key: 'race',
                    label: this.labels.race,
                    class: 'text-nowrap',
                },
                !this.showLocations
                    ? null
                    : {
                        key: 'location_name',
                        label: this.labels.location,
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
