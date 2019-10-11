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

			playlists:[],

		}

	},
	methods:{

		loadSongs(data)
		{

			axios.post('/getUser').then(response => {
		
					   	this.user=response.data;
					   	if(this.user!='')
					   	{
					   		this.initList();
					   	}
						data.forEach(this.trail); 
						
			});
					
		},
	
		trail(element) 
		{

			if( element['public'] == 1 || element['user_id'] == this.user )
			{
				this.songs.push(element['name']);
				
				this.places.push(element['place']);
				
				this.src='/gets/'+element['place']+'/'+element['name']+".mp3";
				
				this.imageLoader(this.src,element['place'],element['name'],element['album']);
				
			}
		},
		
		async imageLoader(blob,place,song,album) 
		{

			await MM.fetchFromUrl(blob).then(metadata => {
			 					
			 					this.md=metadata.common;
			 					
			 					var image="data:image/jpeg;base64,"+metadata.common.picture[0].data.toString('base64');

						    	if(album=="NULL")
						    	{
						    	
						    		album=this.md.album;
						    	
						    	}
						    	
						    	this.genarateAlbums(song,album,image,place);

						    }).catch({});
							  
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
		
				this.album_list[album]={};
		
				this.album_list[album]["name"]=album;
		
				this.album_list[album]["images"]=[];
		
				this.album_list[album]["songs"]=[]
		
				this.album_list[album]["places"]=[];
		
				this.album_list[album]["images"].push(image);
			
				this.album_list[album]["songs"].push(song);
			
				this.album_list[album]["places"].push(place);
			}

		},
				
		initList()
		{
	
			try{
		
					axios.post('/getPlaylists').then(response =>{
		
									(response.data).forEach(this.generateLists);

					});
		
				}
			catch(e)
			{

			}
		},
	
		generateLists(element)
		{
			var temp={};
		
			temp['name']=element['name'];
		
			temp['songs']=element['songs'].split("*");
		
			temp['places']=element['places'].split("*");
		
			this.playlists.push(temp);
		
		},
	},

	mounted()
	{
		try{
				axios.post('/all').then(response => {

						this.loadSongs(response.data);
					
				});

			}
		catch(e){

		};

	}

};
</script>