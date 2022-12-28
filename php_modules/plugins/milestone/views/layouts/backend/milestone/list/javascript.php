<form class="hidden" method="POST" id="form_delete">
    <input type="hidden" value="<?php echo $this->token ?>" name="token">
    <input type="hidden" value="DELETE" name="_method">
</form>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    document.getElementById('clear_filter').onclick = function() {
        document.getElementById("search").value = "";
        document.getElementById("sort").value = "title asc";
        document.getElementById("status").value = "";
        document.getElementById('filter_form').submit();
    };
    $(document).ready(function() {
        $('.toast').toast('show');
        $("#select_all").click( function(){
            $('.checkbox-item').prop('checked', this.checked);
        });
        $(".button_delete_item").click(function() {
            var id = $(this).data('id');
            var result = confirm("You are going to delete 1 record(s). Are you sure ?");
            if (result) {
                $('#form_delete').attr('action', '<?php echo $this->link_form;?>/' + id);
                $('#form_delete').submit();
            }
            else
            {
                return false;
            }
        });
        $('#delete_selected').click(function(){
            var count = 0;
            $('input[name="ids[]"]:checked').each(function() {
                count++;
            });
            if (!count)
            {
                alert('Please select the record before deleting!')
                return false;
            }
            var result = confirm("You are going to delete " + count + " record(s). Are you sure ?");
            if (result) {
                $('#formList').submit();
            }
            else
            {
                return false;
            }
        });
        $('#limit').on("change", function (e) {
            $('#filter_form').submit()
        });
        $(".show_data").click(function() {
            var id = $(this).data('id');
            var title = $(this).data('title');
            var status = $(this).data('status');
            var start_date = $(this).data('start_date');
            var end_date = $(this).data('end_date');
            var description = $(this).data('description');

            $('#title').val(title);
            $('input[name=status][value='+ status +']').prop("checked", true); 
            $('#end_date').val(end_date);
            $('#start_date').val(start_date);
            $('#description').val(description);

            $('#form_milestone').attr('action', '<?php echo $this->link_form;?>/' + id);
            if(id) {
                $('#milestone').val('PUT');
            } else {
                $('#milestone').val('POST');
            }
        });

    });
</script>