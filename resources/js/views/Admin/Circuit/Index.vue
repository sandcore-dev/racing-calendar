<template>
  <div>
    <h1 class="text-center">
      {{ labels.title }}
    </h1>
    <b-row class="mb-3">
      <b-col />
      <b-col cols="auto">
        <global-pagination :links="circuits.links" />
      </b-col>
    </b-row>
    <b-table
      striped
      hover
      :fields="fields"
      :items="circuits.data"
    >
      <template #head(admin)>
        <Link :href="adminAddUrl">
          <b-icon-plus-lg />
        </Link>
      </template>

      <template #cell(country)="data">
        <i :class="data.value.flag_class" />
        {{ data.value.name }}
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

        circuits: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            fields: [
                {
                    key: 'name',
                    label: this.labels.circuit,
                },
                {
                    key: 'city',
                    label: this.labels.city,
                },
                {
                    key: 'country',
                    label: this.labels.country,
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
