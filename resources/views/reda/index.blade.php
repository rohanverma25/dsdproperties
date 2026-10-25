<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="LucknowREDA - Lucknow Real Estate Developers Association | लखनऊ रियल एस्टेट डेवलपर्स एसोसिएशन">
    <meta name="keywords" content="Lucknow real estate developers, RERA compliance Lucknow, real estate association, LDA demolition, property developers, real estate issues Lucknow">
    <meta name="author" content="Lucknow Real Estate Developers Association">
    <title>LucknowREDA - English & Hindi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;800&family=Noto+Sans+Devanagari:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * { font-family: 'Poppins', sans-serif; }
        .hindi-text { font-family: 'Noto Sans Devanagari', sans-serif; }
        
        :root {
            --primary: #2563eb;
            --accent: #f59e0b;
        }
        
        .display-font { font-family: 'Playfair Display', serif; }
        body { background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); }
        html { scroll-behavior: smooth; }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .fade-in-up { animation: fadeInUp 0.8s ease-out forwards; }
        .slide-in-left { animation: slideInLeft 0.8s ease-out forwards; }
        .slide-in-right { animation: slideInRight 0.8s ease-out forwards; }
        .float { animation: float 3s ease-in-out infinite; }
        
        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }
        .stagger-4 { animation-delay: 0.4s; }
        .stagger-5 { animation-delay: 0.5s; }
        .stagger-6 { animation-delay: 0.6s; }
        
        .gradient-text {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 50%, #f59e0b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(37, 99, 235, 0.1);
        }
        
        .hero-gradient { background: linear-gradient(135deg, #f0f9ff 0%, #fef3c7 50%, #fce7f3 100%); }
        
        .card-hover {
            transition: all 0.4s ease;
            border: 1px solid transparent;
            background: white;
        }
        
        .card-hover:hover {
            transform: translateY(-12px);
            border-color: #2563eb;
            box-shadow: 0 20px 50px rgba(37, 99, 235, 0.15);
        }
        
        .team-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.4s ease;
            border: 1px solid #e2e8f0;
        }
        
        .team-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 25px 50px rgba(37, 99, 235, 0.15);
        }
        
        .team-card img {
            width: 100%;
            height: 280px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        
        .team-card:hover img { transform: scale(1.05); }
        
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            aspect-ratio: 1;
            cursor: pointer;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }
        
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        
        .gallery-item:hover img { transform: scale(1.1) rotate(2deg); }
        
        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.8) 0%, rgba(245, 158, 11, 0.8) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            color: white;
            font-weight: bold;
        }
        
        .gallery-item:hover .gallery-overlay { opacity: 1; }
        
        .why-card {
            background: white;
            padding: 32px;
            border-radius: 12px;
            border-left: 4px solid #2563eb;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }
        
        .why-card:hover {
            border-left-color: #f59e0b;
            transform: translateX(10px);
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.15);
        }
        
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.6);
            z-index: 50;
            backdrop-filter: blur(5px);
        }
        
        .modal-overlay.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 16px;
            padding: 32px;
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.15);
            animation: slideUp 0.3s ease-out;
            border: 1px solid rgba(37, 99, 235, 0.1);
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            transition: all 0.3s ease;
            background: white;
        }
        
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            background: #f0f9ff;
        }
        
        .form-input.error, .form-select.error, .form-textarea.error {
            border-color: #ef4444;
            background-color: #fef2f2;
        }
        
        .error-message {
            color: #ef4444;
            font-size: 13px;
            margin-top: 4px;
            display: block;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
        }
        
        /* Language Switcher Styles */
        .lang-switcher {
            display: inline-flex;
            gap: 8px;
            background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 100%);
            padding: 6px;
            border-radius: 8px;
            border: 2px solid #bfdbfe;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
        }
        
        .lang-btn {
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        
        .lang-btn.active {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        }
        
        .lang-btn:not(.active) {
            background: transparent;
            color: #2563eb;
        }
        
        .lang-btn:not(.active):hover {
            background: rgba(37, 99, 235, 0.1);
        }
    </style>
</head>
<body>
    <!-- Navigation with Language Switcher -->
    <nav class="navbar fixed w-full top-0 z-40 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="display-font text-2xl font-bold gradient-text">LUCKNOW REDA</div>
                
                <div class="hidden md:flex gap-6 items-center">
                    <a href="#about" class="text-sm font-medium text-gray-700 hover:text-blue-600 transition">About</a>
                    <a href="#why" class="text-sm font-medium text-gray-700 hover:text-blue-600 transition">Why Choose</a>
                    <a href="#team" class="text-sm font-medium text-gray-700 hover:text-blue-600 transition">Team</a>
                    <a href="#gallery" class="text-sm font-medium text-gray-700 hover:text-blue-600 transition">Gallery</a>
                    <a href="#contact" class="text-sm font-medium text-gray-700 hover:text-blue-600 transition">Contact</a>
                    
                    <!-- Language Switcher Button -->
                    <div class="lang-switcher">
                        <button class="lang-btn active" id="engBtn" onclick="switchLanguage('en')">English</button>
                        <button class="lang-btn" id="hinBtn" onclick="switchLanguage('hi')">हिंदी</button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient relative overflow-hidden pt-32 pb-20">
        <div class="absolute top-20 right-10 w-96 h-96 bg-blue-200/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-10 w-96 h-96 bg-amber-200/20 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="fade-in-up">
                    <h1 class="display-font text-5xl sm:text-6xl md:text-7xl font-bold leading-tight mb-6 text-gray-900">
                        <span class="hero-heading" data-en="United " data-hi="सभी ">United </span><span class="gradient-text hero-heading" data-en="Voice" data-hi="आवाज़">Voice</span> <span class="hero-heading" data-en="of Developers" data-hi="डेवलपर्स की">of Developers</span>
                    </h1>
                    <p class="hero-desc text-lg text-gray-700 mb-8 leading-relaxed font-medium" data-en="20+ real estate developers united to protect our projects, fight for fair RERA compliance, and raise our collective voice against unjust demolitions." data-hi="20+ रियल एस्टेट डेवलपर्स मिलकर अपनी परियोजनाओं की सुरक्षा करने, RERA की सही पालना सुनिश्चित करने, और अन्यायपूर्ण मकानों की तोड़फोड़ के खिलाफ आवाज़ उठाने के लिए एकजुट हैं।">20+ real estate developers united...</p>
                    <div class="flex gap-4 flex-wrap">
                        <button onclick="openJoinModal()" class="btn-primary px-8 py-4 rounded-lg font-semibold join-btn" data-en="Join Us Now" data-hi="अभी जुड़ें">Join Us Now</button>
                        <button onclick="openIssueModal()" class="border-2 border-blue-600 text-blue-600 bg-white hover:bg-blue-50 px-8 py-4 rounded-lg font-semibold transition issue-btn" data-en="Report Issues" data-hi="समस्या बताएं">Report Issues</button>
                    </div>
                </div>
                
                <div class="hidden md:block slide-in-right">
                    <div class="rounded-2xl shadow-2xl float overflow-hidden bg-gradient-to-br from-blue-600 to-blue-800 h-96 flex items-center justify-center">
                        <svg class="w-full h-full" viewBox="0 0 600 500" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="skyGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" style="stop-color:#e0f2fe;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#bfdbfe;stop-opacity:1" />
                                </linearGradient>
                                <linearGradient id="buildingGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" style="stop-color:#3b82f6;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#1e40af;stop-opacity:1" />
                                </linearGradient>
                            </defs>
                            <rect width="600" height="500" fill="url(#skyGradient)"/>
                            <circle cx="500" cy="80" r="40" fill="#fbbf24" opacity="0.9"/>
                            <rect x="50" y="250" width="100" height="250" fill="url(#buildingGrad)" stroke="#1e40af" stroke-width="2"/>
                            <rect x="65" y="270" width="15" height="15" fill="#fbbf24"/>
                            <rect x="85" y="270" width="15" height="15" fill="#fbbf24"/>
                            <rect x="105" y="270" width="15" height="15" fill="#fbbf24"/>
                            <rect x="65" y="295" width="15" height="15" fill="#fbbf24"/>
                            <rect x="85" y="295" width="15" height="15" fill="#fbbf24"/>
                            <rect x="105" y="295" width="15" height="15" fill="#fbbf24"/>
                            <rect x="200" y="150" width="120" height="350" fill="#2563eb" stroke="#1e40af" stroke-width="2"/>
                            <rect x="220" y="175" width="18" height="18" fill="#fbbf24"/>
                            <rect x="250" y="175" width="18" height="18" fill="#fbbf24"/>
                            <rect x="280" y="175" width="18" height="18" fill="#fbbf24"/>
                            <rect x="220" y="210" width="18" height="18" fill="#fbbf24"/>
                            <rect x="250" y="210" width="18" height="18" fill="#fbbf24"/>
                            <rect x="280" y="210" width="18" height="18" fill="#fbbf24"/>
                            <rect x="380" y="280" width="110" height="220" fill="url(#buildingGrad)" stroke="#1e40af" stroke-width="2"/>
                            <rect x="397" y="305" width="16" height="16" fill="#fbbf24"/>
                            <rect x="420" y="305" width="16" height="16" fill="#fbbf24"/>
                            <rect x="443" y="305" width="16" height="16" fill="#fbbf24"/>
                            <line x1="330" y1="120" x2="330" y2="200" stroke="#f59e0b" stroke-width="3"/>
                            <line x1="330" y1="140" x2="420" y2="100" stroke="#f59e0b" stroke-width="3"/>
                            <circle cx="420" cy="100" r="8" fill="#f59e0b"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 fade-in-up">
                <h2 class="display-font text-4xl font-bold mb-4 text-gray-900 section-title" data-en="Who We Are" data-hi="हम कौन हैं">Who We Are</h2>
                <p class="section-desc text-lg text-gray-600 max-w-3xl mx-auto" data-en="Community of 20+ real estate developers united for fair industry practices and RERA compliance" data-hi="20+ रियल एस्टेट डेवलपर्स का एक समुदाय जो उचित उद्योग प्रथाओं और RERA की पालना के लिए एकजुट है">Community of 20+ real estate developers...</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="card-hover fade-in-up stagger-1">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M10.5 1.5H5.75A2.25 2.25 0 003.5 3.75v12.5A2.25 2.25 0 005.75 18.5h8.5a2.25 2.25 0 002.25-2.25V6.5"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-center text-gray-900 card-title" data-en="Transparent Practices" data-hi="पारदर्शी तरीके">Transparent Practices</h3>
                    <p class="card-desc text-gray-600 text-center text-sm" data-en="We advocate for complete transparency in real estate development and RERA compliance" data-hi="हम रियल एस्टेट विकास और RERA की पालना में पूर्ण पारदर्शिता के लिए वकालत करते हैं">We advocate for complete transparency...</p>
                </div>
                
                <div class="card-hover fade-in-up stagger-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-center text-gray-900 card-title" data-en="Unified Advocacy" data-hi="एकजुट आवाज़">Unified Advocacy</h3>
                    <p class="card-desc text-gray-600 text-center text-sm" data-en="Our collective voice is stronger. Together we advocate for developers' rights" data-hi="हमारी सामूहिक आवाज़ ज़्यादा ताकतवर है। एक साथ हम डेवलपर्स के अधिकारों के लिए वकालत करते हैं">Our collective voice is stronger...</p>
                </div>
                
                <div class="card-hover fade-in-up stagger-3">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-center text-gray-900 card-title" data-en="Support & Solutions" data-hi="समर्थन और समाधान">Support & Solutions</h3>
                    <p class="card-desc text-gray-600 text-center text-sm" data-en="We guide developers through regulatory challenges and unfair demolition actions" data-hi="हम डेवलपर्स को नियामक चुनौतियों और अन्यायपूर्ण ध्वस्त कार्रवाइयों के माध्यम से गाइड करते हैं">We guide developers through challenges...</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 fade-in-up">
                <h2 class="display-font text-4xl font-bold mb-4 text-gray-900 section-title" data-en="Get In Touch" data-hi="हमसे संपर्क करें">Get In Touch</h2>
                <p class="section-desc text-lg text-gray-600" data-en="We're here to help and support you" data-hi="हम आपकी मदद करने के लिए यहाँ हैं">We're here to help...</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="card-hover text-center fade-in-up stagger-1">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773c.28.566.68 1.292 1.277 2.002a9.97 9.97 0 002.002 1.277l.773-1.548a1 1 0 011.06-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 4 14.18 4 9.5V5a1 1 0 011-1h2.153z"/></svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-gray-900 contact-title" data-en="Phone" data-hi="फोन">Phone</h3>
                    <p class="contact-desc text-gray-600" data-en="+91 XXXXX XXXXX" data-hi="+91 XXXXX XXXXX">+91 XXXXX XXXXX</p>
                </div>
                
                <div class="card-hover text-center fade-in-up stagger-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-gray-900 contact-title" data-en="Email" data-hi="ईमेल">Email</h3>
                    <p class="contact-desc text-gray-600">info@lucknowreda.com</p>
                </div>
                
                <div class="card-hover text-center fade-in-up stagger-3">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-gray-900 contact-title" data-en="Location" data-hi="स्थान">Location</h3>
                    <p class="contact-desc text-gray-600" data-en="Lucknow, Uttar Pradesh, India" data-hi="लखनऊ, उत्तर प्रदेश, भारत">Lucknow, Uttar Pradesh, India</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="footer-copy" data-en="© 2024 Lucknow Real Estate Developers Association. All rights reserved." data-hi="© 2024 लखनऊ रियल एस्टेट डेवलपर्स एसोसिएशन। सर्वाधिकार सुरक्षित।">© 2024 All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Join Modal -->
    <div id="joinModal" class="modal-overlay">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-6">
                <h2 class="display-font text-3xl font-bold text-gray-900 modal-title" data-en="Join Our Association" data-hi="हमारे एसोसिएशन से जुड़ें">Join Our Association</h2>
                <button onclick="closeJoinModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            <p class="modal-desc text-gray-600 mb-6" data-en="Become part of a growing community of real estate developers." data-hi="रियल एस्टेट डेवलपर्स के बढ़ते समुदाय का हिस्सा बनें।">Become part of growing community...</p>
            <form id="joinForm" onsubmit="handleJoinSubmit(event)">
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 form-label" data-en="Full Name *" data-hi="पूरा नाम *">Full Name *</label>
                    <input type="text" name="name" class="form-input" placeholder="Your full name" required>
                    <span class="error-message" id="joinNameError"></span>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 form-label" data-en="Email *" data-hi="ईमेल *">Email *</label>
                    <input type="email" name="email" class="form-input" placeholder="your@email.com" required>
                    <span class="error-message" id="joinEmailError"></span>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 form-label" data-en="Phone *" data-hi="फोन *">Phone *</label>
                    <input type="tel" name="phone" class="form-input" placeholder="+91 XXXXXXXXXX" required>
                    <span class="error-message" id="joinPhoneError"></span>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 form-label" data-en="Company Name *" data-hi="कंपनी का नाम *">Company Name *</label>
                    <input type="text" name="company" class="form-input" placeholder="Your company" required>
                    <span class="error-message" id="joinCompanyError"></span>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 form-label" data-en="Property Type *" data-hi="संपत्ति का प्रकार *">Property Type *</label>
                    <select name="propertyType" class="form-select" required>
                        <option value="">Select type</option>
                        <option value="residential">Residential</option>
                        <option value="commercial">Commercial</option>
                        <option value="mixed">Mixed</option>
                    </select>
                    <span class="error-message" id="joinPropertyError"></span>
                </div>
                <div class="flex gap-4">
                    <button type="submit" class="btn-primary flex-1 py-3 rounded-lg font-semibold modal-btn" data-en="Submit" data-hi="जमा करें">Submit</button>
                    <button type="button" onclick="closeJoinModal()" class="border-2 border-gray-300 flex-1 py-3 rounded-lg font-semibold hover:bg-gray-50 transition modal-btn" data-en="Cancel" data-hi="रद्द करें">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Issue Modal -->
    <div id="issueModal" class="modal-overlay">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-6">
                <h2 class="display-font text-3xl font-bold text-gray-900 modal-title" data-en="Report Your Issue" data-hi="अपनी समस्या बताएं">Report Your Issue</h2>
                <button onclick="closeIssueModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            <p class="modal-desc text-gray-600 mb-6" data-en="Help us understand the challenges you're facing." data-hi="हमें समझने में मदद करें कि आप किन चुनौतियों का सामना कर रहे हैं।">Help us understand challenges...</p>
            <form id="issueForm" onsubmit="handleIssueSubmit(event)">
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 form-label" data-en="Full Name *" data-hi="पूरा नाम *">Full Name *</label>
                    <input type="text" name="name" class="form-input" placeholder="Your name" required>
                    <span class="error-message" id="issueNameError"></span>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 form-label" data-en="Email *" data-hi="ईमेल *">Email *</label>
                    <input type="email" name="email" class="form-input" placeholder="your@email.com" required>
                    <span class="error-message" id="issueEmailError"></span>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 form-label" data-en="Phone *" data-hi="फोन *">Phone *</label>
                    <input type="tel" name="phone" class="form-input" placeholder="+91 XXXXXXXXXX" required>
                    <span class="error-message" id="issuePhoneError"></span>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 form-label" data-en="Project Name *" data-hi="परियोजना का नाम *">Project Name *</label>
                    <input type="text" name="projectName" class="form-input" placeholder="Project location" required>
                    <span class="error-message" id="issueProjectError"></span>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 form-label" data-en="Issue Category *" data-hi="समस्या की श्रेणी *">Issue Category *</label>
                    <select name="category" class="form-select" required>
                        <option value="">Select category</option>
                        <option value="demolition">Demolition/LDA Action</option>
                        <option value="rera">RERA Compliance</option>
                        <option value="regulatory">Regulatory Harassment</option>
                        <option value="financial">Financial Impact</option>
                    </select>
                    <span class="error-message" id="issueCategoryError"></span>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 form-label" data-en="Describe Your Issue *" data-hi="अपनी समस्या का वर्णन करें *">Describe Your Issue *</label>
                    <textarea name="description" class="form-textarea" placeholder="Detailed information..." rows="4" required></textarea>
                    <span class="error-message" id="issueDescError"></span>
                </div>
                <div class="flex gap-4">
                    <button type="submit" class="btn-primary flex-1 py-3 rounded-lg font-semibold modal-btn" data-en="Submit" data-hi="जमा करें">Submit</button>
                    <button type="button" onclick="closeIssueModal()" class="border-2 border-gray-300 flex-1 py-3 rounded-lg font-semibold hover:bg-gray-50 transition modal-btn" data-en="Cancel" data-hi="रद्द करें">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentLanguage = 'en';

        function switchLanguage(lang) {
            currentLanguage = lang;
            const engBtn = document.getElementById('engBtn');
            const hinBtn = document.getElementById('hinBtn');
            
            if (lang === 'en') {
                engBtn.classList.add('active');
                hinBtn.classList.remove('active');
            } else {
                engBtn.classList.remove('active');
                hinBtn.classList.add('active');
            }
            
            updateAllText();
        }

        function updateAllText() {
            document.querySelectorAll('[data-en][data-hi]').forEach(element => {
                const text = currentLanguage === 'en' ? element.dataset.en : element.dataset.hi;
                element.textContent = text;
                
                if (currentLanguage === 'hi') {
                    element.classList.add('hindi-text');
                } else {
                    element.classList.remove('hindi-text');
                }
            });
        }

        function openJoinModal() {
            document.getElementById('joinModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        function closeJoinModal() {
            document.getElementById('joinModal').classList.remove('active');
            document.body.style.overflow = 'auto';
            document.getElementById('joinForm').reset();
        }
        
        function openIssueModal() {
            document.getElementById('issueModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        function closeIssueModal() {
            document.getElementById('issueModal').classList.remove('active');
            document.body.style.overflow = 'auto';
            document.getElementById('issueForm').reset();
        }
        
        document.getElementById('joinModal').addEventListener('click', function(e) {
            if (e.target === this) closeJoinModal();
        });
        
        document.getElementById('issueModal').addEventListener('click', function(e) {
            if (e.target === this) closeIssueModal();
        });
        
        function validateEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }
        
        function validatePhone(phone) {
            return /^[0-9+\-\s]{10,}$/.test(phone.replace(/\s/g, ''));
        }
        
        function handleJoinSubmit(event) {
            event.preventDefault();
            const form = document.getElementById('joinForm');
            const data = new FormData(form);
            let isValid = true;
            
            if (!data.get('name') || data.get('name').length < 2) {
                document.getElementById('joinNameError').textContent = currentLanguage === 'en' ? 'Please enter valid name' : 'कृपया सही नाम दर्ज करें';
                isValid = false;
            }
            if (!validateEmail(data.get('email'))) {
                document.getElementById('joinEmailError').textContent = currentLanguage === 'en' ? 'Please enter valid email' : 'कृपया सही ईमेल दर्ज करें';
                isValid = false;
            }
            if (!validatePhone(data.get('phone'))) {
                document.getElementById('joinPhoneError').textContent = currentLanguage === 'en' ? 'Please enter valid phone' : 'कृपया सही फोन नंबर दर्ज करें';
                isValid = false;
            }
            if (!data.get('company')) {
                document.getElementById('joinCompanyError').textContent = currentLanguage === 'en' ? 'Please enter company name' : 'कृपया कंपनी का नाम दर्ज करें';
                isValid = false;
            }
            if (!data.get('propertyType')) {
                document.getElementById('joinPropertyError').textContent = currentLanguage === 'en' ? 'Please select property type' : 'कृपया संपत्ति का प्रकार चुनें';
                isValid = false;
            }
            
            if (isValid) {
                const msg = currentLanguage === 'en' ? 'Thank you! We will contact you soon. Welcome to LucknowREDA!' : 'धन्यवाद! हम जल्द ही आपसे संपर्क करेंगे। LucknowREDA में स्वागत है!';
                alert(msg);
                closeJoinModal();
            }
        }
        
        function handleIssueSubmit(event) {
            event.preventDefault();
            const form = document.getElementById('issueForm');
            const data = new FormData(form);
            let isValid = true;
            
            if (!data.get('name') || data.get('name').length < 2) {
                document.getElementById('issueNameError').textContent = currentLanguage === 'en' ? 'Please enter valid name' : 'कृपया सही नाम दर्ज करें';
                isValid = false;
            }
            if (!validateEmail(data.get('email'))) {
                document.getElementById('issueEmailError').textContent = currentLanguage === 'en' ? 'Please enter valid email' : 'कृपया सही ईमेल दर्ज करें';
                isValid = false;
            }
            if (!validatePhone(data.get('phone'))) {
                document.getElementById('issuePhoneError').textContent = currentLanguage === 'en' ? 'Please enter valid phone' : 'कृपया सही फोन नंबर दर्ज करें';
                isValid = false;
            }
            if (!data.get('projectName')) {
                document.getElementById('issueProjectError').textContent = currentLanguage === 'en' ? 'Please enter project name' : 'कृपया परियोजना का नाम दर्ज करें';
                isValid = false;
            }
            if (!data.get('category')) {
                document.getElementById('issueCategoryError').textContent = currentLanguage === 'en' ? 'Please select category' : 'कृपया श्रेणी चुनें';
                isValid = false;
            }
            if (!data.get('description') || data.get('description').length < 10) {
                document.getElementById('issueDescError').textContent = currentLanguage === 'en' ? 'Please provide details' : 'कृपया विस्तार से बताएं';
                isValid = false;
            }
            
            if (isValid) {
                const msg = currentLanguage === 'en' ? 'Thank you for reporting. We will review and contact you soon.' : 'रिपोर्ट करने के लिए धन्यवाद। हम समीक्षा करेंगे और जल्द ही आपसे संपर्क करेंगे।';
                alert(msg);
                closeIssueModal();
            }
        }
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeJoinModal();
                closeIssueModal();
            }
        });
    </script>
</body>
</html>