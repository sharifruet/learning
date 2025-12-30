<div class="fade-in-up">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="mb-2"><span class="text-gradient">Manage Courses</span></h2>
            <p class="lead mb-0">Create and manage your course content</p>
        </div>
        <a href="<?= base_url('admin/courses/create') ?>" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle"></i> Create New Course
        </a>
    </div>

    <?php if (!empty($courses)): ?>
        <div class="card shadow-lg fade-in-up">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Title</th>
                                <th>Slug</th>
                                <th>Difficulty</th>
                                <th>Status</th>
                                <th>Sort Order</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($courses as $course): ?>
                                <tr>
                                    <td class="ps-4 fw-semibold"><?= esc($course['title']) ?></td>
                                    <td><code class="text-muted"><?= esc($course['slug']) ?></code></td>
                                    <td>
                                        <span class="badge bg-<?= $course['difficulty'] === 'beginner' ? 'success' : ($course['difficulty'] === 'intermediate' ? 'warning' : 'danger') ?>">
                                            <?= ucfirst($course['difficulty']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $course['status'] === 'published' ? 'success' : 'secondary' ?>">
                                            <i class="bi bi-<?= $course['status'] === 'published' ? 'check-circle' : 'circle' ?>"></i>
                                            <?= ucfirst($course['status']) ?>
                                        </span>
                                    </td>
                                    <td><?= $course['sort_order'] ?></td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group" role="group">
                                            <a href="<?= base_url('admin/courses/' . $course['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <a href="<?= base_url('courses/' . $course['id']) ?>" class="btn btn-sm btn-outline-info" target="_blank">
                                                <i class="bi bi-eye"></i> View
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
                <h4 class="mt-3 mb-2">No courses found</h4>
                <p class="text-muted mb-4">Get started by creating your first course</p>
                <a href="<?= base_url('admin/courses/create') ?>" class="btn btn-primary btn-lg">
                    <i class="bi bi-plus-circle"></i> Create Your First Course
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
.table-hover tbody tr:hover {
    background-color: var(--gray-100);
    transition: background-color 0.2s ease;
}
</style>
