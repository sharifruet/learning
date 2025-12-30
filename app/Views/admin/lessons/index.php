<div class="fade-in-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-2"><span class="text-gradient">Manage Lessons</span></h2>
            <p class="lead mb-0">Create and manage lesson content</p>
        </div>
        <a href="<?= base_url('admin/lessons/create') ?>" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle me-2"></i>Create New Lesson
        </a>
    </div>

    <?php if (!empty($lessons)): ?>
        <div class="card shadow-lg fade-in-up">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Title</th>
                                <th>Course</th>
                                <th>Module</th>
                                <th>Status</th>
                                <th>Sort Order</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $courseModel = new \App\Models\CourseModel();
                            $moduleModel = new \App\Models\ModuleModel();
                            foreach ($lessons as $lesson): 
                                $course = $courseModel->find($lesson['course_id']);
                                $module = $moduleModel->find($lesson['module_id']);
                            ?>
                                <tr>
                                    <td class="ps-4 fw-semibold"><?= esc($lesson['title']) ?></td>
                                    <td><?= $course ? esc($course['title']) : 'N/A' ?></td>
                                    <td><?= $module ? esc($module['title']) : 'N/A' ?></td>
                                    <td>
                                        <span class="badge bg-<?= ($lesson['status'] ?? 'draft') === 'published' ? 'success' : 'secondary' ?>">
                                            <i class="bi bi-<?= ($lesson['status'] ?? 'draft') === 'published' ? 'check-circle' : 'circle' ?>"></i>
                                            <?= ucfirst($lesson['status'] ?? 'draft') ?>
                                        </span>
                                    </td>
                                    <td><?= $lesson['sort_order'] ?></td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group" role="group">
                                            <a href="<?= base_url('admin/lessons/' . $lesson['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil me-1"></i>Edit
                                            </a>
                                            <a href="<?= base_url('admin/lessons/' . $lesson['id'] . '/delete') ?>" 
                                               class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Are you sure you want to delete this lesson?');">
                                                <i class="bi bi-trash me-1"></i>Delete
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
                <i class="bi bi-file-text text-muted" style="font-size: 4rem;"></i>
                <h4 class="mt-3 mb-2">No lessons found</h4>
                <p class="text-muted mb-4">Get started by creating your first lesson</p>
                <a href="<?= base_url('admin/lessons/create') ?>" class="btn btn-primary btn-lg">
                    <i class="bi bi-plus-circle me-2"></i>Create Your First Lesson
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>
