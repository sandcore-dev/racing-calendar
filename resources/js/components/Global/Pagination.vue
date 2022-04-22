<template>
  <nav>
    <ul class="pagination">
      <li
        class="page-item"
        :class="getPageItemClass(links.first_page_url)"
      >
        <Link
          :href="links.first_page_url"
          class="page-link"
        >
          &laquo;
        </Link>
      </li>
      <li :class="getPageItemClass(links.previous_page_url)">
        <Link
          :href="links.previous_page_url"
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
      <li :class="getPageItemClass(links.next_page_url)">
        <Link
          :href="links.next_page_url"
          class="page-link"
        >
          &gt;
        </Link>
      </li>
      <li :class="getPageItemClass(links.last_page_url)">
        <Link
          :href="links.last_page_url"
          class="page-link"
        >
          &raquo;
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
    },

    computed: {
        pages() {
            return this.links.slice(1, -1);
        },
    },

    methods: {
        getPageItemClass(active) {
            return active
                ? 'page-item'
                : 'page-item disabled';
        },
    },
};
</script>
