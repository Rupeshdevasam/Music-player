<template>
	
	<div class="container" >
		<div class="columns">
			<div class="column" style="display: -webkit-flex;display: grid ">
				<player></player>
				
				
			</div>
		</div>
	</div>

</template>

<script>
	import Song from '../components/Song.vue';
	import Player from '../components/Player.vue';
	export default{
		components:{
			Song,
			Player
		},
		data()
		{
			return{
				count:1,
				songs:["Adhento Gaani Vunnapaatuga - SenSongsmp3.Co","Kirraku - SenSongsmp3.Co","03 - Zindabad Zindabad"]
			}
		},
		methods:{

		}
	};
</script>