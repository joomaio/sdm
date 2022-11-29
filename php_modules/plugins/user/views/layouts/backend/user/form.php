<div class="container-fluid align-items-center row justify-content-center mx-auto pt-3">
    <div class="card box-shadow col-lg-12">
        <div class="card-body">
            <?php echo $this->render('message'); ?>
            <form action="<?php echo $this->link_form . '/' . $this->id ?>" method="post">
                <div class="row g-3 align-items-center">
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto pt-3">
                            <label class="form-label fw-bold">User Name:</label>
                            <?php $this->field('userid'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto">
                            <label class="form-label fw-bold">Password:</label>
                            <?php $this->field('psw'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto">
                            <label class="form-label fw-bold" for="inputEmail4">Email:</label>
                            <?php $this->field('u_email'); ?>
                        </div>
                    </div>
                    <?php
                    $s_time = $this->s_time;
                    $e_time = $this->e_time;
                    ?>
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto">
                            <label class="form-label fw-bold">User type:</label>
                            <?php $this->field('u_type'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto">
                            <label class="form-label fw-bold">Number of Teachers covered:</label>
                            <?php $this->field('t_count'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto">
                            <label class="form-label fw-bold">Grade Levels</label>
                            <?php $this->field('grade_level'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto">
                            <label class="form-label fw-bold">Subscription type</label>
                            <?php $this->field('s_type'); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto ">
                            <label class="form-label fw-bold">First Name</label>
                            <?php $this->field('u_f_name'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto">
                            <label class="form-label fw-bold">Last Name</label>
                            <?php $this->field('u_l_name'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto ">
                            <label class="form-label fw-bold">Phone Number</label>
                            <?php $this->field('phone'); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto">
                            <label class="form-label fw-bold">School Name</label>
                            <?php $this->field('school_name'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto">
                            <label class="form-label fw-bold">Address</label>
                            <?php $this->field('addr1'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto">
                            <label class="form-label fw-bold">Address 2</label>
                            <?php $this->field('addr2'); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto ">
                            <label class="form-label fw-bold">City</label>
                            <?php $this->field('city'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto">
                            <label class="form-label fw-bold">State</label>
                            <?php $this->field('state'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto">
                            <label class="form-label fw-bold">Zip/Postal code</label>
                            <?php $this->field('zip'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto ">
                            <label class="form-label fw-bold">Country</label>
                            <?php $this->field('country'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto">
                            <label class="form-label fw-bold">Time Zone</label>
                            <?php $this->field('time_zone'); ?>
                        </div>

                    </div>
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto ">
                            <label class="form-label fw-bold">Start Time</label>
                            <?php $this->field('start_time'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto">
                            <label class="form-label fw-bold">End Time</label>
                            <?php $this->field('end_time'); ?>
                        </div>
                    </div>
                    <?php $st_date = $this->st_date; ?>
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto ">
                            <label class="form-label fw-bold">Start Date</label>
                            <?php $this->field('start_date'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto">
                            <label class="form-label fw-bold">Payment Date</label>
                            <?php $this->field('payment_date'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto">
                            <label class="form-label fw-bold">Expire Date</label>
                            <?php $this->field('expire_date'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto ">
                            <label class="form-label fw-bold">Gift given by</label>
                            <?php $this->field('gift_name'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12 mx-auto">
                            <label class="form-label fw-bold">IP Login Address</label>
                            <?php $this->field('ip_login'); ?>
                        </div>
                    </div>
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