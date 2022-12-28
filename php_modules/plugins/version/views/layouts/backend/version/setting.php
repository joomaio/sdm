<?php echo $this->render('notification'); ?>
<div class="container-fluid align-items-center row justify-content-center mx-auto ">
    <form enctype='multipart/form-data' action="<?php echo  $this->link_form ?>" method="POST">
        <div class="d-flex mt-2 justify-content-center mb-3">
            <div class="d-flex align-items-center">
                <strong class="me-2">Level: </strong> <?php echo $this->field('version_level'); ?>
            </div>
            <div class="d-flex align-items-center ms-3">
                <strong class="me-2">Level Deep: </strong> <?php echo $this->field('version_level_deep'); ?>
            </div>
        </div>
        <div class="d-flex g-3 flex-row align-items-end m-0 justify-content-center">
            <?php $this->field('token'); ?>
            <input class="form-control rounded-0 border border-1" type="hidden" name="_method" value="<?php echo $this->id ? 'PUT' : 'POST' ?>">
            <div class="me-2">
                <a href="<?php echo $this->link_list ?>">
                    <button type="button" class="btn btn-outline-secondary">Cancel</button>
                </a>
            </div>
            <div class="">
                <button type="submit" class="btn btn-outline-success">Apply</button>
            </div>
        </div>
    </form>
    <?php
    //  } 
    ?>
</div>