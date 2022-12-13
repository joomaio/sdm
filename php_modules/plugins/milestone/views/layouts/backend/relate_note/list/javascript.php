<form class="hidden" method="POST" id="form_delete">
    <input type="hidden" value="<?php echo $this->token ?>" name="token">
    <input type="hidden" value="DELETE" name="_method">
</form>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    // document.getElementById('clear_filter').onclick = function() {
    //     document.getElementById("search").value = "";
    //     document.getElementById("sort").value = "title asc";
    //     document.getElementById('filter_form').submit();
    // };
    $(document).ready(function() {
        $("#select_all_relate_note").click( function(){
            $('.checkbox-item').prop('checked', this.checked);
        });
        $(".button_delete_item_relate_note").click(function() {
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
        $('#delete_relate_note_selected').click(function(){
            var count = 0;
            $('input[name="ids[]"]:checked').each(function() {
                count++;
            });
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
        $(".show_data_relate_note").click(function() {
            var id = $(this).data('id');
            var title = $(this).data('title');
            var description = $(this).data('description');

            $('#title').val(title);
            $('#description').val(description);
            
            $('#form_relate_note').attr('action', '<?php echo $this->link_form;?>/' + id);
            if(id) {
                $('#relate_note').val('PUT');
            } else {
                $('#relate_note').val('POST');
            }
        });
    });
</script>