<template>
	
	<div :id="count" class="box" :class="{'actives':active,'normal':!active}" @click="selected" >
	  
		  <article class="media">

		    <div class="media-content" style="display:inline">
		    
		      <div class="content">
		    
		    		<strong  :class="{'fontWhite':active}" class="index">{{count}}</strong>
		    
		        <p style="float:left;">
		    
		          <strong :class="{'fontWhite':active}">
		    
		          
		    
		          		{{song}}
		    
		          
		    
		           </strong>
		    
		          <br>
		    
		        </p>
		    
		        <p style="float:right">
		    
		        	
		    
		        </p>
		    
		      </div>
		     
		    </div>
		  
		  </article>
	  
	</div>

</template>

<script>

	import Songs from './Songs.js';


	export default{
		

		data(){

			return{

				count:++this.$parent.$data.count,

				active:false,

				time:'',

				song:'',

			};

		},
		methods:{
	
			selected()

			{

				if( this === this.$parent.$data.old )
					return;

				this.active=true;
			
				this.$emit('songSelected',this.count-1);

				this.$parent.$data.old.active = false;

				this.$parent.$data.old=this;	

			},
			reset(){
				this.active=false;
			}
		},

		created(){

			this.song=this.$parent.$data.songs[this.count-1];
		
		}

	};
</script>

<style>
	@import './song.css';



</style>