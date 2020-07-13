<template>
	<div>
		<div>
			<div class="input-group">
				<!--suppress HtmlFormInputWithoutLabel -->
				<input v-model="search" type="text" class="form-control" id="location-search" name="location-search" :placeholder="placeholder" aria-describedby="location-search-icon">
				<div id="location-search-icon" class="input-group-append">
					<span class="input-group-text">
						<span class="fa fa-search"></span>
					</span>
				</div>
			</div>
		</div>
		<location-checkboxes :locations="results" v-on:checked="checked"/>
	</div>
</template>

<script>
	import lodash from 'lodash';
	import axios from 'axios';
	
    export default {
		data() {
			return {
				search: '',
				results: []
			};
		},
		
		props: [ 'season-id', 'placeholder' ],
		
        watch: {
            search()
            {
				this.getResults();
            }
        },
        
        methods: {
			getResults: lodash.debounce(
				function ()
				{
					if( this.search.length < 2 )
						return;

					axios
						.post('/api/locations/search', {
							keywords: this.search,
							exclude_season: this.seasonId,
						})
						.then(this.showResults)
						.catch(this.logError);
				},
				500
			),
			
			showResults( response ) {
				this.results = response.data.data;
			},
			
			logError( jqXHR, status, message ) {
				if( console && console.log )
					console.log( 'Error searching for locations: ' + message );
			},
			
			checked( index )
			{
				this.$emit( 'add', this.results.splice( index, 1 )[0] );
			}
        }
        
    }
</script>
