<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('courses') ?>" class="text-decoration-none"><i class="bi bi-book"></i> Courses</a></li>
        <li class="breadcrumb-item active"><?= esc($course['title']) ?></li>
    </ol>
</nav>

<div class="card shadow-lg mb-4 fade-in-up">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h2 class="mb-2"><?= esc($course['title']) ?></h2>
                <p class="lead text-muted mb-3"><?= esc($course['description']) ?></p>
            </div>
        </div>
        <div class="mb-3">
            <span class="badge bg-<?= $course['difficulty'] === 'beginner' ? 'success' : ($course['difficulty'] === 'intermediate' ? 'warning' : 'danger') ?> me-2">
                <i class="bi bi-<?= $course['difficulty'] === 'beginner' ? 'star' : ($course['difficulty'] === 'intermediate' ? 'star-half' : 'star-fill') ?>"></i>
                <?= ucfirst($course['difficulty']) ?>
            </span>
            <?php if (isset($progress) && $progress > 0): ?>
                <span class="badge bg-info">
                    <i class="bi bi-check-circle"></i> Progress: <?= $progress ?> lessons completed
                </span>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if (!empty($course['modules'])): ?>
    <h3 class="mb-4"><span class="text-gradient">Course Modules</span></h3>
    <div class="row g-4 fade-in-up">
        <?php foreach ($course['modules'] as $index => $module): ?>
            <div class="col-md-6" style="animation-delay: <?= $index * 0.1 ?>s">
                <div class="card h-100 fade-in-up">
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
                        <a href="<?= base_url('courses/' . $course['id'] . '/module/' . $module['id']) ?>" class="btn btn-primary">
                            <i class="bi bi-arrow-right-circle"></i> View Module
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
                <h5 class="mb-1">No modules available</h5>
                <p class="mb-0">This course doesn't have any modules yet.</p>
            </div>
        </div>
    </div>
<?php endif; ?>
