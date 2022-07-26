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
        <global-pagination :links="templateSessions.links" />
      </b-col>
    </b-row>
    <b-table
      striped
      hover
      :fields="fields"
      :items="templateSessions.data"
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
    </b-table>
  </div>
</template>

<script>
import {
    BCol,
    BIconArrowLeftCircleFill,
    BIconPlusLg,
    BIconPencilFill,
    BRow,
    BTable,
} from 'bootstrap-vue';
import { Link } from '@inertiajs/inertia-vue';

import GlobalPagination from '@/components/Global/Pagination.vue';

export default {
    components: {
        BCol,
        BIconArrowLeftCircleFill,
        BIconPlusLg,
        BIconPencilFill,
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

        labels: {
            type: Object,
            required: true,
        },

        templateSessions: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            fields: [
                {
                    key: 'days',
                    label: this.labels.days,
                },
                {
                    key: 'start_time',
                    label: this.labels.startTime,
                },
                {
                    key: 'end_time',
                    label: this.labels.endTime,
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
};
</script>
