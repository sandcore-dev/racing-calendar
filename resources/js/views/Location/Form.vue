<template>
  <Form
    :data="data"
    hide-submit-button
  >
    <template #default="{ form, submit }">
      <b-button
        v-for="location in locations"
        :key="location.id"
        class="w-100 mb-3"
        :variant="getButtonVariant(location.id)"
        @click="form.location_id = location.id; submit()"
      >
        {{ location.name }}
      </b-button>
      <b-button
        class="w-100"
        :variant="nobodyButtonVariant"
        @click="form.location_id = null; submit()"
      >
        {{ labels.nobody }}
      </b-button>
    </template>
  </Form>
</template>

<script>
import {
    BButton,
} from 'bootstrap-vue';

import Form from '@/components/Form.vue';

export default {
    components: {
        BButton,

        Form,
    },

    props: {
        labels: {
            type: Object,
            required: true,
        },

        locations: {
            type: Array,
            required: true,
        },

        data: {
            type: Object,
            default() {
                return {
                    location_id: null,
                };
            },
        },
    },

    computed: {
        nobodyButtonVariant() {
            return this.data.location_id
                ? 'outline-danger'
                : 'danger';
        },
    },

    methods: {
        getButtonVariant(id) {
            return id === this.data.location_id
                ? 'primary'
                : 'secondary';
        },
    },
};
</script>
