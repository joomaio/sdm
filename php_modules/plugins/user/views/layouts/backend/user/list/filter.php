<form id="filter_form" class="row pe-0 pb-2" action="<?php echo $this->link_list ?>" method="POST">
    <div class="col-lg-11 col-sm-12">
        <div class="input-group input-group-navbar">
            <div class="pe-2">
                <div class="row">
                    <div class="col-auto">
                        <a href="<?php echo $this->link_form .'/0';?>" class="align-middle btn border border-1" type="button">
                            <i class="fa-solid fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="pe-2">
                <?php $this->field('status');  ?>
            </div>
            <div class="pe-2">
                <?php $this->field('sub_type');  ?>
            </div>
            <div class="pe-2">
                <?php $this->field('sort');  ?>
            </div>
            <div class="pe-2">
                <?php $this->field('search');  ?>
            </div>
            <!-- <input type="text" name="search" class="form-control rounded-0 border border-1" placeholder="Search…" aria-label="Search"> -->
            <button type='Submit' data-bs-toggle="tooltip" title="Filter" class=" align-middle btn border border-1 ms-2" type="button">
                <i class="fa-solid fa-filter"></i>
            </button>
            <button data-bs-toggle="tooltip" title="Clear Filter" id="clear_filter" class="align-middle btn border border-1 ms-2" type="button">
                <i class="fa-solid fa-filter-circle-xmark"></i>
            </button>
            <button data-bs-toggle="modal" data-bs-target="#renewSpecial" data-bs-toggle="tooltip" title="Renew or special pricing" id="" class="align-middle btn border border-1 ms-2" type="button">
                <i class="fa-solid fa-money-check-dollar fs-4"></i>
            </button>
        </div>
    </div>
    <div class="col-lg-1 col-sm-12 text-end pe-0 pb-1 ">
        <div class="d-flex justify-content-end">
            <?php $this->field('limit');  ?>
        </div>
    </div>
</form>
<form class="row pe-0 pb-2" action="<?php echo $this->url. 'payment' ?>" method="POST">
    <div class="modal fade" id="renewSpecial" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="renewSpecialLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="renewSpecialLabel"><h2>Renew or special pricing</h2></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="pb-2">
                        <label for="" class="form-label">Select User:</label>
                        <div>
                            <select class="form-select" required name="user" id="user_select" class="w-100">
                                <option value="">Select User</option>
                                <?php foreach ($this->users as $user)
                                {
                                    echo '<option value="'.$user['u_id'].'">'. $user['userid'].'</option>';
                                }?>
                            </select>
                        </div>
                        
                    </div>
                    <div class=>
                        <label for="" class="form-label">Renew or special pricing amount:</label>
                        <input name="price" type="text" id="price" required placeholder="" value="" class="form-control h-full input_common w_full_475">
                        <input name="price_special" type="hidden" required placeholder="" value="True" class="form-control h-full input_common w_full_475">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Continue</button>
                </div>
            </div>
        </div>  
    </div>
</form>

<?php echo $this->render('backend.user.list.javascript'); ?>