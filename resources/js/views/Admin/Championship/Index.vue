<template>
  <div>
    <h1 class="text-center">
      {{ labels.title }}
    </h1>
    <b-row>
      <b-col />
      <b-col cols="auto">
        <global-pagination :links="championships.links" />
      </b-col>
    </b-row>
    <b-table-lite
      striped
      hover
      :fields="fields"
      :items="championships.data"
    >
      <template #head(admin)>
        <Link :href="adminAddUrl">
          <i class="fa fa-plus" />
        </Link>
      </template>

      <template #cell(name)="data">
        <Link :href="data.item.admin_season_url">
          {{ data.value }}
        </Link>
      </template>

      <template #cell(admin)="data">
        <Link :href="data.item.admin_edit_url">
          <i class="fa fa-edit" />
        </Link>
      </template>
    </b-table-lite>
  </div>
</template>

<script>
import {
    BRow,
    BCol,
    BTableLite,
} from 'bootstrap-vue';

import { Link } from '@inertiajs/inertia-vue';

import GlobalPagination from '@/components/Global/Pagination.vue';

export default {
    components: {
        BRow,
        BCol,
        BTableLite,
        Link,

        GlobalPagination,
    },

    props: {
        labels: {
            type: Object,
            required: true,
        },

        adminAddUrl: {
            type: String,
            required: true,
        },

        championships: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            fields: [
                {
                    key: 'name',
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
