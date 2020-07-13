<template>
	<div>
		<div class="checkbox" v-for="(location, index) in locations" :key="location.id">
			<label>
				<input type="checkbox" name="locations[]" :index="index" :value="location.id" :checked="checked" v-on:change="hasBeenToggled">
				{{ location.name }}
			</label>
		</div>		
	</div>
</template>

<script>
    export default {
		props: [ 'locations', 'checked' ],
		
		methods: {
			hasBeenToggled( event ) {
				if( event.target.checked )
					this.$emit( 'checked', event.target.getAttribute('index') );
			}
		},
    }
</script>
