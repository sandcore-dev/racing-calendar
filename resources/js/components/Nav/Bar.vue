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
        <b-dropdown-item
          v-for="dropdownItem in dropdownItems"
          :key="dropdownItem.id"
        >
          <Link :href="dropdownItem.url">
            {{ dropdownItem.label }}
          </Link>
        </b-dropdown-item>
        <b-dropdown-divider />
        <b-dropdown-item>
          <dark-mode-switch />
        </b-dropdown-item>
        <b-dropdown-divider />
        <b-dropdown-item>
          <Link :href="sessionAction.url">
            {{ sessionAction.label }}
          </Link>
        </b-dropdown-item>
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
