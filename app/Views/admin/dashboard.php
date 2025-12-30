<div class="fade-in-up">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="mb-2"><span class="text-gradient">Admin Dashboard</span></h2>
            <p class="lead mb-0">System overview and management</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-5">
        <div class="col-6 col-md-3">
            <div class="card text-white border-0 shadow-lg fade-in-up" style="background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="card-subtitle mb-2 opacity-75">Total Courses</h6>
                            <h2 class="mb-0 fw-bold"><?= $total_courses ?></h2>
                            <small class="opacity-75"><?= $published_courses ?> published</small>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-book"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-white border-0 shadow-lg fade-in-up" style="background: linear-gradient(135deg, var(--success-color), #059669);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="card-subtitle mb-2 opacity-75">Total Users</h6>
                            <h2 class="mb-0 fw-bold"><?= $total_users ?></h2>
                            <small class="opacity-75"><?= $total_students ?> students</small>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-white border-0 shadow-lg fade-in-up" style="background: linear-gradient(135deg, var(--accent-color), #0891b2);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="card-subtitle mb-2 opacity-75">Enrollments</h6>
                            <h2 class="mb-0 fw-bold"><?= $total_enrollments ?></h2>
                            <small class="opacity-75"><?= $active_enrollments ?> active</small>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-bookmark-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-white border-0 shadow-lg fade-in-up" style="background: linear-gradient(135deg, var(--warning-color), #d97706);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="card-subtitle mb-2 opacity-75">Lessons</h6>
                            <h2 class="mb-0 fw-bold"><?= $total_lessons ?></h2>
                            <small class="opacity-75"><?= $published_lessons ?> published</small>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-file-text"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card shadow-lg fade-in-up mb-5">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Quick Actions</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="<?= base_url('admin/courses/create') ?>" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                        <i class="bi bi-plus-circle" style="font-size: 2rem;"></i>
                        <span class="mt-2">Create Course</span>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="<?= base_url('admin/courses') ?>" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                        <i class="bi bi-book" style="font-size: 2rem;"></i>
                        <span class="mt-2">Manage Courses</span>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                        <i class="bi bi-people" style="font-size: 2rem;"></i>
                        <span class="mt-2">Manage Users</span>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="<?= base_url('admin/lessons') ?>" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                        <i class="bi bi-file-text" style="font-size: 2rem;"></i>
                        <span class="mt-2">Manage Lessons</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row g-4">
        <!-- Recent Courses -->
        <div class="col-lg-6">
            <div class="card shadow-lg fade-in-up">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Recent Courses</h5>
                </div>
                <div class="card-body p-0">
                    <?php if (!empty($recent_courses)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($recent_courses as $course): ?>
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1"><?= esc($course['title']) ?></h6>
                                            <small class="text-muted">
                                                <span class="badge bg-<?= $course['status'] === 'published' ? 'success' : 'secondary' ?>">
                                                    <?= ucfirst($course['status']) ?>
                                                </span>
                                                <?= timespan(strtotime($course['created_at']), time()) ?> ago
                                            </small>
                                        </div>
                                        <a href="<?= base_url('admin/courses/' . $course['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="card-body text-center text-muted">
                            <p class="mb-0">No courses yet</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="col-lg-6">
            <div class="card shadow-lg fade-in-up">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-person-plus me-2"></i>Recent Users</h5>
                </div>
                <div class="card-body p-0">
                    <?php if (!empty($recent_users)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($recent_users as $user): ?>
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1"><?= esc($user['first_name'] . ' ' . $user['last_name']) ?></h6>
                                            <small class="text-muted">
                                                <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : ($user['role'] === 'instructor' ? 'warning' : 'primary') ?>">
                                                    <?= ucfirst($user['role']) ?>
                                                </span>
                                                <?= esc($user['email']) ?> • <?= timespan(strtotime($user['created_at']), time()) ?> ago
                                            </small>
                                        </div>
                                        <a href="<?= base_url('admin/users/' . $user['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="card-body text-center text-muted">
                            <p class="mb-0">No users yet</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
