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
	import Vue from 'vue';
	
	export default{
		components:{
			Song,
			Player
		},
		data()
		{
			return{
				count:1,
				songs:[],
				places:[],
				user:'',
			}
		},
		methods:{
				loadSongs(data)
				{
					alert(data);
					axios.post('/getUser').then(response => {
						   console.log(response.data);
						   this.user=response.data;
						   data.forEach(this.trail); 
						});
					
				},
				trail(element) {
						
						if(element['public']==1 || element['user_id']==this.user){
						this.songs.push(element['name']);
						this.places.push(element['place']);
					}
						//temp+='/'+element['place']+'/'+element['name']+'.'+element['extension'];
						//this.songs.push(temp);
					}
		},
		mounted(){
				axios.post('/all').then(response => {
					this.loadSongs(response.data);
					});
				} 
	};
</script>