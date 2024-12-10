<div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editServiceModalLabel">Edit Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editServiceForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_service_name" class="form-label">Service Name</label>
                        <input type="text" class="form-control" id="edit_service_name" name="service_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_service_image" class="form-label">Service Image</label>
                        <input type="file" class="form-control" id="edit_service_image" name="service_image" accept="image/*">
                        <small class="form-text text-muted">Leave empty to keep current image</small>
                        <div class="mt-2">
                            <img id="currentImage" src="" alt="Current Image" style="max-width: 200px; display: none;" class="mt-2">
                        </div>
                        <div class="mt-2">
                            <img id="editImagePreview" src="" alt="New Image Preview" style="max-width: 200px; display: none;" class="mt-2">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Service</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Handle form submission
    $('#editServiceForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var formData = new FormData(this);
        
        // Show loading state
        var submitBtn = form.find('button[type="submit"]');
        var originalText = submitBtn.html();
        submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...');
        submitBtn.prop('disabled', true);
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#editServiceModal').modal('hide');
                window.location.reload();
            },
            error: function(xhr) {
                console.error('Update error:', xhr);
                alert('Error updating service. Please try again.');
            },
            complete: function() {
                // Reset button state
                submitBtn.html(originalText);
                submitBtn.prop('disabled', false);
            }
        });
    });

    // Reset form when modal is closed
    $('#editServiceModal').on('hidden.bs.modal', function () {
        $('#editServiceForm')[0].reset();
        $('#currentImage').hide();
        $('#editImagePreview').hide();
    });
});
</script>
@endpush
