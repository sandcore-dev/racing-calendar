<template>
  <div>
    <h1 class="text-center">
      {{ labels.title }}
    </h1>
    <b-row class="mb-3">
      <b-col>
        <Link
          :href="adminBackUrl"
          class="btn btn-primary"
        >
          <b-icon-arrow-left-circle-fill />
          {{ labels.back }}
        </Link>
      </b-col>
      <b-col cols="auto">
        <global-pagination :links="races.links" />
      </b-col>
    </b-row>
    <b-table
      striped
      hover
      :fields="fields"
      :items="races.data"
      show-empty
    >
      <template #head(admin)>
        <Link :href="adminAddUrl">
          <i class="fa fa-plus" />
        </Link>
      </template>

      <template #cell(name)="data">
        <Link :href="data.item.admin_race_session_url">
          {{ data.value }}
        </Link>
      </template>

      <template #cell(admin)="data">
        <Link :href="data.item.admin_edit_url">
          <i class="fa fa-edit" />
        </Link>
      </template>

      <template #empty>
        <b-form @submit.prevent="submit">
          <b-form-row class="justify-content-center">
            <b-col cols="auto">
              <b-form-select
                v-model="form.seasonId"
                value-field="id"
                text-field="year"
                :options="previousSeasons"
                required
              />
            </b-col>
            <b-col cols="auto">
              <b-button
                type="submit"
                variant="primary"
              >
                {{ labels.copySeason }}
              </b-button>
            </b-col>
          </b-form-row>
        </b-form>
      </template>
    </b-table>
  </div>
</template>

<script>
import {
    BButton,
    BCol,
    BIconArrowLeftCircleFill,
    BForm,
    BFormRow,
    BFormSelect,
    BRow,
    BTable,
} from 'bootstrap-vue';
import { Link } from '@inertiajs/inertia-vue';
import { DateTime } from 'luxon';

import GlobalPagination from '@/components/Global/Pagination.vue';

export default {
    components: {
        BButton,
        BCol,
        BIconArrowLeftCircleFill,
        BForm,
        BFormRow,
        BFormSelect,
        BRow,
        BTable,
        Link,

        GlobalPagination,
    },

    props: {
        adminAddUrl: {
            type: String,
            required: true,
        },

        adminBackUrl: {
            type: String,
            required: true,
        },

        adminCopySeasonUrl: {
            type: String,
            required: true,
        },

        labels: {
            type: Object,
            required: true,
        },

        previousSeasons: {
            type: Array,
            required: true,
        },

        races: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            fields: [
                {
                    key: 'start_date',
                    label: this.labels.date,
                    class: ['text-right'],
                    formatter(value, key, { start_time: startTime }) {
                        return DateTime.fromISO(startTime).setLocale('nl').toLocaleString(DateTime.DATE_FULL);
                    },
                },
                {
                    key: 'start_time',
                    label: this.labels.startTime,
                    formatter(value) {
                        return DateTime.fromISO(value).setLocale('nl').toLocaleString(DateTime.TIME_24_SIMPLE);
                    },
                },
                {
                    key: 'name',
                    label: this.labels.name,
                },
                {
                    key: 'admin',
                    label: '',
                    class: 'text-center',
                },
            ],
            form: {
                seasonId: this.previousSeasons.length && this.previousSeasons[0].id,
            },
        };
    },

    methods: {
        submit() {
            this.$inertia.post(this.adminCopySeasonUrl, this.form);
        },
    },
};
</script>
