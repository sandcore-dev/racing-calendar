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
        <global-pagination :links="raceSessions.links" />
      </b-col>
    </b-row>
    <b-table
      striped
      hover
      :fields="fields"
      :items="raceSessions.data"
      show-empty
      sort-by="start_time"
    >
      <template #head(admin)>
        <Link :href="adminAddUrl">
          <b-icon-plus-lg />
        </Link>
      </template>

      <template #cell(name)="data">
        <Link :href="data.item.admin_edit_url">
          {{ data.value }}
        </Link>
      </template>

      <template #cell(admin)="data">
        <Link :href="data.item.admin_edit_url">
          <b-icon-pencil-fill />
        </Link>
      </template>

      <template #empty>
        <b-form @submit.prevent="submit">
          <b-form-row class="justify-content-center">
            <b-col cols="auto">
              <b-form-select
                v-model="form.templateId"
                value-field="id"
                text-field="name"
                :options="templates"
                required
              />
            </b-col>
            <b-col cols="auto">
              <b-button
                type="submit"
                variant="primary"
              >
                {{ labels.applyTemplate }}
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
    BIconPlusLg,
    BIconPencilFill,
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
        BIconPlusLg,
        BIconPencilFill,
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

        adminApplyTemplateUrl: {
            type: String,
            required: true,
        },

        adminBackUrl: {
            type: String,
            required: true,
        },

        labels: {
            type: Object,
            required: true,
        },

        templates: {
            type: Array,
            required: true,
        },

        raceSessions: {
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
                    key: 'end_time',
                    label: this.labels.endTime,
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
                templateId: null,
            },
        };
    },

    methods: {
        submit() {
            this.$inertia.post(this.adminApplyTemplateUrl, this.form);
        },
    },
};
</script>
