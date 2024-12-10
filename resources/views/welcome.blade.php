<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HobelKhayr - Connect and Help Together</title>
    <meta name="description" content="HobelKhayr connects people who want to help with those in need through group chats and community support.">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #128C7E;
            --primary-dark: #0C6B5F;
            --primary-light: #25D366;
            --secondary-color: #075E54;
            --accent-color: #34B7F1;
            --success-color: #25D366;
            --light-bg: #E8F5E9;
            --gradient-start: #128C7E;
            --gradient-end: #34B7F1;
            --text-dark: #075E54;
            --text-light: #6B7280;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
        }

        .navbar {
            padding: 1rem 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(18, 140, 126, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: linear-gradient(to right, var(--primary-color), var(--accent-color));
          
            -webkit-text-fill-color: transparent;
        }

        .nav-link {
            font-weight: 500;
            color: var(--text-dark);
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background: var(--primary-color);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .btn-primary {
            background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: transform 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(18, 140, 126, 0.2);
        }

        .hero {
            padding: 6rem 0;
            background: linear-gradient(135deg, var(--light-bg) 0%, #F0FFF4 100%);
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            color: var(--primary-dark);
        }

        .feature-card {
            background: white;
            box-shadow: 0 4px 6px -1px rgba(18, 140, 126, 0.1);
            transition: transform 0.3s ease;
            border: 1px solid var(--light-bg);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(18, 140, 126, 0.1);
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            background: var(--light-bg);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: var(--primary-color);
        }

        .stats-section {
            background-color: var(--primary-color);
            color: white;
            padding: 4rem 0;
        }

        .chat-preview {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            margin-top: 2rem;
        }

        .chat-message {
            display: flex;
            align-items: start;
            margin-bottom: 1rem;
            padding: 0.5rem;
            border-radius: 8px;
        }

        .chat-message.received {
            background: var(--light-bg);
            margin-right: 2rem;
        }

        .chat-message.sent {
            background: white;
            margin-left: 2rem;
            flex-direction: row-reverse;
        }

        .message-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            margin: 0 0.5rem;
        }

        .message-content {
            background: white;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            max-width: 80%;
        }

        .contact-section {
            padding: 6rem 0;
            background: var(--light-bg);
            position: relative;
            overflow: hidden;
        }

        .contact-section::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            opacity: 0.1;
            top: -150px;
            right: -150px;
        }

        .contact-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(18, 140, 126, 0.05);
        }

        .contact-info {
            margin-bottom: 2rem;
        }

        .contact-info-item {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .contact-info-item i {
            width: 40px;
            height: 40px;
            background: var(--light-bg);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: var(--primary-color);
        }

        .form-control {
            padding: 0.8rem;
            border: 2px solid #E2E8F0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(18, 140, 126, 0.1);
        }

        .form-label {
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--light-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .app-download {
            padding: 4rem 0;
            background: linear-gradient(135deg, var(--light-bg) 0%, #F0FFF4 100%);
        }

        .app-download h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--primary-dark);
        }

        .app-download p {
            font-size: 1.1rem;
            color: var(--secondary-color);
            margin-bottom: 2rem;
        }

        .store-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .store-button {
            background: var(--text-dark);
            color: white;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .store-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(18, 140, 126, 0.2);
            color: white;
        }

        .store-button i {
            font-size: 2rem;
            margin-right: 0.8rem;
        }

        .store-button .button-text {
            text-align: left;
        }

        .store-button .small-text {
            font-size: 0.8rem;
            display: block;
            opacity: 0.8;
        }

        .store-button .big-text {
            font-size: 1.1rem;
            font-weight: 600;
            display: block;
        }

        footer {
            background: var(--text-dark);
            color: white;
            padding: 4rem 0;
        }

        footer a {
            color: rgba(255, 255, 255, 0.8);
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: var(--primary-light);
        }

        @media (max-width: 768px) {
            .store-buttons {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">HobelKhayr</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#community">Community</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-primary" href="/login">Join Now</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1>Connect, Chat & Help Together</h1>
                    <p class="lead mb-4">Join HobelKhayr's community where you can create groups, chat with friends, and coordinate to help those in need.</p>
                    <a href="/register" class="btn btn-primary me-3">Get Started</a>
                    <a href="#learn-more" class="btn btn-outline-success">Learn More</a>
                </div>
                <div class="col-lg-6">
                    <div class="chat-preview">
                        <div class="chat-message received">
                            <img src="{{ asset('images/avatar1.jpg') }}" alt="User" class="message-avatar">
                            <div class="message-content">
                                <p class="mb-0">Hey everyone! I know someone who needs help with medical expenses.</p>
                            </div>
                        </div>
                        <div class="chat-message sent">
                            <img src="{{ asset('images/avatar2.jpg') }}" alt="User" class="message-avatar">
                            <div class="message-content">
                                <p class="mb-0">I can help! Let's create a group to coordinate.</p>
                            </div>
                        </div>
                        <div class="chat-message received">
                            <img src="{{ asset('images/avatar3.jpg') }}" alt="User" class="message-avatar">
                            <div class="message-content">
                                <p class="mb-0">Count me in! Together we can make a difference.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-4 fw-bold text-success">How It Works</h2>
                <p class="lead text-muted">Connecting hearts through technology</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Create Groups</h3>
                        <p>Form groups with friends and family to coordinate help and support.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h3>Real-time Chat</h3>
                        <p>Communicate instantly with group members to organize and plan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-hands-helping"></i>
                        </div>
                        <h3>Coordinate Help</h3>
                        <p>Work together efficiently to provide support where it's needed most.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-number">5,000+</div>
                        <div class="stat-label">Active Users</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-number">1,000+</div>
                        <div class="stat-label">Support Groups</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-number">10,000+</div>
                        <div class="stat-label">Lives Impacted</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Community Section -->
    <section id="community" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-4 fw-bold text-success">Our Community</h2>
                <p class="lead text-muted">Join thousands making a difference</p>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <img src="{{ asset('images/group1.jpg') }}" alt="Community Group" class="img-fluid rounded mb-3">
                        <h4>Medical Support Group</h4>
                        <p>Coordinating support for medical treatments and expenses.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <img src="{{ asset('images/group2.jpg') }}" alt="Community Group" class="img-fluid rounded mb-3">
                        <h4>Education Initiative</h4>
                        <p>Helping students access educational resources and support.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <img src="{{ asset('images/group3.jpg') }}" alt="Community Group" class="img-fluid rounded mb-3">
                        <h4>Emergency Response</h4>
                        <p>Quick response team for urgent community needs.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section" id="contact">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center mb-5">
                    <h2 class="display-4 fw-bold mb-3">Get in Touch</h2>
                    <p class="text-muted">Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <div class="contact-info">
                        <div class="contact-info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <h5 class="mb-1">Address</h5>
                                <p class="mb-0 text-muted">123 Community Street, City, Country</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <h5 class="mb-1">Phone</h5>
                                <p class="mb-0 text-muted">+1 234 567 8900</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <h5 class="mb-1">Email</h5>
                                <p class="mb-0 text-muted">contact@hobelkhayr.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="contact-card">
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" placeholder="John Doe">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" placeholder="john@example.com">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Subject</label>
                                <input type="text" class="form-control" placeholder="How can we help?">
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Message</label>
                                <textarea class="form-control" rows="5" placeholder="Your message here..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- App Download Section -->
    <section class="app-download">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2>Download Our App</h2>
                    <p>Get the HobelKhayr app on your phone to stay connected with your community and help others on the go.</p>
                    <div class="store-buttons">
                        <a href="#" class="store-button">
                            <i class="fab fa-google-play"></i>
                            <div class="button-text">
                                <span class="small-text">GET IT ON</span>
                                <span class="big-text">Google Play</span>
                            </div>
                        </a>
                        <a href="#" class="store-button">
                            <i class="fab fa-apple"></i>
                            <div class="button-text">
                                <span class="small-text">Download on the</span>
                                <span class="big-text">App Store</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="images/app-preview.png" alt="HobelKhayr Mobile App" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h4 class="mb-4">HobelKhayr</h4>
                    <p>Building stronger communities through connection and support.</p>
                    <div class="social-links mt-4">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <h5 class="mb-4">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">About Us</a></li>
                        <li><a href="#" class="text-white">How It Works</a></li>
                        <li><a href="#" class="text-white">FAQ</a></li>
                        <li><a href="#" class="text-white">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h5 class="mb-4">Support</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Help Center</a></li>
                        <li><a href="#" class="text-white">Community Guidelines</a></li>
                        <li><a href="#" class="text-white">Safety Tips</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="mb-4">Join Our Community</h5>
                    <p>Stay updated with new features and community stories.</p>
                    <form class="mt-3">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Enter your email">
                            <button class="btn btn-primary" type="submit">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="mt-4 mb-4">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} HobelKhayr. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Navbar background change on scroll
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                document.querySelector('.navbar').style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
                document.querySelector('.navbar').style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
            } else {
                document.querySelector('.navbar').style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
                document.querySelector('.navbar').style.boxShadow = 'none';
            }
        });
    </script>
</body>
</html>