<div class="container-fluid align-items-center row justify-content-center mx-auto pt-3">
    <div class="card shadow-none p-0 col-lg-12">
        <div class="card-body">
            <?php echo $this->render('message'); ?>
            <form action="<?php echo $this->link_form . '/' . $this->id ?>" method="post">
                <div class="row g-3 align-items-center">
                    <?php if (!$this->note_exist) : ?>
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto pt-3">
                            <label class="form-label fw-bold">Title:</label>
                            <?php $this->field('title'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto">
                            <label class="form-label fw-bold">Note:</label>
                            <?php $this->field('description'); ?>
                        </div>
                    </div>
                    <?php else : ?>
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto">
                            <label class="form-label fw-bold">Note:</label>
                            <?php $this->field('note_id'); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="row g-3 align-items-center m-0">
                        <?php $this->field('token'); ?>
                        <input class="form-control rounded-0 border border-1" type="hidden" name="_method" value="<?php echo $this->id ? 'PUT' : 'POST' ?>">
                        <div class="col-xl-6 col-sm-6 text-end">
                            <a href="<?php echo $this->link_list ?>">
                                <button type="button" class="btn btn-outline-secondary">Cancel</button>
                            </a>
                        </div>
                        <div class="col-xl-3 col-sm-6 text-start ">
                            <button type="submit" class="btn btn-outline-success">Save</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>