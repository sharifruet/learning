<div class="fade-in-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-2"><span class="text-gradient">Course Catalog</span></h2>
            <p class="lead mb-0">Browse and explore all available courses</p>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="<?= base_url('courses') ?>" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">
                        <i class="bi bi-search me-2"></i>Search Courses
                    </label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="<?= esc($current_filters['search'] ?? '') ?>" 
                           placeholder="Search by title, description, or tags...">
                </div>
                <div class="col-md-3">
                    <label for="category" class="form-label">
                        <i class="bi bi-tags me-2"></i>Category
                    </label>
                    <select class="form-select" id="category" name="category">
                        <option value="">All Categories</option>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>" 
                                        <?= (isset($current_filters['category_id']) && $current_filters['category_id'] == $category['id']) ? 'selected' : '' ?>>
                                    <?= esc($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="difficulty" class="form-label">
                        <i class="bi bi-bar-chart me-2"></i>Difficulty
                    </label>
                    <select class="form-select" id="difficulty" name="difficulty">
                        <option value="">All Levels</option>
                        <option value="beginner" <?= (isset($current_filters['difficulty']) && $current_filters['difficulty'] == 'beginner') ? 'selected' : '' ?>>Beginner</option>
                        <option value="intermediate" <?= (isset($current_filters['difficulty']) && $current_filters['difficulty'] == 'intermediate') ? 'selected' : '' ?>>Intermediate</option>
                        <option value="advanced" <?= (isset($current_filters['difficulty']) && $current_filters['difficulty'] == 'advanced') ? 'selected' : '' ?>>Advanced</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel me-2"></i>Filter
                    </button>
                </div>
            </form>
            <?php if (!empty($current_filters)): ?>
                <div class="mt-3">
                    <a href="<?= base_url('courses') ?>" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i>Clear Filters
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Course Grid -->
    <?php if (!empty($courses)): ?>
        <div class="row g-4">
            <?php foreach ($courses as $index => $course): ?>
                <div class="col-md-4" style="animation-delay: <?= $index * 0.1 ?>s">
                    <div class="card course-card h-100 fade-in-up shadow-sm">
                        <div class="course-image">
                            <?php if (!empty($course['image'])): ?>
                                <img src="<?= esc($course['image']) ?>" alt="<?= esc($course['title']) ?>" class="img-fluid">
                            <?php else: ?>
                                <i class="bi bi-filetype-py"></i>
                            <?php endif; ?>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <span class="badge bg-<?= $course['difficulty'] === 'beginner' ? 'success' : ($course['difficulty'] === 'intermediate' ? 'warning' : 'danger') ?> me-2">
                                    <?= ucfirst($course['difficulty']) ?>
                                </span>
                                <?php if (isset($course['category']) && !empty($course['category'])): ?>
                                    <span class="badge bg-secondary"><?= esc($course['category']['name']) ?></span>
                                <?php endif; ?>
                            </div>
                            <h5 class="card-title"><?= esc($course['title']) ?></h5>
                            <p class="card-text text-muted flex-grow-1">
                                <?= esc(character_limiter($course['description'] ?? '', 100)) ?>
                            </p>
                            <div class="mt-auto">
                                <a href="<?= base_url('courses/' . $course['id']) ?>" class="btn btn-primary w-100">
                                    <i class="bi bi-arrow-right-circle me-2"></i>View Course
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info fade-in-up">
            <div class="d-flex align-items-center">
                <i class="bi bi-info-circle-fill me-3 fs-3"></i>
                <div>
                    <h5 class="mb-1">No courses found</h5>
                    <p class="mb-0">
                        <?php if (!empty($current_filters)): ?>
                            Try adjusting your search or filter criteria.
                        <?php else: ?>
                            Check back soon for exciting courses!
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
