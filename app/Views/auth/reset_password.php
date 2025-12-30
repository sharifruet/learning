<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-lg fade-in-up">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="bi bi-shield-lock text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h2 class="fw-bold">Reset Your Password</h2>
                    <p class="text-muted">Enter your new password below</p>
                </div>
                <form method="POST" action="<?= base_url('auth/reset-password') ?>">
                    <?= csrf_field() ?>
                    <input type="hidden" name="token" value="<?= esc($token) ?>">
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">
                            <i class="bi bi-lock me-2"></i>New Password
                        </label>
                        <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Minimum 6 characters" required>
                        <small class="form-text text-muted">Minimum 6 characters</small>
                    </div>
                    <div class="mb-4">
                        <label for="confirm_password" class="form-label fw-semibold">
                            <i class="bi bi-lock-fill me-2"></i>Confirm New Password
                        </label>
                        <input type="password" class="form-control form-control-lg" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                        <i class="bi bi-check-circle me-2"></i>Reset Password
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="text-muted mb-0">
                        <a href="<?= base_url('auth/login') ?>" class="text-decoration-none fw-semibold">
                            <i class="bi bi-arrow-left me-1"></i>Back to Login
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

