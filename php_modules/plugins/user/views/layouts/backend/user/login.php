<main class="d-flex w-100 h-100 pt-5">
    <div class="container d-flex flex-column">
        <div class="row vh-100">
            <div class="col-sm-10 col-lg-4 mx-auto d-table h-100">
                <div class="d-table-cell">
                    <div class="card rounder-0">
                        <div class="card-body">
                            <div class="m-sm-3">
                                <form action="<?php echo $this->link_login;?>" method="POST">
                                    <div class="text-center mt-4">
                                        <h1 class="h2">Login</h1>
                                        <p class="lead">
                                            Sign in to your account to continue
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-center mb-2">
                                        <hr width="75% ">
                                    </div>
                                    <?php echo $this->render('message'); ?>
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">User Name</label>
                                        <input class="form-control form-control-lg" required type="text" name="username" placeholder="User Name">
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Password</label>
                                        <input class="form-control form-control-lg" required type="password" name="password" placeholder="Password">
                                    </div>
                                    <div class="mb-3 text-center">
                                        <input type="submit" value="Sign in" class="btn btn-lg btn-primary form-control form-control-lg border-0">
                                        <a href="<?php echo $this->url;?>" class="mt-2 btn btn-lg btn-success w-100 border-0">Visit frontend</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>