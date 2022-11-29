<tr>
    <td><?php echo $this->index ?></td>
    <td><a href="<?php echo $this->link_form . '/' . $this->item['u_id']; ?>"><?php echo  $this->item['userid']  ?></a></td>
    <td><?php echo  $this->item['s_type'];  ?></td>
    <td><?php echo   $this->item['u_email'];  ?></td>
    <td><?php echo   $this->item['u_f_name'];  ?></td>
    <td><?php echo   $this->item['u_l_name'];  ?></td>
    <td><?php echo   $this->item['school_name'];  ?></td>
    <td><?php echo  $this->item['start_date'] != '0000-00-00' && $this->item['start_date'] ? date('m-d-Y', strtotime($this->item['start_date'])) : '00-00-0000';  ?></td>
    <td><?php echo  $this->item['payment_date'] != '0000-00-00' && $this->item['payment_date'] ? date('m-d-Y', strtotime($this->item['payment_date'])) : '00-00-000';  ?></td>
    <td><?php echo  $this->item['expire_date'] != '0000-00-00' && $this->item['expire_date'] ? date('m-d-Y', strtotime($this->item['expire_date'])) : '00-00-000';  ?></td>
    <td>
        <form id="form_delete_<?php echo $this->item['u_id']; ?>" action="<?php echo $this->link_form. "/" .$this->item['u_id']; ?>" method="POST">
            <input type="hidden" value="<?php echo $this->token ?>" name="token">
            <input type="hidden" value="DELETE" name="_method">
            <?php if ($this->user_id != $this->item['u_id']) { ?>
            <a class="button_delete_item" href="#" data-id_remove="<?php echo $this->item['u_id']; ?>"><i data-feather="trash-2"></i></a>
            <?php } ?>
            <a href="<?php echo $this->link_form . '/' . $this->item['u_id']; ?>"><i data-feather="edit"></i></a>
        </form>
    </td>
</tr>