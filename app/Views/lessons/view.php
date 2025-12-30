<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('courses') ?>">Courses</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('courses/' . $course['id']) ?>"><?= esc($course['title']) ?></a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('courses/' . $course['id'] . '/module/' . $module['id']) ?>"><?= esc($module['title']) ?></a></li>
        <li class="breadcrumb-item active"><?= esc($lesson['title']) ?></li>
    </ol>
</nav>

<div class="row">
    <div class="col-lg-9">
        <!-- Lesson Header -->
        <div class="card shadow-lg mb-4 fade-in-up">
            <?php if (!empty($lesson['featured_image'])): ?>
                <img src="<?= esc($lesson['featured_image']) ?>" class="card-img-top" alt="<?= esc($lesson['title']) ?>" style="max-height: 300px; object-fit: cover;">
            <?php endif; ?>
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h2 class="mb-2"><?= esc($lesson['title']) ?></h2>
                        <?php if (!empty($lesson['estimated_time'])): ?>
                            <p class="text-muted mb-0">
                                <i class="bi bi-clock me-2"></i>Estimated time: <?= $lesson['estimated_time'] ?> minutes
                                <?php if ($progress && !empty($progress['time_spent'])): ?>
                                    | Time spent: <?= round($progress['time_spent'] / 60, 1) ?> minutes
                                <?php endif; ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex gap-2">
                        <?php if ($is_completed): ?>
                            <span class="badge bg-success fs-6">
                                <i class="bi bi-check-circle-fill me-2"></i>Completed
                            </span>
                        <?php else: ?>
                            <form method="POST" action="<?= base_url('courses/' . $course['id'] . '/module/' . $module['id'] . '/lesson/' . $lesson['id'] . '/complete') ?>" class="d-inline">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="bi bi-check-circle me-2"></i>Mark as Complete
                                </button>
                            </form>
                        <?php endif; ?>
                        <form method="POST" action="<?= base_url('courses/' . $course['id'] . '/module/' . $module['id'] . '/lesson/' . $lesson['id'] . '/bookmark') ?>" class="d-inline">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-<?= $is_bookmarked ? 'warning' : 'outline-secondary' ?> btn-sm">
                                <i class="bi bi-bookmark<?= $is_bookmarked ? '-fill' : '' ?> me-2"></i><?= $is_bookmarked ? 'Bookmarked' : 'Bookmark' ?>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Learning Objectives -->
                <?php if (!empty($lesson['objectives'])): ?>
                    <div class="alert alert-info mb-3">
                        <h6 class="alert-heading mb-2">
                            <i class="bi bi-bullseye me-2"></i>Learning Objectives
                        </h6>
                        <ul class="mb-0">
                            <?php 
                            $objectives = explode("\n", $lesson['objectives']);
                            foreach ($objectives as $objective): 
                                $objective = trim($objective);
                                if (!empty($objective)):
                            ?>
                                <li><?= esc($objective) ?></li>
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Lesson Content -->
        <div class="card shadow-sm mb-4 fade-in-up">
            <div class="card-body p-4">
                <div class="lesson-content">
                    <?php if (!empty($lesson['content'])): ?>
                        <div class="content-section mb-4">
                            <?= $lesson['content'] ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>No content available for this lesson yet.
                        </div>
                    <?php endif; ?>

                    <!-- Code Examples with Syntax Highlighting -->
                    <?php if (!empty($lesson['code_examples'])): ?>
                        <div class="code-examples mb-4">
                            <h5 class="mb-3">
                                <i class="bi bi-code-square me-2"></i>Code Examples
                            </h5>
                            <pre class="language-python"><code class="language-python"><?= esc($lesson['code_examples']) ?></code></pre>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Exercises -->
        <?php if (!empty($lesson['exercises'])): ?>
            <div class="card shadow-sm mb-4 fade-in-up">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Practice Exercises</h5>
                </div>
                <div class="card-body">
                    <?php foreach ($lesson['exercises'] as $exercise): ?>
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0"><?= esc($exercise['title']) ?></h6>
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
                                            <strong><i class="bi bi-lightbulb me-2"></i>Hint:</strong> <?= esc($exercise['hints']) ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-send me-2"></i>Submit Code
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Navigation Buttons -->
        <div class="card shadow-sm mb-4 fade-in-up">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <?php if (!empty($navigation['previous'])): ?>
                        <a href="<?= $navigation['previous']['url'] ?>" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-left me-2"></i>Previous: <?= esc($navigation['previous']['title']) ?>
                        </a>
                    <?php else: ?>
                        <span></span>
                    <?php endif; ?>
                    
                    <?php if (!empty($navigation['next'])): ?>
                        <a href="<?= $navigation['next']['url'] ?>" class="btn btn-primary">
                            Next: <?= esc($navigation['next']['title']) ?><i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    <?php else: ?>
                        <span></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Navigation -->
    <div class="col-lg-3">
        <div class="card shadow-sm sticky-top" style="top: 20px;">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="bi bi-list-ul me-2"></i>Course Navigation</h6>
            </div>
            <div class="card-body p-0">
                <?php
                // Get all modules for this course
                $moduleModel = new \App\Models\ModuleModel();
                $allModules = $moduleModel->where('course_id', $course['id'])
                                        ->orderBy('sort_order', 'ASC')
                                        ->findAll();
                
                // Get all lessons for each module
                $lessonModel = new \App\Models\LessonModel();
                foreach ($allModules as &$mod) {
                    $mod['lessons'] = $lessonModel->where('module_id', $mod['id'])
                                                 ->where('status', 'published')
                                                 ->orderBy('sort_order', 'ASC')
                                                 ->findAll();
                }
                ?>
                
                <div class="list-group list-group-flush">
                    <?php foreach ($allModules as $mod): ?>
                        <div class="list-group-item">
                            <strong class="d-block mb-2"><?= esc($mod['title']) ?></strong>
                            <?php if (!empty($mod['lessons'])): ?>
                                <ul class="list-unstyled mb-0 ms-3">
                                    <?php foreach ($mod['lessons'] as $les): ?>
                                        <li class="mb-1">
                                            <?php if ($les['id'] == $lesson['id']): ?>
                                                <span class="text-primary fw-semibold">
                                                    <i class="bi bi-arrow-right-circle-fill me-1"></i><?= esc($les['title']) ?>
                                                </span>
                                            <?php else: ?>
                                                <a href="<?= base_url('courses/' . $course['id'] . '/module/' . $mod['id'] . '/lesson/' . $les['id']) ?>" class="text-decoration-none">
                                                    <i class="bi bi-circle me-1"></i><?= esc($les['title']) ?>
                                                </a>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Prism.js for code syntax highlighting -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>

<style>
    .lesson-content {
        font-size: 1.1rem;
        line-height: 1.8;
    }
    .lesson-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1rem 0;
    }
    .lesson-content pre {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 1rem;
        overflow-x: auto;
    }
    .lesson-content code {
        font-family: 'Courier New', monospace;
    }
</style>

<script>
    // Time tracking - track time spent on lesson
    (function() {
        var startTime = Date.now();
        var trackingInterval = 60000; // Track every 60 seconds
        var lastTracked = 0;

        function trackTime() {
            var currentTime = Date.now();
            var secondsSpent = Math.floor((currentTime - startTime) / 1000);
            var secondsToTrack = secondsSpent - lastTracked;

            if (secondsToTrack >= 60) { // Track at least 60 seconds
                fetch('<?= base_url('courses/' . $course['id'] . '/module/' . $module['id'] . '/lesson/' . $lesson['id'] . '/track-time') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: '<?= csrf_token() ?>=<?= csrf_hash() ?>&seconds=' + secondsToTrack
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        lastTracked = secondsSpent;
                    }
                })
                .catch(error => console.error('Time tracking error:', error));
            }
        }

        // Track time every minute
        setInterval(trackTime, trackingInterval);

        // Track time when leaving the page
        window.addEventListener('beforeunload', function() {
            var secondsSpent = Math.floor((Date.now() - startTime) / 1000);
            var secondsToTrack = secondsSpent - lastTracked;
            
            if (secondsToTrack > 0) {
                // Use sendBeacon for reliable tracking on page unload
                navigator.sendBeacon(
                    '<?= base_url('courses/' . $course['id'] . '/module/' . $module['id'] . '/lesson/' . $lesson['id'] . '/track-time') ?>',
                    '<?= csrf_token() ?>=<?= csrf_hash() ?>&seconds=' + secondsToTrack
                );
            }
        });
    })();
</script>
