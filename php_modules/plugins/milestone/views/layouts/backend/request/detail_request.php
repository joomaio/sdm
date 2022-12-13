
<?php echo $this->render('layouts.backend.relate_note.list'); ?>
<?php echo $this->render('layouts.backend.document.form'); ?>
<?php echo $this->render('layouts.backend.task.list'); ?>
<?php echo $this->render('layouts.backend.version_latest.list'); ?>
<script>
	
	$(document).on("scroll", onScroll);
	$("#sidebar .sidebar-content").addClass('position-fixed');
	function onScroll(event){
		var scrollPos = $(document).scrollTop() +1;
		$('a.sidebar-link').each(function () {
			var currLink = $(this);
			var href = currLink.attr("href");
			var refElement = $('#' + href.split('#')[1]);
			if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() >= scrollPos) {
				$('li.sidebar-item  a.sidebar-link').removeClass("active");
				currLink.parent('li.sidebar-item').addClass("active");
			}
			else{
				currLink.parent('li.sidebar-item').removeClass("active");
			}
		});
	}
	
	$(document).ready(function() {
		$('a.sidebar-link').each(function () {
			var currLink = $(this);
			var href = currLink.attr("href");
			var refElement = $('#' + href.split('#')[1]);
			var hash = window.location.hash.substring(1);
			if (href.split('#')[1] == hash) {
				$('li.sidebar-item  a.sidebar-link').removeClass("active");
				currLink.parent('li.sidebar-item').addClass("active");
			}
			else{
				currLink.parent('li.sidebar-item').removeClass("active");
			}
		});
	});
</script>
