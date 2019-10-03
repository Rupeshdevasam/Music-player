<template>
	<div style="position:relative;top:-12%;display:block;">
	<div :id="count" class="box selected" :class="{'playing':this.sound.is_playing}" @click="selected" style="background:black;color:white;border:2px solid #9f6934; " v-show="!(index=='NA')">
	  	
		  <article class="media">
		    <div class="media-left">
		      <figure class="image is-128x128">
		        <img style="border:2px solid #9f6934;height:190px;border-top-left-radius:35px;" :src="image" alt="Image">
		      </figure> <br><br>
		      <p>
		       <a class="button is-rounded fa fa-random" :class="{'is-danger':suffle,'is-dark':!suffle}" style="padding-left:5px;padding-right:5px"  @click="suffleToggle"></a>
		       <a class="button is-rounded fa fa-repeat" :class="{'is-danger':repeat,'is-dark':!repeat}" style="padding-left:5px;padding-right:5px"  @click="repeatToggle"></a>
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
				    <!-- remember to set v-model  <input style="float:right;width:50%;" class="slider is-fullwidth" step="0.1" min="0" :max="time" value="0" type="range">-->
		     	
		     	 
		      	<p style="position:relative;top:-40%;">
		      		<div style="position:relative;left:35%;">

					<a class="button is-danger is-rounded fa fa-backward"  @click="previous"></a>
					<a class="button is-danger is-rounded fa fa-stop"  @click="stop"></a>
					<a class="button is-danger fa fa-5x is-rounded"  :class="{'fa-play':isPlaying,'fa-pause':!isPlaying}" @click="toggle"></a>
					<a class="button is-danger fa fa-forward is-rounded" @click="next"></a>
					</div>
					<div style="display:inline;float:right">
							 <volume-slider @volumeDown="volume" @volumeUp="volume"></volume-slider>
							 
					</div>
				
		      	</p>
		     	<br>
		      	<p style="float:left">
					<strong style="color:red">Album:<span style="color:lightgreen;display:inline-flex;padding:5px;text-decoration:underline"> {{album}}</span> </strong>
					<strong style="color:red">Director:<span style="color:lightgreen;display:inline-flex;padding:5px;text-decoration:underline"> {{composer}}</span> </strong>
		      	</p>
		  	   </div>
			
		     
		    </div>
		  </article>
	  
	</div>
		
		<div v-for="song in songs">
			<song @songSelected="songs1" :src="src" ></song>
			
		</div>
	</div>

</template>
<script>
	import Song from './Song.vue';
	import {Howl, Howler} from 'howler';
	import Songs from './Songs.js';
	import Slider from "vue-custom-range-slider";
	import * as MM from 'music-metadata-browser';
  // import the styling, css or scss
 	import "./vue-custom-range-slider.scss";
 	import "./volume_slider.css";
 	import VolumeSlider from './VolumeSlider.vue';

	export default{
		components:{
			Song,
			Slider,
			VolumeSlider,
			
			
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
				old:{active:''},
				slider: "0",
        		songLength:"0",
        		repeater:"",
        		suffle:false,
        		randomSong:0,
        		time_count:{
        			remaining:0,
        		},
        		repeat:true,
        		repeatOne:false,
        		played:[],
        		image:'',
        		md:'',
        		composer:'',
        		album:''
        		
	      
			};
		},
		methods:{
			changed(value){
				this.sound.seek(value);
				this.timeRunner();
			},

			async imageLoader(blob) {
			 
			  // blob is a Web API Blob or File
			  await MM.fetchFromUrl(blob).then(metadata => {
			  	this.md=metadata.common;
    	this.image="data:image/jpeg;base64,"+metadata.common.picture[0].data.toString('base64');

    	this.song=this.md.title;

    	this.composer=this.md.composer[0];

    	this.album=this.md.album;

    	console.log(metadata);


   }).catch();
			  // metadata has all the metadata found in the blob or file
			 
			}


			,
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
					this.repeatOne=!this.repeatOne;
			},
			repeatOneToggle()
			{
				this.repeatOne=!this.repeatOne;
				if(this.repeat)
					this.repeat=!this.repeat;
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
				//alert("hiii");
				this.running_time=this.sound.formatTime(parseInt(this.slider));
			},
			moveSeeker()
			{
				//console.log(this.slider);
				//this.timeRunner();
				this.$refs["range"].$refs["slider"].value=this.sound.seeks().toString();
				this.slider=this.sound.seeks().toString();
				//console.log(this.sound.seeks());
				if(!this.repeatOne){
				if( parseInt(this.songLength)-parseInt(this.slider)<=1){
					this.sound.stop();
					setTimeout(this.next(),2000);
				}
			}
				this.timeRunner();
				//console.log(this.slider);
				

			},
			volume(value){
				this.sound.volume(value);
				this.volumeValue=value;
			},
			selected()
			{
				
				
			},
			toggle()
			{
				if(this.src!='')
				{
					//this.previous.sound.stop();
				}


				this.isPlaying=!this.isPlaying;
				if(!this.isPlaying)
				{
				//	alert(this.src);
					
						this.sound.play();
						//alert("hii");
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
				} catch(e) {
					
				}
				
				this.index=count;
				this.numbering=this.index+1;
				this.song=this.songs[this.index];
				this.src=this.songs[this.index]+".mp3";
				this.loadSong();
				//alert("eui");
				
				//this.time=this.sound.duration();
				try {
					this.sound.play();
					
					
					this.isPlaying=false;
				} catch(e) {
						console.log(e)
				}

				
			},
			
			previous()
			{
				
				try{
				//alert(this.index-1);
				//alert();
				if(this.suffle)
						{
							this.index=Math.floor((Math.random() * this.songs.length-1) + 1);
							while(this.index==this.randomSong)
							{
								this.index=Math.floor((Math.random() * this.songs.length-1) + 1);
							}
							this.randomSong=this.song;
							//alert(this.index);
						}
				else if(this.index-1<0)
					this.index=this.$children.length;
				else
					this.index+=this.$children.length-this.songs.length;
				this.$children[this.index-1].selected();;
				} catch(e){

				}
			},

			next()
			{

				//alert(this.$children.length-this.songs.length);
				
				try{
						if(this.suffle)
						{
							this.index=Math.floor((Math.random() * this.songs.length-1));
							console.log(this.index);
							console.log(this.played);
							console.log(this.index in this.played);
							while(this.played.includes(this.index))
							{
								//alert(this.index);
								this.index=Math.floor((Math.random() * this.songs.length-1));
							}

							this.randomSong=this.index;
							this.played.push(this.index);
							if(this.played.length==this.songs.length){
								//console.log(this.played);
								this.played=[];
								//this.played.push(this.index);

							}

						}
						 else if(this.index>this.songs.length-2)
						{	this.$children[this.index-1+this.$children.length-this.songs.length+1].reset();
							this.index=-1;
						}
						if(this.index==-1 && !this.repeat){
							this.stop();

							this.index="NA";

							return;
						}
						this.$children[this.index+this.$children.length-this.songs.length+1].selected();

				} 
				catch(e)
				{
					console.log(e);
				}


			},
			setTimes()
			{
				var timer;
				this.total_time=this.sound.timer[0];
				this.songLength=(parseInt(this.sound.timer[1])).toString();
				this.$refs["range"].$refs["slider"].max=this.songLength;
				timer=setTimeout(this.setTimes, 1000);

			}

			,
			loadSong()
			{
				clearInterval(this.repeater);
				this.slider="0";
				this.$refs["range"].$refs["slider"].value="0";
				this.sound=new Songs({
											'src': './'+this.src,
											autoplay: false,
						  					loop: true,
						  					volume: this.volumeValue,
						  					

				});
				this.imageLoader(this.src);
				//this.songLength=this.sound.duration();
				this.repeater=setInterval(this.moveSeeker,1000);
				this.setTimes();	
				//this.sound.once('load',function(){
					
				//});
				//this.time=this.sound.duration();
				try{
						
					}catch(e)
					{
						console.log(e);
					}

			},

		},
		created()
		{

		}

	};
</script>

	
<style> 
	@import './Player.css';
	
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vue-slider-component@latest/theme/default.css">
<script src="https://cdn.jsdelivr.net/npm/vue-slider-component@latest/dist/vue-slider-component.umd.min.js"></script>