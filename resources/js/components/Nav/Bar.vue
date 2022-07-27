<template>
  <b-navbar>
    <b-navbar-brand>
      <Link :href="url">
        {{ title }}
      </Link>
    </b-navbar-brand>
    <b-navbar-nav v-if="adminItems.length">
      <b-nav-item
        class="d-none d-lg-block"
        v-for="item in adminItems"
        :key="item.url"
        :active="item.active"
      >
        <Link
          :href="item.url"
          class="nav-link"
        >
          {{ item.label }}
        </Link>
      </b-nav-item>
    </b-navbar-nav>
    <b-navbar-nav class="ml-auto">
      <b-nav-item-dropdown
        :text="dropdownTitle"
        right
      >
        <template v-if="adminItems.length">
          <div class="d-block d-lg-none">
            <Link
              v-for="dropdownAdminItem in adminItems"
              :key="dropdownAdminItem.key"
              class="dropdown-item"
              :href="dropdownAdminItem.url"
            >
              {{ dropdownAdminItem.label }}
            </Link>
            <b-dropdown-divider />
          </div>
        </template>
        <a
          v-for="dropdownItem in dropdownItems"
          :key="dropdownItem.id"
          class="dropdown-item"
          :href="dropdownItem.url"
          target="_blank"
        >
          {{ dropdownItem.label }}
        </a>
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
    BNavItem,
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
        BNavItem,
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

        adminItems: {
            type: Array,
            required: true,
        },
    },
};
</script>
