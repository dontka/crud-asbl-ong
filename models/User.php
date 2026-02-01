<?php

/**
 * User Model
 * Based on Phase 4: Backend Development - Step 4.2 Specific Models
 * Handles user authentication and roles
 */

class User extends Model
{
    protected $table = 'users';

    /**
     * Validate user data
     * @param array $data
     * @return bool
     */
    public function validate($data)
    {
        if (empty($data['username']) || strlen($data['username']) < 3) {
            throw new Exception("Username must be at least 3 characters");
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }

        if (empty($data['password'])) {
            throw new Exception("Password is required");
        }

        if (!$this->validatePassword($data['password'])) {
            throw new Exception("Password must be at least 8 characters with uppercase, lowercase, and number");
        }

        return true;
    }

    /**
     * Validate password strength
     * @param string $password
     * @return bool
     */
    public function validatePassword($password)
    {
        // Minimum 8 characters, at least one uppercase, one lowercase, one number
        if (strlen($password) < 8) {
            return false;
        }

        if (!preg_match("/[A-Z]/", $password)) {
            return false;
        }

        if (!preg_match("/[a-z]/", $password)) {
            return false;
        }

        if (!preg_match("/[0-9]/", $password)) {
            return false;
        }

        return true;
    }

    /**
     * Hash password securely
     * @param string $password
     * @return string
     */
    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_ARGON2ID, [
            'memory_cost' => 65536,
            'time_cost' => 4,
            'threads' => 3
        ]);
    }

    /**
     * Verify password
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    /**
     * Authenticate user
     * @param string $username
     * @param string $password
     * @return array|null
     */
    public function authenticate($username, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $this->verifyPassword($password, $user['password'])) {
            return $user;
        }

        return null;
    }

    /**
     * Create new user with secure password
     * @param array $data
     * @return int
     */
    public function create($data)
    {
        $this->validate($data);

        $data['password'] = $this->hashPassword($data['password']);
        $data['created_at'] = date('Y-m-d H:i:s');

        return parent::create($data);
    }

    /**
     * Update user
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data)
    {
        if (isset($data['password'])) {
            $this->validatePassword($data['password']);
            $data['password'] = $this->hashPassword($data['password']);
        }

        return parent::update($id, $data);
    }
}
