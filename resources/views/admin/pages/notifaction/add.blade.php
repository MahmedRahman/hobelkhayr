<div class="modal fade" id="addNotifactionsModal" tabindex="-1" role="dialog" aria-labelledby="addNotifactionsModalLabe
            aria-hidden=" true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNotifactionsModalLabel">Add New Notifactions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add Notifactions Form -->
                <form method="POST" action="{{ route('Notifactions.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="Notifactions_name">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="Notifactions_name">Body</label>
                        <input type="text" class="form-control" id="body" name="body" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Notifactions</button>
                </form>
            </div>
        </div>
    </div>
</div>