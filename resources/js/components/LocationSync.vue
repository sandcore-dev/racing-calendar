<template>
	<div>
		<div class="row">
			<location-checkboxes class="col-sm-6" :locations="locations" checked="yes"/>
			<location-search class="col-sm-6" :season-id="seasonId" :placeholder="searchPlaceholder" v-on:add="addLocation"/>
		</div>
	</div>
</template>

<script>
	import axios from 'axios';
	
    export default {
		data() {
			return {
				locations: []
			};
		},
		
		props: [ 'season-id', 'search-placeholder' ],
		
		mounted() {
			this.populateLocations();
		},
		
		methods: {
			addLocation( location ) {
				this.locations.push( location );
			},
			
			populateLocations() {
				axios
					.post('/api/locations/season/' + this.seasonId)
					.then(this.setLocations)
					.catch(this.logError);
			},
			
			setLocations( response ) {
				this.locations = this.locations.concat( response.data.data );
			},
			
			logError( jqXHR, status, message )
			{
				if( console && console.log )
					console.log( 'Error retrieving locations: ' + message );
			}
		}
    }
</script>
