$(function(){
    

    
$("body").on("mouseover", "video", function(){
  this.play();
  $('video').attr('loop','true');
  
});
$("body").on("mouseout", "video", function(){
	 this.pause();
  $('video').removeAttr('loop');
});
});