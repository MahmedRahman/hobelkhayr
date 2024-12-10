<a href="https://www.google.com/maps?q={{ $latitude }},{{ $longitude }}" 
   target="_blank" 
   class="text-primary location-link"
   data-bs-toggle="tooltip" 
   data-bs-placement="top" 
   title="Click to view on Google Maps">
    <i class="fas fa-map-marker-alt me-1"></i>
    {{ number_format($latitude, 6) }}, {{ number_format($longitude, 6) }}
</a>

@once
@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Add hover effect
        $('.location-link').hover(
            function() { $(this).css('text-decoration', 'underline'); },
            function() { $(this).css('text-decoration', 'none'); }
        );
    });
</script>
@endpush
@endonce
