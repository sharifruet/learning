<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('courses') ?>" class="text-decoration-none"><i class="bi bi-book"></i> Courses</a></li>
        <li class="breadcrumb-item active"><?= esc($course['title']) ?></li>
    </ol>
</nav>

<div class="row">
    <div class="col-lg-8">
        <!-- Course Header -->
        <div class="card shadow-lg mb-4 fade-in-up">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="flex-grow-1">
                        <h2 class="mb-2"><?= esc($course['title']) ?></h2>
                        <p class="lead text-muted mb-3"><?= esc($course['description']) ?></p>
                    </div>
                </div>
                
                <!-- Course Meta Information -->
                <div class="mb-3">
                    <span class="badge bg-<?= $course['difficulty'] === 'beginner' ? 'success' : ($course['difficulty'] === 'intermediate' ? 'warning' : 'danger') ?> me-2">
                        <i class="bi bi-<?= $course['difficulty'] === 'beginner' ? 'star' : ($course['difficulty'] === 'intermediate' ? 'star-half' : 'star-fill') ?>"></i>
                        <?= ucfirst($course['difficulty']) ?>
                    </span>
                    <?php if (isset($course['category']) && !empty($course['category'])): ?>
                        <span class="badge bg-secondary me-2">
                            <i class="bi bi-tag"></i> <?= esc($course['category']['name']) ?>
                        </span>
                    <?php endif; ?>
                    <?php if (isset($course['is_free']) && $course['is_free']): ?>
                        <span class="badge bg-success me-2">
                            <i class="bi bi-check-circle"></i> Free
                        </span>
                    <?php endif; ?>
                    <?php if (isset($course['is_self_paced']) && $course['is_self_paced']): ?>
                        <span class="badge bg-info me-2">
                            <i class="bi bi-clock"></i> Self-Paced
                        </span>
                    <?php endif; ?>
                    <?php if (isset($enrollmentCount)): ?>
                        <span class="badge bg-primary">
                            <i class="bi bi-people"></i> <?= $enrollmentCount ?> enrolled
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Instructor Info -->
                <?php if (isset($course['instructor']) && !empty($course['instructor'])): ?>
                    <div class="mb-3">
                        <strong><i class="bi bi-person-circle me-2"></i>Instructor:</strong>
                        <?= esc($course['instructor']['first_name'] . ' ' . $course['instructor']['last_name']) ?>
                    </div>
                <?php endif; ?>

                <!-- Course Tags -->
                <?php if (!empty($course['tags'])): ?>
                    <div class="mb-3">
                        <?php 
                        $tags = explode(',', $course['tags']);
                        foreach ($tags as $tag): 
                            $tag = trim($tag);
                            if (!empty($tag)):
                        ?>
                            <span class="badge bg-light text-dark me-1"><?= esc($tag) ?></span>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </div>
                <?php endif; ?>

                <!-- Enrollment Button -->
                <div class="mt-4">
                    <?php if (session()->has('user_id')): ?>
                        <?php if ($isEnrolled): ?>
                            <a href="<?= base_url('courses/' . $course['id']) ?>" class="btn btn-success btn-lg me-2">
                                <i class="bi bi-check-circle me-2"></i>Enrolled - Continue Learning
                            </a>
                            <?php if (isset($progress)): ?>
                                <div class="mt-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Progress</span>
                                        <span><?= $progress['percentage'] ?>%</span>
                                    </div>
                                    <div class="progress" style="height: 25px;">
                                        <div class="progress-bar bg-success" role="progressbar" 
                                             style="width: <?= $progress['percentage'] ?>%" 
                                             aria-valuenow="<?= $progress['percentage'] ?>" 
                                             aria-valuemin="0" aria-valuemax="100">
                                            <?= $progress['completed'] ?> / <?= $progress['total'] ?> lessons
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if ($course['enrollment_type'] === 'open'): ?>
                                <form method="POST" action="<?= base_url('enroll/' . $course['id']) ?>" class="d-inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-plus-circle me-2"></i>Enroll Now - Free
                                    </button>
                                </form>
                            <?php elseif ($course['enrollment_type'] === 'approval_required'): ?>
                                <button type="button" class="btn btn-warning btn-lg" disabled>
                                    <i class="bi bi-hourglass-split me-2"></i>Approval Required
                                </button>
                            <?php else: ?>
                                <button type="button" class="btn btn-secondary btn-lg" disabled>
                                    <i class="bi bi-lock me-2"></i>Enrollment Closed
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="<?= base_url('auth/login') ?>" class="btn btn-primary btn-lg">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Log In to Enroll
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Course Syllabus -->
        <?php if (!empty($course['syllabus'])): ?>
            <div class="card shadow-sm mb-4 fade-in-up">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-list-check me-2"></i>Course Syllabus</h5>
                </div>
                <div class="card-body">
                    <div class="syllabus-content">
                        <?= nl2br(esc($course['syllabus'])) ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Course Modules -->
        <?php if (!empty($course['modules'])): ?>
            <h3 class="mb-4"><span class="text-gradient">Course Modules</span></h3>
            <div class="row g-4 fade-in-up">
                <?php foreach ($course['modules'] as $index => $module): ?>
                    <div class="col-md-6" style="animation-delay: <?= $index * 0.1 ?>s">
                        <div class="card h-100 fade-in-up shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                        <span class="fw-bold fs-5"><?= $index + 1 ?></span>
                                    </div>
                                    <h5 class="card-title mb-0"><?= esc($module['title']) ?></h5>
                                </div>
                                <?php if (!empty($module['description'])): ?>
                                    <p class="card-text text-muted mb-3"><?= esc($module['description']) ?></p>
                                <?php endif; ?>
                                <?php if ($isEnrolled): ?>
                                    <a href="<?= base_url('courses/' . $course['id'] . '/module/' . $module['id']) ?>" class="btn btn-primary">
                                        <i class="bi bi-arrow-right-circle me-2"></i>View Module
                                    </a>
                                <?php else: ?>
                                    <button type="button" class="btn btn-outline-secondary" disabled>
                                        <i class="bi bi-lock me-2"></i>Enroll to Access
                                    </button>
                                <?php endif; ?>
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
                        <h5 class="mb-1">No modules available</h5>
                        <p class="mb-0">This course doesn't have any modules yet.</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <div class="card shadow-sm mb-4 fade-in-up">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Course Information</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <strong><i class="bi bi-calendar me-2"></i>Created:</strong>
                        <?= date('F Y', strtotime($course['created_at'])) ?>
                    </li>
                    <li class="mb-2">
                        <strong><i class="bi bi-clock me-2"></i>Pace:</strong>
                        <?= isset($course['is_self_paced']) && $course['is_self_paced'] ? 'Self-Paced' : 'Scheduled' ?>
                    </li>
                    <li class="mb-2">
                        <strong><i class="bi bi-currency-dollar me-2"></i>Price:</strong>
                        <?= isset($course['is_free']) && $course['is_free'] ? 'Free' : 'Paid' ?>
                    </li>
                    <?php if (isset($course['capacity']) && !empty($course['capacity'])): ?>
                        <li class="mb-2">
                            <strong><i class="bi bi-people me-2"></i>Capacity:</strong>
                            <?= $course['capacity'] ?> students
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
