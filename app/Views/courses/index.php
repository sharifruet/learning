<div class="fade-in-up">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="mb-2"><span class="text-gradient">All Courses</span></h2>
            <p class="lead mb-0">Choose a course to start your Python learning journey</p>
        </div>
    </div>

    <?php if (!empty($courses)): ?>
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
</div>
