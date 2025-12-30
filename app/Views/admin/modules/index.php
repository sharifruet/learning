<div class="fade-in-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-2">
                <?php if (isset($course)): ?>
                    <span class="text-gradient">Modules: <?= esc($course['title']) ?></span>
                <?php else: ?>
                    <span class="text-gradient">Manage Modules</span>
                <?php endif; ?>
            </h2>
            <?php if (isset($course)): ?>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/courses') ?>">Courses</a></li>
                        <li class="breadcrumb-item active"><?= esc($course['title']) ?> - Modules</li>
                    </ol>
                </nav>
            <?php endif; ?>
        </div>
        <?php if (isset($courseId)): ?>
            <a href="<?= base_url('admin/modules/create/' . $courseId) ?>" class="btn btn-primary btn-lg">
                <i class="bi bi-plus-circle me-2"></i>Add Module
            </a>
        <?php else: ?>
            <a href="<?= base_url('admin/modules/create') ?>" class="btn btn-primary btn-lg">
                <i class="bi bi-plus-circle me-2"></i>Create Module
            </a>
        <?php endif; ?>
    </div>

    <?php if (!empty($modules)): ?>
        <div class="card shadow-lg fade-in-up">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Title</th>
                                <th>Description</th>
                                <th>Sort Order</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($modules as $module): ?>
                                <tr>
                                    <td class="ps-4 fw-semibold"><?= esc($module['title']) ?></td>
                                    <td>
                                        <?php if (!empty($module['description'])): ?>
                                            <?= esc(character_limiter($module['description'], 100)) ?>
                                        <?php else: ?>
                                            <span class="text-muted">No description</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $module['sort_order'] ?></td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group" role="group">
                                            <a href="<?= base_url('admin/modules/' . $module['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil me-1"></i>Edit
                                            </a>
                                            <a href="<?= base_url('admin/modules/' . $module['id'] . '/delete') ?>" 
                                               class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Are you sure you want to delete this module? All lessons in this module will also be deleted.');">
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
                <i class="bi bi-folder text-muted" style="font-size: 4rem;"></i>
                <h4 class="mt-3 mb-2">No modules found</h4>
                <p class="text-muted mb-4">Get started by creating your first module</p>
                <?php if (isset($courseId)): ?>
                    <a href="<?= base_url('admin/modules/create/' . $courseId) ?>" class="btn btn-primary btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>Create Module
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('admin/modules/create') ?>" class="btn btn-primary btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>Create Module
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

