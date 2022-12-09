<div class="main">
    <main class="content p-0">
        <div class="container-fluid align-items-center row justify-content-center mx-auto p-0">
            <?php
            ?>
            <div class="card shadow-none col-lg-12">
                <div class="card-body">
                    <?php echo $this->render('message'); ?>
                    <form enctype='multipart/form-data' action="<?php echo  $this->link_form ?>" method="POST">
                        <?php foreach ($this->legends as $legend) {
                            foreach($legend['fields'] as $value)
                            {?>
                                <div class="mb-3 col-lg-12 col-sm-12 mx-auto label-bold">
                                    <?php $this->field($value); ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <div class="row align-items-center ">
                            <div class="col-xl-12 col-sm-12 text-center ">
                                <button type="submit" class="btn btn-outline-success">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php
            //  } 
            ?>
        </div>
    </main>
</div>