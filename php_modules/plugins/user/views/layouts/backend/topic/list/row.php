<tr>
    <td><?php echo $this->index ?></td>
    <td><a href="<?php echo $this->link_form . '/' . $this->item['topic_id']; ?>"><?php echo strip_tags($this->item['topic_name']) ?></a></td>
    <td><?php echo $this->item['topic_active'] == "Y" ? 'Yes' : 'No' ?></td>
    <td>
        <form id="form_delete_<?php echo $this->item['topic_id']; ?>" action="<?php echo $this->link_form. "/" .$this->item['topic_id']; ?>" method="POST">
            <input type="hidden" value="<?php echo $this->token ?>" name="token">
            <input type="hidden" value="DELETE" name="_method">
            <a class="button_delete_item" href="#" data-id_remove="<?php echo $this->item['topic_id']; ?>"><i data-feather="trash-2"></i></a>
            <a href="<?php echo $this->link_form . '/' . $this->item['topic_id']; ?>"><i data-feather="edit"></i></a>
        </form>
    </td>
</tr>