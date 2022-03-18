<template>
  <b-table-lite
    :items="items"
    :fields="fields"
  >
    <template #cell(race)="race">
      <i
        :class="race.item.country_flag"
        v-v-b-tooltip.hover.left
        :title="race.item.country_local_name"
      />
      {{ race.item.circuit_city }}
    </template>
  </b-table-lite>
</template>

<script>
import { BTableLite, VBTooltip } from 'bootstrap-vue';
import { DateTime } from 'luxon';

export default {
    directives: {
        VBTooltip,
    },

    components: {
        BTableLite,
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
    },

    computed: {
        fields() {
            return [
                {
                    key: 'date_short',
                    label: this.labels.date,
                    formatter: this.showDateShort,
                    class: 'nowrap d-lg-none',
                },
                {
                    key: 'date_long',
                    label: this.labels.date,
                    formatter: this.showDateLong,
                    class: 'nowrap d-none d-lg-table-cell',
                },
                {
                    key: 'start_time',
                    label: this.labels.race_time,
                    formatter: this.showTime,
                },
                {
                    key: 'race',
                    label: this.labels.race,
                },
            ];
        },
    },

    methods: {
        getDateTime(value) {
            return DateTime.fromISO(value).setLocale('nl');
        },

        showDateShort(value, key, item) {
            return this.getDateTime(item.start_time).toFormat('dd MMM');
        },

        showDateLong(value, key, item) {
            return this.getDateTime(item.start_time).toFormat('dd MMMM');
        },

        showTime(value, key, item) {
            return this.getDateTime(item.start_time).toLocaleString(DateTime.TIME_24_SIMPLE);
        },
    },
};
</script>
