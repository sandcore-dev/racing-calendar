<template>
  <div>
    <h1 class="text-center">
      {{ labels.title }}
    </h1>
    <b-row class="mb-3">
      <b-col />
      <b-col cols="auto">
        <global-pagination :links="countries.links" />
      </b-col>
    </b-row>
    <b-table
      striped
      hover
      :fields="fields"
      :items="countries.data"
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

      <template #cell(flag)="data">
        <i :class="data.item.flag_class" />
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
    BIconPlusLg,
    BIconPencilFill,
    BRow,
    BTable,
} from 'bootstrap-vue';
import { Link } from '@inertiajs/vue2';

import GlobalPagination from '@/components/Global/Pagination.vue';

export default {
    components: {
        BCol,
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

        labels: {
            type: Object,
            required: true,
        },

        countries: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            fields: [
                {
                    key: 'name',
                    label: this.labels.country,
                },
                {
                    key: 'flag',
                    label: '',
                },
                {
                    key: 'code',
                    label: this.labels.code,
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
