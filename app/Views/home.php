<!-- Hero Section with Modern Design -->
<section class="hero-modern fade-in-up">
    <div class="container">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-6">
                <div class="hero-content">
                    <div class="badge-hero mb-4">
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                            <i class="bi bi-star-fill me-2"></i>Start Learning Today
                        </span>
                    </div>
                    <h1 class="hero-title mb-4">
                        Master Python Programming
                        <span class="text-gradient d-block mt-2">From Zero to Hero</span>
                    </h1>
                    <p class="hero-description mb-4">
                        Learn Python with interactive lessons, hands-on coding exercises, and real-world projects. 
                        Build your skills step-by-step with our comprehensive curriculum designed for all levels.
                    </p>
                    <div class="hero-stats mb-4">
                        <div class="stat-item">
                            <div class="stat-number"><?= $courseCount > 0 ? $courseCount : '10+' ?></div>
                            <div class="stat-label">Courses</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number"><?= $totalLessons > 0 ? $totalLessons : '50+' ?></div>
                            <div class="stat-label">Lessons</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">100%</div>
                            <div class="stat-label">Free</div>
                        </div>
                    </div>
                    <div class="hero-actions d-flex gap-3 flex-wrap">
                        <?php if (!session()->has('user_id')): ?>
                            <a href="<?= base_url('auth/register') ?>" class="btn btn-hero-primary btn-lg">
                                <i class="bi bi-rocket-takeoff me-2"></i>Get Started Free
                            </a>
                            <a href="<?= base_url('courses') ?>" class="btn btn-hero-outline btn-lg">
                                <i class="bi bi-play-circle me-2"></i>Watch Demo
                            </a>
                        <?php else: ?>
                            <a href="<?= base_url('courses') ?>" class="btn btn-hero-primary btn-lg">
                                <i class="bi bi-book me-2"></i>Browse Courses
                            </a>
                            <a href="<?= base_url('dashboard') ?>" class="btn btn-hero-outline btn-lg">
                                <i class="bi bi-speedometer2 me-2"></i>My Dashboard
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-visual">
                    <div class="code-preview">
                        <div class="code-header">
                            <div class="code-dots">
                                <span></span><span></span><span></span>
                            </div>
                            <span class="code-title">python_learning.py</span>
                        </div>
                        <div class="code-body">
                            <pre><code><span class="code-keyword">def</span> <span class="code-function">learn_python</span>():
    <span class="code-string">"""Start your Python journey"""</span>
    <span class="code-keyword">print</span>(<span class="code-string">"Hello, Python!"</span>)
    <span class="code-keyword">return</span> <span class="code-string">"Success"</span>

<span class="code-comment"># Join thousands of learners</span>
result = learn_python()</code></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section with Modern Cards -->
<section class="features-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5 fade-in-up">
            <span class="section-badge">Why Choose Us</span>
            <h2 class="section-title mt-3 mb-3">
                Everything You Need to <span class="text-gradient">Master Python</span>
            </h2>
            <p class="section-description">A comprehensive learning platform designed to take you from beginner to expert</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4 fade-in-up" style="animation-delay: 0.1s">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-code-square"></i>
                    </div>
                    <h4 class="feature-title">Interactive Learning</h4>
                    <p class="feature-description">
                        Learn by doing with hands-on coding exercises, real-time feedback, and interactive code editors.
                    </p>
                    <div class="feature-link">
                        <a href="#" class="text-primary text-decoration-none">
                            Learn more <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 fade-in-up" style="animation-delay: 0.2s">
                <div class="feature-card">
                    <div class="feature-icon bg-success bg-opacity-10 text-success">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <h4 class="feature-title">Track Progress</h4>
                    <p class="feature-description">
                        Monitor your learning journey with detailed progress tracking, achievements, and personalized insights.
                    </p>
                    <div class="feature-link">
                        <a href="#" class="text-success text-decoration-none">
                            Learn more <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 fade-in-up" style="animation-delay: 0.3s">
                <div class="feature-card">
                    <div class="feature-icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-trophy"></i>
                    </div>
                    <h4 class="feature-title">Real Projects</h4>
                    <p class="feature-description">
                        Build practical projects that showcase your Python skills and prepare you for real-world challenges.
                    </p>
                    <div class="feature-link">
                        <a href="#" class="text-warning text-decoration-none">
                            Learn more <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<?php if ($courseCount > 0 || $totalModules > 0 || $totalLessons > 0): ?>
<section class="stats-section py-5">
    <div class="container">
        <div class="stats-card fade-in-up">
            <div class="row g-4 text-center">
                <?php if ($courseCount > 0): ?>
                <div class="col-md-4">
                    <div class="stat-box">
                        <div class="stat-icon">
                            <i class="bi bi-book"></i>
                        </div>
                        <div class="stat-value"><?= $courseCount ?></div>
                        <div class="stat-label"><?= $courseCount === 1 ? 'Course' : 'Courses' ?></div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ($totalModules > 0): ?>
                <div class="col-md-4">
                    <div class="stat-box">
                        <div class="stat-icon">
                            <i class="bi bi-folder"></i>
                        </div>
                        <div class="stat-value"><?= $totalModules ?></div>
                        <div class="stat-label"><?= $totalModules === 1 ? 'Module' : 'Modules' ?></div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ($totalLessons > 0): ?>
                <div class="col-md-4">
                    <div class="stat-box">
                        <div class="stat-icon">
                            <i class="bi bi-file-text"></i>
                        </div>
                        <div class="stat-value"><?= $totalLessons ?></div>
                        <div class="stat-label"><?= $totalLessons === 1 ? 'Lesson' : 'Lessons' ?></div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Courses Section -->
<?php if (!empty($courses)): ?>
<section class="courses-section py-5">
    <div class="container">
        <div class="section-header mb-5 fade-in-up">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <span class="section-badge">Our Courses</span>
                    <h2 class="section-title mt-3 mb-2">
                        Start Learning <span class="text-gradient">Today</span>
                    </h2>
                    <p class="section-description mb-0">Choose from our comprehensive Python courses</p>
                </div>
                <?php if (count($courses) > 3): ?>
                    <a href="<?= base_url('courses') ?>" class="btn btn-outline-primary mt-3">
                        View All Courses <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="row g-4">
            <?php foreach ($featuredCourses as $index => $course): ?>
                <div class="col-md-4 fade-in-up" style="animation-delay: <?= ($index + 1) * 0.1 ?>s">
                    <div class="course-card-modern">
                        <div class="course-image-modern">
                            <div class="course-overlay">
                                <span class="badge-difficulty bg-<?= $course['difficulty'] === 'beginner' ? 'success' : ($course['difficulty'] === 'intermediate' ? 'warning' : 'danger') ?>">
                                    <?= ucfirst($course['difficulty']) ?>
                                </span>
                            </div>
                            <i class="bi bi-filetype-py"></i>
                        </div>
                        <div class="course-content">
                            <h5 class="course-title"><?= esc($course['title']) ?></h5>
                            <p class="course-description"><?= esc($course['description']) ?></p>
                            <div class="course-footer">
                                <a href="<?= base_url('courses/' . $course['id']) ?>" class="btn btn-course">
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
<?php else: ?>
<!-- Coming Soon Section -->
<section class="courses-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5 fade-in-up">
            <span class="section-badge">Coming Soon</span>
            <h2 class="section-title mt-3 mb-3">
                Exciting Courses <span class="text-gradient">On The Way</span>
            </h2>
            <p class="section-description">We're preparing amazing Python courses for you!</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4 fade-in-up" style="animation-delay: 0.1s">
                <div class="course-card-modern coming-soon">
                    <div class="course-image-modern">
                        <div class="course-overlay">
                            <span class="badge-difficulty bg-success">Beginner</span>
                        </div>
                        <i class="bi bi-filetype-py"></i>
                    </div>
                    <div class="course-content">
                        <h5 class="course-title">Python Basics</h5>
                        <p class="course-description">
                            Learn the fundamentals of Python programming, including variables, data types, 
                            control structures, and basic operations.
                        </p>
                        <div class="course-footer">
                            <button class="btn btn-course" disabled>
                                <i class="bi bi-clock me-2"></i>Coming Soon
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 fade-in-up" style="animation-delay: 0.2s">
                <div class="course-card-modern coming-soon">
                    <div class="course-image-modern">
                        <div class="course-overlay">
                            <span class="badge-difficulty bg-warning">Intermediate</span>
                        </div>
                        <i class="bi bi-filetype-py"></i>
                    </div>
                    <div class="course-content">
                        <h5 class="course-title">Python Advanced</h5>
                        <p class="course-description">
                            Dive deeper into Python with advanced topics like decorators, generators, 
                            object-oriented programming, and design patterns.
                        </p>
                        <div class="course-footer">
                            <button class="btn btn-course" disabled>
                                <i class="bi bi-clock me-2"></i>Coming Soon
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 fade-in-up" style="animation-delay: 0.3s">
                <div class="course-card-modern coming-soon">
                    <div class="course-image-modern">
                        <div class="course-overlay">
                            <span class="badge-difficulty bg-danger">Advanced</span>
                        </div>
                        <i class="bi bi-filetype-py"></i>
                    </div>
                    <div class="course-content">
                        <h5 class="course-title">Python Projects</h5>
                        <p class="course-description">
                            Build real-world applications and projects to showcase your Python programming 
                            expertise and prepare for professional development.
                        </p>
                        <div class="course-footer">
                            <button class="btn btn-course" disabled>
                                <i class="bi bi-clock me-2"></i>Coming Soon
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- How It Works Section -->
<section class="how-it-works-section py-5 bg-light">
    <div class="container">
        <div class="section-header text-center mb-5 fade-in-up">
            <span class="section-badge">Simple Process</span>
            <h2 class="section-title mt-3 mb-3">
                How It <span class="text-gradient">Works</span>
            </h2>
            <p class="section-description">Get started in just a few simple steps</p>
        </div>
        <div class="row g-4">
            <div class="col-md-3 col-sm-6 fade-in-up" style="animation-delay: 0.1s">
                <div class="step-card">
                    <div class="step-number">01</div>
                    <div class="step-icon">
                        <i class="bi bi-person-plus"></i>
                    </div>
                    <h5 class="step-title">Sign Up</h5>
                    <p class="step-description">Create your free account in seconds with email or social login</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 fade-in-up" style="animation-delay: 0.2s">
                <div class="step-card">
                    <div class="step-number">02</div>
                    <div class="step-icon">
                        <i class="bi bi-book"></i>
                    </div>
                    <h5 class="step-title">Choose Course</h5>
                    <p class="step-description">Browse our Python courses and pick one that matches your skill level</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 fade-in-up" style="animation-delay: 0.3s">
                <div class="step-card">
                    <div class="step-number">03</div>
                    <div class="step-icon">
                        <i class="bi bi-code-slash"></i>
                    </div>
                    <h5 class="step-title">Learn & Practice</h5>
                    <p class="step-description">Follow interactive lessons and complete hands-on coding exercises</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 fade-in-up" style="animation-delay: 0.4s">
                <div class="step-card">
                    <div class="step-number">04</div>
                    <div class="step-icon">
                        <i class="bi bi-rocket-takeoff"></i>
                    </div>
                    <h5 class="step-title">Build Projects</h5>
                    <p class="step-description">Apply your knowledge by building real-world Python projects</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<?php if (!session()->has('user_id')): ?>
<section class="cta-section py-5">
    <div class="container">
        <div class="cta-card fade-in-up">
            <div class="row align-items-center">
                <div class="col-lg-8 text-center text-lg-start">
                    <h2 class="cta-title mb-3">Ready to Start Your Python Journey?</h2>
                    <p class="cta-description mb-0">
                        Join thousands of learners mastering Python programming. Start learning today for free!
                    </p>
                </div>
                <div class="col-lg-4 text-center text-lg-end mt-4 mt-lg-0">
                    <a href="<?= base_url('auth/register') ?>" class="btn btn-cta-primary btn-lg me-2 mb-2">
                        <i class="bi bi-rocket-takeoff me-2"></i>Get Started Free
                    </a>
                    <a href="<?= base_url('courses') ?>" class="btn btn-cta-outline btn-lg mb-2">
                        <i class="bi bi-book me-2"></i>Explore Courses
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<style>
/* Hero Section Styles */
.hero-modern {
    padding: 4rem 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
    margin: -2rem -15px 4rem -15px;
    padding: 6rem 2rem;
}

.hero-modern::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.3;
}

.hero-modern .container {
    position: relative;
    z-index: 1;
}

.min-vh-75 {
    min-height: 75vh;
}

.hero-content {
    color: white;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    line-height: 1.2;
    color: white;
    margin-bottom: 1.5rem;
}

.hero-description {
    font-size: 1.25rem;
    line-height: 1.8;
    opacity: 0.95;
    color: rgba(255, 255, 255, 0.95);
}

.hero-stats {
    display: flex;
    gap: 3rem;
    margin-top: 2rem;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: white;
    line-height: 1;
}

.stat-label {
    font-size: 0.875rem;
    opacity: 0.9;
    margin-top: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.btn-hero-primary {
    background: white;
    color: #667eea;
    font-weight: 600;
    padding: 1rem 2rem;
    border-radius: 0.75rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.btn-hero-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    color: #667eea;
}

.btn-hero-outline {
    background: transparent;
    color: white;
    border: 2px solid white;
    font-weight: 600;
    padding: 1rem 2rem;
    border-radius: 0.75rem;
    transition: all 0.3s ease;
}

.btn-hero-outline:hover {
    background: white;
    color: #667eea;
    transform: translateY(-2px);
}

/* Code Preview */
.hero-visual {
    position: relative;
}

.code-preview {
    background: #1e293b;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    transform: perspective(1000px) rotateY(-5deg);
    transition: transform 0.3s ease;
}

.code-preview:hover {
    transform: perspective(1000px) rotateY(0deg);
}

.code-header {
    background: #334155;
    padding: 1rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.code-dots {
    display: flex;
    gap: 0.5rem;
}

.code-dots span {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #64748b;
}

.code-dots span:nth-child(1) { background: #ef4444; }
.code-dots span:nth-child(2) { background: #f59e0b; }
.code-dots span:nth-child(3) { background: #10b981; }

.code-title {
    color: #cbd5e1;
    font-size: 0.875rem;
    font-weight: 500;
}

.code-body {
    padding: 1.5rem;
}

.code-body pre {
    margin: 0;
    background: transparent;
    color: #e2e8f0;
    font-size: 0.875rem;
    line-height: 1.8;
}

.code-keyword { color: #c792ea; }
.code-function { color: #82aaff; }
.code-string { color: #c3e88d; }
.code-comment { color: #546e7a; font-style: italic; }

/* Features Section */
.features-section {
    background: white;
}

.section-header {
    margin-bottom: 3rem;
}

.section-badge {
    display: inline-block;
    padding: 0.5rem 1.25rem;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-radius: 2rem;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 1rem;
}

.section-description {
    font-size: 1.125rem;
    color: #64748b;
    max-width: 600px;
    margin: 0 auto;
}

.feature-card {
    background: white;
    border-radius: 1.5rem;
    padding: 2.5rem;
    height: 100%;
    transition: all 0.3s ease;
    border: 1px solid #e2e8f0;
    position: relative;
    overflow: hidden;
}

.feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.feature-card:hover::before {
    transform: scaleX(1);
}

.feature-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    border-color: #667eea;
}

.feature-icon {
    width: 70px;
    height: 70px;
    border-radius: 1rem;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    margin-bottom: 1.5rem;
}

.feature-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1rem;
}

.feature-description {
    color: #64748b;
    line-height: 1.7;
    margin-bottom: 1.5rem;
}

.feature-link a {
    font-weight: 600;
    transition: all 0.3s ease;
}

.feature-link a:hover {
    gap: 0.5rem;
}

/* Stats Section */
.stats-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    margin: 4rem -15px;
    padding: 4rem 2rem;
}

.stats-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 2rem;
    padding: 3rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.stat-box {
    color: white;
}

.stat-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.9;
}

.stat-value {
    font-size: 3.5rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 1.125rem;
    opacity: 0.9;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Course Cards Modern */
.courses-section {
    background: white;
}

.course-card-modern {
    background: white;
    border-radius: 1.5rem;
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid #e2e8f0;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.course-card-modern:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.course-card-modern.coming-soon {
    opacity: 0.8;
}

.course-image-modern {
    height: 200px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 4rem;
    color: white;
    position: relative;
    overflow: hidden;
}

.course-overlay {
    position: absolute;
    top: 1rem;
    right: 1rem;
}

.badge-difficulty {
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.course-content {
    padding: 2rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.course-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1rem;
}

.course-description {
    color: #64748b;
    line-height: 1.7;
    margin-bottom: 1.5rem;
    flex: 1;
}

.course-footer {
    margin-top: auto;
}

.btn-course {
    width: 100%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
    padding: 0.875rem 1.5rem;
    border-radius: 0.75rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-course:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-course:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* How It Works */
.how-it-works-section {
    background: #f8fafc;
}

.step-card {
    text-align: center;
    padding: 2rem;
    background: white;
    border-radius: 1.5rem;
    transition: all 0.3s ease;
    border: 1px solid #e2e8f0;
    height: 100%;
}

.step-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.step-number {
    font-size: 4rem;
    font-weight: 800;
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1;
    margin-bottom: 1rem;
    opacity: 0.2;
}

.step-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    margin: -3rem auto 1.5rem;
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.step-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.75rem;
}

.step-description {
    color: #64748b;
    line-height: 1.7;
}

/* CTA Section */
.cta-section {
    background: white;
}

.cta-card {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 2rem;
    padding: 4rem;
    color: white;
    box-shadow: 0 20px 60px rgba(102, 126, 234, 0.3);
}

.cta-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: white;
    margin-bottom: 1rem;
}

.cta-description {
    font-size: 1.25rem;
    opacity: 0.95;
    color: rgba(255, 255, 255, 0.95);
}

.btn-cta-primary {
    background: white;
    color: #667eea;
    font-weight: 600;
    padding: 1rem 2rem;
    border-radius: 0.75rem;
    transition: all 0.3s ease;
}

.btn-cta-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    color: #667eea;
}

.btn-cta-outline {
    background: transparent;
    color: white;
    border: 2px solid white;
    font-weight: 600;
    padding: 1rem 2rem;
    border-radius: 0.75rem;
    transition: all 0.3s ease;
}

.btn-cta-outline:hover {
    background: white;
    color: #667eea;
    transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-description {
        font-size: 1.125rem;
    }
    
    .hero-stats {
        gap: 2rem;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .code-preview {
        transform: none;
        margin-top: 2rem;
    }
    
    .cta-title {
        font-size: 2rem;
    }
    
    .stat-value {
        font-size: 2.5rem;
    }
}
</style>
