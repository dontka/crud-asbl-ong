<?php

/**
 * Abstract Model Class
 * Based on Phase 4: Backend Development - Step 4.1 Abstract Model Class
 * Provides generic CRUD operations for all entities
 */

abstract class Model
{
    protected $db;
    protected $table;
    protected $primaryKey = 'id';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Get all records from the table
     * @param array $conditions Optional WHERE conditions
     * @param string $orderBy Optional ORDER BY clause
     * @param int $limit Optional LIMIT
     * @return array
     */
    public function findAll($conditions = [], $orderBy = '', $limit = null)
    {
        try {
            $sql = "SELECT * FROM {$this->table}";
            $params = [];

            if (!empty($conditions)) {
                $whereClause = $this->buildWhereClause($conditions);
                $sql .= " WHERE " . $whereClause['clause'];
                $params = $whereClause['params'];
            }

            if (!empty($orderBy)) {
                $sql .= " ORDER BY {$orderBy}";
            }

            if ($limit !== null) {
                $sql .= " LIMIT {$limit}";
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            $this->logError("findAll failed: " . $e->getMessage());
            throw new Exception("Database error: Unable to fetch records");
        }
    }

    /**
     * Find a record by primary key
     * @param mixed $id
     * @return array|null
     */
    public function findById($id)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            $this->logError("findById failed: " . $e->getMessage());
            throw new Exception("Database error: Unable to find record");
        }
    }

    /**
     * Find records by a specific column
     * @param string $column
     * @param mixed $value
     * @param string $orderBy
     * @return array
     */
    public function findBy($column, $value, $orderBy = '')
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE {$column} = ?";
            if (!empty($orderBy)) {
                $sql .= " ORDER BY {$orderBy}";
            }
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$value]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            $this->logError("findBy failed: " . $e->getMessage());
            throw new Exception("Database error: Unable to find records");
        }
    }

    /**
     * Search records by text in specified columns
     * @param string $searchTerm
     * @param array $searchColumns
     * @param array $conditions Additional WHERE conditions
     * @param string $orderBy
     * @param int $limit
     * @return array
     */
    public function search($searchTerm, $searchColumns = [], $conditions = [], $orderBy = '', $limit = null)
    {
        try {
            $sql = "SELECT * FROM {$this->table}";
            $params = [];

            $whereClauses = [];

            // Add search conditions
            if (!empty($searchTerm) && !empty($searchColumns)) {
                $searchConditions = [];
                foreach ($searchColumns as $column) {
                    $searchConditions[] = "{$column} LIKE ?";
                    $params[] = "%{$searchTerm}%";
                }
                $whereClauses[] = "(" . implode(" OR ", $searchConditions) . ")";
            }

            // Add additional conditions
            if (!empty($conditions)) {
                $conditionClause = $this->buildWhereClause($conditions);
                $whereClauses[] = $conditionClause['clause'];
                $params = array_merge($params, $conditionClause['params']);
            }

            if (!empty($whereClauses)) {
                $sql .= " WHERE " . implode(" AND ", $whereClauses);
            }

            if (!empty($orderBy)) {
                $sql .= " ORDER BY {$orderBy}";
            }

            if ($limit !== null) {
                $sql .= " LIMIT {$limit}";
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            $this->logError("search failed: " . $e->getMessage());
            throw new Exception("Database error: Unable to search records");
        }
    }

    /**
     * Save a record (insert or update)
     * @param array $data
     * @return mixed The ID of the inserted/updated record
     */
    public function save($data)
    {
        try {
            if (isset($data[$this->primaryKey]) && !empty($data[$this->primaryKey])) {
                // Update
                return $this->update($data[$this->primaryKey], $data);
            } else {
                // Insert
                return $this->insert($data);
            }
        } catch (PDOException $e) {
            $this->logError("save failed: " . $e->getMessage());
            throw new Exception("Database error: Unable to save record");
        }
    }

    /**
     * Insert a new record
     * @param array $data
     * @return mixed The ID of the inserted record
     */
    protected function insert($data)
    {
        $columns = array_keys($data);
        $placeholders = str_repeat('?,', count($columns) - 1) . '?';
        $sql = "INSERT INTO {$this->table} (" . implode(',', $columns) . ") VALUES ({$placeholders})";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_values($data));
        return $this->db->lastInsertId();
    }

    /**
     * Update an existing record
     * @param mixed $id
     * @param array $data
     * @return mixed The ID of the updated record
     */
    protected function update($id, $data)
    {
        unset($data[$this->primaryKey]); // Don't update primary key
        $columns = array_keys($data);
        $setClause = implode('=?,', $columns) . '=?';
        $sql = "UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = ?";

        $params = array_values($data);
        $params[] = $id;

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $id;
    }

    /**
     * Delete a record by primary key
     * @param mixed $id
     * @return bool
     */
    public function delete($id)
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            $this->logError("delete failed: " . $e->getMessage());
            throw new Exception("Database error: Unable to delete record");
        }
    }

    /**
     * Build WHERE clause from conditions array
     * @param array $conditions
     * @return array ['clause' => string, 'params' => array]
     */
    protected function buildWhereClause($conditions)
    {
        $clauses = [];
        $params = [];

        foreach ($conditions as $column => $value) {
            if (is_array($value)) {
                // Handle operators like ['>', 10] or ['IN', [1,2,3]]
                $operator = strtoupper($value[0]);
                $val = $value[1];
                if ($operator === 'IN') {
                    $placeholders = str_repeat('?,', count($val) - 1) . '?';
                    $clauses[] = "{$column} IN ({$placeholders})";
                    $params = array_merge($params, $val);
                } else {
                    $clauses[] = "{$column} {$operator} ?";
                    $params[] = $val;
                }
            } else {
                $clauses[] = "{$column} = ?";
                $params[] = $value;
            }
        }

        return [
            'clause' => implode(' AND ', $clauses),
            'params' => $params
        ];
    }

    /**
     * Log errors (simple implementation, can be extended)
     * @param string $message
     */
    protected function logError($message)
    {
        // For now, just log to error log
        error_log("[Model Error] {$message}");
    }

    /**
     * Validate data (to be implemented in subclasses)
     * @param array $data
     * @return bool
     */
    abstract public function validate($data);
}
