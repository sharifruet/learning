<div class="fade-in-up">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="mb-2"><span class="text-gradient">Admin Dashboard</span></h2>
            <p class="lead mb-0">Manage your learning platform</p>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card text-white border-0 shadow-lg" style="background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="card-subtitle mb-2 opacity-75">Total Courses</h6>
                            <h2 class="mb-0 fw-bold"><?= $total_courses ?></h2>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-book"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white border-0 shadow-lg" style="background: linear-gradient(135deg, var(--success-color), #059669);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="card-subtitle mb-2 opacity-75">Published</h6>
                            <h2 class="mb-0 fw-bold"><?= $published_courses ?></h2>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white border-0 shadow-lg" style="background: linear-gradient(135deg, var(--accent-color), #0891b2);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="card-subtitle mb-2 opacity-75">Total Users</h6>
                            <h2 class="mb-0 fw-bold"><?= $total_users ?></h2>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white border-0 shadow-lg" style="background: linear-gradient(135deg, var(--warning-color), #d97706);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="card-subtitle mb-2 opacity-75">Completed</h6>
                            <h2 class="mb-0 fw-bold"><?= $total_progress ?></h2>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-trophy"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-lg fade-in-up">
        <div class="card-body p-4">
            <h3 class="mb-4"><i class="bi bi-lightning-charge"></i> Quick Actions</h3>
            <div class="d-flex flex-wrap gap-3">
                <a href="<?= base_url('admin/courses/create') ?>" class="btn btn-primary btn-lg">
                    <i class="bi bi-plus-circle"></i> Create New Course
                </a>
                <a href="<?= base_url('admin/courses') ?>" class="btn btn-outline-primary btn-lg">
                    <i class="bi bi-book"></i> Manage Courses
                </a>
                <a href="<?= base_url('admin/lessons') ?>" class="btn btn-outline-primary btn-lg">
                    <i class="bi bi-file-text"></i> Manage Lessons
                </a>
            </div>
        </div>
    </div>
</div>
