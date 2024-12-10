@extends('admin.layouts.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">System Settings</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Manage Content</h6>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="terms-tab" data-bs-toggle="tab" href="#terms" role="tab" aria-controls="terms" aria-selected="true">
                            Terms & Conditions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="privacy-tab" data-bs-toggle="tab" href="#privacy" role="tab" aria-controls="privacy" aria-selected="false">
                            Privacy Policy
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="about-tab" data-bs-toggle="tab" href="#about" role="tab" aria-controls="about" aria-selected="false">
                            About Us
                        </a>
                    </li>
                </ul>

                <form id="settingsForm" class="mt-4">
                    @csrf
                    <div class="tab-content" id="settingsTabContent">
                        <!-- Terms & Conditions -->
                        <div class="tab-pane fade show active" id="terms" role="tabpanel">
                            <div class="form-group">
                                <label for="terms_content">Terms & Conditions Content</label>
                                <textarea class="form-control summernote" id="terms_content" name="terms_and_conditions" rows="10">{{ isset($settings['legal']) && isset($settings['legal'][0]) && $settings['legal'][0]->key === 'terms_and_conditions' ? $settings['legal'][0]->value : '' }}</textarea>
                            </div>
                        </div>

                        <!-- Privacy Policy -->
                        <div class="tab-pane fade" id="privacy" role="tabpanel">
                            <div class="form-group">
                                <label for="privacy_content">Privacy Policy Content</label>
                                <textarea class="form-control summernote" id="privacy_content" name="privacy_policy" rows="10">{{ isset($settings['legal']) && isset($settings['legal'][1]) && $settings['legal'][1]->key === 'privacy_policy' ? $settings['legal'][1]->value : '' }}</textarea>
                            </div>
                        </div>

                        <!-- About Us -->
                        <div class="tab-pane fade" id="about" role="tabpanel">
                            <div class="form-group">
                                <label for="about_content">About Us Content</label>
                                <textarea class="form-control summernote" id="about_content" name="about_us" rows="10">{{ isset($settings['about']) && isset($settings['about'][0]) && $settings['about'][0]->key === 'about_us' ? $settings['about'][0]->value : '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Initialize Summernote
    $('.summernote').summernote({
        height: 300,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });

    // Handle form submission
    $('#settingsForm').on('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        Swal.fire({
            title: 'Saving...',
            text: 'Please wait while we update the settings',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        const settings = [
            {
                key: 'terms_and_conditions',
                value: $('#terms_content').summernote('code'),
                type: 'html',
                group: 'legal'
            },
            {
                key: 'privacy_policy',
                value: $('#privacy_content').summernote('code'),
                type: 'html',
                group: 'legal'
            },
            {
                key: 'about_us',
                value: $('#about_content').summernote('code'),
                type: 'html',
                group: 'about'
            }
        ];

        // For debugging
        console.log('Submitting settings:', settings);

        $.ajax({
            url: '{{ route("admin.settings.update") }}',
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                settings: settings
            },
            success: function(response) {
                console.log('Success response:', response);
                // Check if response has status or if the response itself is truthy
                if (response.status || response.success || (response && !response.error)) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message || 'Settings have been updated successfully',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                } else {
                    // Even if we get a success callback but the response indicates an error
                    let errorMessage = response.message || response.error || 'Failed to update settings';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorMessage,
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                // Only show error if it's a real error (not a successful save)
                if (xhr.status !== 200) {
                    let errorMessage = 'An error occurred while updating settings';
                    
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.message) {
                            errorMessage = response.message;
                        } else if (response.error) {
                            errorMessage = response.error;
                        }
                    } catch (e) {
                        console.error('Error parsing response:', e);
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorMessage,
                        confirmButtonText: 'OK'
                    });
                } else {
                    // If status is 200, treat it as success even if it came to error callback
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Settings have been updated successfully',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                }
            }
        });
    });
});
</script>
@endsection
