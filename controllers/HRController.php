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
            $allEmployees = $employee->findAll(['status' => 'active']);
            $totalEmployees = count($allEmployees);

            // Get employees on leave today
            $absence = new Absence();
            $allAbsences = $absence->findAll(['status' => 'valide']);
            $today = date('Y-m-d');
            $onLeaveToday = 0;
            $pendingApprovals = 0;
            $recentAbsences = [];

            foreach ($allAbsences as $abs) {
                if ($abs['start_date'] <= $today && $abs['end_date'] >= $today) {
                    $onLeaveToday++;
                }
                if ($abs['status'] === 'demande') {
                    $pendingApprovals++;
                }
                $recentAbsences[] = $abs;
            }

            // Get pending absences count
            $pendingAbsencesAll = $absence->findAll(['status' => 'demande']);
            $pendingApprovals = count($pendingAbsencesAll);

            // Limit recent absences
            $recentAbsences = array_slice($allAbsences, 0, 10);

            // Get upcoming evaluations
            $evaluation = new Evaluation();
            $allEvaluations = $evaluation->findAll();
            $upcomingEvaluations = count($allEvaluations); // Simplified

            // Get departments (simplified - no department column)
            $departments = [];

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

            // Get employees (no department filtering - column doesn't exist)
            $employee = new Employee();
            $allEmployees = $employee->findAll();

            // Filter by search if provided
            if ($search) {
                $allEmployees = array_filter($allEmployees, function ($emp) use ($search) {
                    $searchLower = strtolower($search);
                    return stripos($emp['first_name'] ?? '', $search) !== false ||
                        stripos($emp['last_name'] ?? '', $search) !== false ||
                        stripos($emp['email'] ?? '', $search) !== false ||
                        stripos($emp['phone'] ?? '', $search) !== false;
                });
            }

            // Convert to objects for view compatibility
            $employeesData = [];
            foreach ($allEmployees as $emp) {
                $obj = (object) $emp;
                $obj->position = 'N/A'; // No position column in database
                $obj->department = 'N/A'; // No department column in database
                $employeesData[] = $obj;
            }

            // Simple pagination
            $limit = 15;
            $total = count($employeesData);
            $totalPages = ceil($total / $limit);
            $offset = ($page - 1) * $limit;
            $employees = (object) ['data' => array_slice($employeesData, $offset, $limit)];

            // Get departments list (empty for now - no department column)
            $departments = [];

            return $this->renderPage('hr/employees/index', [
                'employees' => $employees,
                'page' => $page,
                'totalPages' => $totalPages,
                'department' => $department,
                'search' => $search,
                'departments' => $departments,
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
                // Handle both employe_id and employee_id column names for compatibility
                $empId = $absence_data['employe_id'] ?? $absence_data['employee_id'] ?? null;
                if (!empty($empId)) {
                    $emp = $employee->findById($empId);
                    $absence_data['employee_name'] = ($emp['first_name'] ?? '') . ' ' . ($emp['last_name'] ?? '');
                } else {
                    $absence_data['employee_name'] = 'N/A';
                }

                // Map type to absence_type for view compatibility
                $absence_data['absence_type'] = $this->mapAbsenceType($absence_data['type'] ?? 'conge');

                // Map status values for view compatibility
                $absence_data['status'] = $this->mapAbsenceStatus($absence_data['status'] ?? 'demande');
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
     * Map absence type from database values to display values
     */
    private function mapAbsenceType($type)
    {
        $mapping = [
            'conge' => 'Congé',
            'maladie' => 'Maladie',
            'autre' => 'Autre',
        ];
        return $mapping[$type] ?? $type;
    }

    /**
     * Map absence status from database values to display values
     */
    private function mapAbsenceStatus($status)
    {
        $mapping = [
            'demande' => 'pending',
            'valide' => 'approved',
            'refuse' => 'rejected',
        ];
        return $mapping[$status] ?? $status;
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
     * Edit absence
     */
    public function editAbsence($id)
    {
        try {
            $absence = new Absence();
            $abs = $absence->findById($id);

            if (!$abs) {
                $this->setFlash('error', 'Absence non trouvée');
                return $this->redirect('/hr/absences');
            }

            // Handle form submission
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'id' => $id,
                    'employe_id' => $_POST['employe_id'] ?? $abs['employe_id'],
                    'type' => $_POST['type'] ?? $abs['type'],
                    'start_date' => $_POST['start_date'] ?? $abs['start_date'],
                    'end_date' => $_POST['end_date'] ?? $abs['end_date'],
                    'status' => $_POST['status'] ?? $abs['status'],
                ];

                if ($absence->save($data)) {
                    $this->setFlash('success', 'Absence mise à jour');
                    return $this->redirect('/hr/absences');
                } else {
                    $this->setFlash('error', 'Erreur lors de la mise à jour');
                }
            }

            // Get employees for dropdown
            $employee = new Employee();
            $employees = $employee->findAll();

            return $this->renderPage('hr/absences/edit', [
                'absence' => $abs,
                'employees' => $employees,
                'absenceTypes' => ['conge' => 'Congé', 'maladie' => 'Maladie', 'autre' => 'Autre'],
                'statuses' => ['demande' => 'Demande', 'valide' => 'Validée', 'refuse' => 'Refusée'],
                'pageTitle' => 'Édition de l\'Absence'
            ]);
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
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

            // Mark as approved (valide in French)
            $absData = is_array($abs) ? $abs : (array) $abs;
            $absData['status'] = 'valide';
            $absData['approval_date'] = date('Y-m-d H:i:s');

            $absence->save($absData);

            $this->setFlash('success', 'Absence approuvée');
            return $this->redirect('/hr/absences');
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/hr/absences');
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

            // Mark as rejected (refuse in French)
            $absData = is_array($abs) ? $abs : (array) $abs;
            $absData['status'] = 'refuse';

            $absence->save($absData);

            $this->setFlash('success', 'Absence rejetée');
            return $this->redirect('/hr/absences');
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/hr/absences');
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
                // Map column names for compatibility
                if (isset($contract_data['type']) && !isset($contract_data['contract_type'])) {
                    $contract_data['contract_type'] = $contract_data['type'];
                }

                $emp_id = $contract_data['employe_id'] ?? $contract_data['employee_id'] ?? null;
                if (!empty($emp_id)) {
                    $emp = $employee->findById($emp_id);
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

            return $this->renderPage('hr/contracts/create', [
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

    /**
     * Display Payroll Dashboard with CRUD operations
     */
    public function payroll()
    {
        try {
            $payroll = new Payroll();
            $employee = new Employee();

            $currentMonth = $_GET['month'] ?? date('Y-m');
            $action = $_GET['action'] ?? 'list';

            // Handle AJAX generate payroll
            if ($action === 'generate' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $generated = $payroll->generatePayrollForMonth($currentMonth . '-01');
                $this->setFlash('success', "$generated fiches de paie générées pour $currentMonth");
                return $this->redirect('/hr/payroll?month=' . $currentMonth);
            }

            // Get payroll data
            $payrolls = $payroll->findAll();
            $stats = $payroll->getStatistics();

            // Filter by month
            $monthPayrolls = array_filter($payrolls, function ($p) use ($currentMonth) {
                return substr($p['mois'], 0, 7) === $currentMonth;
            });

            // Enrich with employee data
            foreach ($monthPayrolls as &$p) {
                $emp = $employee->findById($p['employe_id']);
                $p['employee_name'] = ($emp['first_name'] ?? '') . ' ' . ($emp['last_name'] ?? '');
                $p['employee_email'] = $emp['email'] ?? '';
            }

            return $this->renderPage('hr/payroll', [
                'payrolls' => $monthPayrolls,
                'stats' => $stats,
                'currentMonth' => $currentMonth,
                'allPayrolls' => $payrolls,
                'pageTitle' => 'Gestion de la Paie'
            ]);
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/dashboard');
        }
    }

    /**
     * Create or edit payroll
     */
    public function editPayroll($id = null)
    {
        try {
            $payroll = new Payroll();
            $employee = new Employee();

            $payrollData = null;
            if ($id) {
                $payrollData = $payroll->findById($id);
                if (!$payrollData) {
                    $this->setFlash('error', 'Fiche de paie non trouvée');
                    return $this->redirect('/hr/payroll');
                }
            }

            // Handle form submission
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $salaire_base = floatval($_POST['salaire_base'] ?? 0);
                $prime = floatval($_POST['prime'] ?? 0);
                $gratification = floatval($_POST['gratification'] ?? 0);
                $cotisation = floatval($_POST['cotisation_sociale'] ?? Payroll::calculateCotisation($salaire_base));
                $impot = floatval($_POST['impot_revenu'] ?? 0);
                $autres = floatval($_POST['autres_retenues'] ?? 0);
                $net = Payroll::calculateNetSalary($salaire_base, $prime, $gratification, $cotisation, $impot, $autres);

                $data = [
                    'employe_id' => $_POST['employe_id'] ?? ($payrollData['employe_id'] ?? null),
                    'mois' => $_POST['mois'] ?? ($payrollData['mois'] ?? date('Y-m-01')),
                    'salaire_base' => $salaire_base,
                    'prime' => $prime,
                    'gratification' => $gratification,
                    'cotisation_sociale' => $cotisation,
                    'impot_revenu' => $impot,
                    'autres_retenues' => $autres,
                    'salaire_net' => $net,
                    'statut' => $_POST['statut'] ?? ($payrollData['statut'] ?? 'brouillon'),
                    'date_paiement' => $_POST['date_paiement'] ?? ($payrollData['date_paiement'] ?? null),
                    'notes' => $_POST['notes'] ?? ''
                ];

                if ($id) {
                    $data['id'] = $id;
                    $payroll->save($data);
                    $this->setFlash('success', 'Fiche de paie mise à jour');
                } else {
                    $payroll->insert($data);
                    $this->setFlash('success', 'Fiche de paie créée');
                }
                return $this->redirect('/hr/payroll');
            }

            $employees = $employee->findAll();

            return $this->renderPage('hr/payroll-edit', [
                'payroll' => $payrollData,
                'employees' => $employees,
                'pageTitle' => $id ? 'Éditer Fiche de Paie' : 'Créer Fiche de Paie'
            ]);
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/hr/payroll');
        }
    }

    /**
     * Delete payroll
     */
    public function deletePayroll($id)
    {
        try {
            $payroll = new Payroll();
            $payrollData = $payroll->findById($id);

            if (!$payrollData) {
                $this->setFlash('error', 'Fiche de paie non trouvée');
                return $this->redirect('/hr/payroll');
            }

            // Delete using raw query
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("DELETE FROM fiches_paie WHERE id = ?");
            $stmt->execute([$id]);

            $this->setFlash('success', 'Fiche de paie supprimée');
            return $this->redirect('/hr/payroll');
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/hr/payroll');
        }
    }
}
