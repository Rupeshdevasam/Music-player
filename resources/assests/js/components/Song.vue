<template>
	
	<div :id="count" class="box" :class="{'actives':active,'normal':!active}"  >

		<article class="media">

			<div class="media-content" style="display:inline" @click="selected">

				<div class="content">

					<strong  :class="{'fontWhite':active}" class="index">{{count}}</strong>

					<p style="float:left;">

						<strong :class="{'fontWhite':active}">



							{{song}}



						</strong>

						<br>

					</p>

				</div>

			</div>

			<div class="dropdown is-right" :class="{'is-active':toggle}" style="display:inline">

				<div class="dropdown-trigger">
				
					<span class="icon is-small">
				
						<i aria-haspopup="true" aria-controls="dropdown-menu" @click="options" class="fa" :class="{'fa-plus':!toggle,'fa-times':toggle}" style="color:darkred;" aria-hidden="true"></i>
					
					</span>
				</div>
				
				<div class="dropdown-menu" id="dropdown-menu" role="menu">
				
					<div class="dropdown-content">

						<a href="#" class="dropdown-item" v-for="item in playlists" @click="listSelect(item)" v-if="user!=''">
						
							<span>Add to <b> {{item.name}}</b></span>
						
							<hr class="dropdown-divider">
						
						</a>

						<input href="#" v-model="new_playlist" v-if="user!=''" class="dropdown-item" placeholder="Create a new playlist" style="margin:10px;" ></input>
						
						<a style="position:relative;left:35%;z-index:30;" v-if="user!=''" class="button is-primary" @click="createPlaylist">Create and Add</a>
						
						<a href="/login" class="dropdown-item" v-else>
						
							<span><b>Please to login to access playlists</b></span>
						
							<hr class="dropdown-divider">
						
						</a>
					
					</div>
				
				</div>
			
			</div>
		
		</article>

	</div>

</template>

<script>

import Songs from './Songs.js';

export default{

	data()
	{

		return{

			count:++this.$parent.$data.count,

			active:false,

			time:'',
	
			user:'',

			song:'',
			
			place:'',
			
			playlists:[],
			
			new_playlist:'',
			
			toggle:false,

		};

	},
	
	methods:{
	
		options()
		{
			this.toggle=!this.toggle;
		},
	
		listSelect(data)
		{
	
			let formData = new FormData();

			formData.append('song',this.song);

			formData.append('place',this.place);

			formData.append('id',data.id);

			alert("Submitted");

			axios.post( '/addToList',

					formData,

					{
						headers: {
							'Content-Type': 'form-data'
						}
					}

			).then(function(){
					
					console.log('SUCCESS!!');

			}).catch(function(){
			
					console.log('FAILURE!!');
			});
	
		},

		createPlaylist()
		{

			let formData = new FormData();

			formData.append('name', this.new_playlist);

			formData.append('public',1);

			formData.append('song',this.song);

			formData.append('place',this.place);

			alert("Submitted");

			axios.post( '/createList',

				formData,

				{

					headers: {

						'Content-Type': 'form-data'

					}
				}).then(function(){
				
					console.log('SUCCESS!!');
				
				}).catch(function(){
				
					console.log('FAILURE!!');
				
				});
		
	},
	
	selected()
	{

		if( this === this.$parent.$data.old )
		{
			return;
		}

		this.active=true;

		this.$emit('songSelected',this.count-1);

		this.$parent.$data.old.active = false;

		this.$parent.$data.old=this;	

	},
	
	reset()
	{
	
		this.active=false;
	
	},
	
	playlistsLoad()
	{
	
		axios.get('/getPlay').then(response=>{
	
			this.playlists=response.data;
	
		});
	
	}
},

created()
{

	axios.post('/getUser').then(response => {

						   this.user=response.data;
		
						   if(this.user!='')
						   {
		
						   	this.playlistsLoad();
		
						   }
		
	});

	this.song=this.$parent.$data.songs[this.count-1];
	this.place=this.$parent.$data.places[this.count-1];


}

};

</script>

<style>
@import './song.css';

.dropdown-content {
	max-height: 10em;
	overflow: auto;
}


</style>