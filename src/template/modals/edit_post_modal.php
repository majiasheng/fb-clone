<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel">Edit Post</h6>
        <h6><?php echo $post_id; ?></h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <textarea row="3" style="width:100%" name="new_content" form="post_edit_form_id"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm" id="post_edit_form_btn">Save</button>
      </div>
    </div>
  </div>
</div>