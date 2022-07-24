<template>
  <div>
    <h1 class="text-center">
      {{ labels.title }}
    </h1>
    <b-row class="mb-3">
      <b-col />
      <b-col cols="auto">
        <global-pagination :links="locations.links" />
      </b-col>
    </b-row>
    <b-table
      striped
      hover
      :fields="fields"
      :items="locations.data"
    >
      <template #head(admin)>
        <Link :href="adminAddUrl">
          <i class="fa fa-plus" />
        </Link>
      </template>

      <template #cell(name)="data">
        <Link :href="data.item.admin_edit_url">
          {{ data.value }}
        </Link>
      </template>

      <template #cell(admin)="data">
        <Link :href="data.item.admin_edit_url">
          <i class="fa fa-edit" />
        </Link>
      </template>
    </b-table>
  </div>
</template>

<script>
import {
    BCol,
    BRow,
    BTable,
} from 'bootstrap-vue';
import { Link } from '@inertiajs/inertia-vue';

import GlobalPagination from '@/components/Global/Pagination.vue';

export default {
    components: {
        BCol,
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

        labels: {
            type: Object,
            required: true,
        },

        locations: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            fields: [
                {
                    key: 'name',
                    label: this.labels.location,
                },
                {
                    key: 'admin',
                    label: '',
                    class: 'text-center',
                },
            ],
        };
    },
};
</script>
