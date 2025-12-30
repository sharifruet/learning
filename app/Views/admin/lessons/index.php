<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manage Lessons</h2>
    <a href="<?= base_url('admin/lessons/create') ?>" class="btn btn-primary">Create New Lesson</a>
</div>

<?php if (!empty($lessons)): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Course ID</th>
                <th>Module ID</th>
                <th>Sort Order</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lessons as $lesson): ?>
                <tr>
                    <td><?= esc($lesson['title']) ?></td>
                    <td><?= $lesson['course_id'] ?></td>
                    <td><?= $lesson['module_id'] ?></td>
                    <td><?= $lesson['sort_order'] ?></td>
                    <td>
                        <a href="<?= base_url('admin/lessons/' . $lesson['id'] . '/edit') ?>" class="btn btn-sm btn-primary">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-info">No lessons found. <a href="<?= base_url('admin/lessons/create') ?>">Create your first lesson</a></div>
<?php endif; ?>

