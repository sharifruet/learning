<div class="fade-in-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Create New Module</h2>
        <?php if (isset($courseId)): ?>
            <a href="<?= base_url('admin/courses/' . $courseId . '/modules') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Modules
            </a>
        <?php else: ?>
            <a href="<?= base_url('admin/modules') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Modules
            </a>
        <?php endif; ?>
    </div>

    <form method="POST" action="<?= base_url('admin/modules/store') ?>">
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
                            <option value="<?= $course['id'] ?>" 
                                    <?= (old('course_id') == $course['id'] || (isset($courseId) && $courseId == $course['id'])) ? 'selected' : '' ?>>
                                <?= esc($course['title']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Module Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="title" name="title" value="<?= old('title') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4"><?= old('description') ?></textarea>
                    <small class="form-text text-muted">Brief description of what students will learn in this module</small>
                </div>
                <div class="mb-3">
                    <label for="sort_order" class="form-label">Sort Order</label>
                    <input type="number" class="form-control" id="sort_order" name="sort_order" value="<?= old('sort_order') ?: 0 ?>">
                    <small class="form-text text-muted">Lower numbers appear first (0 = first)</small>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <?php if (isset($courseId)): ?>
                <a href="<?= base_url('admin/courses/' . $courseId . '/modules') ?>" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            <?php else: ?>
                <a href="<?= base_url('admin/modules') ?>" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle me-2"></i>Create Module
            </button>
        </div>
    </form>
</div>

