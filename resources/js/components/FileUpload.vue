<template>
	<div v-on:change="fileChosen">
		<slot>
			<label :for="name" class="btn btn-default">
				{{ label }} <input type="file" :id="name" :name="name" style="display: none">
			</label>
		</slot>
		<span v-for="file in files">
			{{ file.name }}
		</span>
	</div>
</template>

<script>
	export default {
		props: {
			name: String,
			label: { default: 'Choose file' },
		},
		
		data()
		{
			return { files: [] };
		},
		
		methods: {
			fileChosen(event) {
				var files = [];
				
				for(var i = 0; i < event.target.files.length; i++)
					files.push( event.target.files.item(i) );
				
				this.files = files;
			}
		},
	}
</script>
