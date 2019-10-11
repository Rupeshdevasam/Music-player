<template>

  <div class="container">
  
    <div class="columns">
  
      <div class="column">

        <songupload v-if="user!=''"></songupload>

        <div v-else>

         <section class="hero  is-medium">

          <div class="hero-body">
            <div class="container">

              <div class="columns is-centered">

                <div class="column is-5-tablet is-4-desktop is-3-widescreen">

                  <div class="container" style="padding:10px;">

                    <a class="button is-primary" @click="login">Login</a>
        
                  </div>

                  <div class="container">

                    <a class="button is-primary" @click="newUser">New User?</a>
        
                  </div>

                </div>

              </div>

            </div>

          </div>

        </section>

      </div>

    
    </div>
  
  </div>

</div>

</template>

<script>
import songupload from '../components/SongUpload';

export default{

  components:{

    songupload,

  },

  data()
  {

    return {

      user:'',

      username:'',

      password:'',

    }

  },

  methods: {
  
    login()
    {
  
      window.location="/login";
  
    },
  
    newUser()
    {
  
      window.location='/register';
  
    },

    attemptLogin()
    {

      let formData = new FormData();
  
      formData.append('email', this.username);
  
      formData.append('password', this.password);

      axios.post( 'authenticate',
  
        formData,
        {
  
          headers: {
  
            'Content-Type': 'multipart/form-data'
  
          }
  
        }).then(function(){

          window.location = "http://project.management.com/#/";
         
          console.log("LOGGEDIN");
        
        }).catch(function(){
        
          console.log('FAILED');
        
        });
      
      },

    },
    mounted()
    {
    
      axios.post('/getUser').then(response => {
      
       console.log(response.data);
      
       this.user=response.data;
     
      }).catch();
 
   }
 
 };

 </script>