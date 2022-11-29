<tr>
    <td><?php echo $this->index ?></td>
    <td><a href="<?php echo $this->link_form . '/' . $this->item['id']; ?>"><?php echo strip_tags($this->item['e_name']) ?></a></td>
    <td>
        <form id="form_delete_<?php echo $this->item['id']; ?>" action="<?php echo $this->link_form. "/" .$this->item['id']; ?>" method="POST">
            <input type="hidden" value="<?php echo $this->token ?>" name="token">
            <input type="hidden" value="DELETE" name="_method">
            <a class="button_delete_item" href="#" data-id_remove="<?php echo $this->item['id']; ?>"><i data-feather="trash-2"></i></a>
            <a href="<?php echo $this->link_form . '/' . $this->item['id']; ?>"><i data-feather="edit"></i></a>
        </form>
    </td>
</tr>