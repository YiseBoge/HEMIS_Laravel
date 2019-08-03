<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="p-0" id="delete-form"
                  method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">Are you sure you wish to delete?</div>

                <div class="modal-footer">
                    <button class="btn btn-secondary shadow-sm" type="button" data-dismiss="modal"> Cancel</button>
                    <button class="btn btn-danger shadow-sm" type="submit"> Delete</button>
                </div>

                <input type="hidden" name="_method" value="DELETE">
            </form>
        </div>
    </div>
</div>