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
  background-image: url('https://cdn.mos.cms.futurecdn.net/EJbwCgvYQXna5ZQy6tqVsQ-650-80.jpg');

}
</style>
    

          
    </head>
    <body>

      <div id="root">
        @include('header')
        <div class="container box" style="max-height: 1000px;overflow-y: scroll;background: white;border: 5px inline red">
        <section class="section">
          <div class="container">
            <router-view></router-view>    
          </div>
        </section>
    </div>
        
      </div>
     <script src="/js/app.js"></script>
    </body>
</html>
