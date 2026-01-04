<div class="fade-in-up">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="mb-2">Welcome back, <span class="text-gradient"><?= esc(session()->get('first_name') ?: session()->get('username')) ?></span>!</h2>
            <p class="lead mb-0">Continue your learning journey</p>
        </div>
    </div>

    <!-- Overall Progress Statistics -->
    <?php if (isset($overallProgress)): ?>
        <div class="row g-4 mb-5">
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm fade-in-up">
                    <div class="card-body text-center">
                        <i class="bi bi-book-fill text-primary" style="font-size: 2.5rem;"></i>
                        <h3 class="mt-3 mb-0"><?= $overallProgress['courses']['total'] ?></h3>
                        <p class="text-muted mb-0">Enrolled Courses</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm fade-in-up">
                    <div class="card-body text-center">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 2.5rem;"></i>
                        <h3 class="mt-3 mb-0"><?= $overallProgress['courses']['completed'] ?></h3>
                        <p class="text-muted mb-0">Completed Courses</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm fade-in-up">
                    <div class="card-body text-center">
                        <i class="bi bi-file-text-fill text-info" style="font-size: 2.5rem;"></i>
                        <h3 class="mt-3 mb-0"><?= $overallProgress['lessons']['completed'] ?>/<?= $overallProgress['lessons']['total'] ?></h3>
                        <p class="text-muted mb-0">Lessons Completed</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm fade-in-up">
                    <div class="card-body text-center">
                        <i class="bi bi-graph-up-arrow text-warning" style="font-size: 2.5rem;"></i>
                        <h3 class="mt-3 mb-0"><?= $overallProgress['lessons']['percentage'] ?>%</h3>
                        <p class="text-muted mb-0">Overall Progress</p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Recent Activity & Bookmarks -->
    <div class="row g-4 mb-5">
        <?php if (!empty($recentActivity)): ?>
            <div class="col-lg-6">
                <div class="card shadow-sm fade-in-up">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Recent Activity</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <?php 
                            $lessonModel = new \App\Models\LessonModel();
                            $courseModel = new \App\Models\CourseModel();
                            foreach ($recentActivity as $activity): 
                                $lesson = $lessonModel->find($activity['lesson_id']);
                                if ($lesson):
                                    $course = $courseModel->find($lesson['course_id']);
                            ?>
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1"><?= esc($lesson['title']) ?></h6>
                                            <small class="text-muted"><?= esc($course['title'] ?? 'Course') ?></small>
                                        </div>
                                        <a href="<?= base_url('courses/' . ($activity['course_slug'] ?? $lesson['course_id']) . '/module/' . $lesson['module_id'] . '/lesson/' . $lesson['id']) ?>" class="btn btn-sm btn-outline-primary">
                                            Continue
                                        </a>
                                    </div>
                                    <small class="text-muted">
                                        <?= timespan(strtotime($activity['last_accessed_at']), time()) ?> ago
                                    </small>
                                </div>
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($bookmarks)): ?>
            <div class="col-lg-6">
                <div class="card shadow-sm fade-in-up">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-bookmark-fill me-2"></i>Bookmarked Lessons</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <?php 
                            $lessonModel = new \App\Models\LessonModel();
                            $courseModel = new \App\Models\CourseModel();
                            foreach (array_slice($bookmarks, 0, 5) as $bookmark): 
                                $lesson = $lessonModel->find($bookmark['lesson_id']);
                                if ($lesson):
                                    $course = $courseModel->find($lesson['course_id']);
                            ?>
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1"><?= esc($lesson['title']) ?></h6>
                                            <small class="text-muted"><?= esc($course['title'] ?? 'Course') ?></small>
                                        </div>
                                        <a href="<?= base_url('courses/' . ($bookmark['course_slug'] ?? $lesson['course_id']) . '/module/' . $lesson['module_id'] . '/lesson/' . $lesson['id']) ?>" class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>
                                    </div>
                                </div>
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </div>
                        <?php if (count($bookmarks) > 5): ?>
                            <div class="card-footer bg-light text-center">
                                <small class="text-muted">And <?= count($bookmarks) - 5 ?> more...</small>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- My Enrolled Courses -->
    <?php if (!empty($enrolledCourses)): ?>
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">
                    <i class="bi bi-bookmark-check me-2"></i> My Courses
                    <span class="badge bg-primary ms-2"><?= $enrollmentCount ?></span>
                </h3>
                <a href="<?= base_url('courses') ?>" class="btn btn-outline-primary">
                    <i class="bi bi-plus-circle me-2"></i>Browse More Courses
                </a>
            </div>
            <div class="row g-4">
                <?php foreach ($enrolledCourses as $index => $course): ?>
                    <div class="col-md-6 col-lg-4" style="animation-delay: <?= $index * 0.1 ?>s">
                        <div class="card course-card h-100 fade-in-up shadow-sm">
                            <div class="course-image">
                                <?php if (!empty($course['image'])): ?>
                                    <img src="<?= esc($course['image']) ?>" alt="<?= esc($course['title']) ?>" class="img-fluid">
                                <?php else: ?>
                                    <i class="bi bi-filetype-py"></i>
                                <?php endif; ?>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="mb-2">
                                    <span class="badge bg-<?= $course['difficulty'] === 'beginner' ? 'success' : ($course['difficulty'] === 'intermediate' ? 'warning' : 'danger') ?> me-2">
                                        <?= ucfirst($course['difficulty']) ?>
                                    </span>
                                    <?php if (isset($course['category']) && !empty($course['category'])): ?>
                                        <span class="badge bg-secondary"><?= esc($course['category']['name']) ?></span>
                                    <?php endif; ?>
                                </div>
                                <h5 class="card-title"><?= esc($course['title']) ?></h5>
                                <p class="card-text text-muted flex-grow-1">
                                    <?php 
                                    $desc = $course['description'] ?? '';
                                    $maxLen = 100;
                                    if (mb_strlen($desc) > $maxLen) {
                                        $desc = mb_substr($desc, 0, $maxLen) . '...';
                                    }
                                    echo esc($desc);
                                    ?>
                                </p>
                                
                                <!-- Progress Bar -->
                                <?php if (isset($course['progress'])): ?>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small class="text-muted">Progress</small>
                                            <small class="text-muted"><?= $course['progress']['percentage'] ?>%</small>
                                        </div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-success" role="progressbar" 
                                                 style="width: <?= $course['progress']['percentage'] ?>%" 
                                                 aria-valuenow="<?= $course['progress']['percentage'] ?>" 
                                                 aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                        <small class="text-muted">
                                            <?= $course['progress']['completed'] ?> of <?= $course['progress']['total'] ?> lessons completed
                                        </small>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="mt-auto">
                                    <a href="<?= base_url('courses/' . $course['slug']) ?>" class="btn btn-primary w-100">
                                        <i class="bi bi-play-circle me-2"></i>Continue Learning
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info fade-in-up mb-5">
            <div class="d-flex align-items-center">
                <i class="bi bi-info-circle-fill me-3 fs-3"></i>
                <div class="flex-grow-1">
                    <h5 class="mb-2">No enrolled courses yet</h5>
                    <p class="mb-3">Start your learning journey by enrolling in a course.</p>
                    <a href="<?= base_url('courses') ?>" class="btn btn-primary">
                        <i class="bi bi-search me-2"></i>Browse Courses
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Browse All Courses Section -->
    <?php if (!empty($allCourses)): ?>
        <div class="mt-5">
            <h3 class="mb-4">
                <i class="bi bi-compass me-2"></i> Browse All Courses
            </h3>
            <div class="row g-4">
                <?php foreach (array_slice($allCourses, 0, 6) as $index => $course): ?>
                    <div class="col-md-4" style="animation-delay: <?= $index * 0.1 ?>s">
                        <div class="card course-card h-100 fade-in-up shadow-sm">
                            <div class="course-image">
                                <?php if (!empty($course['image'])): ?>
                                    <img src="<?= esc($course['image']) ?>" alt="<?= esc($course['title']) ?>" class="img-fluid">
                                <?php else: ?>
                                    <i class="bi bi-filetype-py"></i>
                                <?php endif; ?>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="mb-2">
                                    <span class="badge bg-<?= $course['difficulty'] === 'beginner' ? 'success' : ($course['difficulty'] === 'intermediate' ? 'warning' : 'danger') ?>">
                                        <?= ucfirst($course['difficulty']) ?>
                                    </span>
                                </div>
                                <h5 class="card-title"><?= esc($course['title']) ?></h5>
                                <p class="card-text text-muted flex-grow-1">
                                    <?php 
                                    $desc = $course['description'] ?? '';
                                    $maxLen = 100;
                                    if (mb_strlen($desc) > $maxLen) {
                                        $desc = mb_substr($desc, 0, $maxLen) . '...';
                                    }
                                    echo esc($desc);
                                    ?>
                                </p>
                                <div class="mt-auto">
                                    <a href="<?= base_url('courses/' . $course['slug']) ?>" class="btn btn-outline-primary w-100">
                                        <i class="bi bi-arrow-right-circle me-2"></i>View Course
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if (count($allCourses) > 6): ?>
                <div class="text-center mt-4">
                    <a href="<?= base_url('courses') ?>" class="btn btn-primary">
                        <i class="bi bi-arrow-right me-2"></i>View All Courses
                    </a>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
