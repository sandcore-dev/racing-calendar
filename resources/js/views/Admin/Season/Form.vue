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
      <template v-if="!!seasonId">
        <b-form-group
          :label="labels.accessToken"
          :state="getState(form.errors.accessToken)"
          :invalid-feedback="form.errors.accessToken"
        >
          <b-input-group>
            <b-form-input
              v-model="form.access_token"
              :state="getState(form.errors.access_token)"
              readonly
            />
            <b-input-group-append is-text>
              <b-form-checkbox
                class="mr-n2"
                v-model="form.regenerate_token"
                switch
                :value="true"
                :unchecked-value="false"
              >
                {{ labels.regenerateToken }}
              </b-form-checkbox>
            </b-input-group-append>
          </b-input-group>
        </b-form-group>
        <b-form-group
          :label="labels.locations"
          :state="getState(form.errors.locations)"
          :invalid-feedback="form.errors.locations"
        >
          <locations
            v-model="form.locations"
            :options="locations"
          />
        </b-form-group>
      </template>
    </template>
  </Form>
</template>

<script>
import {
    BInputGroup,
    BInputGroupAppend,
    BFormCheckbox,
    BFormGroup,
    BFormInput,
    BFormFile,
} from 'bootstrap-vue';

import Form from '@/components/Form.vue';
import Locations from '@/components/Locations.vue';

export default {
    components: {
        BInputGroup,
        BInputGroupAppend,
        BFormCheckbox,
        BFormGroup,
        BFormInput,
        BFormFile,

        Form,
        Locations,
    },

    props: {
        labels: {
            type: Object,
            required: true,
        },

        seasonId: {
            type: Number,
            default: null,
        },

        acceptedMimeTypes: {
            type: String,
            required: true,
        },

        locations: {
            type: Array,
            default() {
                return [];
            },
        },

        data: {
            type: Object,
            default() {
                return {
                    year: new Date().getFullYear(),
                    header_image: null,
                    footer_image: null,
                    access_token: null,
                    regenerate_token: false,
                    locations: [],
                };
            },
        },
    },
};
</script>
