class Songs{

	

	constructor(data)
	{
		this.timer=0;
		this.is_playing=true;
		this.repeatOne=false;

		this.src=data['src'];
		//console.log(data);
		this.sound = new Howl({
  				src: ['./'+data['src']],
  				autoplay: false,
  					loop: true,
  					volume: data['volume'],
  					onload: function () {
             		this.timer=this.timerCount();
             		//alert(this.timer);
				}.bind(this),
				onplay: function (){
					//alert("playing");
					//this.playing();
					//this.is_playing=true;
					//alert(this.is_playing);
				},
				onend: function (){
					//alert("hiii");
					//this.sound.pause();
				}
		});
	}
	playing(){
		alert("thii");
		this.is_playing=true;
	}
	play()
	{
		this.sound.play();
	}
	
	pause()
	{
		this.sound.pause();
	}
	timerCount()
	{

		var time=0;
		var time_in_seconds=this.sound.duration();
		time=this.formatTime(time_in_seconds);
		//console.log(time);

		return [time,time_in_seconds.toString()];
	}
	formatTime(secs) {
    var minutes = Math.floor(secs / 60) || 0;
    var seconds =this.round( (secs - minutes * 60)) || 0;

    return minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
  	}
	duration()
	{
		return this.sound.duration().toString();
	}


	volume(value){
		this.sound.volume(value);
	}

	seeks()
	{
		return this.sound.seek();
	}
	


	round(value, precision) {
    var multiplier = Math.pow(10, precision || 0);
    return Math.floor(value * multiplier) / multiplier;
	}

	stop()
	{
		this.sound.stop();
	}

	seek(sec)
	{
		this.sound.seek(sec);
	}
}
export default Songs;