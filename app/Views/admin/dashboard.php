<h2>Admin Dashboard</h2>

<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Courses</h5>
                <h2><?= $total_courses ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Published Courses</h5>
                <h2><?= $published_courses ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <h2><?= $total_users ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Completed Lessons</h5>
                <h2><?= $total_progress ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <h3>Quick Actions</h3>
    <a href="<?= base_url('admin/courses/create') ?>" class="btn btn-primary">Create New Course</a>
    <a href="<?= base_url('admin/courses') ?>" class="btn btn-secondary">Manage Courses</a>
    <a href="<?= base_url('admin/lessons') ?>" class="btn btn-secondary">Manage Lessons</a>
</div>

