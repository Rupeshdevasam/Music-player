<template>

	<div :id="count" class="container box" :class="{'selected':active,'normal':!active}" @click="selected">
		<p class="name">
			{{count}}
		</p>
		<p>
			<marquee>This is a song named {{name}}</marquee>
		</p>
			<div style="display:inline-block;padding-left:5%;" v-if="active" >
				
			<button type="button" class="fa fa-backward" ></button>
			
			<button type="button" class="fa" :class="{'fa-play':isPlaying,'fa-pause':!isPlaying}" @click="toggle" aria-label="Left Align" ></button>
			<button type="button" class="fa fa-forward" ></button>
			
			</div>
		
	</div>

</template>

<script>
	export default{
		data(){
			return{
				count:this.$parent.$data.count++,
				active:false,
				name:"temp",
				time:"2:00",
				isPlaying:false
			};
		},
		methods:{
			selected()
			{
				this.$parent.$data.prev.active=false;
				this.active=true;
				this.$parent.$data.prev=this;
			
				
			},
			toggle()
			{
				//alert('hiii');
				this.isPlaying=!this.isPlaying;
				//alert(this.isPlaying);
			}
		},

	};
</script>

<style>
	button{

	}
	p{
		display:inline-block;
		padding-left: 10%;
	}
	.name{
		display:inline-block;
		padding-left: 1%;
	}
	.normal{
		height: 40px;
		padding: 1%;
		background: #F0FFF0;
		color:black;
		margin-bottom: 10px;
	}
	.normal > figure{
		padding-left: 1.5%;
		overflow: hidden;
		position: absolute;

		top:0%;
	}
	.active{
		height: 500px;
		background: lightgreen;
	}
	.normal:hover{
		background: red;
	}
	.button.play {
  width: 10px;
  height: 10px;
  border-style: solid;
  border-width: 10px 0px 10px 40px;
  border-color: transparent transparent transparent #202020;
}
</style>