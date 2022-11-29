<?php if( $this->message ){ ?>
    <div id="alert_message" class="alert alert_msg <?php echo (0 === strpos($this->message, 'Error')) ? 'alert-danger' : 'alert-primary'; ?> alert-primary fade show" role="alert">
        <?php echo $this->message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
            style="display: block;
            position: absolute;
            font-size: 25px;
            right: 20px;
            top: 5px;
            color: #423f3f;
            font-weight: 900;
            width: auto;
            height: auto;
            background: none;padding: 0;"
        >
            <!-- <i class="fas fa-times" id="close_message"></i> -->
        </button>
    </div>
<script>
    document.getElementById('close_message').onclick =  function() {
        document.getElementById("alert_message").style.display = "none";
    };
</script>
<?php 
}
?>