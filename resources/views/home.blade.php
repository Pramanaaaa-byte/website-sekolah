<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eduspace - Sistem Meja Piket Sekolah</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #5b21b6;
            --secondary-color: #7c3aed;
            --accent-color: #a855f7;
            --gradient-primary: linear-gradient(135deg, #5b21b6 0%, #7c3aed 50%, #a855f7 100%);
            --gradient-hero: linear-gradient(135deg, #4c1d95 0%, #5b21b6 25%, #6d28d9 50%, #7c3aed 75%, #8b5cf6 100%);
            --gradient-secondary: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #d97706 100%);
            --gradient-accent: linear-gradient(135deg, #ec4899 0%, #f43f5e 50%, #ef4444 100%);
            --sidebar-bg: #0f172a;
            --sidebar-text: #f1f5f9;
            --sidebar-hover: #1e293b;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --card-shadow-hover: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --border-color: #e2e8f0;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --bg-light: #f8fafc;
            --bg-white: #ffffff;
            --font-primary: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --font-heading: 'Montserrat', 'Playfair Display', 'Poppins', sans-serif;
            --font-display: 'Playfair Display', serif;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: var(--font-primary);
            background: var(--bg-light);
            min-height: 100vh;
            color: var(--text-primary);
            overflow-x: hidden;
            line-height: 1.6;
            font-weight: 400;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        /* Typography Enhancements */
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-heading);
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1rem;
            color: var(--text-primary);
        }
        
        h1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
            font-family: var(--font-display);
            letter-spacing: -0.02em;
        }
        
        h2 {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 700;
            letter-spacing: -0.01em;
        }
        
        h3 {
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 600;
        }
        
        p {
            font-family: var(--font-primary);
            font-size: clamp(1rem, 2vw, 1.125rem);
            line-height: 1.7;
            margin-bottom: 1rem;
            color: var(--text-secondary);
        }
        
        .text-gradient {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .text-large {
            font-size: clamp(1.125rem, 2.5vw, 1.25rem);
            font-weight: 500;
        }
        
        .text-small {
            font-size: clamp(0.875rem, 1.5vw, 1rem);
            color: var(--text-muted);
        }
        
        /* Enhanced Navigation */
        .navbar {
            background: white !important;
            border-bottom: 1px solid var(--border-color) !important;
            box-shadow: var(--card-shadow) !important;
            transition: all 0.3s ease;
            padding: 1rem 0;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            z-index: 1000 !important;
        }
        
        /* Navigation Styles */
        .navbar-brand {
            color: var(--text-primary) !important;
            font-family: var(--font-heading);
            font-weight: 800;
            font-size: 1.75rem;
            text-decoration: none;
            transition: all 0.3s ease;
            letter-spacing: -0.01em;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .navbar-brand i {
            font-size: 1.5rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .nav-link {
            color: var(--text-primary) !important;
            font-family: var(--font-heading);
            font-weight: 600;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
            border-radius: 0.75rem;
            padding: 0.625rem 1.25rem !important;
            font-size: 1rem;
            letter-spacing: 0.01em;
            position: relative;
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--gradient-primary);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::before {
            width: 80%;
        }
        
        .nav-link:hover {
            color: var(--primary-color) !important;
            background: var(--bg-light);
            transform: translateY(-1px);
        }
        
        .nav-link.active {
            color: white !important;
            background: var(--primary-color);
            border-radius: 0.5rem;
        }
        
        .navbar[style*="background"] {
            background: linear-gradient(135deg, #6366f1, #8b5cf6) !important;
        }
        
        .navbar.scrolled {
            background: linear-gradient(135deg, #6366f1, #8b5cf6) !important;
        }
        
        .navbar.scrolled .navbar-brand {
            color: white !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5) !important;
        }
        
        .navbar.scrolled .nav-link {
            color: white !important;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5) !important;
        }
        
        .navbar.scrolled .nav-link:hover {
            background: rgba(255, 255, 255, 0.3) !important;
            color: white !important;
        }
        
        /* Hero Section */
        .hero-section {
            padding: 140px 0 100px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #2d1b69 0%, #4c1d95 25%, #5b21b6 50%, #6d28d9 75%, #7c3aed 100%);
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/><circle cx="10" cy="50" r="0.5" fill="rgba(255,255,255,0.05)"/><circle cx="90" cy="50" r="0.5" fill="rgba(255,255,255,0.05)"/><circle cx="50" cy="90" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.4;
            animation: drift 20s linear infinite;
        }
        
        .hero-section::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 80%, rgba(168, 85, 247, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(99, 102, 241, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }
        
        @keyframes drift {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.25);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            font-family: var(--font-heading);
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            letter-spacing: 0.5px;
            backdrop-filter: blur(20px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            animation: float 3s ease-in-out infinite;
            color: #ffffff;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .hero-title {
            font-family: var(--font-display);
            font-size: clamp(3rem, 8vw, 5rem);
            font-weight: 900;
            margin-bottom: 1.5rem;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            line-height: 0.9;
            letter-spacing: -0.03em;
            color: #ffffff;
            position: relative;
        }
        
        .hero-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
            border-radius: 2px;
        }
        
        .hero-subtitle {
            font-family: var(--font-primary);
            font-size: clamp(1.125rem, 3vw, 1.5rem);
            margin-bottom: 3rem;
            opacity: 1;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
            font-weight: 500;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.4);
            color: #ffffff;
        }
        
        .hero-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .btn-hero {
            padding: 1rem 2rem;
            font-family: var(--font-heading);
            font-size: 1.125rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.01em;
            border: none;
            cursor: pointer;
        }
        
        .btn-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
        }
        
        .btn-hero::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            transform: translate(-50%, -50%);
            transition: all 0.5s ease;
        }
        
        .btn-hero:hover::before {
            left: 100%;
        }
        
        .btn-hero:hover::after {
            width: 300px;
            height: 300px;
        }
        
        .btn-primary-hero {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            color: #5b21b6;
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.4), 0 4px 15px rgba(0, 0, 0, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
        
        .btn-primary-hero:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 12px 35px rgba(255, 255, 255, 0.4), 0 6px 20px rgba(0, 0, 0, 0.15);
        }
        
        .btn-secondary-hero {
            background: transparent;
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(20px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .btn-secondary-hero:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.6);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2);
        }
        
        .btn-hero i {
            font-size: 1.125rem;
            transition: transform 0.3s ease;
        }
        
        .btn-hero:hover i {
            transform: translateX(3px);
        }
        
        /* Floating Elements */
        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
        }
        
        .floating-element {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 50%;
            animation: float-random 20s ease-in-out infinite;
        }
        
        .floating-element:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .floating-element:nth-child(2) {
            width: 60px;
            height: 60px;
            top: 60%;
            right: 10%;
            animation-delay: 3s;
        }
        
        .floating-element:nth-child(3) {
            width: 40px;
            height: 40px;
            top: 40%;
            right: 20%;
            animation-delay: 6s;
        }
        
        @keyframes float-random {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(30px, -30px) rotate(90deg); }
            50% { transform: translate(-20px, 20px) rotate(180deg); }
            75% { transform: translate(40px, 10px) rotate(270deg); }
        }
        
        /* Features Section */
        .features-section {
            padding: 80px 0;
            background: white;
            position: relative;
        }
        
        .features-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            transform: skewY(-2deg);
            transform-origin: top left;
        }
        
        .features-container {
            position: relative;
            z-index: 2;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .section-title {
            font-family: var(--font-display);
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 800;
            color: #5b21b6;
            margin-bottom: 1.5rem;
            position: relative;
            letter-spacing: -0.02em;
            text-shadow: 0 2px 4px rgba(91, 33, 182, 0.1);
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 6px;
            background: var(--gradient-primary);
            border-radius: 3px;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }
        
        .section-subtitle {
            font-family: var(--font-primary);
            font-size: clamp(1.125rem, 3vw, 1.375rem);
            color: var(--text-secondary);
            max-width: 600px;
            margin: 2rem auto 0;
            font-weight: 500;
            line-height: 1.7;
        }
        
        .feature-card {
            background: var(--bg-white);
            border-radius: 20px;
            padding: 2.5rem 2rem;
            text-align: center;
            box-shadow: var(--card-shadow);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transform-origin: left;
        }
        
        .feature-card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.05) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.4s ease;
            pointer-events: none;
        }
        
        .feature-card:hover::before {
            transform: scaleX(1);
        }
        
        .feature-card:hover::after {
            opacity: 1;
        }
        
        .feature-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: var(--card-shadow-hover);
            border-color: rgba(99, 102, 241, 0.2);
        }
        
        .feature-icon-wrapper {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .feature-icon-bg {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            position: relative;
            animation: pulse 3s ease-in-out infinite;
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.4); }
            50% { transform: scale(1.05); box-shadow: 0 0 0 25px rgba(99, 102, 241, 0); }
        }
        
        .feature-icon {
            font-size: 2.25rem;
            color: white;
            z-index: 2;
            position: relative;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }
        
        .feature-title {
            font-family: var(--font-heading);
            font-size: clamp(1.25rem, 3vw, 1.5rem);
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
            letter-spacing: -0.01em;
        }
        
        .feature-description {
            font-family: var(--font-primary);
            color: #475569;
            line-height: 1.7;
            font-size: clamp(0.95rem, 2vw, 1.0625rem);
            font-weight: 500;
        }
        
        /* Stats Section */
        .stats-section {
            padding: 60px 0;
            background: #f8f9fc;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.03);
        }
        
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.8rem;
            font-size: 1.2rem;
            color: white;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.3rem;
        }
        
        .stat-label {
            color: var(--secondary-color);
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        /* CTA Section */
        .cta-section {
            padding: 70px 0;
            background: var(--gradient-hero);
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain2" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain2)"/></svg>');
            opacity: 0.3;
        }
        
        .cta-content {
            position: relative;
            z-index: 2;
        }
        
        .cta-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .cta-subtitle {
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            opacity: 0.85;
            font-weight: 400;
        }
        
        .btn-cta {
            background: white;
            color: var(--primary-color);
            padding: 12px 30px;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 40px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(255, 255, 255, 0.25);
        }
        
        .btn-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.35);
        }
        
        /* Footer */
        .footer {
            background: var(--sidebar-bg);
            color: white;
            padding: 2rem 0 1rem;
        }
        
        .footer-content {
            text-align: center;
        }
        
        .footer-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .footer-description {
            opacity: 0.8;
            margin-bottom: 1.5rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            font-size: 0.95rem;
        }
        
        .social-links {
            display: flex;
            justify-content: center;
            gap: 0.8rem;
            margin-bottom: 1.5rem;
        }
        
        .social-link {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 0.9rem;
        }
        
        .social-link:hover {
            background: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(78, 115, 223, 0.25);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 1rem;
            margin-top: 1.5rem;
            opacity: 0.7;
            font-size: 0.85rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-section {
                padding: 100px 0 60px;
                min-height: auto;
            }
            
            .hero-title {
                font-size: 2.2rem;
                margin-bottom: 1rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
                margin-bottom: 2rem;
                max-width: 400px;
            }
            
            .hero-badge {
                font-size: 0.8rem;
                padding: 0.3rem 1rem;
                margin-bottom: 1rem;
            }
            
            .btn-hero {
                padding: 10px 20px;
                font-size: 0.9rem;
                margin: 3px;
            }
            
            .section-title {
                font-size: 1.8rem;
            }
            
            .section-subtitle {
                font-size: 1rem;
                max-width: 400px;
            }
            
            .feature-card {
                margin-bottom: 1.5rem;
                padding: 1.5rem;
            }
            
            .feature-icon-bg {
                width: 70px;
                height: 70px;
            }
            
            .feature-icon {
                font-size: 1.8rem;
            }
            
            .feature-title {
                font-size: 1.1rem;
            }
            
            .feature-description {
                font-size: 0.9rem;
            }
            
            .stats-section {
                padding: 40px 0;
            }
            
            .stat-card {
                padding: 1.2rem;
                margin-bottom: 1rem;
            }
            
            .stat-number {
                font-size: 1.8rem;
            }
            
            .stat-label {
                font-size: 0.85rem;
            }
            
            .cta-section {
                padding: 50px 0;
            }
            
            .cta-title {
                font-size: 1.6rem;
            }
            
            .cta-subtitle {
                font-size: 1rem;
                margin-bottom: 1.2rem;
            }
            
            .btn-cta {
                padding: 10px 25px;
                font-size: 0.9rem;
            }
            
            .footer {
                padding: 1.5rem 0 0.8rem;
            }
            
            .footer-logo {
                font-size: 1.3rem;
            }
            
            .footer-description {
                font-size: 0.9rem;
                max-width: 350px;
            }
            
            .social-link {
                width: 35px;
                height: 35px;
                font-size: 0.85rem;
            }
            
            .navbar-brand {
                font-size: 1.4rem;
            }
            
            .nav-link {
                margin: 0 0.2rem;
                padding: 0.4rem 0.8rem !important;
                font-size: 0.9rem;
            }
        }
        
        /* Loading Animation */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Enhanced Button Effects */
        .btn-hero:hover::before {
            left: 100%;
        }
        
        .btn-hero:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }
        
        .btn-primary-hero:hover {
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }
        
        .btn-secondary-hero:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
        }
        
        /* Enhanced Card Animations */
        .feature-card {
            transform-style: preserve-3d;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .feature-card:hover {
            transform: translateY(-12px) rotateX(2deg);
        }
        
        .stat-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .stat-card:hover {
            transform: translateY(-5px) scale(1.02);
        }
        
        /* Smooth Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--bg-light);
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-color);
        }
        
        /* Selection Color */
        ::selection {
            background: var(--primary-color);
            color: white;
        }
        
        /* Focus States */
        .btn-hero:focus,
        .nav-link:focus,
        .social-link:focus {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }
        
        @media (max-width: 480px) {
            .hero-title {
                font-size: 1.8rem;
            }
            
            .hero-subtitle {
                font-size: 0.95rem;
            }
            
            .section-title {
                font-size: 1.5rem;
            }
            
            .feature-card {
                padding: 1.2rem;
            }
            
            .feature-icon-bg {
                width: 60px;
                height: 60px;
            }
            
            .feature-icon {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-graduation-cap"></i>
                Meja Piket
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#stats">Statistik</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="floating-elements">
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
        </div>
        <div class="container">
            <div class="hero-content" data-aos="fade-up">
                <div class="hero-badge">
                    <i class="fas fa-star me-2"></i>System Meja Piket Sekolah SMKN 1 Ciomas
                </div>
                <h1 class="hero-title">System Piket</h1>
                <p class="hero-subtitle">
                    System Meja Piket adalah sistem yang digunakan untuk mengelola jadwal meja piket di sekolah.
                </p>
                <div class="hero-buttons">
                    <a href="{{ route('login') }}" class="btn-hero btn-primary-hero">
                        <i class="fas fa-rocket"></i>
                        Mulai Sekarang
                    </a>
                    <a href="#features" class="btn-hero btn-secondary-hero">
                        <i class="fas fa-play-circle"></i>
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features-section">
        <div class="container features-container">
            <div class="section-header" data-aos="fade-up">
                <h2 class="section-title">Fitur Unggulan</h2>
                <p class="section-subtitle">
                    Kemudahan pengelolaan sekolah dalam satu platform terintegrasi dengan teknologi terkini
                </p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon-wrapper">
                            <div class="feature-icon-bg">
                                <i class="fas fa-users feature-icon"></i>
                            </div>
                        </div>
                        <h3 class="feature-title">Manajemen Siswa</h3>
                        <p class="feature-description">
                            Kelola data siswa, absensi, nilai, dan tracking perkembangan akademik dengan sistem yang terintegrasi dan real-time
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="feature-icon-wrapper">
                            <div class="feature-icon-bg">
                                <i class="fas fa-chalkboard-teacher feature-icon"></i>
                            </div>
                        </div>
                        <h3 class="feature-title">Manajemen Guru</h3>
                        <p class="feature-description">
                            Pantau jadwal mengajar, performa mengajar, dan data kehadiran guru dengan dashboard yang komprehensif
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="feature-icon-wrapper">
                            <div class="feature-icon-bg">
                                <i class="fas fa-calendar-check feature-icon"></i>
                            </div>
                        </div>
                        <h3 class="feature-title">Jadwal & Piket</h3>
                        <p class="feature-description">
                            Atur jadwal pelajaran dan sistem piket sekolah yang terorganisir dengan notifikasi otomatis
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-card">
                        <div class="feature-icon-wrapper">
                            <div class="feature-icon-bg">
                                <i class="fas fa-door-open feature-icon"></i>
                            </div>
                        </div>
                        <h3 class="feature-title">Izin Keluar</h3>
                        <p class="feature-description">
                            Sistem izin keluar siswa yang terintegrasi dengan keamanan sekolah dan notifikasi orang tua
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="500">
                    <div class="feature-card">
                        <div class="feature-icon-wrapper">
                            <div class="feature-icon-bg">
                                <i class="fas fa-clock feature-icon"></i>
                            </div>
                        </div>
                        <h3 class="feature-title">Keterlambatan</h3>
                        <p class="feature-description">
                            Monitor dan catat keterlambatan siswa dengan sistem yang akurat dan laporan otomatis
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="600">
                    <div class="feature-card">
                        <div class="feature-icon-wrapper">
                            <div class="feature-icon-bg">
                                <i class="fas fa-chart-line feature-icon"></i>
                            </div>
                        </div>
                        <h3 class="feature-title">Analitik & Laporan</h3>
                        <p class="feature-description">
                            Dapatkan insight mendalam tentang performa sekolah melalui dashboard analitik yang interaktif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="stats" class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-school"></i>
                        </div>
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Sekolah Terpercaya</div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-number">50K+</div>
                        <div class="stat-label">Siswa Aktif</div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="stat-number">5K+</div>
                        <div class="stat-label">Guru Profesional</div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div class="stat-number">99%</div>
                        <div class="stat-label">Tingkat Kepuasan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2 class="cta-title">Siap Meningkatkan Efisiensi Sekolah Anda?</h2>
                <p class="cta-subtitle">
                    Bergabunglah dengan ratusan sekolah yang telah mempercayai Eduspace untuk mengelola operasional mereka
                </p>
                <a href="{{ route('login') }}" class="btn-cta">
                    <i class="fas fa-arrow-right"></i>
                    Mulai Gratis Sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <i class="fas fa-graduation-cap"></i>
                    Eduspace
                </div>
                <p class="footer-description">
                    Sistem Manajemen Sekolah Modern yang memudahkan pengelolaan data akademik dan administrasi sekolah dengan teknologi terkini
                </p>
                <div class="social-links">
                    <a href="#" class="social-link">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
                <div class="footer-bottom">
                    <p>&copy; 2024 Eduspace. All rights reserved. Made with <i class="fas fa-heart text-danger"></i> in Indonesia</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });
        
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Add parallax effect to hero section
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const hero = document.querySelector('.hero-section');
            if (hero) {
                hero.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        });
        
        // Counter animation for stats
        function animateCounter(element, target) {
            let current = 0;
            const increment = target / 100;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                element.textContent = Math.floor(current) + (element.textContent.includes('+') ? '+' : '') + (element.textContent.includes('K') ? 'K' : '') + (element.textContent.includes('%') ? '%' : '');
            }, 20);
        }
        
        // Trigger counter animation when stats section is visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statNumbers = entry.target.querySelectorAll('.stat-number');
                    statNumbers.forEach(stat => {
                        const text = stat.textContent;
                        if (text.includes('500+')) animateCounter(stat, 500);
                        else if (text.includes('50K+')) animateCounter(stat, 50000);
                        else if (text.includes('5K+')) animateCounter(stat, 5000);
                        else if (text.includes('99%')) animateCounter(stat, 99);
                    });
                    observer.unobserve(entry.target);
                }
            });
        });
        
        const statsSection = document.querySelector('.stats-section');
        if (statsSection) {
            observer.observe(statsSection);
        }
    </script>
</body>
</html>
