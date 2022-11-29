<div class="container-fluid align-items-center row justify-content-center mx-auto py-3">
    <?php
    ?>
    <div class="card box-shadow col-lg-12 ">
        <div class="card-body">
            <?php echo $this->render('message'); ?>
            <form enctype='multipart/form-data' action="<?php echo  $this->link_form ?>" method="POST">
                <?php foreach($this->fileds as $key => $value) { 
                    if ($key != 'token') {?>
                <div class="mb-3 col-lg-12 col-sm-12 mx-auto">
                    <?php if ($value['label']) { ?>
                    <label class="form-label fs-5 fw-bold pt-2"><?php echo $value['label'];?></label>
                    <?php }?>

                    <?php $this->field($key); ?>
                </div>
                <?php }}?>

                <div class="row align-items-center ">
                    <div class="col-xl-12 col-sm-12 text-center ">
                        <button type="submit" class="btn btn-outline-success">Save</button>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-xl-6 col-sm-4 text-end"></div>
                    <div class="col-xl-3 col-sm-8 text-start ">
                        <?php $this->field('token'); ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    //  } 
    ?>
</div>