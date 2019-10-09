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
	import * as MM from 'music-metadata-browser';
	
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
				album_list:{},
				src:'',
			}
		},
		methods:{
				loadSongs(data)
				{
					//alert(data);
					axios.post('/getUser').then(response => {
						   console.log(response.data);
						   this.user=response.data;
						   data.forEach(this.trail); 
						  // alert(this.user)
						});
					
				},
				trail(element) {
						
						if(element['public']==1 || element['user_id']==this.user){
						this.songs.push(element['name']);
						this.places.push(element['place']);
						this.src='/gets/'+element['place']+'/'+element['name']+".mp3";
						this.imageLoader(this.src,element['place'],element['name']);
					}
						//temp+='/'+element['place']+'/'+element['name']+'.'+element['extension'];
						//this.songs.push(temp);
					},
					async imageLoader(blob,place,song) {
			 
							await MM.fetchFromUrl(blob).then(metadata => {
									  	this.md=metadata.common;
						    	 var image="data:image/jpeg;base64,"+metadata.common.picture[0].data.toString('base64');

						    	// this.song=this.md.title;

						    	// this.composer=this.md.composer[0];

						    	// this.album=this.md.album;
						    	var album=this.md.album;
						    	//console.log(metadata);
						    	this.genarateAlbums(song,album,image,place);


						   }).catch({});
							  // metadata has all the metadata found in the blob or file
							 
					},

					genarateAlbums(song,album,image,place)
					{
						if(Object.keys(this.album_list).includes(album))
						{
							this.album_list[album]["songs"].push(song);
							this.album_list[album]["places"].push(place);
						}
						else
						{
							//alert(album);

							this.album_list[album]={};
							this.album_list[album]["name"]=album;
							this.album_list[album]["images"]=[];
							this.album_list[album]["songs"]=[]
							this.album_list[album]["places"]=[];
							this.album_list[album]["images"].push(image);
							this.album_list[album]["songs"].push(song);
							this.album_list[album]["places"].push(place);
						}
					}
		},
		mounted(){

				axios.post('/all').then(response => {

					this.loadSongs(response.data);
					});
				} 
	};
</script>