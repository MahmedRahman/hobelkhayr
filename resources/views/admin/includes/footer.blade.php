<footer class="admin-footer">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0">&copy; {{ date('Y') }} HobelKhayr. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="footer-links">
                    <a href="#" class="text-muted me-3">Privacy Policy</a>
                    <a href="#" class="text-muted me-3">Terms of Service</a>
                    <a href="#" class="text-muted">Contact Support</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .admin-footer {
        background: white;
        padding: 1rem 0;
        position: fixed;
        bottom: 0;
        left: var(--sidebar-width);
        right: 0;
        border-top: 1px solid #e5e7eb;
        font-size: 0.875rem;
        z-index: 1000;
        transition: all 0.3s ease;
    }

    .footer-links a {
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .footer-links a:hover {
        color: var(--primary-color) !important;
    }

    @media (max-width: 768px) {
        .admin-footer {
            left: 0;
            padding: 1rem;
        }

        .footer-links {
            margin-top: 0.5rem;
            text-align: left;
        }
    }
</style>

<!-- Core Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<!-- Custom Scripts -->
<script>
    // Toggle Sidebar on Mobile
    document.addEventListener('DOMContentLoaded', function() {
        const toggleSidebar = document.querySelector('.toggle-sidebar');
        const sidebar = document.querySelector('.admin-sidebar');
        
        if (toggleSidebar && sidebar) {
            toggleSidebar.addEventListener('click', function() {
                sidebar.classList.toggle('show');
            });
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !toggleSidebar.contains(event.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });
    });

    // Highlight active menu item
    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-link').forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
        }
    });
</script>