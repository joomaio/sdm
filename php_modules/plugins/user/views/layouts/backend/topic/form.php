<div class="container-fluid align-items-center row justify-content-center mx-auto py-3">
    <?php
    ?>
    <div class="card box-shadow col-lg-12 ">
        <div class="card-body">
            <?php echo $this->render('message');?>
            <form  enctype='multipart/form-data' action="<?php echo  $this->link_form  .'/'. $this->id ?>" method="POST">
                <div class="mb-3 col-lg-4 col-sm-12 mx-auto">
                    <label class="form-label fs-5 fw-bold pt-2">Name</label>
                    <?php $this->field('topic_name'); ?>
                    <div class="d-flex mt-3">
                        <label class="col-form-label p-0 me-3 fw-bold fs-5">Active:</label>
                        <?php $this->field('topic_active'); ?>
                    </div>
                    
                <div class="row align-items-center mx-auto">
                    <div class="col-12 m-0 text-left mx-auto">
                        
                    </div> <br>
                <div class="mb-3">
                    <?php
                    //  if ($topic_hdr_img != "None")
                    if ((isset($this->data['image']) && $this->data['image'])) { 
                    ?>
                        <div class="d-flex justify-content-center">
                            <img class="img-fluid" id="topic_hdr_imgs" src="<?php echo  $this->data['image'] ?>" alt="<?php echo  $data['topic_name'] ?>" border="1">
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 text-start mx-auto">
                                <label class="col-form-label fw-bold">Replace this picture</label> <br>
                                <input  type="file" name="topic_hdr_img" id="topic_hdr_img" class="form-control">
                            </div>
                        </div>
                    <?php
                    } else { 
                    ?>
                    <div class="row g-3 align-items-center">
                        <div class="mb-3 col-lg-12 col-sm-12 mx-auto">
                            <div class="fw-bold fs-5 text-center pt-3">No header picture</div>
                            <label class="form-label w-100 fw-bold text-start fs-5">Load header picture:</label>
                            <div class="mb-3">
                                <input  type="file" name="topic_hdr_img" id="topic_hdr_img" class="form-control">
                            </div>
                        </div>
                    </div>
                    <?php
                    } 
                    ?>
                </div>

    <div class="row align-items-center ">
        <div class="col-xl-6 col-sm-3 text-end"></div>
        <div class="col-xl-3 col-sm-8 text-start ">
            <input class="form-control rounded-0 border border-1" type="hidden" name="topic_id" value="<?php echo  $this->topic_id ?>">
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