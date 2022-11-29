<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    document.getElementById('clear_filter').onclick = function() {
        document.getElementById("search").value = "";
        document.getElementById("sort").value = "";
        document.getElementById("status").value = "";
        document.getElementById('filter_form').submit();
    };
    $(document).ready(function() {
        $('#limit').on("change", function (e) {
            $('#filter_form').submit()
        });
        $(".button_delete_item").click(function() {
            var id = $(this).data('id_remove');
            var result = confirm("Are you sure you want to delete this topic id: "+ id +"?");
            console.log(id);
            if (result) {
                $('#form_delete_' + id).submit();
            }
        });
    });
</script>