class Songs{

	

	constructor(data)
	{
		this.timer=0;
		this.src=data['src'];
		//console.log(data);
		this.sound = new Howl({
  				src: ['./'+data['src']],
  				autoplay: false,
  					loop: true,
  					volume: 0.5,
  					onload: function () {
             		this.timer=this.timerCount();
				}.bind(this)
		});
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
		var minutes = this.round( time_in_seconds / 60);
		var seconds = this.round(time_in_seconds - minutes * 60);	
		time=minutes.toString()+":"+seconds.toString();
		if(seconds.toString().length==1)
			time+='0';

		//console.log(time);

		return time;
	}
	duration()
	{
		return this.timer;
	}
	


	round(value, precision) {
    var multiplier = Math.pow(10, precision || 0);
    return Math.floor(value * multiplier) / multiplier;
	}

	stop()
	{
		this.sound.stop();
	}
}
export default Songs;