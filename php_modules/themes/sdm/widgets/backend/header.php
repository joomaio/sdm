<nav class="navbar navbar-expand navbar-light navbar-bg" style="box-shadow: inherit;">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>
    <?php if ($this->title_page_edit) { ?>
        <h2 class="m-0 w-100">
            <?php echo $this->field('title'); ?>
        </h2>
    <?php } else { ?>
        <h2 class="m-0 d-flex align-items-center"><?php echo $this->title_page; ?></h2>
    <?php } ?>
</nav>