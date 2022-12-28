<nav class="navbar navbar-expand navbar-light navbar-bg" style="box-shadow: inherit;">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>
    <?php if ($this->title_page_edit) { ?>
        <div class="d-flex w-100">
            <h2 class="m-0 flex-grow-1 pe-1">
                <?php echo $this->field('title'); ?>
            </h2>
            <div class="me-2">
                <a href="<?php echo $this->link_list ?>">
                    <button type="button" class="btn btn-outline-secondary">Cancel</button>
                </a>
            </div>
            <div class="me-2">
                <button type="submit" class="btn btn-outline-success btn_save_close">Save & Close</button>
            </div>
            <div class="">
                <button type="submit" class="btn btn-outline-success btn_apply">Apply</button>
            </div>
        </div>

    <?php } else { ?>
        <h2 class="m-0 d-flex align-items-center"><?php echo $this->title_page; ?></h2>
    <?php } ?>
</nav>