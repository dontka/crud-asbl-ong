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
            throw new Exception("Invalid email address");
        }

        if (!isset($data['role']) || !in_array($data['role'], ['admin', 'moderator', 'visitor'])) {
            $data['role'] = 'visitor'; // Default role
        }

        // Check for duplicate username
        if ($this->isUsernameTaken($data['username'], $data['id'] ?? null)) {
            throw new Exception("Username already taken");
        }

        // Check for duplicate email
        if ($this->isEmailTaken($data['email'], $data['id'] ?? null)) {
            throw new Exception("Email already taken");
        }

        return true;
    }

    /**
     * Authenticate user
     * @param string $username
     * @param string $password
     * @return array|null User data if authenticated
     */
    public function authenticate($username, $password)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE username = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                unset($user['password']); // Don't return password
                return $user;
            }

            return null;
        } catch (PDOException $e) {
            $this->logError("Authentication failed: " . $e->getMessage());
            throw new Exception("Authentication error");
        }
    }

    /**
     * Save user (hash password if provided)
     * @param array $data
     * @return mixed
     */
    public function save($data)
    {
        // Hash password if provided
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } elseif (!isset($data[$this->primaryKey])) {
            throw new Exception("Password is required for new users");
        }

        return parent::save($data);
    }

    /**
     * Check if username is taken
     * @param string $username
     * @param int|null $excludeId
     * @return bool
     */
    private function isUsernameTaken($username, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE username = ?";
        $params = [$username];

        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Check if email is taken
     * @param string $email
     * @param int|null $excludeId
     * @return bool
     */
    private function isEmailTaken($email, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE email = ?";
        $params = [$email];

        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Get users by role
     * @param string $role
     * @return array
     */
    public function getByRole($role)
    {
        return $this->findBy('role', $role, 'username ASC');
    }
}
