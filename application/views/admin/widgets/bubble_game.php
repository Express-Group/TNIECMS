<style>
#wrapper{
	margin: 0 auto;
	text-align: center;
	margin-top: 4%;
	position:relative;
}
#wrapper h1{
    color: #fff; 
}
#wrapper #timer_div{
	color: #fff;
    font-size: 11px;
    margin-bottom: 30px;
    position: absolute;
    top: 6px;
    left: 6px;
    z-index: 99;
	text-transform: uppercase;
}
#wrapper #score{
	color: #fff;
    font-size: 11px;
    margin-bottom: 10px;
    position: absolute;
    top: 6px;
    right: 6px;
    z-index: 99;
    text-transform: uppercase;
}
#wrapper #container{
	background: url(https://static3.scirra.net/images/newstore/products/4113/FB%20720x320.PNG);
	font-family: calibri, serif;
	color: #d9d9d9;
	display: block;
	height: 350px;
	width: 100%;
	margin: 0 auto;
	border: 1px solid #000;
	z-index: 1;
	overflow: hidden;
	position: relative;
	background-size: cover;
	background-repeat: no-repeat; 
}
#wrapper #container #create{
	border: none;
	display: inline-block;
	cursor: pointer;
	color: #ffffff;
	margin-top: 42%;
	text-decoration: none;
	background: transparent;
	outline:none;
}
#wrapper #container .audio-controls{
	position: absolute;
	bottom: 6px;
	right: 1%;
	cursor: pointer;
	width: 22px;
}
#wrapper .bubble{
	width: 40px;
	height: 40px;
	border-radius: 50%;
	background: transparent;
	box-shadow: inset 0 0 15px 1px white;
	cursor: pointer;
	position: absolute;
	bottom: -60px;
	left: 300px;
	z-index: -2;
	-webkit-box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(255, 255, 255, 1);
	-moz-box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(255, 255, 255, 1);
	box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(255, 255, 255, 1);
}
#wrapper .bubble:after{
	content: "";
	position: absolute;
	top: 10px;
	left: 10px;
	width: 10px;
	height: 10px;
	background: #ffffff57;
	opacity: 1;
	border-radius: 50%; 
}
#wrapper .bubble:hover{
	animation: shake 0.2s linear; 
}
#wrapper #container #create img{
	width: 65px;
}
.bubble-login{
	height: 208px;
    position: absolute;
    width: 285px;
    left: 6px;
    top: 19%;
    background: url(<?php echo image_url ?>images/bubblegame/login.png);
    z-index: 999;
    background-size: contain;
}
.bubble-login .screen{
	width: 87%;
    margin-top: 7px;
}
.bubble-login .screen-1{
	position: absolute;
    width: 73%;
    left: 10%;
    top: -24%;
}
.close-1{
	position: absolute;
    right: 3%;
    top: -6%;
    width: 33px;
	cursor:pointer;
}
.bubble-login .name{
	position: absolute;
    top: 21%;
    width: 68%;
    left: 15%;

}
.bubble-login .phone{
	position: absolute;
    top: 43%;
    width: 68%;
    left: 15%;
}
.login-ok{
	position: absolute;
    left: 34%;
    width: 36px;
    bottom: 20%;
	cursor:pointer;
}
.login-close{
	position: absolute;
    left: 50%;
    width: 36px;
    bottom: 20%;
	cursor:pointer;
}
.win-screen{
	position: absolute;
    width: 75%;
    height: 298px;
    background: url(<?php echo image_url ?>images/bubblegame/win.png);
    z-index: 9;
    background-size: contain;
    left: 13%;
    top: 11%;
}
.win-inner{
	width: 80%;
    position: absolute;
    left: 8%;
    top: 6%;
}
.win-text{
	position: absolute;
    left: 5%;
    width: 82%;
    top: -7%;
}
.win-star{
	position: absolute;
    left: 21%;
    width: 49%;
    top: 14%;
}

.win-text-1 , .win-text-3{
	position: absolute;
    margin: 0;
    top: 38%;
    left: 25%;
    color: green;
    text-transform: uppercase;
    font-family: 'Oswald', sans-serif;
    font-weight: bold;
}
.win-text-2{
	position: absolute;
    margin: 0;
    top: 45%;
    left: 36%;
    color: #ff3d00;
    text-transform: uppercase;
    font-weight: bold;
    font-size: 37px;
}
.win-text-3{
	top: 60%;
    left: 35%;
}
.win-restart ,.win-close{
	position: absolute;
    left: 25%;
    width: 40px;
    bottom: 10%;
}
.win-close{
	left: 47%;
}

.pop1{-webkit-box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(79, 237, 167, 0.92) !important;	-moz-box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(79, 237, 167, 0.92) !important;box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(79, 237, 167, 0.92) !important;}

.pop2{-webkit-box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(255, 188, 26, 0.83) !important;	-moz-box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(255, 188, 26, 0.83) !important;box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(255, 188, 26, 0.83) !important;}

.pop3{-webkit-box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(49, 204, 223, 0.85) !important;	-moz-box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(49, 204, 223, 0.85) !important;box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(49, 204, 223, 0.85) !important;}

.pop4{-webkit-box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(252, 136, 30, 0.86) !important;	-moz-box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(252, 136, 30, 0.86) !important;box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(252, 136, 30, 0.86) !important;}

.pop5{-webkit-box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(255, 78, 141, 0.87) !important;	-moz-box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(255, 78, 141, 0.87) !important;box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(255, 78, 141, 0.87) !important;}

.pop6{-webkit-box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(194, 233, 83, 0.94) !important;	-moz-box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(194, 233, 83, 0.94) !important;box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(194, 233, 83, 0.94) !important;}

.pop7{-webkit-box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(58, 155, 229, 0.94) !important;	-moz-box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(58, 155, 229, 0.94) !important;box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(58, 155, 229, 0.94) !important;}

.pop8{-webkit-box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(60, 235, 52, 0.94) !important;	-moz-box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(60, 235, 52, 0.94) !important;box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(60, 235, 52, 0.94) !important;}

.pop9{-webkit-box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(200, 229, 58, 0.94) !important;	-moz-box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(200, 229, 58, 0.94) !important;box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgba(200, 229, 58, 0.94) !important;}

.pop10{-webkit-box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgb(255, 133, 133) !important;	-moz-box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgb(255, 133, 133) !important;box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2), inset 0px 10px 30px 5px rgb(255, 133, 133) !important;}

@keyframes shake{
	from{
		transform: scale(1, 1); 
	}
	33%{
		transform: scale(1, 1.2); 
	}
	66%{
		transform: scale(1.2, 1); 
	}
	to{
		transform: scale(1, 1); 
	} 
}
@keyframes pop{
	from {
		opacity: 1;
		transform: translateZ(0) scale(1, 1);
	}
	to{
		opacity: 0;
		transform: translateZ(0) scale(1.75, 1.75);
	} 
}
</style>

<div id="wrapper">
	<div id="score"></div> 
	<div id="timer_div">Time : 40 sec</div>
	<div class="bubble-login" style="display:none;">
		<img class="screen" src="<?php echo image_url ?>images/bubblegame/login-inner.png">
		<img class="screen-1" src="<?php echo image_url ?>images/bubblegame/login-banner.png">
		<img class="close-1" src="<?php echo image_url ?>images/bubblegame/close.png">
		<input type="text" class="form-control name" placeholder="Name">
		<input type="text" class="form-control phone" placeholder="Phone Number">
		<img class="login-ok" src="<?php echo image_url ?>images/bubblegame/login-ok.png">
		<img class="login-close" src="<?php echo image_url ?>images/bubblegame/login-close.png">
	</div>
	<div class="win-screen" style="display:none;">
		<img class="win-inner" src="<?php echo image_url ?>images/bubblegame/win-inner.png">
		<img class="win-text" src="<?php echo image_url ?>images/bubblegame/win-text.png">
		<img class="win-star" src="<?php echo image_url ?>images/bubblegame/star.png">
		<h5 class="win-text-1">You have poped</h5>
		<h3 class="win-text-2">0</h3>
		<h5 class="win-text-3">Bubbles</h5>
		<img class="win-restart" src="<?php echo image_url ?>images/bubblegame/restart.png">
		<img class="win-close" src="<?php echo image_url ?>images/bubblegame/login-close.png">
	</div>
	<div id="container">
		<button id="create"><img src="<?php echo image_url ?>images/bubblegame/play.png"></button>
		<img class="audio-controls sound" src="<?php echo image_url ?>images/bubblegame/sound.png">
		<img style="display:none;" class="audio-controls mute" src="<?php echo image_url ?>images/bubblegame/mute.png">
	</div>
</div>
<div id="sounds" style="display:none;">
	<audio id="s-pop" controls><source src="<?php echo image_url ?>images/bubblegame/sounds/pop.mp3" type="audio/mpeg"></audio>
	<audio id="s-background" controls autoplay loop><source src="<?php echo image_url ?>images/bubblegame/sounds/background.wav" type="audio/wav"></audio>
</div>
<script>
 var colors = ['pop1' , 'pop2' , 'pop3' ,'pop4' , 'pop5' , 'pop6' , 'pop7' , 'pop8' ,'pop9' ,'pop10'];
var Game = function(options) {
  this.bubbles = options.bubbles;
  this.bubblesArr = [];
  this.score = 0;
  this.duration = options.duration;
  this.finish = function() {
    $('#create').html('Play again?');
    $('#create').show();
  };
  this.start = function() {
    
    setTimeout(function() {
      $('#create').html('Play again?');
		$('#create').show();
    }, this.duration);
    
    for (i = 0; i < this.bubbles; i++) {
      // Wait random amount of time between creating bubbles
      setTimeout(function() {
        var newBubble = new Bubble();
        newBubble.blow();
      }, Math.floor(Math.random() * this.duration - 10000) + 0);
    };
    //Set countdown timer from 16 seconds 
    var seconds_left = this.duration / 1000;
    var interval = setInterval(function() {
      $('#timer_div').html('Time : '+ --seconds_left+' sec');

      if (seconds_left <= 0) {
        $('#timer_div').html("GAME OVER");
		$('.bubble').hide();
		$('.win-screen').find('h3').html(game.score);
		$('.win-screen').show('fast');
        clearInterval(interval);
      }
    }, 1000);
  };

  
  
};

//click to start the game and create new bubbles
$('#create').click(function() {
 // game.start();
  $('#create').hide();
  $('.bubble-login').show('fast');
});
$('.close-1,.login-close').on('click' , function(){
	$('#create').show('fast');
	$('.bubble-login').hide('fast');
	$('.name').val('');
	$('.phone').val('');
});
$('.login-ok').on('click' , function(e){
	var n,p;
	n=$('.name').val();
	p=$('.phone').val();
	if(n.trim()!='' && p.trim()!=''){
		$('.bubble-login').hide('fast');
		game.start();
	}else{
		alert('Enter valid details');
	}
});

// Defines what a bubble is
function Bubble(left, top) {
  this.id = game.bubblesArr.length;

  //Animate this bubble
  this.animate = function() {
    $("#bubble-" + this.id).animate({
      top: -90,
    }, Math.floor(Math.random() * 39000) + 1000)
  }

  this.blow = function() {

    // This function is going to add the bubble to the page
	var color = colors[Math.floor(Math.random()* colors.length)];
    $('#container').append('<div class="bubble '+color+'" id="bubble-' + this.id + '"></div>');
    
    game.bubblesArr.push(this);

    $('#bubble-' + this.id).click(function() {
      var num = this.id.replace('bubble-', '');
	  console.log(num);
      game.bubblesArr[num].pop();
    });

    // Randomise the size and position
    var pageWidth = $(document).width();
    $('#bubble-' + this.id).css("left", Math.floor(Math.random() * pageWidth / 100 * 15) + 18);
    var size = Math.floor(Math.random() * 30) + 20 + "px";
    $('#bubble-' + this.id).css("width", size);
    $('#bubble-' + this.id).css("height", size);

    this.animate();

  }

  this.pop = function() {
	  console.log(this.id);
   // $('#bubble-' + this.id).css('animation' , 'pop 0.08s cubic-bezier(0.16, 0.87, 0.48, 0.99) forwards');
	
	$('#bubble-' + this.id).css('animation' , 'pop 0.08s cubic-bezier(0.16, 0.87, 0.48, 0.99) forwards').promise().done(function(){
		$('#bubble-' + this.id).hide();
	});
	document.getElementById("s-pop").play();
	//$('#bubble-' + this.id).hide();
    game.score++;
    $('#score').html('Score : ' + game.score);
  }

}



var game = new Game({
  bubbles: 60,
  duration: 40000
});
$('.sound').on('click' , function(e){
	$(this).hide();$('.mute').show();
	document.getElementById("s-background").pause();
});
$('.mute').on('click' , function(e){
	$(this).hide();$('.sound').show();
	document.getElementById("s-background").play();
});
</script>