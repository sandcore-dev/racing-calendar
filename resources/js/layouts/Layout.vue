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
        >
        <link
          rel="shortcut icon"
          :href="iconUrl"
        >
        <link
          rel="apple-touch-icon"
          :href="iconUrl"
        >
        <link
          rel="apple-touch-icon-precomposed"
          :href="iconUrl"
        >
      </template>
    </Head>
    <b-container>
      <nav-bar
        :title="title"
        :url="navBarUrl"
        :dropdown-title="dropdownTitle"
        :dropdown-items="dropdownItems"
        :session-action="sessionAction"
      />
      <slot />
    </b-container>
  </div>
</template>

<script>
import { BContainer } from 'bootstrap-vue';
import { Head } from '@inertiajs/inertia-vue';

import NavBar from '@/components/Nav/Bar.vue';

export default {
    components: {
        BContainer,
        Head,
        NavBar,
    },

    props: {
        title: {
            type: String,
            required: true,
        },

        navBarUrl: {
            type: String,
            required: true,
        },

        iconUrl: {
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
    },
};
</script>
