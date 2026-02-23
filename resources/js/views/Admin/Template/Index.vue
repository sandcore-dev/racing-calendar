<template>
  <div>
    <h1 class="text-center">
      {{ labels.title }}
    </h1>
    <b-row class="mb-3">
      <b-col />
      <b-col cols="auto">
        <global-pagination :links="templates.links" />
      </b-col>
    </b-row>
    <b-table
      striped
      hover
      :fields="fields"
      :items="templates.data"
    >
      <template #head(admin)>
        <Link :href="adminAddUrl">
          <b-icon-plus-lg />
        </Link>
      </template>

      <template #cell(name)="data">
        <Link :href="data.item.admin_template_session_url">
          {{ data.value }}
        </Link>
      </template>

      <template #cell(admin)="data">
        <Link :href="data.item.admin_edit_url">
          <b-icon-pencil-fill />
        </Link>
      </template>

      <template #cell(admin_delete_url)="{value:url}">
        <b-icon-trash
          class="text-danger cursor-pointer"
          @click.prevent="submit(url)"
        />
      </template>
    </b-table>
  </div>
</template>

<style>
.cursor-pointer {
    cursor: pointer;
}
</style>

<script>
import {
    BCol,
    BIconPlusLg,
    BIconPencilFill,
    BIconTrash,
    BRow,
    BTable,
} from 'bootstrap-vue';
import { Link, router } from '@inertiajs/vue2';

import GlobalPagination from '@/components/Global/Pagination.vue';

export default {
    components: {
        BCol,
        BIconPlusLg,
        BIconPencilFill,
        BIconTrash,
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

        templates: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            fields: [
                {
                    key: 'name',
                    label: this.labels.template,
                },
                {
                    key: 'admin',
                    label: '',
                    class: 'text-center',
                },
                {
                    key: 'admin_delete_url',
                    label: '',
                    class: 'text-center',
                },
            ],
        };
    },

    methods: {
        submit(url) {
            router.delete(url);
        },
    },
};
</script>
