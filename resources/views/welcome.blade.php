<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">       
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.css">
   
        <title>Music Player</title>
    <style>
        body, html {
  padding: 0;
  margin: 0;
  width: 100%;
  min-height: 100vh;
}
body {
  
 background: black;
/* The rectangle in which to repeat. 
   It can be fully wide in this case */
background-size: 100% 20px;
}
.playing {
  box-shadow: 1px 1px 5px #00FFFF;
  -webkit-animation-name: playingColor; /* Safari 4.0 - 8.0 */
  -webkit-animation-duration: 4s; /* Safari 4.0 - 8.0 */
  animation-name: playingColor;
  animation-duration: 1s;
  animation-iteration-count: infinite;
}

/* Safari 4.0 - 8.0 */
@-webkit-keyframes playingColor {
  from {box-shadow: 1px 1px 5px #00FFFF;}
  to {box-shadow: 3px 3px 3px red;}
}

/* Standard syntax */
@keyframes example {
  from {border-color: #00FFFF;}
  to {border-color: red;}
}
</style>
    

          
    </head>
    <body>

      <div id="root">

        @include('header')

        <div class="container box playing" style="max-height: 1000px;overflow-y: hidden;overflow-x: hidden;background: #1C00ff00;border: 1px inset #9f6934;box-shadow: 1px 1px 5px #00FFFF">
        <section class="section" >
          <div class="container" style="position:relative;top:2%">
            <router-view></router-view>  

          </div>
        </section>
    </div>
        
      </div>
     <script src="/js/app.js"></script>
    </body>
</html>

