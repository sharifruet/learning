<h2>Create New Lesson</h2>

<form method="POST" action="<?= base_url('admin/lessons/store') ?>">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label for="course_id" class="form-label">Course</label>
        <select class="form-select" id="course_id" name="course_id" required>
            <option value="">Select a course</option>
            <?php foreach ($courses as $course): ?>
                <option value="<?= $course['id'] ?>" <?= old('course_id') == $course['id'] ? 'selected' : '' ?>><?= esc($course['title']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="module_id" class="form-label">Module</label>
        <select class="form-select" id="module_id" name="module_id" required>
            <option value="">Select a module</option>
            <?php foreach ($modules as $module): ?>
                <option value="<?= $module['id'] ?>" <?= old('module_id') == $module['id'] ? 'selected' : '' ?>><?= esc($module['title']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="<?= old('title') ?>" required>
    </div>
    <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea class="form-control" id="content" name="content" rows="10"><?= old('content') ?></textarea>
        <small class="form-text text-muted">HTML content for the lesson</small>
    </div>
    <div class="mb-3">
        <label for="code_examples" class="form-label">Code Examples</label>
        <textarea class="form-control font-monospace" id="code_examples" name="code_examples" rows="5"><?= old('code_examples') ?></textarea>
    </div>
    <div class="mb-3">
        <label for="sort_order" class="form-label">Sort Order</label>
        <input type="number" class="form-control" id="sort_order" name="sort_order" value="<?= old('sort_order') ?: 0 ?>">
    </div>
    <button type="submit" class="btn btn-primary">Create Lesson</button>
    <a href="<?= base_url('admin/lessons') ?>" class="btn btn-secondary">Cancel</a>
</form>

