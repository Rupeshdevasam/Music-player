<template>
	<div  style="display:block;position:absolute;top:50%;left:87%;background:black;">
	  <div class="content">
	  	<progress class="progress" :class="{'is-primary':volume<0.8,'is-danger':volume>=0.8}" :value="progress" max="100">90%</progress>
	      <input v-show="false" type="range" style="display:inline" class="volume" :value="volume" min="0" max="1" >
		<a class="button is-danger fa fa-volume-down is-rounded" @click="volumeDown" style="display:inline" :disabled="volume==0"></a>
		<a class="button is-danger fa fa-volume-up is-rounded" style="display:inline" @click="volumeUp" :disabled="volume==1" ></a>
	  </div>
	</div>

</template>

<script>

export default{
	data(){
		return{
			volume:0.5,
			progress:50,
		}
	},
	methods:{
		volumeDown()
		{
			this.volume=this.volume-0.2;
			this.progress=this.progress-20;
			if(this.volume<0){
				this.volume=0;
				this.progress=0;
			}
			this.$emit('volumeDown',this.volume);

		},
		volumeUp()
		{
			this.volume=this.volume+0.2;
			this.progress=this.progress+20;
			if(this.volume>1){
				this.volume=1;
				this.progress=100;
			}
			this.$emit('volumeUp',this.volume);
		}
	}
};
</script>

<style>
	@import './volume_slider.css';
	
</style>