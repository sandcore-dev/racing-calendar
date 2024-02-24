<template>
  <div>
    <Head>
      <title>
        {{ title }}
      </title>
      <template v-if="iconUrl">
        <link
          rel="icon"
          :href="iconUrl"
          :type="iconMimeType"
          :sizes="iconDimensions"
        >
        <link
          rel="shortcut icon"
          :href="iconUrl"
          :type="iconMimeType"
          :sizes="iconDimensions"
        >
        <link
          rel="apple-touch-icon"
          :href="iconUrl"
          :type="iconMimeType"
          :sizes="iconDimensions"
        >
      </template>
    </Head>
    <b-container>
      <nav-bar
        :title="navBarTitle"
        :url="navBarUrl"
        :dropdown-title="dropdownTitle"
        :dropdown-items="dropdownItems"
        :session-action="sessionAction"
        :admin-items="adminItems"
      />
      <b-alert
        v-for="(message, variant) in messages"
        :key="variant"
        :variant="variant"
        :show="!!message"
      >
        {{ message }}
      </b-alert>
      <slot />
    </b-container>
  </div>
</template>

<script>
import { BAlert, BContainer } from 'bootstrap-vue';
import { Head } from '@inertiajs/vue2';

import NavBar from '@/components/Nav/Bar.vue';

export default {
    components: {
        BAlert,
        BContainer,
        Head,
        NavBar,
    },

    props: {
        title: {
            type: String,
            required: true,
        },

        navBarTitle: {
            type: String,
            default() {
                return this.title;
            },
        },

        navBarUrl: {
            type: String,
            required: true,
        },

        iconUrl: {
            type: String,
            default: null,
        },

        iconMimeType: {
            type: String,
            default: null,
        },

        iconDimensions: {
            type: String,
            default: null,
        },

        dropdownTitle: {
            type: String,
            required: true,
        },

        dropdownItems: {
            type: Array,
            required: true,
        },

        sessionAction: {
            type: Object,
            required: true,
        },

        adminItems: {
            type: Array,
            required: true,
        },

        messages: {
            type: Object,
            required: true,
        },
    },
};
</script>
