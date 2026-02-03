<?php

class HRController extends Controller
{
    /**
     * Check user has HR access
     */
    public function __construct()
    {
        parent::__construct();

        // Check if user has access to HR module
        if (!$this->hasHRAccess()) {
            $this->redirect('/dashboard');
        }
    }

    /**
     * Check if user has HR module access
     */
    private function hasHRAccess()
    {
        $allowedRoles = ['admin', 'moderator', 'hr_manager', 'hr_supervisor'];
        return in_array($_SESSION['user']['role'] ?? null, $allowedRoles);
    }

    /**
     * Display HR Dashboard
     */
    public function dashboard()
    {
        try {
            // Get statistics
            $employee = new Employee();
            $allEmployees = $employee->findAll(['employment_status' => 'active']);
            $totalEmployees = count($allEmployees);

            // Get employees on leave today
            $absence = new Absence();
            $allAbsences = $absence->findAll(['status' => 'approved']);
            $today = date('Y-m-d');
            $onLeaveToday = 0;
            $pendingApprovals = 0;
            $recentAbsences = [];

            foreach ($allAbsences as $abs) {
                if ($abs['start_date'] <= $today && $abs['end_date'] >= $today) {
                    $onLeaveToday++;
                }
                if ($abs['status'] === 'pending') {
                    $pendingApprovals++;
                }
                $recentAbsences[] = $abs;
            }

            // Get pending absences count
            $pendingAbsencesAll = $absence->findAll(['status' => 'pending']);
            $pendingApprovals = count($pendingAbsencesAll);

            // Limit recent absences
            $recentAbsences = array_slice($allAbsences, 0, 10);

            // Get upcoming evaluations
            $evaluation = new Evaluation();
            $allEvaluations = $evaluation->findAll();
            $upcomingEvaluations = count($allEvaluations); // Simplified

            // Get departments (from employees)
            $departments = [];
            foreach ($allEmployees as $emp) {
                if (!empty($emp['department']) && !in_array($emp['department'], $departments)) {
                    $departments[] = $emp['department'];
                }
            }

            return $this->renderPage('hr/dashboard', [
                'totalEmployees' => $totalEmployees,
                'onLeaveToday' => $onLeaveToday,
                'pendingApprovals' => $pendingApprovals,
                'upcomingEvaluations' => $upcomingEvaluations,
                'recentAbsences' => $recentAbsences,
                'departments' => $departments,
                'pageTitle' => 'Tableau de Bord RH'
            ]);
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/dashboard');
        }
    }

    /**
     * List employees
     */
    public function index()
    {
        try {
            $page = $_GET['page'] ?? 1;
            $department = $_GET['department'] ?? null;
            $search = $_GET['search'] ?? null;

            $conditions = [];
            if ($department) {
                $conditions['department'] = $department;
            }

            // Get employees
            $employee = new Employee();
            $allEmployees = $employee->findAll($conditions);

            // Filter by search if provided
            if ($search) {
                $allEmployees = array_filter($allEmployees, function ($emp) use ($search) {
                    $searchLower = strtolower($search);
                    return stripos($emp['first_name'] ?? '', $search) !== false ||
                        stripos($emp['last_name'] ?? '', $search) !== false ||
                        stripos($emp['email'] ?? '', $search) !== false ||
                        stripos($emp['employee_number'] ?? '', $search) !== false;
                });
            }

            // Simple pagination
            $limit = 15;
            $total = count($allEmployees);
            $totalPages = ceil($total / $limit);
            $offset = ($page - 1) * $limit;
            $employees = array_slice($allEmployees, $offset, $limit);

            return $this->renderPage('hr/employees/index', [
                'employees' => $employees,
                'page' => $page,
                'totalPages' => $totalPages,
                'department' => $department,
                'search' => $search,
                'pageTitle' => 'Gestion des Employés'
            ]);
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/dashboard');
        }
    }

    /**
     * Show employee details
     */
    public function show($id)
    {
        try {
            $employee = new Employee();
            $emp = $employee->findById($id);

            if (!$emp) {
                $this->setFlash('error', 'Employé non trouvé');
                return $this->redirect('/hr');
            }

            return $this->renderPage('hr/employees/show', [
                'employee' => $emp,
                'pageTitle' => 'Détails Employé'
            ]);
        } catch (\Exception $e) {
            $this->setFlash('error', 'Employé non trouvé');
            return $this->redirect('/hr');
        }
    }

    /**
     * Create new employee
     */
    public function create()
    {
        try {
            return $this->renderPage('hr/employees/create', [
                'pageTitle' => 'Créer un Nouvel Employé'
            ]);
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/hr');
        }
    }

    /**
     * Store new employee
    /**
     * Store new employee
     */
    public function store()
    {
        try {
            // Basic validation
            if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email'])) {
                $this->setFlash('error', 'Veuillez remplir tous les champs obligatoires');
                return $this->redirect('/hr/create');
            }

            // Filter POST data to only include valid fields
            $validFields = [
                'first_name',
                'last_name',
                'email',
                'phone',
                'birth_date',
                'gender',
                'employee_number',
                'position',
                'department',
                'hire_date',
                'employment_type',
                'salary_gross',
                'address',
                'city',
                'postal_code',
                'country'
            ];

            $data = array_filter($_POST, function ($key) use ($validFields) {
                return in_array($key, $validFields);
            }, ARRAY_FILTER_USE_KEY);

            $data['employment_status'] = 'active';

            $employee = new Employee();
            $result = $employee->save($data);

            if ($result) {
                $this->setFlash('success', 'Employé créé avec succès');
            } else {
                $this->setFlash('error', 'Erreur lors de la création de l\'employé');
            }
            return $this->redirect('/hr');
        } catch (\Exception $e) {
            error_log('HR Store Error: ' . $e->getMessage());
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/hr/create');
        }
    }

    /**
     * Edit employee
     */
    public function edit($id)
    {
        try {
            $employee = new Employee();
            $emp = $employee->findById($id);

            if (!$emp) {
                $this->setFlash('error', 'Employé non trouvé');
                return $this->redirect('/hr');
            }

            return $this->renderPage('hr/employees/edit', [
                'employee' => $emp,
                'pageTitle' => 'Modifier Employé'
            ]);
        } catch (\Exception $e) {
            $this->setFlash('error', 'Employé non trouvé');
            return $this->redirect('/hr');
        }
    }

    /**
     * Update employee
     */
    public function update($id)
    {
        try {
            $employee = new Employee();
            $emp = $employee->findById($id);

            if (!$emp) {
                $this->setFlash('error', 'Employé non trouvé');
                return $this->redirect('/hr');
            }

            // Filter POST data to only include valid fields
            $validFields = [
                'first_name',
                'last_name',
                'email',
                'phone',
                'birth_date',
                'gender',
                'employee_number',
                'position',
                'department',
                'hire_date',
                'employment_type',
                'salary_gross',
                'address',
                'city',
                'postal_code',
                'country'
            ];

            $data = array_filter($_POST, function ($key) use ($validFields) {
                return in_array($key, $validFields);
            }, ARRAY_FILTER_USE_KEY);

            $data['id'] = $id;

            $employee = new Employee();
            $employee->save($data);

            $this->setFlash('success', 'Employé mis à jour avec succès');
            return $this->redirect('/hr/' . $id);
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/hr/' . $id . '/edit');
        }
    }

    /**
     * Manage absences
     */
    public function absences()
    {
        try {
            $absence = new Absence();
            $absences = $absence->findAll();

            // Enrich absences with employee data
            $employee = new Employee();
            foreach ($absences as &$absence_data) {
                if (!empty($absence_data['employee_id'])) {
                    $emp = $employee->findById($absence_data['employee_id']);
                    $absence_data['employee_name'] = ($emp['first_name'] ?? '') . ' ' . ($emp['last_name'] ?? '');
                } else {
                    $absence_data['employee_name'] = 'N/A';
                }
            }

            return $this->renderPage('hr/absences/index', [
                'absences' => $absences,
                'pageTitle' => 'Gestion des Absences'
            ]);
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/dashboard');
        }
    }

    /**
     * Show absence details
     */
    public function showAbsence($id)
    {
        try {
            $absence = new Absence();
            $abs = $absence->findById($id);

            if (!$abs) {
                $this->setFlash('error', 'Absence non trouvée');
                return $this->redirect('/hr/absences');
            }

            return $this->renderPage('hr/absences/show', [
                'absence' => $abs,
                'pageTitle' => 'Détails de l\'Absence'
            ]);
        } catch (\Exception $e) {
            $this->setFlash('error', 'Absence non trouvée');
            return $this->redirect('/hr/absences');
        }
    }

    /**
     * Approve absence
     */
    public function approveAbsence($id)
    {
        try {
            $absence = new Absence();
            $abs = $absence->findById($id);

            if (!$abs) {
                $this->setFlash('error', 'Absence non trouvée');
                return $this->redirect('/hr/absences');
            }

            // Mark as approved
            $abs['status'] = 'approved';
            $abs['approved_by'] = $_SESSION['user']['id'] ?? null;
            $abs['approval_date'] = date('Y-m-d H:i:s');
            $absence->save($abs);

            $this->setFlash('success', 'Absence approuvée');
            return $this->redirect('/hr/absences');
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/hr/absences/' . $id);
        }
    }

    /**
     * Reject absence
     */
    public function rejectAbsence($id)
    {
        try {
            $absence = new Absence();
            $abs = $absence->findById($id);

            if (!$abs) {
                $this->setFlash('error', 'Absence non trouvée');
                return $this->redirect('/hr/absences');
            }

            // Mark as rejected
            $abs['status'] = 'rejected';
            $abs['approved_by'] = $_SESSION['user']['id'] ?? null;
            $absence->save($abs);

            $this->setFlash('success', 'Absence rejetée');
            return $this->redirect('/hr/absences');
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/hr/absences/' . $id);
        }
    }

    /**
     * Update leave balance
     */
    private function updateLeaveBalance($employeeId, $daysUsed)
    {
        // Placeholder for leave balance update
    }

    /**
     * Manage evaluations
     */
    public function evaluations()
    {
        try {
            $evaluation = new Evaluation();
            $evaluations = $evaluation->findAll();

            // Enrich evaluations with employee data
            $employee = new Employee();
            foreach ($evaluations as &$eval_data) {
                if (!empty($eval_data['employee_id'])) {
                    $emp = $employee->findById($eval_data['employee_id']);
                    $eval_data['employee_name'] = ($emp['first_name'] ?? '') . ' ' . ($emp['last_name'] ?? '');
                } else {
                    $eval_data['employee_name'] = 'N/A';
                }
            }

            return $this->renderPage('hr/evaluations/index', [
                'evaluations' => $evaluations,
                'pageTitle' => 'Gestion des Évaluations'
            ]);
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/dashboard');
        }
    }

    /**
     * Create evaluation
     */
    public function createEvaluation($employeeId)
    {
        try {
            $employee = new Employee();
            $emp = $employee->findById($employeeId);

            if (!$emp) {
                $this->setFlash('error', 'Employé non trouvé');
                return $this->redirect('/hr/evaluations');
            }

            return $this->renderPage('hr/evaluations/create', [
                'employee' => $emp,
                'pageTitle' => 'Créer une Évaluation'
            ]);
        } catch (\Exception $e) {
            $this->setFlash('error', 'Employé non trouvé');
            return $this->redirect('/hr/evaluations');
        }
    }

    /**
     * Store evaluation
     */
    public function storeEvaluation()
    {
        try {
            $evaluation = new Evaluation();
            $evaluation->save($_POST);
            $evaluation->save();

            $this->setFlash('success', 'Évaluation créée avec succès');
            return $this->redirect('/hr/evaluations');
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/hr/evaluations');
        }
    }

    /**
     * Manage contracts
     */
    public function contracts()
    {
        try {
            $contract = new Contract();
            $contracts = $contract->findAll();

            // Enrich contracts with employee data
            $employee = new Employee();
            foreach ($contracts as &$contract_data) {
                if (!empty($contract_data['employee_id'])) {
                    $emp = $employee->findById($contract_data['employee_id']);
                    $contract_data['employee_name'] = ($emp['first_name'] ?? '') . ' ' . ($emp['last_name'] ?? '');
                } else {
                    $contract_data['employee_name'] = 'N/A';
                }
            }

            return $this->renderPage('hr/contracts/index', [
                'contracts' => $contracts,
                'pageTitle' => 'Gestion des Contrats'
            ]);
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/dashboard');
        }
    }

    /**
     * List trainings
     */
    public function trainings()
    {
        try {
            $training = new Training();
            $trainings = $training->findAll();

            return $this->renderPage('hr/trainings/index', [
                'trainings' => $trainings,
                'pageTitle' => 'Gestion des Formations'
            ]);
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/dashboard');
        }
    }

    /**
     * Create new contract
     */
    public function createContract()
    {
        try {
            $employee = new Employee();
            $employees = $employee->findAll(['employment_status' => 'active']);

            return $this->renderPage('hr/contracts/create', [
                'employees' => $employees,
                'pageTitle' => 'Créer un Nouveau Contrat'
            ]);
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/hr/contracts');
        }
    }

    /**
     * Store new contract
     */
    public function storeContract()
    {
        try {
            // Basic validation
            if (empty($_POST['employee_id']) || empty($_POST['contract_type']) || empty($_POST['start_date'])) {
                $this->setFlash('error', 'Veuillez remplir tous les champs obligatoires');
                return $this->redirect('/hr/create-contract');
            }

            // Filter POST data to only include valid fields
            $validFields = [
                'employee_id',
                'contract_type',
                'contract_number',
                'start_date',
                'end_date',
                'renewal_date',
                'status',
                'position_title',
                'salary',
                'working_hours',
                'probation_period_days',
                'probation_end_date',
                'notes'
            ];

            $data = [];
            foreach ($validFields as $field) {
                if (isset($_POST[$field])) {
                    $data[$field] = $_POST[$field];
                }
            }

            // Save contract
            $contract = new Contract();
            $result = $contract->save($data);

            $this->setFlash('success', 'Contrat créé avec succès');
            return $this->redirect('/hr/contracts');
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/hr/create-contract');
        }
    }

    /**
     * Edit contract
     */
    public function editContract($id)
    {
        try {
            $contract = new Contract();
            $contract_data = $contract->findById($id);

            if (!$contract_data) {
                $this->setFlash('error', 'Contrat non trouvé');
                return $this->redirect('/hr/contracts');
            }

            $employee = new Employee();
            $employees = $employee->findAll(['employment_status' => 'active']);

            return $this->renderPage('hr/contracts/edit', [
                'contract' => $contract_data,
                'employees' => $employees,
                'pageTitle' => 'Éditer le Contrat'
            ]);
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/hr/contracts');
        }
    }

    /**
     * Update contract
     */
    public function updateContract($id)
    {
        try {
            // Get existing contract
            $contract = new Contract();
            $contract_data = $contract->findById($id);

            if (!$contract_data) {
                $this->setFlash('error', 'Contrat non trouvé');
                return $this->redirect('/hr/contracts');
            }

            // Filter POST data
            $validFields = [
                'employee_id',
                'contract_type',
                'contract_number',
                'start_date',
                'end_date',
                'renewal_date',
                'status',
                'position_title',
                'salary',
                'working_hours',
                'probation_period_days',
                'probation_end_date',
                'notes'
            ];

            $data = ['id' => $id];
            foreach ($validFields as $field) {
                if (isset($_POST[$field])) {
                    $data[$field] = $_POST[$field];
                }
            }

            // Save updated contract
            $result = $contract->save($data);

            $this->setFlash('success', 'Contrat mis à jour avec succès');
            return $this->redirect('/hr/contracts');
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/hr/contracts');
        }
    }

    /**
     * Show contract details
     */
    public function showContract($id)
    {
        try {
            $contract = new Contract();
            $contract_data = $contract->findById($id);

            if (!$contract_data) {
                $this->setFlash('error', 'Contrat non trouvé');
                return $this->redirect('/hr/contracts');
            }

            $employee = new Employee();
            $emp = $employee->findById($contract_data['employee_id']);

            return $this->renderPage('hr/contracts/show', [
                'contract' => $contract_data,
                'employee' => $emp,
                'pageTitle' => 'Détails du Contrat'
            ]);
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/hr/contracts');
        }
    }

    /**
     * Delete contract
     */
    public function deleteContract($id)
    {
        try {
            $contract = new Contract();
            $contract_data = $contract->findById($id);

            if (!$contract_data) {
                $this->setFlash('error', 'Contrat non trouvé');
                return $this->redirect('/hr/contracts');
            }

            // Delete contract
            $query = 'DELETE FROM contracts WHERE id = ?';
            $db = Database::getInstance();
            $stmt = $db->getConnection()->prepare($query);
            $stmt->execute([$id]);

            $this->setFlash('success', 'Contrat supprimé avec succès');
            return $this->redirect('/hr/contracts');
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/hr/contracts');
        }
    }
}
