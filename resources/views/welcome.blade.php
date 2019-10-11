<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<head>
 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
@keyframes move_wave {
  0% {
    transform: translateX(0) translateZ(0) scaleY(1)
  }
  50% {
    transform: translateX(-25%) translateZ(0) scaleY(0.55)
  }
  100% {
    transform: translateX(-50%) translateZ(0) scaleY(1)
  }
}
.waveWrapper {
  overflow: hidden;
  position: absolute;
  left: 0;
  right: 0;
  bottom: 0;
  top: 0;
  margin: auto;
}
.waveWrapperInner {
  position: absolute;
  width: 100%;
  overflow: hidden;
  height: 100%;
  bottom: -1px;
  background-image: linear-gradient(to top, #86377b 20%, #27273c 80%);
}
.bgTop {
  z-index: 15;
  opacity: 0.5;
}
.bgMiddle {
  z-index: 10;
  opacity: 0.75;
}
.bgBottom {
  z-index: 5;
}
.wave {
  position: absolute;
  left: 0;
  width: 200%;
  height: 100%;
  background-repeat: repeat no-repeat;
  background-position: 0 bottom;
  transform-origin: center bottom;
}
.waveTop {
  background-size: 50% 100px;
}
.waveAnimation .waveTop {
  animation: move-wave 3s;
  -webkit-animation: move-wave 3s;
  -webkit-animation-delay: 1s;
  animation-delay: 1s;
}
.waveMiddle {
  background-size: 50% 120px;
}
.waveAnimation .waveMiddle {
  animation: move_wave 10s linear infinite;
}
.waveBottom {
  background-size: 50% 100px;
}
.waveAnimation .waveBottom {
  animation: move_wave 15s linear infinite;
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
        <div class="container" style="position:relative;top:2%;z-index: 13;">
          <router-view></router-view>  

        </div>
        
        <div class="waveWrapper waveAnimation" style="z-index:3">

          <div class="waveWrapperInner bgTop">
            <div class="wave waveTop" style="background-image: url('http://front-end-noobs.com/jecko/img/wave-top.png')"></div>
          </div>
          <div class="waveWrapperInner bgMiddle">
            <div class="wave waveMiddle" style="background-image: url('http://front-end-noobs.com/jecko/img/wave-mid.png')"></div>
          </div>
          <div class="waveWrapperInner bgBottom">
            <div class="wave waveBottom" style="background-image: url('http://front-end-noobs.com/jecko/img/wave-bot.png')"></div>
          </div>

        </div>
      </section>
      
    </div>
    
  </div>
  <script src="/js/app.js"></script>
</body>
</html>

