<template>
	<div class="">
	<div :id="count" class="box selected" @click="selected" >
	  
		  <article class="media">
		    <div class="media-left">
		      <figure class="image is-64x64">
		        <img  src="https://m.media-amazon.com/images/M/MV5BM2ZkZGIwZDAtNGU1ZS00NTlkLThjYjYtMjU5MzQzNDQyMTBmXkEyXkFqcGdeQXVyODA2ODM3NDQ@._V1_QL50_.jpg" alt="Image">
		      </figure>
		    </div>
		    <div class="media-content" style="display:inline">
		      <div class="content">
		    		<strong style="float:left">{{numbering}}</strong>
		        <p style="float:left;width:40%;" class="p_active">
		          <strong>
		          	<marquee style="color:red;">
		          		 {{song}}
		          	</marquee>
		           </strong>
		          <br>
		        </p>
		        <p style="float:right">
		        	{{time}}
		        </p>
		      </div>
		     
		      <div class="media-right">
		     	 <hr>
		     	 <input style="float:right;width:50%;" class="slider is-fullwidth" step="0.1" min="0" :max="time" value="0" type="range">
		      	<p>
		      		

					<a class="button is-primary is-rounded fa fa-backward" @click="previous"></a>
					<a class="button is-primary fa is-rounded" :class="{'fa-play':isPlaying,'fa-pause':!isPlaying}" @click="toggle"></a>
					<a class="button is-primary fa fa-forward is-rounded" @click="next"></a>

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

	export default{
		components:{
			Song
		},
		data(){
			return{
				index:"NA",
				count:0,
				name:"NA",
				time:"NA",
				isPlaying:true,
				song:'NA',
				src:'',
				numbering:'',
				sound:{},
				songs:this.$parent.$data.songs,
				old:{active:''}
			};
		},
		methods:{
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
				}
				else if(this.src!='')
				{
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
				//this.time=this.sound.duration();
				try {
					this.sound.play();

					this.isPlaying=false;
				} catch(e) {

				}

				
			},
			
			previous()
			{
				
				try{
				
				if(this.index-1<0)
					this.index=this.songs.length;
				this.$children[this.index-1].selected();;
				} catch(e){

				}
			},

			next()
			{
				
				try{

						if(this.index>this.songs.length-2)
						{	
							this.index=-1;
						}
						this.$children[this.index+1].selected();

				} 
				catch(e)
				{

				}


			},
			setTimes()
			{
				var timer;
				this.time=this.sound.timer;
				if(this.time!=0)
					clearTime(timer);
				timer=setTimeout(this.setTimes, 1000);
			}

			,
			loadSong()
			{
				this.sound=new Songs({
											'src': './'+this.src,
											autoplay: false,
						  					loop: true,
						  					volume: 0.5,
						  					onload: function () {
						             		this.timer=this.timerCount();
										}.bind(this),
										onend:function(){
											this.next();
										}.bind(this),
				});
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
	@import './rangeslider.css'; 
	@import './Player.css';



</style>