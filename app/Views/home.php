<div class="hero-section fade-in-up">
    <h1>Master Python Programming</h1>
    <p class="lead">Learn Python with interactive lessons, hands-on exercises, and real-world projects</p>
    <?php if (!session()->has('user_id')): ?>
        <a href="<?= base_url('auth/register') ?>" class="btn btn-light btn-lg mt-3">
            <i class="bi bi-rocket-takeoff"></i> Get Started Free
        </a>
    <?php else: ?>
        <a href="<?= base_url('courses') ?>" class="btn btn-light btn-lg mt-3">
            <i class="bi bi-book"></i> Browse Courses
        </a>
    <?php endif; ?>
</div>

<?php if (!empty($courses)): ?>
    <div class="fade-in-up">
        <h2 class="text-center mb-5">
            <span class="text-gradient">Featured Courses</span>
        </h2>
        <div class="row g-4">
            <?php foreach ($courses as $index => $course): ?>
                <div class="col-md-4" style="animation-delay: <?= $index * 0.1 ?>s">
                    <div class="card course-card h-100 fade-in-up">
                        <div class="course-image">
                            <i class="bi bi-filetype-py"></i>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <span class="badge bg-<?= $course['difficulty'] === 'beginner' ? 'success' : ($course['difficulty'] === 'intermediate' ? 'warning' : 'danger') ?>">
                                    <?= ucfirst($course['difficulty']) ?>
                                </span>
                            </div>
                            <h5 class="card-title"><?= esc($course['title']) ?></h5>
                            <p class="card-text"><?= esc($course['description']) ?></p>
                            <a href="<?= base_url('courses/' . $course['id']) ?>" class="btn btn-primary w-100">
                                <i class="bi bi-arrow-right-circle"></i> View Course
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-info fade-in-up">
        <div class="d-flex align-items-center">
            <i class="bi bi-info-circle-fill me-3 fs-3"></i>
            <div>
                <h5 class="mb-1">No courses available yet</h5>
                <p class="mb-0">Check back soon for exciting Python courses!</p>
            </div>
        </div>
    </div>
<?php endif; ?>
