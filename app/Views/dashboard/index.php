<div class="fade-in-up">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="mb-2">Welcome back, <span class="text-gradient"><?= esc(session()->get('first_name') ?: session()->get('username')) ?></span>!</h2>
            <p class="lead mb-0">Continue your Python learning journey</p>
        </div>
    </div>

    <?php if (!empty($courses)): ?>
        <h3 class="mb-4"><i class="bi bi-bookmark-check"></i> My Courses</h3>
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
                                <?php if (isset($course['progress'])): ?>
                                    <span class="badge bg-info ms-1">
                                        <i class="bi bi-graph-up"></i> <?= $course['progress'] ?> lessons
                                    </span>
                                <?php endif; ?>
                            </div>
                            <h5 class="card-title"><?= esc($course['title']) ?></h5>
                            <p class="card-text"><?= esc($course['description']) ?></p>
                            <a href="<?= base_url('courses/' . $course['id']) ?>" class="btn btn-primary w-100">
                                <i class="bi bi-play-circle"></i> Continue Learning
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
                <div class="flex-grow-1">
                    <h5 class="mb-2">No courses yet</h5>
                    <p class="mb-3">Start learning by browsing our available courses.</p>
                    <a href="<?= base_url('courses') ?>" class="btn btn-primary">
                        <i class="bi bi-search"></i> Browse Courses
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
