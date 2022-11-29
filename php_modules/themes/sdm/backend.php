<?php defined('APP_PATH') or die('');
$this->theme->prepareAssets([
  'bootstrap-css',
]);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <META name="verify-v1" content="MjjEVcfc+4AlZMy4hC0hMAsi0HJQF9dcydjLOP0QLvM=" />
  <title>Administrator Facts 4 Me</title>
  <meta name="description" content="<?php echo  $abstract?>">
  <meta name="abstract" content="<?php echo  $abstract?>">
  <meta name="keywords" content="Facts 4 Me, Facts for Me, Factsforme">
  <meta name="format-detection" content="telephone=no">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="imagetoolbar" content="no">
  <meta http-equiv="reply-to" content="joe@borschedigital.com">
  <meta http-equiv="Content-Language" content="en-us">
  <?php $this->theme->add($this->url. '/assets/css/app.css', '', 'styles'); ?>
  <?php $this->theme->add($this->url. '/assets/css/select2.min.css', '', 'select2'); ?>
  <?php $this->theme->add($this->url. '/assets/font/fontawesome/css/fontawesome.min.css', '', 'font'); ?>
  <?php $this->theme->add($this->url. '/assets/js/jquery-3.6.0.min.js', '', 'jquery', 'top'); ?>
  <?php $this->theme->add($this->url. '/assets/js/app.js', '', 'js'); ?>

  <?php $this->theme->echo('css', $this->url) ?>
  <?php $this->theme->echo('topJs', $this->url) ?>
  <?php $this->theme->echo('inlineCss', $this->url) ?>
  
</head>

<body  data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
  <div class="wrapper">
    <?php echo $this->render('widgets.backend.sidebar'); ?>
    <div class="main">
      <?php echo $this->render('widgets.backend.header'); ?>

      <main class="content p-0">
        <?php echo $this->theme->getBody(); ?>
      </main>

    </div>
  </div>
  <?php $this->theme->echo('js', $this->url) ?>
  <?php $this->theme->echo('inlineJs', $this->url) ?>
</body>

</html>