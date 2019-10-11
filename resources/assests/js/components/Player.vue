<template>
	<div style="position:relative;top:-12%;display:block;">
		
		<div :id="count" class="box selected" :class="{'playing':this.sound.is_playing}" style="background:black;color:white;border:2px solid #9f6934;margin-top:5%" v-show="!(index=='NA')">

			<article class="media">

				<div class="media-left">

					<figure class="image is-128x128">

						<img style="border:2px solid #9f6934;height:190px;border-top-left-radius:35px;" :src="image" alt="Image">

					</figure> <br><br>

					<p>

						<a class="button is-rounded fa fa-random" :class="{'is-danger':suffle,'is-dark':!suffle}" style="
						padding-left:5px;padding-right:5px"  @click="suffleToggle"></a>

						<a class="button is-rounded fa fa-repeat" :class="{'is-danger':repeat,'is-dark':!repeat}" style="
						padding-left:5px;padding-right:5px"  @click="repeatToggle"></a>

						<a class="button is-rounded fa fa-undo" :class="{'is-danger':repeatOne,'is-dark':!repeatOne}" style="padding-left:5px;padding-right:5px"  @click="repeatOneToggle"></a>

					</p> 

				</div>

				<div class="media-content" style="display:inline">

					<div class="content">

						<strong style="float:left;color:white">{{numbering}} |<i> {{running_time}}</i></strong>

						<p style="float:left;" class="p_active">

							<strong>

								<marquee style="color:red">

									{{song}}

								</marquee>

							</strong>

							<br>

						</p>

						<p style="float:right;display:inline-block">

							{{total_time}}

						</p>
					</div>

					<div class="media-right">
						<p>
							<div>
						
								<slider

								min="0"
								:max="songLength"
								ref="range"
								@input="changed"
								step="1"
								:value="slider"
								v-model="slider"
								></slider>
						
							</div>
						
						</p>

						<p style="position:relative;top:-40%;">
						
							<div style="position:relative;left:35%;">

								<a class="button is-danger is-rounded fa fa-backward"  @click="previous"></a>
						
								<a class="button is-danger is-rounded fa fa-stop"  @click="stop"></a>
						
								<a class="button is-danger fa fa-5x is-rounded"  :class="{'fa-play':isPlaying,'fa-pause':!isPlaying}" @click="toggle"></a>
						
								<a class="button is-danger fa fa-forward is-rounded" @click="next"></a>
						
							</div>
						
							<div style="display:inline;float:right;">
						
								<volume-slider @volumeDown="volume" @volumeUp="volume"></volume-slider>

							</div>

						</p>
						
						<br>
						
						<p style="float:left">
						
							<strong style="color:red">Album: 
						
								<a :href="search(album)" target="_blank">
						
									<span style="color:lightgreen;display:inline-flex;padding:5px;text-decoration:underline">
									 {{album}}</span>
								
								</a> 
							
							</strong>

							<strong style="color:red">Director: 
							
								<a :href="search(composer)" target="_blank">
							
									<span style="color:lightgreen;display:inline-flex;padding:5px;text-decoration:underline">

									 {{composer}}
							
									</span>
								
								</a> 
							
							</strong>
						
						</p>
					
					</div>

				</div>

			</article>

		</div>
		
		<div>
		
			<a class="button is-danger is-rounded fa" :class="{'fa-toggle-on':!album_toggle,'fa-toggle-off':album_toggle}" @click="album_toggle=!album_toggle;count=0;" style="margin-bottom:10px;"></a>
		
		</div>
		
		<div class="container scrollbar" id="style-1" v-if="album_toggle">
			
			<div v-for="song in songs" v-if="album_toggle">
		
				<song @songSelected="songs1" ></song>
		
			</div>
		
		</div>
		
		<div class="container scrollbar1" id="style-1" v-if="!album_toggle">
			
			<h1 class="title is-3" v-if="!album_toggle" style="text-align:center;color:darkred;">ALBUMS</h1>
			
			<div class="container scrollbar" id="style-1" v-if="!album_toggle">

				<ul>
				
					<li>
				
						<album :album="reset_album" @albumSelected="albumSelected"></album>
				
					</li>
				
					<li v-for="album in album_list">

						<album :album="album" @albumSelected="albumSelected"></album>

					</li>
				
				</ul>

			</div>
			
			<h1 class="title is-3" v-if="!album_toggle" style="text-align:center;color:darkred;">Playlists</h1>
			
			<a href="/login" class="button is-primary" style="position:relative;left:40%;" v-if="user==''">
			
				<span><b>Please to login to access playlists</b></span>
			
			</a>
			
			<div class="container scrollbar" id="style-1" v-if="!album_toggle && user!=''">

				<ul>
			
					<li v-for="item in playlists">

						<playlist :album="item" @albumSelected="albumSelected"></playlist>

					</li>
			
				</ul>

			</div>
		
		</div>
	
	</div>

</template>


<script>
import Song from './Song.vue';
import {Howl, Howler} from 'howler';
import Songs from './Songs.js';
import Slider from "vue-custom-range-slider";
import * as MM from 'music-metadata-browser';
import "./vue-custom-range-slider.scss";
import "./volume_slider.css";
import VolumeSlider from './VolumeSlider.vue';
import album from './album.vue';
import playlist from './Playlist.vue';

  export default{

  	components:{
  		Song,
  		Slider,
  		VolumeSlider,
  		album,
  		playlist,
  	},

  	data(){
  	
  		return{
  	
  			volumeValue:0.5,
  	
  			index:"NA",
  	
  			count:0,
  	
  			name:"NA",
  	
  			total_time:"NA",
  	
  			isPlaying:true,
  	
  			song:'NA',
  	
  			running_time:"NA",
  	
  			src:'',
  	
  			numbering:'',
  	
  			sound:{is_playing:false},
  	
  			songs:this.$parent.$data.songs,
  	
  			places:this.$parent.$data.places,
  	
  			album_toggle:true,
  	
  			play_list:{},
  	
  			old:{active:''},
  	
  			slider: "0",
  	
  			songLength:"0",
  	
  			repeater:"",
  	
  			suffle:false,
  	
  			randomSong:0,
  	
  			temp_play:[],
  	
  			user:"",
  	
  			time_count:{
  				remaining:0,
  	
  			},
  	
  			repeat:true,
  	
  			repeatOne:false,
  	
  			played:[],
  	
  			image:'',
  	
  			md:'',
  	
  			composer:'',
  	
  			album:'',
  	
  			album_list:this.$parent.$data.album_list,
  	
  			reset_album:{
  	
  				images:["https://previews.123rf.com/images/aalbedouin/	aalbedouin1709/aalbedouin170901245/85783425-music-albums-icon-.jpg"],
  				
  				name:"All songs",
  				
  				songs:this.$parent.$data.songs,
  				
  				places:this.$parent.$data.places,
  			},

  			playlists:this.$parent.$data.playlists,

  		};

  	},

  	methods:
  	{

  		changed(value) {

  			this.sound.seek(value);

  			this.timeRunner();

  		},

  		albumSelected(album)

  		{

				//alert('ggg');

				this.count=0;

				this.index=0;

				this.$parent.$data.count=0;

				this.songs=album['songs'];

				this.places=album['places'];

				this.album_toggle=true;

			},



			search(word) 
			{

				return "https://www.google.co.in/search?q="+word;

			},

			async imageLoader(blob) 
			{

				this.album="NA";

				this.composer="NA";

				await MM.fetchFromUrl(blob).then(metadata => {
				
				  	this.md=metadata.common;

				  	this.image="data:image/jpeg;base64,"+metadata.common.picture[0].data.toString('base64');

				  	this.song=this.md.title;

				  	this.composer=this.md.composer[0];

				  	this.album=this.md.album;


    			}).catch();

			},

		suffleToggle()
		{
	
			this.suffle=!this.suffle;
	
			this.played=[];
	
			this.played.push(this.index-1);
	
		},
	
		repeatToggle()
		{
			
			this.repeat=!this.repeat;
			
			if(this.repeatOne)
			{
			
				this.repeatOne=!this.repeatOne;
			
			}
		
		},
		repeatOneToggle()
		{
			this.repeatOne=!this.repeatOne;
		
			if(this.repeat)
			{
		
			this.repeat=!this.repeat;
		
			}
		
		},

		stop()
		{
				this.sound.stop();
		
				clearInterval(this.repeater);
		
				this.$refs["range"].$refs["slider"].value="0";
		
				this.slider="0";
		
				this.toggle();
		
				this.timeRunner();

		},

		timeRunner()
		{
		
				this.running_time=this.sound.formatTime(parseInt(this.slider));
		
		},
		
		moveSeeker()
		{
			try{
			
					this.$refs["range"].$refs["slider"].value=this.sound.seeks().toString();
			
					this.slider=this.sound.seeks().toString();

					if(!this.repeatOne)
					{
						if( parseInt(this.songLength)-parseInt(this.slider)<=1)
						{
							this.sound.stop();
							setTimeout(this.next(),2000);
						}
					}
				this.timeRunner();

			}
			catch(e)
			{
				
				this.sound.stop();
			
			}


		},
		
		volume(value)
		{
		
			this.sound.volume(value);
		
			this.volumeValue=value;
		
		},

		toggle()
		{
		
			if(!this.isPlaying)
			{

				this.sound.play();

				this.repeater=setInterval(this.moveSeeker, 1000);
			
			}
			
			else if(this.src!='')
			{
			
				this.time_count.remaining=
			
				clearInterval(this.repeater);
			
				this.sound.pause();
			
			}

		},

		songs1(count)
		{
			
			try {
			
					this.sound.stop();	
			
				} 
			catch(e) {

				}

			this.index=count;
			
			this.numbering=this.index+1;
			
			this.song=this.songs[this.index];
			
			this.src='/gets/'+this.places[this.index]+'/'+this.songs[this.index]+".mp3";
			
			this.loadSong();

			try {
			
					this.sound.play();		
		
					this.isPlaying=false;

			}
			catch(e) {
			
			}
	
		},
			
		previous()
		{
			
			try{

					if(this.suffle)
					{

						this.index=Math.floor((Math.random() * this.songs.length-1) + 1);

						while(this.index==this.randomSong)
						{

								this.index=Math.floor((Math.random() * this.songs.length-1) + 1);

						}

							this.randomSong=this.song;
								
					}
					
					else if(this.index-1<0)
					{
					
						this.index=this.$children.length;
					
					}
				
					else
					{
				
						this.index+=this.$children.length-this.songs.length;
				
					}
				
					this.$children[this.index-1].selected();;
			} 
			catch(e){

			}
		
		},

		next()
		{
				
			try{
			
					if(this.suffle)
					{
			
						this.index=Math.floor((Math.random() * this.songs.length-1));
						while(this.played.includes(this.index))
						{
	
							this.index=Math.floor((Math.random() * this.songs.length-1));
							
						}

						this.randomSong=this.index;
			
						this.played.push(this.index);
			
						if(this.played.length==this.songs.length)
						{
							
							this.played=[];

						}

					}
					
					else if(this.songs.length==1)
					{
					
							this.sound.stop();
					
							this.sound.play();
					
							return ;
					}
					else if(this.index>this.songs.length-2)
					{	
					
							this.$children[this.index-1+this.$children.length-this.songs.length+1].reset();
					
							this.index=-1;
					
					}
					
					if(this.index==-1 && !this.repeat)
					{
					
						this.stop();

						this.index="NA";

						return;
					}
					this.$children[this.index+this.$children.length-this.songs.length+1].selected();

			} catch(e) {
					//
			}

		},
		
		setTimes()
		{		
		
			var timer;
			
			this.total_time=this.sound.timer[0];
			
			this.songLength=(parseInt(this.sound.timer[1])).toString();
			
			this.$refs["range"].$refs["slider"].max=this.songLength;
			
			timer=setTimeout(this.setTimes, 1000);

		},
			
		loadSong()
		{
		
			clearInterval(this.repeater);
		
			this.slider="0";
		
			this.$refs["range"].$refs["slider"].value="0";
		
			this.sound=new Songs({
					'src':this.src,
					autoplay: false,
					loop: true,
					volume: this.volumeValue,
			});
		
			this.imageLoader(this.src);
		
			this.repeater=setInterval(this.moveSeeker,1000);
			
			this.setTimes();	

		},

	},
	
	mounted()
	{
	
		axios.post('/getUser').then(response => {
	
			this.user=response.data;
	
			});

	}

};
</script>


<style> 
		@import './Player.css';
		li{
			display: inline;
		} 
		.scrollbar {

			float: left;
			height: 250px;

			margin-left: 22px;
			width:100%;
			overflow-y: scroll;
			overflow-x: none;
		}
		.scrollbar1 {

			float: left;
			height: 550px;

			margin-left: 22px;

			width:100%;
			overflow: none;
		}


		.force-overflow {
			min-height: 450px;
		}
		#style-1::-webkit-scrollbar {
			width: 6px;
			background-color: #000000;
		} 
		#style-1::-webkit-scrollbar-thumb {
			background-color: darkred;
		}

		div.scrollmenu {
			background-color: #333;
			overflow: auto;
			white-space: nowrap;
		}



</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vue-slider-component@latest/theme/default.css">
<script src="https://cdn.jsdelivr.net/npm/vue-slider-component@latest/dist/vue-slider-component.umd.min.js"></script>