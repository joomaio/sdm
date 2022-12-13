<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    document.getElementById('clear_filter').onclick = function() {
        document.getElementById("search").value = "";
        document.getElementById("sort").value = "title asc";
        document.getElementById('filter_form').submit();
    }
</script>