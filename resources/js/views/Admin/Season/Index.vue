<template>
  <div>
    <h1 class="text-center">
      {{ labels.title }}
    </h1>
    <nav class="row mt-3 mb-3">
      <div class="col text-center">
        <Link
          class="btn btn-primary"
          :href="adminBackUrl"
        >
          {{ labels.back }}
        </Link>
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
          <b-icon-plus-lg />
        </Link>
      </template>

      <template #cell(year)="data">
        <Link :href="data.item.admin_race_url">
          {{ data.value }}
        </Link>
      </template>

      <template #cell(admin)="data">
        <Link :href="data.item.admin_edit_url">
          <b-icon-pencil-fill />
        </Link>
      </template>

      <template #cell(images)="data">
        <Link :href="data.item.admin_images_url">
          <b-icon-image />
        </Link>
      </template>
    </b-table-lite>
  </div>
</template>

<script>
import {
    BCol,
    BIconPlusLg,
    BIconPencilFill,
    BIconImage,
    BRow,
    BTableLite,
} from 'bootstrap-vue';

import { Link } from '@inertiajs/vue2';

import GlobalPagination from '@/components/Global/Pagination.vue';

export default {
    components: {
        BCol,
        BIconPlusLg,
        BIconPencilFill,
        BIconImage,
        BRow,
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
                {
                    key: 'images',
                    label: '',
                    class: 'text-center',
                },
            ],
        };
    },
};
</script>
