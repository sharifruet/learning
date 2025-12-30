<div class="fade-in-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-2">
                <?php if (isset($lesson)): ?>
                    <span class="text-gradient">Exercises: <?= esc($lesson['title']) ?></span>
                <?php else: ?>
                    <span class="text-gradient">Manage Exercises</span>
                <?php endif; ?>
            </h2>
            <?php if (isset($lesson)): ?>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/courses') ?>">Courses</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/modules/' . $lesson['module_id'] . '/edit') ?>">Module</a></li>
                        <li class="breadcrumb-item active"><?= esc($lesson['title']) ?> - Exercises</li>
                    </ol>
                </nav>
            <?php endif; ?>
        </div>
        <?php if (isset($lesson)): ?>
            <a href="<?= base_url('admin/exercises/create/' . $lesson['id']) ?>" class="btn btn-primary btn-lg">
                <i class="bi bi-plus-circle me-2"></i>Add Exercise
            </a>
        <?php else: ?>
            <a href="<?= base_url('admin/exercises/create') ?>" class="btn btn-primary btn-lg">
                <i class="bi bi-plus-circle me-2"></i>Create Exercise
            </a>
        <?php endif; ?>
    </div>

    <?php if (!empty($exercises)): ?>
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
                            <?php foreach ($exercises as $exercise): ?>
                                <tr>
                                    <td class="ps-4 fw-semibold"><?= esc($exercise['title']) ?></td>
                                    <td>
                                        <?php if (!empty($exercise['description'])): ?>
                                            <?= esc(character_limiter($exercise['description'], 100)) ?>
                                        <?php else: ?>
                                            <span class="text-muted">No description</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $exercise['sort_order'] ?></td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group" role="group">
                                            <a href="<?= base_url('admin/exercises/' . $exercise['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil me-1"></i>Edit
                                            </a>
                                            <a href="<?= base_url('admin/exercises/' . $exercise['id'] . '/delete') ?>" 
                                               class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Are you sure you want to delete this exercise?');">
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
                <i class="bi bi-pencil-square text-muted" style="font-size: 4rem;"></i>
                <h4 class="mt-3 mb-2">No exercises found</h4>
                <p class="text-muted mb-4">Get started by creating your first exercise</p>
                <?php if (isset($lesson)): ?>
                    <a href="<?= base_url('admin/exercises/create/' . $lesson['id']) ?>" class="btn btn-primary btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>Create Exercise
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('admin/exercises/create') ?>" class="btn btn-primary btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>Create Exercise
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

