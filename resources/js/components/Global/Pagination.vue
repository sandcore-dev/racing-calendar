<template>
  <nav v-show="showPagination">
    <ul class="pagination">
      <li :class="getPageItemClass(!previousPage.url)">
        <Link
          :href="previousPage.url"
          class="page-link"
        >
          &lt;
        </Link>
      </li>
      <li
        v-for="page in pages"
        :key="page.label"
        :class="getPageItemClass(page.active)"
      >
        <Link
          :href="page.url"
          class="page-link"
        >
          {{ page.label }}
        </Link>
      </li>
      <li :class="getPageItemClass(!nextPage.url)">
        <Link
          :href="nextPage.url"
          class="page-link"
        >
          &gt;
        </Link>
      </li>
    </ul>
  </nav>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue';

export default {
    components: {
        Link,
    },

    props: {
        links: {
            type: Array,
            required: true,
        },

        alwaysShowPagination: {
            type: Boolean,
            default: false,
        },
    },

    computed: {
        previousPage() {
            return this.links.slice(0, 1)[0];
        },

        nextPage() {
            return this.links.slice(-1)[0];
        },

        pages() {
            return this.links.slice(1, -1);
        },

        showPagination() {
            return this.alwaysShowPagination || this.pages.length > 1;
        },
    },

    methods: {
        getPageItemClass(active) {
            return active
                ? 'page-item disabled'
                : 'page-item';
        },
    },
};
</script>
