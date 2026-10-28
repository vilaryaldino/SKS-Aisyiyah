# TODO: Fix Myth/Auth to Match Custom Views

## Step 1: Update Auth.php Configuration

- [ ] Modify vendor/myth/auth/src/Config/Auth.php to use custom views for login and register.

## Step 2: Update Routes.php

- [ ] Change app/Config/Routes.php to use Myth/Auth routes for login and register instead of Admin controller.

## Step 3: Edit Login View

- [ ] Update app/Views/pages/akun/login.php to include proper form action, method, CSRF token, and input names for Myth/Auth.

## Step 4: Edit Register View

- [ ] Update app/Views/pages/akun/register.php similarly for register functionality.

## Step 5: Test and Verify

- [ ] Ensure the changes work correctly and authentication functions as expected.
