<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('courses') ?>">Courses</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('courses/' . $course['id']) ?>"><?= esc($course['title']) ?></a></li>
        <li class="breadcrumb-item active"><?= esc($module['title']) ?></li>
    </ol>
</nav>

<h2><?= esc($module['title']) ?></h2>
<?php if (!empty($module['description'])): ?>
    <p class="lead"><?= esc($module['description']) ?></p>
<?php endif; ?>

<?php if (!empty($module['lessons'])): ?>
    <div class="list-group mt-4">
        <?php foreach ($module['lessons'] as $lesson): ?>
            <div class="list-group-item">
                <div class="d-flex w-100 justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">
                            <?= esc($lesson['title']) ?>
                            <?php if (in_array($lesson['id'], $completed_lessons)): ?>
                                <i class="bi bi-check-circle-fill text-success"></i>
                            <?php endif; ?>
                        </h5>
                    </div>
                    <a href="<?= base_url('courses/' . $course['id'] . '/module/' . $module['id'] . '/lesson/' . $lesson['id']) ?>" class="btn btn-primary">
                        Start Lesson <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="alert alert-info">This module doesn't have any lessons yet.</div>
<?php endif; ?>

