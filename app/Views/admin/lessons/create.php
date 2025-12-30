<div class="fade-in-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Create New Lesson</h2>
        <?php if (isset($moduleId)): ?>
            <a href="<?= base_url('admin/modules/' . $moduleId . '/edit') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Module
            </a>
        <?php else: ?>
            <a href="<?= base_url('admin/lessons') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Lessons
            </a>
        <?php endif; ?>
    </div>

    <form method="POST" action="<?= base_url('admin/lessons/store') ?>" id="lessonForm">
        <?= csrf_field() ?>
        
        <!-- Basic Information -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Basic Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
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
                    <div class="col-md-6 mb-3">
                        <label for="module_id" class="form-label">Module <span class="text-danger">*</span></label>
                        <select class="form-select" id="module_id" name="module_id" required>
                            <option value="">Select a module</option>
                            <?php foreach ($modules as $module): ?>
                                <option value="<?= $module['id'] ?>" 
                                        <?= (old('module_id') == $module['id'] || (isset($moduleId) && $moduleId == $module['id'])) ? 'selected' : '' ?>>
                                    <?= esc($module['title']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Lesson Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="title" name="title" value="<?= old('title') ?>" required>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="draft" <?= old('status', 'draft') === 'draft' ? 'selected' : '' ?>>Draft</option>
                            <option value="published" <?= old('status') === 'published' ? 'selected' : '' ?>>Published</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="content_type" class="form-label">Content Type</label>
                        <select class="form-select" id="content_type" name="content_type">
                            <option value="text" <?= old('content_type', 'text') === 'text' ? 'selected' : '' ?>>Text</option>
                            <option value="video" <?= old('content_type') === 'video' ? 'selected' : '' ?>>Video</option>
                            <option value="mixed" <?= old('content_type') === 'mixed' ? 'selected' : '' ?>>Mixed</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="estimated_time" class="form-label">Estimated Time (minutes)</label>
                        <input type="number" class="form-control" id="estimated_time" name="estimated_time" value="<?= old('estimated_time') ?>" min="1">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="objectives" class="form-label">Learning Objectives</label>
                    <textarea class="form-control" id="objectives" name="objectives" rows="3"><?= old('objectives') ?></textarea>
                    <small class="form-text text-muted">What students will learn in this lesson (one per line)</small>
                </div>
                <div class="mb-3">
                    <label for="featured_image" class="form-label">Featured Image URL</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="featured_image" name="featured_image" value="<?= old('featured_image') ?>" placeholder="Image URL">
                        <button type="button" class="btn btn-outline-secondary" onclick="openImageUpload()">
                            <i class="bi bi-upload me-1"></i>Upload
                        </button>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="sort_order" class="form-label">Sort Order</label>
                    <input type="number" class="form-control" id="sort_order" name="sort_order" value="<?= old('sort_order') ?: 0 ?>">
                </div>
            </div>
        </div>

        <!-- Lesson Content (WYSIWYG Editor) -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-file-text me-2"></i>Lesson Content</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="content" class="form-label">Main Content</label>
                    <div id="content" style="min-height: 400px;"><?= old('content') ?></div>
                    <textarea name="content" id="content_hidden" style="display: none;"><?= old('content') ?></textarea>
                    <small class="form-text text-muted">Use the rich text editor to format your lesson content</small>
                </div>
            </div>
        </div>

        <!-- Code Examples -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-code-square me-2"></i>Code Examples</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="code_examples" class="form-label">Code Examples</label>
                    <textarea class="form-control font-monospace" id="code_examples" name="code_examples" rows="10" style="font-family: 'Courier New', monospace;"><?= old('code_examples') ?></textarea>
                    <small class="form-text text-muted">Add code examples here. They will be displayed with syntax highlighting.</small>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <?php if (isset($moduleId)): ?>
                <a href="<?= base_url('admin/modules/' . $moduleId . '/edit') ?>" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            <?php else: ?>
                <a href="<?= base_url('admin/lessons') ?>" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle me-2"></i>Create Lesson
            </button>
        </div>
    </form>
</div>

<!-- Quill.js WYSIWYG Editor (Free and Open Source) -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    // Initialize Quill editor
    var quill = new Quill('#content', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'align': [] }],
                ['link', 'image', 'code-block'],
                ['clean']
            ]
        },
        placeholder: 'Start writing your lesson content...'
    });

    // Handle image uploads
    var toolbar = quill.getModule('toolbar');
    toolbar.addHandler('image', function() {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        input.click();
        
        input.onchange = function() {
            var file = input.files[0];
            if (file) {
                var formData = new FormData();
                formData.append('image', file);
                formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

                fetch('<?= base_url('admin/upload/image') ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        var range = quill.getSelection(true);
                        quill.insertEmbed(range.index, 'image', data.url);
                    } else {
                        alert('Upload failed: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Upload error: ' + error);
                });
            }
        };
    });

    // Update hidden textarea before form submission
    document.getElementById('lessonForm').addEventListener('submit', function() {
        var hiddenContent = document.getElementById('content_hidden');
        hiddenContent.value = quill.root.innerHTML;
    });

    // Initialize with existing content if any
    <?php if (old('content')): ?>
        quill.root.innerHTML = <?= json_encode(old('content')) ?>;
    <?php endif; ?>

    // Code syntax highlighting (using Prism.js)
    function openImageUpload() {
        var input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/*';
        input.onchange = function(e) {
            var file = e.target.files[0];
            if (file) {
                var formData = new FormData();
                formData.append('image', file);
                formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

                fetch('<?= base_url('admin/upload/image') ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('featured_image').value = data.url;
                        alert('Image uploaded successfully!');
                    } else {
                        alert('Upload failed: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Upload error: ' + error);
                });
            }
        };
        input.click();
    }

    // Update modules dropdown when course changes
    document.getElementById('course_id').addEventListener('change', function() {
        var courseId = this.value;
        var moduleSelect = document.getElementById('module_id');
        
        if (courseId) {
            // Fetch modules for selected course
            fetch('<?= base_url('admin/api/modules/') ?>' + courseId)
                .then(response => response.json())
                .then(data => {
                    moduleSelect.innerHTML = '<option value="">Select a module</option>';
                    if (data.modules) {
                        data.modules.forEach(function(module) {
                            var option = document.createElement('option');
                            option.value = module.id;
                            option.textContent = module.title;
                            moduleSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        } else {
            moduleSelect.innerHTML = '<option value="">Select a module</option>';
        }
    });
</script>

<!-- Prism.js for code syntax highlighting -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
