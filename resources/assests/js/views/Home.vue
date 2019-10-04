<template>
	
	<div class="container">
		<div class="columns">
			<div class="column">
				
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
				songs:["Adhento Gaani Vunnapaatuga - SenSongsmp3.Co","Kirraku - SenSongsmp3.Co","03 - Zindabad Zindabad","Apudo Ipudo-SenSongsMp3.Co","01 - Padara Padara","03 - Nuvve Samastham","05 - Phir Shuru","07 - Idhe Kadha Nee Katha","08 - Nuvvani Idhi Needani"]
			}
		},
		methods:{

		}
	};
</script>