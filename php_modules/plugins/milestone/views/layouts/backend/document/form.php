<div class="container-fluid align-items-center row justify-content-center mx-auto pt-3 border-bottom border-3 border-dark">
    <div class="card shadow-none p-0 col-lg-12">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-7 col-6 border-end">
                    <?php echo $this->render('message'); ?>
                    <h4>Document:</h4>
                    <?php if ($this->editor) : ?>
                        <form action="<?php echo $this->link_form ?>" method="post">
                            <div class="row">
                                <div class="mb-3 col-sm-12 mx-auto">
                                    <?php $this->field('description'); ?>
                                </div>
                            </div>
                            <div class="row g-3 align-items-center m-0">
                                <?php $this->field('token'); ?>
                                <input class="form-control rounded-0 border border-1" type="hidden" name="_method" value="<?php echo $this->data && $this->data['id'] ? 'PUT' : 'POST' ?>">
                                <div class="col-xl-12 col-sm-12 text-center">
                                    <a href="<?php echo $this->link_list ?>">
                                        <button type="button" class="btn btn-outline-secondary">Cancel</button>
                                    </a>
                                    <button type="submit" class="btn btn-outline-success">Save</button>
                                </div>
                            </div>
                        </form>
                    <?php else :
                        echo ($this->data['description']);
                    ?>
                        <a href="<?php echo $this->link_form . '?editor=1' ?>" type="submit" class="btn btn-outline-success">Edit</a>
                    <?php
                    endif;
                    ?>
                </div>
                <div class="col-lg-5 col-6">
                    <h4>Discussion:</h4>
                    <ul id="list-discussion" class="list-unstyled pt-2" style="max-height: 60vh; overflow:auto;">
                        <?php foreach ($this->discussion as $item) : ?>
                        <li class="d-flex <?php echo $this->user_id == $item['user_id'] ? 'ms-5 me-2 justify-content-end' : 'me-5 ms-2 justify-content-between'; ?>  mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between p-3">
                                    <p class="fw-bold mb-0"><?php echo $this->user_id == $item['user_id'] ? 'You' : $item['user']; ?></p>
                                    <p class="ms-2 text-muted small mb-0 align-self-center"><i class="far fa-clock"></i> <?php echo $item['sent_at'] ?></p>
                                </div>
                                <div class="card-body pt-0">
                                    <p class="mb-0">
                                        <?php echo nl2br($item['message']) ?>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; ?>
                        
                    </ul>
                    <form action="<?php echo $this->link_form_comment ?>" method="post">
                        <?php $this->field('token'); ?>
                        <div class="form-outline">
                            <textarea required name="message" class="form-control" id="textAreaExample2" rows="4"></textarea>
                            <div class="form-notch">
                                <div class="form-notch-leading" style="width: 9px;"></div>
                                <div class="form-notch-middle" style="width: 60px;"></div>
                                <div class="form-notch-trailing"></div>
                            </div>
                        </div>
                        <button type="submit" class="mt-2 btn btn-info btn-rounded float-end">Comment</button>
                    </form>
                </div>
                <div class="col-12">
                    <hr class="bg-danger border-2 border-top border-danger">
                    <h4>History:</h4>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($this->history as $item) : ?>
                            <li class="list-group-item">Edited at <?php echo $item['modified_at'];?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>


        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#list-discussion").scrollTop($("#list-discussion")[0].scrollHeight);
        $("#description").attr('rows', 25);
    });
</script>