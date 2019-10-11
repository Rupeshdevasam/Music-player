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

					<input class="input" type="text" ref="album" v-model="album" placeholder="Text input">

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
		
		<div class="notification is-success" :class="{'is-success':!is_danger,'is-danger':is_danger}" v-if="submitted_flag">
		
			<strong>{{message}}</strong>
		
		</div>
	
	</div>

</template>

<script>
import axios from 'axios';

window.axios=axios;

export default{

	data()
	{
		return {
			file: 'ssss',
			public:1,
			album:'NULL',
			is_danger:false,
			message:'',
			submitted_flag:false,
		}
	},

	methods:{

		handleChange()
		{
	
			this.album=this.$refs.album.value;

		},

		handleFile()
		{

			this.file=this.$refs.file.files[0];

		},

		closeFlag()
		{

			this.submitted_flag=false;

		},

		submitted()
		{

			let formData = new FormData();
		
			formData.append('file', this.file);

			var names=""
		
			for(var i=0;this.file.name.charAt(i)!='.';i++)
			{
		
				names+=this.file.name.charAt(i);
		
			}
	    
	    	formData.append('name',names);
	    
	    	formData.append('public',this.public);
	    
	    	formData.append('album',this.album);

			axios.post( '/files/add',
		
				formData,
				{
		
					headers: {
		
						'Content-Type': 'multipart/form-data'
		
					}
		
				}).then(response =>{
				
				this.album='NULL';
				
				this.$refs.file.value='';
				
				this.submitted_flag=true;
				
				this.message="Uploaded";
				
				this.is_danger=false;
				
				setTimeout(this.closeFlag, 3000);
				
				console.log('SUCCESS!!');

			}).catch(response =>{
			
					this.submitted_flag=true;
			
					this.is_danger=true;
			
					this.message=response;
			
				setTimeout(this.closeFlag, 5000);
			
			});

		}
	}
};


</script>