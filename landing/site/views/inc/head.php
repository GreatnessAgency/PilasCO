<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="ie6 ielt8"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="ie7 ielt8"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="ie8"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<title><?php echo $title;?></title>
<!-- meta tags -->
<meta name="keywords" content="<?php echo $keywords;?>" />
<meta name="description" content="<?php echo $description;?>" />
<!-- css styles and fonts -->
<link rel="stylesheet" type="text/css" href="<?php echo $template;?>css/style.css" >
<!-- javascript -->
<script type="text/javascript" src="<?php echo $template;?>js/modernizr.js"></script>  
<script type="text/javascript" src="https://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-7526679-39']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<?php if(isset($alert)){?>
<script type="text/javascript">
$(function(){
	alert('<?php echo $alert;?>');
});
</script>
<?php }?>
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 995568818;
var google_conversion_label = "xqUnCP6fmQQQstnc2gM";
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/995568818/?value=0&amp;label=xqUnCP6fmQQQstnc2gM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>