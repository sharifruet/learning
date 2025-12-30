<div class="fade-in-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Create New Exercise</h2>
        <?php if (isset($lesson)): ?>
            <a href="<?= base_url('admin/exercises/' . $lesson['id']) ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Exercises
            </a>
        <?php else: ?>
            <a href="<?= base_url('admin/exercises') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Exercises
            </a>
        <?php endif; ?>
    </div>

    <form method="POST" action="<?= base_url('admin/exercises/store') ?>">
        <?= csrf_field() ?>
        
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Exercise Information</h5>
            </div>
            <div class="card-body">
                <?php if (isset($lesson)): ?>
                    <input type="hidden" name="lesson_id" value="<?= $lesson['id'] ?>">
                    <div class="alert alert-info">
                        <strong>Lesson:</strong> <?= esc($lesson['title']) ?>
                    </div>
                <?php else: ?>
                    <div class="mb-3">
                        <label for="lesson_id" class="form-label">Lesson <span class="text-danger">*</span></label>
                        <select class="form-select" id="lesson_id" name="lesson_id" required>
                            <option value="">Select a lesson</option>
                            <?php foreach ($lessons as $les): ?>
                                <option value="<?= $les['id'] ?>" <?= old('lesson_id') == $les['id'] ? 'selected' : '' ?>>
                                    <?= esc($les['title']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>
                
                <div class="mb-3">
                    <label for="title" class="form-label">Exercise Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="title" name="title" value="<?= old('title') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4"><?= old('description') ?></textarea>
                    <small class="form-text text-muted">Describe what students need to do in this exercise</small>
                </div>
                <div class="mb-3">
                    <label for="starter_code" class="form-label">Starter Code</label>
                    <textarea class="form-control font-monospace" id="starter_code" name="starter_code" rows="8" style="font-family: 'Courier New', monospace;"><?= old('starter_code') ?></textarea>
                    <small class="form-text text-muted">Initial code template for students</small>
                </div>
                <div class="mb-3">
                    <label for="solution_code" class="form-label">Solution Code</label>
                    <textarea class="form-control font-monospace" id="solution_code" name="solution_code" rows="8" style="font-family: 'Courier New', monospace;"><?= old('solution_code') ?></textarea>
                    <small class="form-text text-muted">Correct solution for validation</small>
                </div>
                <div class="mb-3">
                    <label for="hints" class="form-label">Hints</label>
                    <textarea class="form-control" id="hints" name="hints" rows="3"><?= old('hints') ?></textarea>
                    <small class="form-text text-muted">Helpful hints for students</small>
                </div>
                <div class="mb-3">
                    <label for="sort_order" class="form-label">Sort Order</label>
                    <input type="number" class="form-control" id="sort_order" name="sort_order" value="<?= old('sort_order') ?: 0 ?>">
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <?php if (isset($lesson)): ?>
                <a href="<?= base_url('admin/exercises/' . $lesson['id']) ?>" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            <?php else: ?>
                <a href="<?= base_url('admin/exercises') ?>" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle me-2"></i>Create Exercise
            </button>
        </div>
    </form>
</div>

