<template>
  <div>
    <h1 class="text-center">
      {{ labels.name }} - {{ labels.year }}
    </h1>

    <div class="text-center mb-5">
      <Link
        class="btn btn-primary"
        :href="backUrl"
      >
        {{ labels.back }}
      </Link>
    </div>

    <div
      class="mb-3"
      v-if="headerUrl"
    >
      <h3 class="text-center">
        {{ labels.iconImage }}
      </h3>
      <image-crop
        square
        :season-id="seasonId"
        name="icon"
        :src="headerUrl"
        :alt="labels.iconImage"
        :current-image="iconUrl"
      />
    </div>

    <div
      class="mb-3"
      v-if="headerUrl"
    >
      <h3 class="text-center">
        {{ labels.headerImage }}
      </h3>
      <image-crop
        :season-id="seasonId"
        name="header"
        :src="headerUrl"
        :alt="labels.headerImage"
      />
    </div>

    <div
      class="mb-3"
      v-if="footerUrl"
    >
      <h3 class="text-center">
        {{ labels.footerImage }}
      </h3>
      <image-crop
        :season-id="seasonId"
        name="footer"
        :src="footerUrl"
        :alt="labels.footerImage"
      />
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/vue2';

import ImageCrop from '@/components/ImageCrop.vue';

export default {
    components: {
        Link,

        ImageCrop,
    },

    props: {
        labels: {
            type: Object,
            required: true,
        },

        seasonId: {
            type: Number,
            required: true,
        },

        backUrl: {
            type: String,
            required: true,
        },

        iconUrl: {
            type: String,
            default: null,
        },

        headerUrl: {
            type: String,
            default: null,
        },

        footerUrl: {
            type: String,
            default: null,
        },
    },
};
</script>
