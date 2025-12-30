<div class="fade-in-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-2"><span class="text-gradient">Manage Users</span></h2>
            <p class="lead mb-0">View and manage platform users</p>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row g-4 mb-4">
        <div class="col-6 col-md-3">
            <div class="card shadow-sm fade-in-up">
                <div class="card-body text-center">
                    <i class="bi bi-people-fill text-primary" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-0"><?= $total_users ?></h4>
                    <small class="text-muted">Total Users</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm fade-in-up">
                <div class="card-body text-center">
                    <i class="bi bi-person-fill text-success" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-0"><?= $total_students ?></h4>
                    <small class="text-muted">Students</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm fade-in-up">
                <div class="card-body text-center">
                    <i class="bi bi-person-badge-fill text-warning" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-0"><?= $total_instructors ?></h4>
                    <small class="text-muted">Instructors</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm fade-in-up">
                <div class="card-body text-center">
                    <i class="bi bi-shield-fill text-danger" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-0"><?= $total_admins ?></h4>
                    <small class="text-muted">Admins</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="card shadow-sm mb-4 fade-in-up">
        <div class="card-body">
            <div class="btn-group" role="group">
                <a href="<?= base_url('admin/users') ?>" class="btn btn-<?= !$current_role ? 'primary' : 'outline-primary' ?>">
                    All Users
                </a>
                <a href="<?= base_url('admin/users?role=student') ?>" class="btn btn-<?= $current_role === 'student' ? 'primary' : 'outline-primary' ?>">
                    Students
                </a>
                <a href="<?= base_url('admin/users?role=instructor') ?>" class="btn btn-<?= $current_role === 'instructor' ? 'primary' : 'outline-primary' ?>">
                    Instructors
                </a>
                <a href="<?= base_url('admin/users?role=admin') ?>" class="btn btn-<?= $current_role === 'admin' ? 'primary' : 'outline-primary' ?>">
                    Admins
                </a>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <?php if (!empty($users)): ?>
        <div class="card shadow-lg fade-in-up">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td class="ps-4">
                                        <strong><?= esc($user['first_name'] . ' ' . $user['last_name']) ?></strong>
                                        <br>
                                        <small class="text-muted">@<?= esc($user['username']) ?></small>
                                    </td>
                                    <td><?= esc($user['email']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : ($user['role'] === 'instructor' ? 'warning' : 'primary') ?>">
                                            <?= ucfirst($user['role']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= ($user['email_verified'] ?? 0) ? 'success' : 'secondary' ?>">
                                            <?= ($user['email_verified'] ?? 0) ? 'Verified' : 'Unverified' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?= date('M d, Y', strtotime($user['created_at'])) ?></small>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="<?= base_url('admin/users/' . $user['id'] . '/edit') ?>" class="btn btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <?php if ($user['id'] != session()->get('user_id')): ?>
                                                <a href="<?= base_url('admin/users/' . $user['id'] . '/delete') ?>" 
                                                   class="btn btn-outline-danger"
                                                   onclick="return confirm('Are you sure you want to delete this user?');"
                                                   title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            <?php endif; ?>
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
                <i class="bi bi-people text-muted" style="font-size: 4rem;"></i>
                <h4 class="mt-3 mb-2">No users found</h4>
                <p class="text-muted">No users match the selected filter</p>
            </div>
        </div>
    <?php endif; ?>
</div>

