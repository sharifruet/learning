<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-lg fade-in-up">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="bi bi-person-plus text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h2 class="fw-bold">Create Your Account</h2>
                    <p class="text-muted">Start learning Python today</p>
                </div>
                <form method="POST" action="<?= base_url('auth/register') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="username" class="form-label fw-semibold">
                            <i class="bi bi-person me-2"></i>Username
                        </label>
                        <input type="text" class="form-control form-control-lg" id="username" name="username" value="<?= old('username') ?>" placeholder="Choose a username" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="first_name" class="form-label fw-semibold">First Name</label>
                            <input type="text" class="form-control form-control-lg" id="first_name" name="first_name" value="<?= old('first_name') ?>" placeholder="John">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="last_name" class="form-label fw-semibold">Last Name</label>
                            <input type="text" class="form-control form-control-lg" id="last_name" name="last_name" value="<?= old('last_name') ?>" placeholder="Doe">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">
                            <i class="bi bi-envelope me-2"></i>Email Address
                        </label>
                        <input type="email" class="form-control form-control-lg" id="email" name="email" value="<?= old('email') ?>" placeholder="you@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">
                            <i class="bi bi-lock me-2"></i>Password
                        </label>
                        <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Minimum 6 characters" required>
                        <small class="form-text text-muted">Minimum 6 characters</small>
                    </div>
                    <div class="mb-4">
                        <label for="confirm_password" class="form-label fw-semibold">
                            <i class="bi bi-lock-fill me-2"></i>Confirm Password
                        </label>
                        <input type="password" class="form-control form-control-lg" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                        <i class="bi bi-person-plus me-2"></i>Create Account
                    </button>
                </form>

                <div class="divider my-4">
                    <span class="divider-text">or sign up with</span>
                </div>

                <div class="d-grid gap-2">
                    <a href="<?= base_url('auth/google') ?>" class="btn btn-outline-danger btn-lg">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="me-2">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                        Sign up with Google
                    </a>
                    <a href="<?= base_url('auth/facebook') ?>" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-facebook me-2"></i>Sign up with Facebook
                    </a>
                </div>

                <div class="text-center mt-4">
                    <p class="text-muted mb-0">Already have an account? 
                        <a href="<?= base_url('auth/login') ?>" class="text-decoration-none fw-semibold">Sign in here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
