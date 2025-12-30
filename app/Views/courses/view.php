<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('courses') ?>">Courses</a></li>
        <li class="breadcrumb-item active"><?= esc($course['title']) ?></li>
    </ol>
</nav>

<h2><?= esc($course['title']) ?></h2>
<p class="lead"><?= esc($course['description']) ?></p>

<div class="mb-3">
    <span class="badge bg-<?= $course['difficulty'] === 'beginner' ? 'success' : ($course['difficulty'] === 'intermediate' ? 'warning' : 'danger') ?>">
        <?= ucfirst($course['difficulty']) ?>
    </span>
    <?php if (isset($progress) && $progress > 0): ?>
        <span class="badge bg-info">Progress: <?= $progress ?> lessons completed</span>
    <?php endif; ?>
</div>

<?php if (!empty($course['modules'])): ?>
    <div class="list-group mt-4">
        <?php foreach ($course['modules'] as $module): ?>
            <div class="list-group-item">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1"><?= esc($module['title']) ?></h5>
                </div>
                <?php if (!empty($module['description'])): ?>
                    <p class="mb-1"><?= esc($module['description']) ?></p>
                <?php endif; ?>
                <a href="<?= base_url('courses/' . $course['id'] . '/module/' . $module['id']) ?>" class="btn btn-sm btn-primary mt-2">
                    View Module <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="alert alert-info">This course doesn't have any modules yet.</div>
<?php endif; ?>

