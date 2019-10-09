<template>
	<div>
		<h1 class="title is-3 " style="color:red">Add a song</h1>
<div class="container box">
	
 

<div class="field">
  <label class="label" style="color:black">Name</label>
  <div class="control">
    <input class="input" type="file" ref="file" @change="handleFile" placeholder="Text input">
  </div>
</div>
<div class="field">
  <label class="label" style="color:black">Album</label>
  <div class="control">
    <input class="input" type="text" :value="album" ref="album" @change="handleChange" placeholder="Text input">
  </div>
</div>


<div class="field">
	<label><strong style="color:black">Make it public?</strong></label>
  <div class="control">
    <label class="radio" style="color:black">
      <input type="radio" v-model="public" name="question" :value=1 selected>
      Yes
    </label>
    <label class="radio" style="color:black">
      <input type="radio" v-model="public" name="question" :value=0>
      No
    </label>
  </div>
</div>

<div class="field is-grouped">
  <div class="control">
    <button class="button is-link" @click="submitted">Submit</button>
  </div>
  <div class="control">
    <button class="button is-danger" style="color:white">Cancel</button>
  </div>
</div>
</div>
</div>
</template>

<script>
import axios from 'axios';

window.axios=axios;

export default{

	data(){
		  return {
		    file: 'ssss',
		    public:1,
		    album:'NULL',
		  }
		},

	methods:{

		handleChange()
		{
			//alert("message?: DOMString");
			this.album=this.$refs.album.value;
		},
		handleFile()
		{
			alert("HII");
			this.file=this.$refs.file.files[0];
		},
		submitted(){
			let formData = new FormData();
			formData.append('file', this.file);

			   var names=""
	      for(var i=0;this.file.name.charAt(i)!='.';i++)
	      {
	      		names+=this.file.name.charAt(i);
		  }
	      console.log(names);


			formData.append('name',names);
			formData.append('public',this.public);
			formData.append('album',this.album);
			alert("Submitted");

			axios.post( '/files/add',
			  formData,
			  {
			    headers: {
			        'Content-Type': 'multipart/form-data'
			    }
			  }
			).then(function(){
			  console.log('SUCCESS!!');
			})
			.catch(function(){
			  console.log('FAILURE!!');
			});

		}
	}
};


</script>