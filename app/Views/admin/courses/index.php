<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manage Courses</h2>
    <a href="<?= base_url('admin/courses/create') ?>" class="btn btn-primary">Create New Course</a>
</div>

<?php if (!empty($courses)): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Slug</th>
                <th>Difficulty</th>
                <th>Status</th>
                <th>Sort Order</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courses as $course): ?>
                <tr>
                    <td><?= esc($course['title']) ?></td>
                    <td><?= esc($course['slug']) ?></td>
                    <td><span class="badge bg-<?= $course['difficulty'] === 'beginner' ? 'success' : ($course['difficulty'] === 'intermediate' ? 'warning' : 'danger') ?>"><?= ucfirst($course['difficulty']) ?></span></td>
                    <td><span class="badge bg-<?= $course['status'] === 'published' ? 'success' : 'secondary' ?>"><?= ucfirst($course['status']) ?></span></td>
                    <td><?= $course['sort_order'] ?></td>
                    <td>
                        <a href="<?= base_url('admin/courses/' . $course['id'] . '/edit') ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="<?= base_url('courses/' . $course['id']) ?>" class="btn btn-sm btn-info" target="_blank">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-info">No courses found. <a href="<?= base_url('admin/courses/create') ?>">Create your first course</a></div>
<?php endif; ?>

