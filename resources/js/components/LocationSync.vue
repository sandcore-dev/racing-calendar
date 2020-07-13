<template>
	<div>
		<div class="row">
			<location-checkboxes class="col-sm-6" :locations="locations" checked="yes"/>
			<location-search class="col-sm-6" :season-id="seasonId" :api-token="apiToken" :placeholder="searchPlaceholder" v-on:add="addLocation"/>
		</div>
	</div>
</template>

<script>
	import jquery from 'jquery';
	
    export default {
		data() {
			return {
				locations: []
			};
		},
		
		props: [ 'season-id', 'api-token', 'search-placeholder' ],
		
		mounted() {
			this.populateLocations();
		},
		
		methods: {
			addLocation( location ) {
				this.locations.push( location );
			},
			
			populateLocations() {
				var settings = {
					url: '/api/locations/season/' + this.seasonId,
					data: {
						api_token: this.apiToken
					}
				};
				
				jquery.post( settings ).done( this.setLocations ).fail( this.logError );
			},
			
			setLocations( response ) {
				this.locations = this.locations.concat( response.data );
			},
			
			logError( jqXHR, status, message )
			{
				if( console && console.log )
					console.log( 'Error retrieving locations: ' + message );
			}
		}
    }
</script>
