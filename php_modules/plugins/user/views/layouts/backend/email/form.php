<div class="container-fluid align-items-center row justify-content-center mx-auto py-3">
    <?php
    ?>
    <div class="card box-shadow col-lg-12 ">
        <div class="card-body">
            <?php echo $this->render('message'); ?>
            <form enctype='multipart/form-data' action="<?php echo  $this->link_form  . '/' . $this->id ?>" method="POST">
                <div class="mb-3 col-lg-8 col-sm-12 mx-auto">
                    <label class="form-label fs-5 fw-bold pt-2">Name</label>
                    <?php $this->field('e_name'); ?>
                </div>
                <div class="mb-3 col-lg-8 col-sm-12 mx-auto">
                    <label class="form-label fs-5 fw-bold pt-2">Short code:</label>
                    <div class="row">
                    <?php foreach ($this->short_code as $key => $value) { ?>
                            <div class="col-6">
                                <span class="list-group-item"><?php echo "<b>" . $key ."</b> : ". $value?></span>
                            </div>
                    <?php } ?>
                    </div>
                </div>
                <div class="mb-3 col-lg-8 col-sm-12 mx-auto">
                    <label class="form-label fs-5 fw-bold pt-2">Email Subject:</label>
                    <?php $this->field('e_sub'); ?>
                </div>
                <div class="mb-3 col-lg-8 col-sm-12 mx-auto">
                    <label class="form-label fs-5 fw-bold pt-2">Email Content:</label>
                    <?php $this->field('e_tmp'); ?>
                </div>
                <div class="mb-3 col-lg-8 col-sm-12 mx-auto">
                    <div class="row align-items-center mx-auto">
                        <div class="row align-items-center ">
                            <div class="col-xl-6 col-sm-6 text-end">
                                <a href="<?php echo $this->link_list ?>">
                                    <button type="button" class="btn btn-outline-secondary">Cancel</button>
                                </a>
                            </div>
                            <div class="col-xl-3 col-sm-6 text-start ">
                                <button type="submit" class="btn btn-outline-success">Save</button>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-xl-6 col-sm-4 text-end"></div>
                            <div class="col-xl-3 col-sm-8 text-start ">
                                <?php $this->field('token'); ?>
                                <input class="form-control rounded-0 border border-1" type="hidden" name="_method" value="<?php echo $this->id ? 'PUT' : 'POST' ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?php
        //  } 
        ?>
    </div>