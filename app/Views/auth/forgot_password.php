<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-lg fade-in-up">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="bi bi-key text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h2 class="fw-bold">Forgot Password?</h2>
                    <p class="text-muted">Enter your email address and we'll send you a link to reset your password</p>
                </div>
                <form method="POST" action="<?= base_url('auth/forgot-password') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold">
                            <i class="bi bi-envelope me-2"></i>Email Address
                        </label>
                        <input type="email" class="form-control form-control-lg" id="email" name="email" value="<?= old('email') ?>" placeholder="you@example.com" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                        <i class="bi bi-send me-2"></i>Send Reset Link
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

