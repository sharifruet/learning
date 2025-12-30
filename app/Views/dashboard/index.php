<h2>My Dashboard</h2>
<p class="lead">Welcome back, <?= esc(session()->get('first_name') ?: session()->get('username')) ?>!</p>

<div class="row mb-4">
    <div class="col-md-12">
        <h3>My Courses</h3>
    </div>
</div>

<?php if (!empty($courses)): ?>
    <div class="row g-4">
        <?php foreach ($courses as $course): ?>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= esc($course['title']) ?></h5>
                        <p class="card-text"><?= esc($course['description']) ?></p>
                        <div class="mb-3">
                            <span class="badge bg-<?= $course['difficulty'] === 'beginner' ? 'success' : ($course['difficulty'] === 'intermediate' ? 'warning' : 'danger') ?>">
                                <?= ucfirst($course['difficulty']) ?>
                            </span>
                            <?php if (isset($course['progress'])): ?>
                                <span class="badge bg-info">Progress: <?= $course['progress'] ?> lessons</span>
                            <?php endif; ?>
                        </div>
                        <a href="<?= base_url('courses/' . $course['id']) ?>" class="btn btn-primary">Continue Learning</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="alert alert-info">
        <h5>No courses yet</h5>
        <p>Start learning by browsing our available courses.</p>
        <a href="<?= base_url('courses') ?>" class="btn btn-primary">Browse Courses</a>
    </div>
<?php endif; ?>

