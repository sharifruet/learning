<div class="fade-in-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Create New Course</h2>
        <a href="<?= base_url('admin/courses') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Courses
        </a>
    </div>

    <form method="POST" action="<?= base_url('admin/courses/store') ?>">
        <?= csrf_field() ?>
        
        <!-- Basic Information -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Basic Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="title" class="form-label">Course Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="title" name="title" value="<?= old('title') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="slug" name="slug" value="<?= old('slug') ?>" required>
                    <small class="form-text text-muted">URL-friendly version (e.g., python-basics)</small>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4"><?= old('description') ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="syllabus" class="form-label">Course Syllabus/Outline</label>
                    <textarea class="form-control" id="syllabus" name="syllabus" rows="6"><?= old('syllabus') ?></textarea>
                    <small class="form-text text-muted">Outline what students will learn in this course</small>
                </div>
                <div class="mb-3">
                    <label for="tags" class="form-label">Tags</label>
                    <input type="text" class="form-control" id="tags" name="tags" value="<?= old('tags') ?>" placeholder="python, programming, basics (comma-separated)">
                    <small class="form-text text-muted">Comma-separated tags for search and filtering</small>
                </div>
            </div>
        </div>

        <!-- Course Settings -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-gear me-2"></i>Course Settings</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select" id="category_id" name="category_id">
                            <option value="">Select Category</option>
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" <?= old('category_id') == $category['id'] ? 'selected' : '' ?>>
                                        <?= esc($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="instructor_id" class="form-label">Instructor</label>
                        <select class="form-select" id="instructor_id" name="instructor_id">
                            <option value="">Select Instructor</option>
                            <?php if (!empty($instructors)): ?>
                                <?php foreach ($instructors as $instructor): ?>
                                    <option value="<?= $instructor['id'] ?>" <?= (old('instructor_id') == $instructor['id'] || session()->get('user_id') == $instructor['id']) ? 'selected' : '' ?>>
                                        <?= esc($instructor['first_name'] . ' ' . $instructor['last_name'] . ' (' . $instructor['email'] . ')') ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="difficulty" class="form-label">Difficulty Level</label>
                        <select class="form-select" id="difficulty" name="difficulty">
                            <option value="beginner" <?= old('difficulty') === 'beginner' ? 'selected' : 'selected' ?>>Beginner</option>
                            <option value="intermediate" <?= old('difficulty') === 'intermediate' ? 'selected' : '' ?>>Intermediate</option>
                            <option value="advanced" <?= old('difficulty') === 'advanced' ? 'selected' : '' ?>>Advanced</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="draft" <?= old('status') === 'draft' ? 'selected' : 'selected' ?>>Draft</option>
                            <option value="published" <?= old('status') === 'published' ? 'selected' : '' ?>>Published</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" class="form-control" id="sort_order" name="sort_order" value="<?= old('sort_order') ?: 0 ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- Enrollment Settings -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-people me-2"></i>Enrollment Settings</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="enrollment_type" class="form-label">Enrollment Type</label>
                        <select class="form-select" id="enrollment_type" name="enrollment_type">
                            <option value="open" <?= old('enrollment_type') === 'open' ? 'selected' : 'selected' ?>>Open (Default - Anyone can enroll)</option>
                            <option value="approval_required" <?= old('enrollment_type') === 'approval_required' ? 'selected' : '' ?>>Approval Required</option>
                            <option value="closed" <?= old('enrollment_type') === 'closed' ? 'selected' : '' ?>>Closed</option>
                        </select>
                        <small class="form-text text-muted">Default: Open enrollment (no approval needed)</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="capacity" class="form-label">Capacity (Optional)</label>
                        <input type="number" class="form-control" id="capacity" name="capacity" value="<?= old('capacity') ?>" placeholder="Leave empty for unlimited">
                        <small class="form-text text-muted">Maximum number of students (leave empty for unlimited)</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_free" name="is_free" value="1" <?= old('is_free', 1) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_free">
                                Free Course
                            </label>
                        </div>
                        <small class="form-text text-muted">Default: Free (uncheck for paid courses)</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_self_paced" name="is_self_paced" value="1" <?= old('is_self_paced', 1) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_self_paced">
                                Self-Paced Course
                            </label>
                        </div>
                        <small class="form-text text-muted">Default: Self-paced (students learn at their own pace)</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="<?= base_url('admin/courses') ?>" class="btn btn-secondary">
                <i class="bi bi-x-circle me-2"></i>Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle me-2"></i>Create Course
            </button>
        </div>
    </form>
</div>
