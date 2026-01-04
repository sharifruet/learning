<!-- Hero Section with Enhanced Design -->
<section class="hero-section">
    <div class="hero-background">
        <div class="hero-gradient"></div>
        <div class="hero-pattern"></div>
        <div class="floating-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>
    </div>
    <div class="container position-relative">
        <div class="row align-items-center min-vh-80">
            <div class="col-lg-6 col-xl-5">
                <div class="hero-content">
                    <div class="app-name-hero mb-4 fade-in-up">
                        <img src="<?= base_url('logo.png') ?>" alt="Bandhanhara Learning" class="hero-logo" style="max-height: 80px; width: auto;">
                    </div>
                    <h1 class="hero-title mb-3 fade-in-up" style="animation-delay: 0.2s">
                        Learn Anything,
                        <span class="text-gradient-advanced">Anytime, Anywhere</span>
                    </h1>
                    <p class="hero-description mb-4 fade-in-up" style="animation-delay: 0.2s">
                        Master any subject with our comprehensive, interactive courses. From programming to business, 
                        arts to sciences—learn at your own pace with expert-designed content.
                    </p>
                </div>
            </div>
            <div class="col-lg-6 col-xl-7">
                <div class="hero-visual-modern fade-in-up" style="animation-delay: 0.3s">
                    <div class="visual-container">
                        <div class="floating-card card-1">
                            <div class="card-icon">
                                <i class="bi bi-code-slash"></i>
                            </div>
                            <div class="card-content">
                                <h6>Interactive Coding</h6>
                                <p>Practice with real-time feedback</p>
                            </div>
                        </div>
                        <div class="floating-card card-2">
                            <div class="card-icon">
                                <i class="bi bi-graph-up"></i>
                            </div>
                            <div class="card-content">
                                <h6>Track Progress</h6>
                                <p>Monitor your learning journey</p>
                            </div>
                        </div>
                        <div class="floating-card card-3">
                            <div class="card-icon">
                                <i class="bi bi-trophy"></i>
                            </div>
                            <div class="card-content">
                                <h6>Earn Certificates</h6>
                                <p>Showcase your achievements</p>
                            </div>
                        </div>
                        <div class="main-visual">
                            <div class="code-window">
                                <div class="window-header">
                                    <div class="window-controls">
                                        <span class="control-dot red"></span>
                                        <span class="control-dot yellow"></span>
                                        <span class="control-dot green"></span>
                                    </div>
                                    <span class="window-title">learning.py</span>
                                </div>
                                <div class="window-body">
                                    <div class="code-line">
                                        <span class="line-number">1</span>
                                        <span class="code-text"><span class="keyword">def</span> <span class="function">start_learning</span>():</span>
                                    </div>
                                    <div class="code-line">
                                        <span class="line-number">2</span>
                                        <span class="code-text">    <span class="keyword">print</span>(<span class="string">"Welcome to Learning!"</span>)</span>
                                    </div>
                                    <div class="code-line">
                                        <span class="line-number">3</span>
                                        <span class="code-text">    <span class="keyword">return</span> <span class="string">"Success"</span></span>
                                    </div>
                                    <div class="code-line">
                                        <span class="line-number">4</span>
                                        <span class="code-text"></span>
                                    </div>
                                    <div class="code-line">
                                        <span class="line-number">5</span>
                                        <span class="code-text"><span class="comment"># Start your journey today</span></span>
                                    </div>
                                    <div class="code-line">
                                        <span class="line-number">6</span>
                                        <span class="code-text">result = <span class="function">start_learning</span>()</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Courses Section Enhanced -->
<?php if (!empty($courses)): ?>
<section class="courses-section-modern py-4">
    <div class="container">
        <div class="section-header-modern mb-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <span class="section-badge-modern">Our Courses</span>
                    <h2 class="section-title-modern mt-2 mb-2">
                        Start Learning <span class="text-gradient-advanced">Today</span>
                    </h2>
                    <p class="section-description-modern mb-0">Choose from our comprehensive courses on any subject</p>
                </div>
                <?php if (count($courses) > 3): ?>
                    <a href="<?= base_url('courses') ?>" class="btn btn-view-all">
                        View All Courses <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="row g-4 justify-content-center">
            <?php foreach ($featuredCourses as $index => $course): ?>
                <div class="col-sm-6 col-md-6 col-lg-4 mb-4">
                    <div class="course-card-enhanced">
                        <div class="course-image-enhanced">
                            <div class="course-overlay-enhanced">
                                <span class="badge-difficulty-enhanced bg-<?= $course['difficulty'] === 'beginner' ? 'success' : ($course['difficulty'] === 'intermediate' ? 'warning' : 'danger') ?>">
                                    <?= ucfirst($course['difficulty']) ?>
                                </span>
                            </div>
                            <div class="course-icon-large">
                                <i class="bi bi-filetype-py"></i>
                            </div>
                            <div class="course-gradient-overlay"></div>
                        </div>
                        <div class="course-content-enhanced">
                            <h5 class="course-title-enhanced"><?= esc($course['title']) ?></h5>
                            <p class="course-description-enhanced"><?php 
                                $description = $course['description'] ?? '';
                                $description = mb_strlen($description) > 120 ? mb_substr($description, 0, 120) . '...' : $description;
                                echo esc($description);
                            ?></p>
                            <div class="course-footer-enhanced">
                                <a href="<?= base_url('courses/' . $course['slug']) ?>" class="btn btn-course-enhanced">
                                    Start Learning <i class="bi bi-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>


<style>
/* Global font override for home page - must be very specific */
html, body, *,
.hero-section, .hero-content, .hero-title, .hero-description,
.app-name-hero, .app-name-title,
.courses-section-modern, .course-card-enhanced, .course-title-enhanced, .course-description-enhanced,
.section-header-modern, .section-title-modern, .section-badge-modern,
.btn, .btn, .btn-hero-primary-modern, .btn-course-enhanced,
h1, h2, h3, h4, h5, h6, p, span, div, a, button, input, textarea, select, label {
    font-family: Verdana, Tahoma, Arial, sans-serif !important;
}

/* Hero Section Enhanced */
.hero-section {
    position: relative;
    min-height: 75vh;
    display: flex;
    align-items: center;
    padding: 4rem 0;
    overflow: hidden;
    margin: -2rem -15px 2rem -15px;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 0;
}

.hero-gradient {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #0E9C92 0%, #0B7A73 50%, #14B8AA 100%);
    opacity: 0.95;
}

.hero-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 40% 20%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
}

.floating-shapes {
    position: absolute;
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.shape {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    animation: float 20s infinite ease-in-out;
}

.shape-1 {
    width: 300px;
    height: 300px;
    top: -150px;
    right: -150px;
    animation-delay: 0s;
}

.shape-2 {
    width: 200px;
    height: 200px;
    bottom: -100px;
    left: -100px;
    animation-delay: 5s;
}

.shape-3 {
    width: 150px;
    height: 150px;
    top: 50%;
    right: 10%;
    animation-delay: 10s;
}

@keyframes float {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    33% { transform: translate(30px, -30px) rotate(120deg); }
    66% { transform: translate(-20px, 20px) rotate(240deg); }
}

.hero-content {
    position: relative;
    z-index: 2;
    color: white;
}

.app-name-hero {
    margin-bottom: 1rem;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.hero-logo {
    filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
    transition: transform 0.3s ease;
    background: white;
    padding: 0.5rem;
    border-radius: 0.75rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.hero-logo:hover {
    transform: scale(1.05);
}

.app-name-title {
    font-size: 2rem;
    font-weight: 800;
    color: white;
    margin: 0;
    display: inline-flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.hero-badge {
    display: inline-block;
}

.badge-pulse {
    display: inline-flex;
    align-items: center;
    padding: 0.75rem 1.5rem;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 50px;
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4); }
    50% { box-shadow: 0 0 0 10px rgba(255, 255, 255, 0); }
}

.hero-title {
    font-family: Verdana, Tahoma, Arial, sans-serif !important;
    font-size: 4rem;
    font-weight: 900;
    line-height: 1.1;
    color: white;
    margin-bottom: 1.5rem;
    letter-spacing: -0.02em;
}

.text-gradient-advanced {
    background: linear-gradient(135deg, #fff 0%, #f0f0f0 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    display: inline-block;
}

.hero-description {
    font-family: Verdana, Tahoma, Arial, sans-serif !important;
    font-size: 1.25rem;
    line-height: 1.8;
    color: rgba(255, 255, 255, 0.9);
    max-width: 540px;
}

.hero-stats {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.stat-item-modern {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    padding: 1rem 1.5rem;
    border-radius: 1rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.stat-icon-modern {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.stat-number-modern {
    font-size: 2rem;
    font-weight: 800;
    color: white;
    line-height: 1;
}

.stat-label-modern {
    font-size: 0.875rem;
    color: rgba(255, 255, 255, 0.8);
    margin-top: 0.25rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.btn-hero-primary-modern {
    background: white;
    color: #0E9C92;
    font-weight: 700;
    padding: 1rem 2.5rem;
    border-radius: 12px;
    border: none;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.btn-hero-primary-modern:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    color: #0E9C92;
}

.btn-hero-secondary-modern {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
    font-weight: 700;
    padding: 1rem 2.5rem;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.btn-hero-secondary-modern:hover {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    transform: translateY(-3px);
    border-color: rgba(255, 255, 255, 0.5);
}

.hero-trust-badges {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
    margin-top: 2rem;
}

.trust-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.875rem;
}

.trust-item i {
    font-size: 1.25rem;
}

/* Hero Visual Enhanced */
.hero-visual-modern {
    position: relative;
    z-index: 2;
}

.visual-container {
    position: relative;
    height: 500px;
}

.floating-card {
    position: absolute;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    animation: floatCard 6s infinite ease-in-out;
    z-index: 3;
}

.card-1 {
    top: 10%;
    right: 10%;
    animation-delay: 0s;
}

.card-2 {
    top: 50%;
    right: 5%;
    animation-delay: 2s;
}

.card-3 {
    bottom: 10%;
    right: 15%;
    animation-delay: 4s;
}

@keyframes floatCard {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(2deg); }
}

.card-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: linear-gradient(135deg, #0E9C92, #0B7A73);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    margin-bottom: 1rem;
}

.card-content h6 {
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.card-content p {
    color: #64748b;
    font-size: 0.875rem;
    margin: 0;
}

.main-visual {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
    max-width: 500px;
}

.code-window {
    background: #1e293b;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
    transform: perspective(1000px) rotateY(-5deg) rotateX(5deg);
    transition: transform 0.3s ease;
}

.code-window:hover {
    transform: perspective(1000px) rotateY(0deg) rotateX(0deg);
}

.window-header {
    background: #334155;
    padding: 1rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.window-controls {
    display: flex;
    gap: 0.5rem;
}

.control-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.control-dot.red { background: #ef4444; }
.control-dot.yellow { background: #f59e0b; }
.control-dot.green { background: #10b981; }

.window-title {
    color: #cbd5e1;
    font-size: 0.875rem;
    font-weight: 500;
}

.window-body {
    padding: 1.5rem;
    font-family: 'Courier New', monospace;
}

.code-line {
    display: flex;
    margin-bottom: 0.5rem;
}

.line-number {
    color: #64748b;
    margin-right: 1rem;
    min-width: 30px;
    text-align: right;
}

.code-text {
    color: #e2e8f0;
}

.keyword { color: #c792ea; }
.function { color: #82aaff; }
.string { color: #c3e88d; }
.comment { color: #546e7a; font-style: italic; }

/* Features Section Enhanced */
.features-section-modern {
    background: linear-gradient(to bottom, #f8fafc, white);
    padding: 3rem 0 !important;
}

.section-header-modern {
    margin-bottom: 2rem;
}

.section-badge-modern {
    display: inline-block;
    padding: 0.5rem 1.5rem;
    background: linear-gradient(135deg, #0E9C92, #0B7A73);
    color: white;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
}

.section-title-modern {
    font-family: Verdana, Tahoma, Arial, sans-serif !important;
    font-size: 3rem;
    font-weight: 900;
    color: #1e293b;
    margin-bottom: 1rem;
    letter-spacing: -0.02em;
}

.section-description-modern {
    font-size: 1.125rem;
    color: #64748b;
    max-width: 600px;
    margin: 0 auto;
}

.feature-card-modern {
    background: white;
    border-radius: 1.5rem;
    padding: 2.5rem;
    height: 100%;
    transition: all 0.4s ease;
    border: 1px solid #e2e8f0;
    position: relative;
    overflow: hidden;
}

.feature-card-modern::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #0E9C92, #0B7A73);
    transform: scaleX(0);
    transition: transform 0.4s ease;
}

.feature-card-modern:hover::before {
    transform: scaleX(1);
}

.feature-card-modern:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    border-color: #0E9C92;
}

.feature-icon-wrapper {
    position: relative;
    margin-bottom: 1.5rem;
}

.feature-icon-modern {
    width: 80px;
    height: 80px;
    border-radius: 1.5rem;
    background: linear-gradient(135deg, #0E9C92, #0B7A73);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: white;
    position: relative;
    z-index: 2;
}

.feature-icon-modern.icon-success {
    background: linear-gradient(135deg, #10B981, #059669);
}

.feature-icon-modern.icon-warning {
    background: linear-gradient(135deg, #FFD93D, #FFC107);
}

.icon-glow {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, #0E9C92, #0B7A73);
    opacity: 0.2;
    filter: blur(20px);
    z-index: 1;
    animation: pulseGlow 2s infinite;
}

.glow-success {
    background: linear-gradient(135deg, #10B981, #059669);
}

.glow-warning {
    background: linear-gradient(135deg, #FFD93D, #FFC107);
}

@keyframes pulseGlow {
    0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.2; }
    50% { transform: translate(-50%, -50%) scale(1.2); opacity: 0.3; }
}

.feature-title-modern {
    font-size: 1.5rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 1rem;
}

.feature-description-modern {
    color: #64748b;
    line-height: 1.8;
    margin-bottom: 1.5rem;
}

.feature-link-modern {
    color: #0E9C92;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
}

.feature-link-modern:hover {
    color: #0B7A73;
    transform: translateX(5px);
}

/* Stats Section Enhanced */
.stats-section-modern {
    background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%);
    padding: 3rem 0;
    margin: 2rem -15px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
}

.stat-card-modern {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 1.5rem;
    padding: 2.5rem;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.stat-card-modern:hover {
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.2);
}

.stat-icon-large {
    font-size: 4rem;
    color: white;
    margin-bottom: 1rem;
    opacity: 0.9;
}

.stat-value-modern {
    font-size: 4rem;
    font-weight: 900;
    color: white;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stat-label-large {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.9);
    text-transform: uppercase;
    letter-spacing: 0.1em;
    font-weight: 600;
}

/* Courses Section Enhanced */
.courses-section-modern {
    background: white;
    padding: 2rem 0 !important;
}

.courses-section-modern .container {
    max-width: 1200px;
    margin: 0 auto;
}

.courses-section-modern .row.justify-content-center {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
    margin: 0;
}

/* Ensure cards fill available space with proper spacing */
@media (min-width: 992px) {
    .courses-section-modern .row.justify-content-center {
        justify-content: flex-start;
    }
    
    .courses-section-modern .row.justify-content-center .col-lg-4 {
        flex: 0 0 auto;
        width: calc(33.333333% - 1.5rem);
        margin-right: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .courses-section-modern .row.justify-content-center .col-lg-4:nth-child(3n) {
        margin-right: 0;
    }
}

@media (max-width: 991px) {
    .courses-section-modern .row.justify-content-center .col-sm-6,
    .courses-section-modern .row.justify-content-center .col-md-6 {
        margin-bottom: 1.5rem;
    }
}

.section-header-modern.mb-5 {
    margin-bottom: 1.5rem !important;
}

.section-header-modern.mb-3 {
    margin-bottom: 1.5rem !important;
}

.section-title-modern.mt-2 {
    margin-top: 0.75rem !important;
}

.section-title-modern.mb-2 {
    margin-bottom: 0.75rem !important;
}

.btn-view-all {
    background: linear-gradient(135deg, #0E9C92, #0B7A73);
    color: white;
    border: none;
    padding: 0.875rem 2rem;
    border-radius: 12px;
    font-weight: 700;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.btn-view-all:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    color: white;
}

.course-card-enhanced {
    background: white;
    border-radius: 1.5rem;
    overflow: hidden;
    transition: all 0.4s ease;
    border: 1px solid #e2e8f0;
    height: 100%;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    width: 100%;
}

.course-card-enhanced:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    border-color: #0E9C92;
}

.course-image-enhanced {
    height: 180px;
    background: linear-gradient(135deg, #0E9C92, #0B7A73);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.course-gradient-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.2));
}

.course-icon-large {
    font-size: 5rem;
    color: white;
    position: relative;
    z-index: 2;
    opacity: 0.9;
}

.course-overlay-enhanced {
    position: absolute;
    top: 1rem;
    right: 1rem;
    z-index: 3;
}

.badge-difficulty-enhanced {
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-weight: 700;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.course-content-enhanced {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.course-title-enhanced {
    font-family: Verdana, Tahoma, Arial, sans-serif !important;
    font-size: 1.5rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 1rem;
    line-height: 1.3;
}

.course-description-enhanced {
    color: #64748b;
    line-height: 1.7;
    margin-bottom: 1.5rem;
    flex: 1;
}

.course-footer-enhanced {
    margin-top: auto;
}

.btn-course-enhanced {
    width: 100%;
    background: linear-gradient(135deg, #0E9C92, #0B7A73);
    color: white;
    border: none;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    font-weight: 700;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-course-enhanced:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    color: white;
}

/* How It Works Enhanced */
.how-it-works-modern {
    background: linear-gradient(to bottom, white, #f8fafc);
    padding: 3rem 0 !important;
}

.step-card-modern {
    text-align: center;
    padding: 2.5rem 2rem;
    background: white;
    border-radius: 1.5rem;
    transition: all 0.4s ease;
    border: 1px solid #e2e8f0;
    height: 100%;
    position: relative;
    overflow: hidden;
}

.step-card-modern::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #0E9C92, #0B7A73);
    transform: scaleX(0);
    transition: transform 0.4s ease;
}

.step-card-modern:hover::before {
    transform: scaleX(1);
}

.step-card-modern:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
}

.step-number-modern {
    font-size: 5rem;
    font-weight: 900;
    background: linear-gradient(135deg, #0E9C92, #0B7A73);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1;
    margin-bottom: 1rem;
    opacity: 0.15;
}

.step-icon-modern {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: linear-gradient(135deg, #0E9C92, #0B7A73);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: white;
    margin: -4rem auto 1.5rem;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    position: relative;
    z-index: 2;
}

.step-title-modern {
    font-size: 1.5rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 1rem;
}

.step-description-modern {
    color: #64748b;
    line-height: 1.8;
}

/* CTA Section Enhanced */
.cta-section-modern {
    background: white;
    padding: 3rem 0 !important;
}

.cta-card-modern {
    background: linear-gradient(135deg, #0E9C92, #0B7A73);
    border-radius: 2rem;
    padding: 3rem;
    color: white;
    box-shadow: 0 25px 60px rgba(102, 126, 234, 0.3);
    position: relative;
    overflow: hidden;
}

.cta-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
    opacity: 0.5;
}

.cta-title-modern {
    font-size: 3rem;
    font-weight: 900;
    color: white;
    margin-bottom: 1rem;
    letter-spacing: -0.02em;
}

.cta-description-modern {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.95);
    line-height: 1.8;
}

.btn-cta-primary-modern {
    background: white;
    color: #0E9C92;
    font-weight: 700;
    padding: 1rem 2.5rem;
    border-radius: 12px;
    border: none;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.btn-cta-primary-modern:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    color: #0E9C92;
}

.btn-cta-secondary-modern {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
    font-weight: 700;
    padding: 1rem 2.5rem;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.btn-cta-secondary-modern:hover {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    transform: translateY(-3px);
    border-color: rgba(255, 255, 255, 0.5);
}

/* Responsive Design */
@media (max-width: 992px) {
    .hero-title {
        font-size: 3rem;
    }
    
    .section-title-modern {
        font-size: 2.5rem;
    }
    
    .cta-title-modern {
        font-size: 2.5rem;
    }
    
    .visual-container {
        height: 400px;
    }
    
    .floating-card {
        display: none;
    }
}

@media (max-width: 768px) {
    .hero-section {
        min-height: auto;
        padding: 4rem 0;
    }
    
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-description {
        font-size: 1.125rem;
    }
    
    .hero-stats {
        gap: 1rem;
    }
    
    .stat-item-modern {
        flex: 1;
        min-width: 140px;
    }
    
    .section-title-modern {
        font-size: 2rem;
    }
    
    .cta-title-modern {
        font-size: 2rem;
    }
    
    .code-window {
        transform: none;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .stat-value-modern {
        font-size: 3rem;
    }
}

/* Animation Utilities */
.fade-in-up {
    animation: fadeInUp 0.8s ease-out forwards;
    opacity: 0;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.min-vh-80 {
    min-height: 65vh;
}

/* Reduce spacing in section titles */
.section-title-modern.mt-4 {
    margin-top: 1.5rem !important;
}

/* Reduce padding in feature cards */
.feature-card-modern {
    padding: 2rem;
}

/* Reduce padding in step cards */
.step-card-modern {
    padding: 2rem 1.5rem;
}
</style>
