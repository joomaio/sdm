<div class="main" id="version_link">
	<main class="content p-0 ">
		<div class="container-fluid p-0">
			<div class="row justify-content-center mx-auto">
				<div class="col-12 p-0">
					<div class="card border-0 shadow-none">
						<div class="card-body">
						<h2 class="pb-4 border-bottom"><i class="fa-solid fa-code-branch pe-2"></i><?php echo $this->title_page_version ?></h2>
							<?php echo $this->render('message'); ?>
							<?php if ($this->version_latest['id']) { ?>
							<div class="row align-items-center justify-content-center pt-3">
								<div class="col-lg-8 col-12">
									<?php foreach ($this->list as $item) : ?>
										<form action="<?php echo $this->link_form . '/' . $item['id']; ?>" method="post">
											<input type="hidden" value="<?php echo $this->token ?>" name="token">
											<input type="hidden" id="method_<?php echo $item['id'] ?>" value="PUT" name="_method">
											<div class="input-group mb-3">
												<input class="form-control rounded-0 border border-1" name="log" value="<?php echo $item['log'] ?>"></input>
												<button class="btn btn-outline-secondary" type="submit">Edit</button>
												<button class="btn btn-outline-secondary button-remove" data-id-remove="<?php echo $item['id'];?>">Remove</button>
											</div>
										</form>
									<?php endforeach; ?>
									<form class="" action="<?php echo $this->link_form . '/0' ?>" method="post">
										<input type="hidden" value="<?php echo $this->token ?>" name="token">
										<input type="hidden" value="POST" name="_method">
										<div class="input-group mb-3">
											<input class="form-control rounded-0 border border-1" name="log" ></input>
											<button class="btn btn-outline-secondary" type="submit">Add</button>
										</div>
									</form>
								</div>
								<div class="col-xl-12 col-sm-12 text-center">
									<a href="<?php echo $this->link_cancel ?>">
										<button type="button" class="btn btn-outline-secondary">Cancel</button>
									</a>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>

			</div>
	</main>


</div>
</div>
<script>
    $(document).ready(function() {
        $(".button-remove").click( function(){
            var id = $(this).data('id-remove');
			$("#method_" + id).val('DELETE');
        });
    });
</script>