<h2>All Courses</h2>
<p class="lead">Choose a course to start learning Python</p>

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
                        </div>
                        <a href="<?= base_url('courses/' . $course['id']) ?>" class="btn btn-primary">View Course</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="alert alert-info">No courses available yet. Check back soon!</div>
<?php endif; ?>
