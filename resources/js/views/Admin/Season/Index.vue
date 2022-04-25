<template>
  <div>
    <h1 class="text-center">
      {{ labels.title }}
    </h1>
    <nav class="row mt-3 mb-3">
      <div class="col text-center">
        <a
          class="btn btn-primary"
          :href="adminBackUrl"
        >
          {{ labels.back }}
        </a>
      </div>
    </nav>
    <b-row>
      <b-col />
      <b-col cols="auto">
        <global-pagination :links="seasons.links" />
      </b-col>
    </b-row>
    <b-table-lite
      striped
      hover
      :fields="fields"
      :items="seasons.data"
    >
      <template #head(admin)>
        <Link :href="adminAddUrl">
          <i class="fa fa-plus" />
        </Link>
      </template>

      <template #cell(year)="data">
        <Link :href="data.item.admin_race_url">
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

        seasons: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            fields: [
                {
                    key: 'year',
                    label: this.labels.year,
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
