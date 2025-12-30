<div class="fade-in-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Edit Module: <?= esc($module['title']) ?></h2>
        <a href="<?= base_url('admin/courses/' . $module['course_id'] . '/modules') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Modules
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Module Edit Form -->
            <form method="POST" action="<?= base_url('admin/modules/' . $module['id'] . '/update') ?>">
                <?= csrf_field() ?>
                
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Module Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="course_id" class="form-label">Course <span class="text-danger">*</span></label>
                            <select class="form-select" id="course_id" name="course_id" required>
                                <option value="">Select a course</option>
                                <?php foreach ($courses as $course): ?>
                                    <option value="<?= $course['id'] ?>" <?= (old('course_id', $module['course_id']) == $course['id']) ? 'selected' : '' ?>>
                                        <?= esc($course['title']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Module Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" value="<?= old('title', $module['title']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4"><?= old('description', $module['description']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order" value="<?= old('sort_order', $module['sort_order']) ?>">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="<?= base_url('admin/courses/' . $module['course_id'] . '/modules') ?>" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Update Module
                    </button>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <!-- Lessons in this Module -->
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="bi bi-list-ul me-2"></i>Lessons (<?= count($lessons) ?>)</h6>
                </div>
                <div class="card-body">
                    <?php if (!empty($lessons)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($lessons as $lesson): ?>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <strong><?= esc($lesson['title']) ?></strong>
                                        <br>
                                        <small class="text-muted">
                                            <span class="badge bg-<?= $lesson['status'] === 'published' ? 'success' : 'secondary' ?>">
                                                <?= ucfirst($lesson['status']) ?>
                                            </span>
                                        </small>
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('admin/lessons/' . $lesson['id'] . '/edit') ?>" class="btn btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="<?= base_url('admin/lessons/' . $lesson['id'] . '/delete') ?>" 
                                           class="btn btn-outline-danger"
                                           onclick="return confirm('Delete this lesson?');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted mb-0">No lessons yet</p>
                    <?php endif; ?>
                    <div class="mt-3 d-grid gap-2">
                        <a href="<?= base_url('admin/lessons/create/' . $module['id']) ?>" class="btn btn-success">
                            <i class="bi bi-plus-circle me-2"></i>Add Lesson
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

