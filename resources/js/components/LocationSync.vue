<template>
  <div>
    <div class="row">
      <location-checkboxes
        class="col-sm-6"
        :locations="locations"
        checked
      />
      <location-search
        class="col-sm-6"
        :season-id="seasonId"
        :placeholder="searchPlaceholder"
        @add="addLocation"
      />
    </div>
  </div>
</template>

<script>
import axios from 'axios';

import LocationCheckboxes from '@/components/LocationCheckboxes.vue';
import LocationSearch from '@/components/LocationSearch.vue';

export default {
    components: {
        LocationCheckboxes,
        LocationSearch,
    },

    data() {
        return {
            locations: [],
        };
    },

    props: {
        seasonId: {
            type: [Number, String],
            required: true,
        },
        searchPlaceholder: {
            type: String,
            default: null,
        },
    },

    mounted() {
        this.populateLocations();
    },

    methods: {
        addLocation(location) {
            this.locations.push(location);
        },

        populateLocations() {
            axios
                .post(`/api/locations/season/${this.seasonId}`)
                .then(this.setLocations)
                .catch(this.logError);
        },

        setLocations(response) {
            this.locations = this.locations.concat(response.data.data);
        },

        logError(jqXHR, status, message) {
            // eslint-disable-next-line no-console
            console.log(`Error retrieving locations: ${message}`);
        },
    },
};
</script>
