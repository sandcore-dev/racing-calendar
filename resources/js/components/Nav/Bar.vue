<template>
  <b-navbar>
    <b-navbar-brand>
      <Link :href="url">
        {{ title }}
      </Link>
    </b-navbar-brand>
    <b-navbar-nav class="ml-auto">
      <b-nav-item-dropdown
        :text="dropdownTitle"
        right
      >
        <Link
          v-for="dropdownItem in dropdownItems"
          :key="dropdownItem.id"
          class="dropdown-item"
          :href="dropdownItem.url"
        >
          {{ dropdownItem.label }}
        </Link>
        <b-dropdown-divider />
        <b-dropdown-item>
          <dark-mode-switch />
        </b-dropdown-item>
        <b-dropdown-divider />
        <Link
          :href="sessionAction.url"
          class="dropdown-item"
        >
          {{ sessionAction.label }}
        </Link>
      </b-nav-item-dropdown>
    </b-navbar-nav>
  </b-navbar>
</template>

<script>
import {
    BNavbar,
    BNavbarBrand,
    BNavbarNav,
    BNavItemDropdown,
    BDropdownDivider,
    BDropdownItem,
} from 'bootstrap-vue';
import { Link } from '@inertiajs/inertia-vue';

import DarkModeSwitch from '@/components/DarkModeSwitch.vue';

export default {
    components: {
        BNavbar,
        BNavbarBrand,
        BNavbarNav,
        BNavItemDropdown,
        BDropdownDivider,
        BDropdownItem,
        DarkModeSwitch,
        Link,
    },

    props: {
        title: {
            type: String,
            required: true,
        },

        url: {
            type: String,
            required: true,
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
