<h2>Create New Course</h2>

<form method="POST" action="<?= base_url('admin/courses/store') ?>">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="<?= old('title') ?>" required>
    </div>
    <div class="mb-3">
        <label for="slug" class="form-label">Slug</label>
        <input type="text" class="form-control" id="slug" name="slug" value="<?= old('slug') ?>" required>
        <small class="form-text text-muted">URL-friendly version of the title (e.g., python-basics)</small>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="4"><?= old('description') ?></textarea>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="difficulty" class="form-label">Difficulty</label>
            <select class="form-select" id="difficulty" name="difficulty">
                <option value="beginner" <?= old('difficulty') === 'beginner' ? 'selected' : '' ?>>Beginner</option>
                <option value="intermediate" <?= old('difficulty') === 'intermediate' ? 'selected' : '' ?>>Intermediate</option>
                <option value="advanced" <?= old('difficulty') === 'advanced' ? 'selected' : '' ?>>Advanced</option>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status">
                <option value="draft" <?= old('status') === 'draft' ? 'selected' : '' ?>>Draft</option>
                <option value="published" <?= old('status') === 'published' ? 'selected' : '' ?>>Published</option>
            </select>
        </div>
    </div>
    <div class="mb-3">
        <label for="sort_order" class="form-label">Sort Order</label>
        <input type="number" class="form-control" id="sort_order" name="sort_order" value="<?= old('sort_order') ?: 0 ?>">
    </div>
    <button type="submit" class="btn btn-primary">Create Course</button>
    <a href="<?= base_url('admin/courses') ?>" class="btn btn-secondary">Cancel</a>
</form>

