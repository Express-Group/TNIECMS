<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 footer1">
  <!--<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="news"> <a href="javascript:void(0)" class="scrollToTop"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
      <h3 class="foot_head">NEWS LETTER</h3>
      <div class="newsbox">
        <form class="navbar-form news_form" id="newsletter_form" name="newsletter_form" role="search" action="<?php echo base_url(); ?>user/common_widget/subscribe_newsletter">
          <div class="input-group">
            <input type="text" class="form-control ntb"  placeholder="Enter email for newsletter" name="email_newsletter" id="email-newsletter">
            <div class="input-group-btn">
              <button class="btn btn-default btn-back" id="submit_newsletter" type="button"><i class="fa fa-chevron-right"></i></button>
            </div>
          </div>
        </form>
        <span id="news_error_throw"></span> </div>
    </div>
  </div>-->
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?php 
$view_mode              = $content['mode'];
$social_urls            = $this->widget_model->select_setting($view_mode); 
$widget_bg_color 		= $content['widget_bg_color'];
$widget_custom_title 	= $content['widget_title'];
$widget_instance_id 	= $content['widget_values']['data-widgetinstanceid'];
$main_sction_id 		= "";
$page_type 				= 'section';
// widget config block ends
?>
    <div class="follow">
      <h3 class="foot_head">FOLLOW US</h3>
      <div class="footer_social"> <a class="fb" href="<?php echo $social_urls['facebook_url'];?>"><i class="fa fa-facebook"></i></a> <a class="google" href="<?php echo $social_urls['google_plus_url'];?>"><i class="fa fa-google-plus"></i></a> <a class="twit" href="<?php echo $social_urls['twitter_url'];?>"><i class="fa fa-twitter"></i></a> <a href="http://www.pinterest.com/newindianexpres" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a> <a href="https://instagram.com/newindianexpress/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a> <a class="rss" href="<?php echo $social_urls['rss_url'];?>"><i class="fa fa-rss"></i></a> </div>
    </div>
  </div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 footer2bac">
  <div class="footer2">
    <p>Copyrights New Indian Express. 2016</p>
    
    <p> <a class="AllTopic" href="http://www.dinamani.com">Dinamani | </a> <a class="AllTopic" href="http://www.kannadaprabha.com">Kannada Prabha | </a> <a class="AllTopic" href="http://www.sakhi.in">Sakhi  | </a> <a class="AllTopic" href="http://www.cinemaexpress.com">Cinema Express  | </a> <a class="AllTopic" href="http://www.malayalamvaarika.com">Malayalam Vaarika </a>  </p>
	<p> <a class="AllTopic" href="<?php echo base_url()."contact-us"; ?>"><?php echo "Contact Us"; ?> | </a> <a class="AllTopic" href="<?php echo base_url()."about-us"; ?>"><?php echo "About Us"; ?> | </a> <a class="AllTopic" href="<?php echo base_url()."privacy-policy"; ?>"><?php echo "Privacy Policy"; ?> | </a> <a class="AllTopic" href="<?php echo base_url()."topic"; ?>"><?php echo "Search"; ?> | </a> <a class="AllTopic" href="<?php echo base_url()."terms-of-use"; ?>"><?php echo "Terms of Use"; ?> | </a> <a class="AllTopic" href="<?php echo base_url()."advertise-with-us"; ?>"><?php echo "Advertise With Us"; ?> </a></p>
	<p> <a class="AllTopic" href="<?php echo base_url(); ?>"><?php echo "Home"; ?> | </a> <a class="AllTopic" href="<?php echo base_url()."nation"; ?>"><?php echo "Nation"; ?> | </a> <a class="AllTopic" href="<?php echo base_url()."world"; ?>"><?php echo "World"; ?> | </a> <a class="AllTopic" href="<?php echo base_url()."cities"; ?>"><?php echo "Cities"; ?> | </a> <a class="AllTopic" href="<?php echo base_url()."business"; ?>"><?php echo "Business"; ?> | </a> <a class="AllTopic" href="<?php echo base_url()."opinions/columns"; ?>"><?php echo "Columns"; ?> | </a> <a class="AllTopic" href="<?php echo base_url()."entertainment"; ?>"><?php echo "Entertainment"; ?> | </a> <a class="AllTopic" href="<?php echo base_url()."sport"; ?>"><?php echo "Sport"; ?> | </a> <a class="AllTopic" href="<?php echo base_url()."magazine"; ?>"><?php echo "Magazine"; ?> | </a> <a class="AllTopic" href="<?php echo base_url()."thesundaystandard"; ?>"><?php echo "The Sunday Standard"; ?>  </a></p>
  </div>
</div>
<script>
var $ = $.noConflict();
$(document).ready(function( $ ){
    scrollToTop.init( );
});
var scrollToTop =
{
    init: function(  ){
        //Check to see if the window is top if not then display button
        $(window).scroll(function(){
            if ($(this).scrollTop() > 100) {
                $('.scrollToTop').fadeIn();
            } else {
                $('.scrollToTop').fadeOut();
            }
        });
        // Click event to scroll to top
        $('.scrollToTop').click(function(){
            $('html, body').animate({scrollTop : 0},800);
            return false;
        });
    }
};
</script>