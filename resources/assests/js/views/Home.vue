<template>
	
	<div class="container" >
		<div class="columns">
			<div class="column">
				<song></song>
				<song></song>
				<song></song>
				<song></song>
				<song></song>
				<song></song>
				<song></song>
				<song></song>
				<song></song>
				<song></song><song></song>
			</div>
		</div>
	</div>

</template>

<script>
	import Song from '../components/Song.vue';
	export default{
		components:{
			Song
		},
		data()
		{
			return{
				count:0,
				prev:{active:false},
			}
		},
	};
</script>