<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('courses') ?>">Courses</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('courses/' . $course['id']) ?>"><?= esc($course['title']) ?></a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('courses/' . $course['id'] . '/module/' . $module['id']) ?>"><?= esc($module['title']) ?></a></li>
        <li class="breadcrumb-item active"><?= esc($lesson['title']) ?></li>
    </ol>
</nav>

<h2><?= esc($lesson['title']) ?></h2>

<?php if ($is_completed): ?>
    <div class="alert alert-success">
        <i class="bi bi-check-circle-fill"></i> You've completed this lesson!
    </div>
<?php endif; ?>

<div class="lesson-content mt-4">
    <?php if (!empty($lesson['content'])): ?>
        <div class="content-section mb-4">
            <?= $lesson['content'] ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($lesson['code_examples'])): ?>
        <div class="code-examples mb-4">
            <h4>Code Example</h4>
            <pre><code class="language-python"><?= esc($lesson['code_examples']) ?></code></pre>
        </div>
    <?php endif; ?>
</div>

<?php if (!empty($lesson['exercises'])): ?>
    <div class="exercises mt-5">
        <h3>Exercises</h3>
        <?php foreach ($lesson['exercises'] as $exercise): ?>
            <div class="card mb-3">
                <div class="card-header">
                    <h5><?= esc($exercise['title']) ?></h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($exercise['description'])): ?>
                        <p><?= esc($exercise['description']) ?></p>
                    <?php endif; ?>
                    
                    <form method="POST" action="<?= base_url('courses/' . $course['id'] . '/module/' . $module['id'] . '/lesson/' . $lesson['id'] . '/exercise') ?>">
                        <?= csrf_field() ?>
                        <input type="hidden" name="exercise_id" value="<?= $exercise['id'] ?>">
                        
                        <div class="mb-3">
                            <label for="code_<?= $exercise['id'] ?>" class="form-label">Your Code</label>
                            <textarea class="form-control font-monospace" id="code_<?= $exercise['id'] ?>" name="code" rows="10" required><?= esc($exercise['starter_code'] ?? '') ?></textarea>
                        </div>
                        
                        <?php if (!empty($exercise['hints'])): ?>
                            <div class="alert alert-info">
                                <strong>Hint:</strong> <?= esc($exercise['hints']) ?>
                            </div>
                        <?php endif; ?>
                        
                        <button type="submit" class="btn btn-primary">Submit Code</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
