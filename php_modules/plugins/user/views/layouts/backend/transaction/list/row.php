<tr>
    <td><?php echo $this->index ?></td>
    <td><a href="<?php echo $this->link_form . '/' . $this->item['id']; ?>"><?php echo strip_tags($this->item['transid']) ?></a></td>
    <td><?php echo $this->item['userid'];?></td>
    <td><?php echo $this->item['status'] ? 'Success' : 'Fail' ?></td>
    <td><?php echo $this->item['created_at'] && $this->item['created_at'] != '0000-00-00 00:00:00' ? date('m/d/Y H:i:s', strtotime($this->item['created_at'])) : '00-00-0000 00:00:00' ?></td>
    <td>
        <form id="form_delete_<?php echo $this->item['id']; ?>" action="<?php echo $this->link_form. "/" .$this->item['id']; ?>" method="POST">
            <input type="hidden" value="<?php echo $this->token ?>" name="token">
            <input type="hidden" value="DELETE" name="_method">
            <a class="button_delete_item" href="#" data-id_remove="<?php echo $this->item['id']; ?>"><i data-feather="trash-2"></i></a>
        </form>
    </td>
</tr>