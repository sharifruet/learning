<div class="fade-in-up">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="mb-2">Welcome back, <span class="text-gradient"><?= esc(session()->get('first_name') ?: session()->get('username')) ?></span>!</h2>
            <p class="lead mb-0">Manage your courses and track student progress</p>
        </div>
        <a href="<?= base_url('admin/courses/create') ?>" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle me-2"></i>Create New Course
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm fade-in-up">
                <div class="card-body text-center">
                    <i class="bi bi-book-fill text-primary" style="font-size: 2.5rem;"></i>
                    <h3 class="mt-3 mb-0"><?= $totalCourses ?></h3>
                    <p class="text-muted mb-0">My Courses</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm fade-in-up">
                <div class="card-body text-center">
                    <i class="bi bi-people-fill text-success" style="font-size: 2.5rem;"></i>
                    <h3 class="mt-3 mb-0"><?= $totalEnrollments ?></h3>
                    <p class="text-muted mb-0">Total Enrollments</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm fade-in-up">
                <div class="card-body text-center">
                    <i class="bi bi-folder-fill text-info" style="font-size: 2.5rem;"></i>
                    <h3 class="mt-3 mb-0"><?= $totalModules ?></h3>
                    <p class="text-muted mb-0">Total Modules</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm fade-in-up">
                <div class="card-body text-center">
                    <i class="bi bi-file-text-fill text-warning" style="font-size: 2.5rem;"></i>
                    <h3 class="mt-3 mb-0"><?= $totalLessons ?></h3>
                    <p class="text-muted mb-0">Total Lessons</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card shadow-sm mb-5 fade-in-up">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Quick Actions</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6 col-lg-3">
                    <a href="<?= base_url('admin/courses/create') ?>" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                        <i class="bi bi-plus-circle" style="font-size: 2rem;"></i>
                        <span class="mt-2">Create Course</span>
                    </a>
                </div>
                <div class="col-md-6 col-lg-3">
                    <a href="<?= base_url('admin/courses') ?>" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                        <i class="bi bi-book" style="font-size: 2rem;"></i>
                        <span class="mt-2">Manage Courses</span>
                    </a>
                </div>
                <div class="col-md-6 col-lg-3">
                    <a href="<?= base_url('admin/lessons') ?>" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                        <i class="bi bi-file-text" style="font-size: 2rem;"></i>
                        <span class="mt-2">Manage Lessons</span>
                    </a>
                </div>
                <div class="col-md-6 col-lg-3">
                    <a href="<?= base_url('admin/exercises') ?>" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                        <i class="bi bi-pencil-square" style="font-size: 2rem;"></i>
                        <span class="mt-2">Manage Exercises</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- My Courses -->
    <?php if (!empty($myCourses)): ?>
        <div class="card shadow-lg fade-in-up">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="bi bi-bookmark-check me-2"></i>My Courses</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Course</th>
                                <th>Status</th>
                                <th>Enrollments</th>
                                <th>Completed</th>
                                <th>Modules</th>
                                <th>Lessons</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($myCourses as $stat): 
                                $course = $stat['course'];
                            ?>
                                <tr>
                                    <td class="ps-4">
                                        <strong><?= esc($course['title']) ?></strong>
                                        <br>
                                        <small class="text-muted"><?= esc(character_limiter($course['description'] ?? '', 60)) ?></small>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $course['status'] === 'published' ? 'success' : 'secondary' ?>">
                                            <?= ucfirst($course['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary"><?= $stat['enrollments'] ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success"><?= $stat['completed'] ?></span>
                                    </td>
                                    <td><?= $stat['modules'] ?></td>
                                    <td><?= $stat['lessons'] ?></td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="<?= base_url('admin/courses/' . $course['id'] . '/edit') ?>" class="btn btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="<?= base_url('admin/courses/' . $course['id'] . '/modules') ?>" class="btn btn-outline-success" title="Modules">
                                                <i class="bi bi-folder"></i>
                                            </a>
                                            <a href="<?= base_url('courses/' . $course['slug']) ?>" class="btn btn-outline-info" title="View" target="_blank">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="card shadow-lg fade-in-up">
            <div class="card-body p-5 text-center">
                <i class="bi bi-book text-muted" style="font-size: 4rem;"></i>
                <h4 class="mt-3 mb-2">No courses yet</h4>
                <p class="text-muted mb-4">Start by creating your first course</p>
                <a href="<?= base_url('admin/courses/create') ?>" class="btn btn-primary btn-lg">
                    <i class="bi bi-plus-circle me-2"></i>Create Your First Course
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

