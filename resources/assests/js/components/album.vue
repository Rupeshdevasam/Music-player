<template>
	<div class="album-wrapper" style="display:inline-block" @click="selected">
    <div :class="'album'">
      <img :src="album['images']" class="album-image">
      <h2 class="name" style="color:red">{{album['name']}}</h2>
    </div>
    <!-- <div v-for="song in album['songs']" v-show="album_toggle">
				<song @songSelected=""></song>
			</div> -->
  </div>
</template>

<script>
import song from './Song.vue';

export default {
 	props:['album'],

 	components:{
 		song,
 	},
 	data()
 	{
 		return{
 			album_toggle:false,
 		}
 	},
 	methods:
 	{
 		selected()
 		{
 			
 			this.$emit('albumSelected',this.album);
 		}
 	},
 	mounted(){
 		console.log(this.album);
 	}
};
</script>

<style>


.album-wrapper {
  margin: 12px;
}

.album {
  width: 180px;
  padding: 5px;
  cursor: pointer;
  margin: 10px 0 5px 0;
  display: inline-block;
  box-sizing: border-box;
  text-align: center;
  transition: transform 0.3s ease-in-out;
  overflow: hidden;

  .album-image {
    display: inline-block;
    width: 156px;
    height: 156px;
    margin: 0 auto;
    border-radius: 4px;
    object-fit: cover;

    &[src=""] {
      background-color: @color-background-transparent;
    }
  }

  

  
}
.name {
    display: block;
    width: 156px;
    font-size: 16px;
    max-height: 40px;
    overflow: hidden;
    margin: 0 auto;
    color:red;
  }
.album:hover {
    transform: scale3d(1.05, 1.05, 1);
  }
</style>