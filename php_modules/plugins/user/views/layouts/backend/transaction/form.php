<div class="container-fluid align-items-center row justify-content-center mx-auto py-3">
    <?php
    ?>
    <div class="card box-shadow col-lg-12 ">
        <div class="card-body">
            <?php echo $this->render('message'); ?>
            <div class=" col-lg-8 col-sm-12 mx-auto">
                <label class="form-label fs-5 fw-bold pt-2">Transaction ID:</label>
                <span><?php echo $this->data['transid']; ?></span>
            </div>
            <div class=" col-lg-8 col-sm-12 mx-auto">
                <label class="form-label fs-5 fw-bold pt-2">User ID:</label>
                <span><?php echo $this->data['userid']; ?></span>
            </div>
            <div class=" col-lg-8 col-sm-12 mx-auto">
                <label class="form-label fs-5 fw-bold pt-2">Payment Date:</label>
                <span><?php echo $this->data['created_at'] && $this->data['created_at'] != '0000-00-00 00:00:00' ? date('m/d/Y H:i:s', strtotime($this->data['created_at'])) : '00-00-0000 00:00:00' ?></span>
            </div>
            <div class=" col-lg-8 col-sm-12 mx-auto">
                <label class="form-label fs-5 fw-bold pt-2">Status:</label>
                <span><?php echo $this->data['status'] ? 'Success' : 'Fail'; ?></span>
            </div>
            <div class=" col-lg-8 col-sm-12 mx-auto">
                <label class="form-label fs-5 fw-bold pt-2">Logs:</label>
                <br>
                <span><?php echo str_replace("\n" , '<br>', $this->data['logs']); ?></span>
            </div>
            <div class="mb-3 col-lg-8 col-sm-12 mx-auto">
                <div class="row align-items-center mx-auto">
                    <div class="row align-items-center ">
                        <div class="col-xl-6 col-sm-6 text-end">
                            <a href="<?php echo $this->link_list ?>">
                                <button type="button" class="btn btn-outline-secondary">Back</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        //  } 
        ?>
    </div>