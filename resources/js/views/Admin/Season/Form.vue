<template>
  <Form :data="data">
    <template #default="{ form, getState }">
      <b-form-group
        :label="labels.year"
        :state="getState(form.errors.year)"
        :invalid-feedback="form.errors.year"
      >
        <b-form-input
          type="number"
          v-model="form.year"
          :state="getState(form.errors.year)"
        />
      </b-form-group>
      <b-form-group
        :label="labels.headerImage"
        :state="getState(form.errors.header_image)"
        :invalid-feedback="form.errors.header_image"
      >
        <b-form-file
          v-model="form.header_image"
          :accept="acceptedMimeTypes"
          :placeholder="labels.noFileChosen"
          :browse-text="labels.browse"
          :state="getState(form.errors.header_image)"
        />
      </b-form-group>
      <b-form-group
        :label="labels.footerImage"
        :state="getState(form.errors.footer_image)"
        :invalid-feedback="form.errors.footer_image"
      >
        <b-form-file
          v-model="form.footer_image"
          :accept="acceptedMimeTypes"
          :placeholder="labels.noFileChosen"
          :browse-text="labels.browse"
          :state="getState(form.errors.footer_image)"
        />
      </b-form-group>
    </template>
  </Form>
</template>

<script>
import {
    BFormGroup,
    BFormInput,
    BFormFile,
} from 'bootstrap-vue';

import Form from '@/components/Form.vue';

export default {
    components: {
        BFormGroup,
        BFormInput,
        BFormFile,

        Form,
    },

    props: {
        labels: {
            type: Object,
            required: true,
        },

        acceptedMimeTypes: {
            type: String,
            required: true,
        },

        data: {
            type: Object,
            default() {
                return {
                    year: new Date().getFullYear(),
                    header_image: null,
                    footer_image: null,
                };
            },
        },
    },
};
</script>
