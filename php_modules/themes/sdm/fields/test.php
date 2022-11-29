<?php 
    use SPT\Theme; 
    use SPT\Router;
    Theme::add( Router::url('assets/css/bootstrap-select.min.css'), '', 'bt-select');
    Theme::add("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js", '','bt-select');

?>
<select class="selectpicker" multiple>
  <option>Mustard</option>
  <option>Ketchup</option>
  <option>Relish</option>
</select>
