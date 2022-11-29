<?php defined( 'APP_PATH' ) or die('');

$this->theme->prepareAssets([
    // 'jquery',
    // 'bootstrap-css',
]);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
<head>
    <?php  echo $this->render('widgets.head'); ?>
    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-24373914-1']);
        _gaq.push(['_trackPageview']);

        (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
    </script>
    <?php $this->theme->echo('css', $this->url) ?> 
    <?php $this->theme->echo('topJs', $this->url) ?>
    <?php $this->theme->echo('inlineCss', $this->url) ?>
</head>
<body bgcolor="<?php echo $this->bg_color ? $this->bg_color : '#F7F7C6'; ?>" text="#000000" link="#CC0000" vlink="#CC0000" alink="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" 
onLoad="MM_preloadImages('media/images/facts_button_visitor_f3.jpg','media/images/facts_button_visitor_f2.jpg','media/images/facts_button_visitor_f4.jpg','media/images/facts_button_login_f3.jpg',
'media/images/facts_button_login_f2.jpg','media/images/facts_button_login_f4.jpg')">
    <?php echo $this->theme->getBody(); ?>
    <?php $this->theme->echo('js', $this->url) ?> 
    <?php $this->theme->echo('inlineJs', $this->url) ?>
</body>
</html>
