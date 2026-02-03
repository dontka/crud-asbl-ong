<?php

/**
 * User Controller
 * Based on Phase 4: Backend Development - Step 4.3 Controllers and Business Logic
 * Handles user authentication and user management
 */

class UserController extends Controller
{
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    /**
     * Show login form
     */
    public function login()
    {
        if ($this->isAuthenticated()) {
            $this->redirect('/dashboard');
        }

        $flash = $this->getFlash();
        $this->renderContent('auth/login', [
            'flash' => $flash
        ]);
    }

    /**
     * Process login
     */
    public function authenticate()
    {
        if ($this->isAuthenticated()) {
            $this->redirect('/dashboard');
        }

        $data = $this->getPostData();

        if (empty($data['username']) || empty($data['password'])) {
            $this->setFlash('error', 'Username and password are required.');
            $this->redirect('/login');
        }

        $user = $this->userModel->authenticate($data['username'], $data['password']);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user'] = $user;
            $this->setFlash('success', 'Welcome back, ' . $user['username'] . '!');
            $this->redirect('/dashboard');
        } else {
            $this->setFlash('error', 'Invalid username or password.');
            $this->redirect('/login');
        }
    }

    /**
     * Logout user
     */
    public function logout()
    {
        session_destroy();
        $this->setFlash('success', 'You have been logged out.');
        $this->redirect('/login');
    }

    /**
     * Show user profile
     */
    public function profile()
    {
        $this->requireAuth();
        $user = $this->getCurrentUser();
        $flash = $this->getFlash();

        $this->renderPage('users/profile', [
            'user' => $user,
            'flash' => $flash
        ]);
    }

    /**
     * Update user profile
     */
    public function updateProfile()
    {
        $this->requireAuth();
        $user = $this->getCurrentUser();
        $data = $this->getPostData();

        try {
            $updateData = [
                'id' => $user['id'],
                'username' => $this->sanitize($data['username'] ?? ''),
                'email' => $this->sanitize($data['email'] ?? ''),
            ];

            // Only update password if provided
            if (!empty($data['password'])) {
                $updateData['password'] = $data['password'];
            }

            $this->userModel->validate($updateData);
            $this->userModel->save($updateData);

            // Update session data
            $_SESSION['user'] = array_merge($user, $updateData);
            unset($_SESSION['user']['password']); // Don't store password in session

            $this->setFlash('success', 'Profile updated successfully.');
        } catch (Exception $e) {
            $this->handleValidationError($e);
        }

        $this->redirect('/profile');
    }

    /**
     * List all users (admin only)
     */
    public function index()
    {
        $this->requireRole('admin');

        $users = $this->userModel->findAll([], 'username ASC');
        $flash = $this->getFlash();

        $this->renderPage('users/index', [
            'users' => $users,
            'flash' => $flash
        ]);
    }

    /**
     * Show create user form (admin only)
     */
    public function create()
    {
        $this->requireRole('admin');
        $flash = $this->getFlash();

        $this->renderPage('users/create', [
            'flash' => $flash
        ]);
    }

    /**
     * Store new user (admin only)
     */
    public function store()
    {
        $this->requireRole('admin');
        $data = $this->getPostData();

        try {
            $userData = [
                'username' => $this->sanitize($data['username'] ?? ''),
                'email' => $this->sanitize($data['email'] ?? ''),
                'password' => $data['password'] ?? '',
                'role' => $data['role'] ?? 'visitor'
            ];

            $this->userModel->validate($userData);
            $this->userModel->save($userData);

            $this->setFlash('success', 'User created successfully.');
            $this->redirect('/users');
        } catch (Exception $e) {
            $this->handleValidationError($e);
        }
    }

    /**
     * Show edit user form (admin only)
     */
    public function edit()
    {
        $this->requireRole('admin');
        $id = $this->getQueryData()['id'] ?? null;

        if (!$id) {
            $this->redirect('/users');
        }

        $user = $this->userModel->findById($id);
        if (!$user) {
            $this->setFlash('error', 'User not found.');
            $this->redirect('/users');
        }

        $flash = $this->getFlash();

        $this->renderPage('users/edit', [
            'user' => $user,
            'flash' => $flash
        ]);
    }

    /**
     * Update user (admin only)
     */
    public function update()
    {
        $this->requireRole('admin');
        $data = $this->getPostData();
        $id = $data['id'] ?? null;

        if (!$id) {
            $this->redirect('/users');
        }

        try {
            $userData = [
                'id' => $id,
                'username' => $this->sanitize($data['username'] ?? ''),
                'email' => $this->sanitize($data['email'] ?? ''),
                'role' => $data['role'] ?? 'visitor'
            ];

            // Only update password if provided
            if (!empty($data['password'])) {
                $userData['password'] = $data['password'];
            }

            $this->userModel->validate($userData);
            $this->userModel->save($userData);

            $this->setFlash('success', 'User updated successfully.');
            $this->redirect('/users');
        } catch (Exception $e) {
            $this->handleValidationError($e);
        }
    }

    /**
     * Delete user (admin only)
     */
    public function delete()
    {
        $this->requireRole('admin');
        $id = $this->getQueryData()['id'] ?? null;

        if (!$id) {
            $this->redirect('/users');
        }

        try {
            $this->userModel->delete($id);
            $this->setFlash('success', 'User deleted successfully.');
        } catch (Exception $e) {
            $this->setFlash('error', 'Failed to delete user: ' . $e->getMessage());
        }

        $this->redirect('/users');
    }
}
