<div class="main">
	<main class="content p-0">
		<div class="container-fluid p-0">
			<div class="row justify-content-center mx-auto">
				<div class="col-12 p-0">
					<div class="card" style="box-shadow: none;">
						<div class="card-body">
						<?php echo $this->render('message');?>
							<div class="row align-items-center">
								<?php echo $this->render('backend.post.list.filter');?>
							</div>
							<div class="collapse navbar-collapse pb-2" id="navbarTogglerDemo01">
								<div class="row">
									<div class="col-auto pt-2">
										<select class="px-2 rounded-0 border border-1 w-100 h-33" name="t_zone">
											<option value="">Active</option>
											<option value="">Yes</option>
											<option value="">No</option>
										</select>
									</div>
									
								</div>

							</div>
							<table id="datatables-buttons" class="table table-striped border-top border-1" style="width:100%">
								<thead>
									<tr>
										<th style="width: 40px;">#</th>
										<th>Name</th>
										<th>Active</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php while($this->list->hasRow()) $this->render('backend.post.list.row'); ?> 
								</tbody>
							</table>
							<div class="row g-3 align-items-center">
								<?php echo $this->render('pagination'); ?>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</main>


</div>
</div>



</body>

</html>