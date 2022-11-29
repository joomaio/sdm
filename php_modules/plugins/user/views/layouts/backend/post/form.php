<div class="container-fluid align-items-center row justify-content-center mx-auto p-0">
    <?php
    ?>
    <div class="card col-lg-12 " style="box-shadow: none;">
        <div class="card-body" style="box-shadow: none;">
            <?php echo $this->render('message');?>
            <form  enctype='multipart/form-data' action="<?php echo  $this->link_form  .'/'. $this->id ?>" method="POST">
                <div class="mb-3 col-lg-11 col-sm-12 mx-auto">
                    <label class="form-label fs-5 fw-bold pt-2">Name</label>
                    <?php $this->field('name'); ?>
                    <div class="mt-3">
                        <label class="col-form-label p-0 me-3 fw-bold fs-5">Content:</label>
                        <?php $this->field('content'); ?>
                    </div>
                    <div class="d-flex mt-3">
                        <label class="col-form-label p-0 me-3 fw-bold fs-5">Active:</label>
                        <?php $this->field('status'); ?>
                    </div>
                    
                <div class="mb-3">
                    
                </div>

    <div class="row align-items-center ">
        <div class="col-xl-6 col-sm-3 text-end"></div>
        <div class="col-xl-3 col-sm-8 text-start ">
            <input class="form-control rounded-0 border border-1" type="hidden" name="id" value="<?php echo  $this->id ?>">
        </div>
        <div class="col-xl-6 col-sm-6 text-end">
            <a href="<?php echo $this->link_list?>" >
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

    </form>
</div>
<?php
//  } 
?>
</div>