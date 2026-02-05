<?php

class HRController extends Controller
{
    /**
     * Check user has HR access
     */
    public function __construct()
    {
        parent::__construct();
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

            // Get departments
            $departments = [];
            foreach ($allEmployees as $emp) {
                $dept = $emp['department'] ?? 'Non défini';
                if (!isset($departments[$dept])) {
                    $departments[$dept] = 0;
                }
                $departments[$dept]++;
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

            // Get employees
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
                $employeesData[] = $obj;
            }

            // Simple pagination
            $limit = 15;
            $total = count($employeesData);
            $totalPages = ceil($total / $limit);
            $offset = ($page - 1) * $limit;
            $employees = (object) ['data' => array_slice($employeesData, $offset, $limit)];

            // Get departments list from employees
            $departments = [];
            foreach ($allEmployees as $emp) {
                $dept = $emp['department'] ?? 'Non défini';
                if (!isset($departments[$dept])) {
                    $departments[$dept] = 0;
                }
                $departments[$dept]++;
            }

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
            $employee = new Employee();
            
            // Get filter parameters
            $selectedDepartment = $_GET['department'] ?? null;
            $selectedYear = $_GET['year'] ?? date('Y');
            $evaluationStatus = $_GET['status'] ?? null;

            // Get all evaluations
            $evaluations = $evaluation->findAll();
            
            // Get all employees with their details
            $allEmployees = $employee->findAll(['employment_status' => 'active']);
            
            // Build departments list
            $departments = [];
            $evaluationsByDept = [];
            $employeesByDept = [];
            
            foreach ($allEmployees as $emp) {
                $dept = $emp['department'] ?? 'Non défini';
                if (!isset($departments[$dept])) {
                    $departments[$dept] = 0;
                    $employeesByDept[$dept] = [];
                }
                $departments[$dept]++;
                $employeesByDept[$dept][] = $emp;
            }
            
            // Enrich evaluations with employee data
            foreach ($evaluations as &$eval_data) {
                if (!empty($eval_data['employee_id'])) {
                    $emp = $employee->findById($eval_data['employee_id']);
                    if ($emp) {
                        $eval_data['employee_name'] = ($emp['first_name'] ?? '') . ' ' . ($emp['last_name'] ?? '');
                        $eval_data['department'] = $emp['department'] ?? 'Non défini';
                    } else {
                        $eval_data['employee_name'] = 'N/A';
                        $eval_data['department'] = 'N/A';
                    }
                } else {
                    $eval_data['employee_name'] = 'N/A';
                    $eval_data['department'] = 'N/A';
                }
                
                // Group by department
                $dept = $eval_data['department'];
                if (!isset($evaluationsByDept[$dept])) {
                    $evaluationsByDept[$dept] = [];
                }
                $evaluationsByDept[$dept][] = $eval_data;
            }
            
            // Filter by department if selected
            if ($selectedDepartment) {
                $filteredEvaluations = array_filter($evaluations, function($e) use ($selectedDepartment) {
                    return ($e['department'] ?? null) === $selectedDepartment;
                });
            } else {
                $filteredEvaluations = $evaluations;
            }
            
            // Filter by year if needed
            if ($selectedYear) {
                $filteredEvaluations = array_filter($filteredEvaluations, function($e) use ($selectedYear) {
                    return ($e['evaluation_year'] ?? null) == $selectedYear;
                });
            }
            
            // Filter by status if needed
            if ($evaluationStatus) {
                $filteredEvaluations = array_filter($filteredEvaluations, function($e) use ($evaluationStatus) {
                    return ($e['status'] ?? null) === $evaluationStatus;
                });
            }
            
            // Calculate statistics based on FILTERED evaluations
            $scoresWithValues = array_filter(array_column($filteredEvaluations, 'overall_score'), function($score) {
                return !empty($score) && $score !== null;
            });
            
            $stats = [
                'total_employees' => count($allEmployees),
                'total_evaluations' => count($filteredEvaluations),
                'departments' => count($departments),
                'average_score' => count($scoresWithValues) > 0 ? array_sum($scoresWithValues) / count($scoresWithValues) : 0
            ];
            
            // Get years for filter
            $years = array_unique(array_column($evaluations, 'evaluation_year'));
            sort($years);
            if (empty($years)) {
                $years = [date('Y')];
            }

            return $this->renderPage('hr/evaluations/index', [
                'evaluations' => $filteredEvaluations,
                'allEvaluations' => $evaluations,
                'allEmployees' => $allEmployees,
                'departments' => $departments,
                'employeesByDept' => $employeesByDept,
                'evaluationsByDept' => $evaluationsByDept,
                'selectedDepartment' => $selectedDepartment,
                'selectedYear' => $selectedYear,
                'evaluationStatus' => $evaluationStatus,
                'years' => $years,
                'stats' => $stats,
                'pageTitle' => 'Gestion des Évaluations'
            ]);
        } catch (\Exception $e) {
            error_log("EXCEPTION in evaluations(): " . $e->getMessage() . " | File: " . $e->getFile() . " | Line: " . $e->getLine());
            error_log("Trace: " . $e->getTraceAsString());
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/dashboard');
        }
    }

    /**
     * Create evaluation
     */
    public function createEvaluation($employeeId = null)
    {
        try {
            $employee = new Employee();
            $allEmployees = null;
            $selectedEmployee = null;
            
            if ($employeeId) {
                $selectedEmployee = $employee->findById($employeeId);
                if (!$selectedEmployee) {
                    $this->setFlash('error', 'Employé non trouvé');
                    return $this->redirect('/hr/evaluations');
                }
            } else {
                // Get all active employees
                $allEmployees = $employee->findAll(['employment_status' => 'active']);
            }

            return $this->renderPage('hr/evaluations/create', [
                'employee' => $selectedEmployee,
                'allEmployees' => $allEmployees,
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
            
            // Pagination parameters
            $limit = intval($_GET['limit'] ?? 10);
            $page = intval($_GET['page'] ?? 1);
            if ($limit < 5 || $limit > 100) $limit = 10;
            if ($page < 1) $page = 1;
            $offset = ($page - 1) * $limit;

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
            list($year, $month) = explode('-', $currentMonth);
            $monthPayrolls = array_filter($payrolls, function ($p) use ($month, $year) {
                return $p['payroll_month'] == $month && $p['payroll_year'] == $year;
            });
            
            // Pagination calculations
            $totalRecords = count($monthPayrolls);
            $totalPages = max(1, ceil($totalRecords / $limit));
            if ($page > $totalPages) $page = $totalPages;
            $offset = ($page - 1) * $limit;
            
            // Apply pagination
            $paginatedPayrolls = array_slice($monthPayrolls, $offset, $limit);

            // Enrich with employee data
            foreach ($paginatedPayrolls as &$p) {
                $emp = $employee->findById($p['employee_id']);
                $p['employee_name'] = ($emp['first_name'] ?? '') . ' ' . ($emp['last_name'] ?? '');
                $p['employee_email'] = $emp['email'] ?? '';
            }

            // Prepare view data
            $totalEmployees = $stats['total_employees'] ?? 0;
            $totalPayroll = $stats['total_salary_net'] ?? 0;
            $averageSalary = $stats['avg_salary_net'] ?? 0;
            
            // Get contract types and statuses (dummy data for now)
            $contractTypes = ['CDI' => 5, 'CDD' => 3, 'Stage' => 2];
            $contractStatuses = ['active' => 8, 'completed' => 1, 'suspended' => 1];
            
            // Salary ranges for distribution chart
            $salaryRanges = [
                '< 1500€' => 2,
                '1500-2500€' => 5,
                '2500-3500€' => 4,
                '3500-4500€' => 3,
                '> 4500€' => 1
            ];
            
            // Monthly trend data (last 6 months)
            $monthlyTrend = [];
            for ($i = 5; $i >= 0; $i--) {
                $date = new DateTime("-$i month");
                $key = $date->format('M Y');
                $monthlyTrend[$key] = rand(30000, 50000);
            }

            return $this->renderPage('hr/payroll/payroll', [
                'payrolls' => $paginatedPayrolls,
                'stats' => $stats,
                'currentMonth' => $currentMonth,
                'allPayrolls' => $payrolls,
                'totalEmployees' => $totalEmployees,
                'totalPayroll' => $totalPayroll,
                'averageSalary' => $averageSalary,
                'contractTypes' => $contractTypes,
                'contractStatuses' => $contractStatuses,
                'salaryRanges' => $salaryRanges,
                'monthlyTrend' => $monthlyTrend,
                'pageTitle' => 'Gestion de la Paie',
                'pagination' => [
                    'page' => $page,
                    'limit' => $limit,
                    'totalRecords' => $totalRecords,
                    'totalPages' => $totalPages,
                    'offset' => $offset
                ]
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
                $salary_gross = floatval($_POST['salary_gross'] ?? 0);
                $bonuses = floatval($_POST['bonuses'] ?? 0);
                $deductions = floatval($_POST['deductions'] ?? 0);
                $social_contributions = floatval($_POST['social_contributions'] ?? Payroll::calculateSocialContributions($salary_gross));
                $taxes = floatval($_POST['taxes'] ?? 0);
                $salary_net = Payroll::calculateNetSalary($salary_gross, $bonuses, $deductions, $taxes, $social_contributions);

                $date = new DateTime($_POST['payroll_month'] ?? ($payrollData['payroll_month'] ?? date('Y-m-01')));
                $month = intval($date->format('m'));
                $year = intval($date->format('Y'));

                $data = [
                    'employee_id' => $_POST['employee_id'] ?? ($payrollData['employee_id'] ?? null),
                    'payroll_month' => $month,
                    'payroll_year' => $year,
                    'salary_gross' => $salary_gross,
                    'bonuses' => $bonuses,
                    'deductions' => $deductions,
                    'taxes' => $taxes,
                    'social_contributions' => $social_contributions,
                    'salary_net' => $salary_net,
                    'status' => $_POST['status'] ?? ($payrollData['status'] ?? 'draft'),
                    'payment_date' => $_POST['payment_date'] ?? ($payrollData['payment_date'] ?? null),
                    'payment_method' => $_POST['payment_method'] ?? ($payrollData['payment_method'] ?? 'bank_transfer'),
                    'notes' => $_POST['notes'] ?? ''
                ];

                if ($id) {
                    $data['id'] = $id;
                    $payroll->save($data);
                    $this->setFlash('success', 'Fiche de paie mise à jour');
                } else {
                    $payroll->save($data);
                    $this->setFlash('success', 'Fiche de paie créée');
                }
                return $this->redirect('/hr/payroll');
            }

            $employees = $employee->findAll();

            return $this->renderPage('hr/payroll/payroll-edit', [
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

            // Delete using model
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("DELETE FROM payroll WHERE id = ?");
            $stmt->execute([$id]);

            $this->setFlash('success', 'Fiche de paie supprimée');
            return $this->redirect('/hr/payroll');
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/hr/payroll');
        }
    }

    /**
     * Generate payroll PDF
     */
    public function payrollPDF($id)
    {
        try {
            $payroll = new Payroll();
            $employee = new Employee();
            
            $payrollData = $payroll->findById($id);
            if (!$payrollData) {
                $this->setFlash('error', 'Fiche de paie non trouvée');
                return $this->redirect('/hr/payroll');
            }

            $emp = $employee->findById($payrollData['employee_id']);

            // Generate simple HTML to PDF (using browser print)
            $html = $this->generatePayrollHTML($payrollData, $emp);
            
            header('Content-Type: text/html; charset=utf-8');
            header('Content-Disposition: inline; filename="fiche_paie_' . $payrollData['id'] . '.html"');
            echo $html;
            exit;
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/hr/payroll');
        }
    }

    /**
     * Generate HTML for payroll PDF
     */
    private function generatePayrollHTML($payrollData, $emp)
    {
        $html = '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche de Paie</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; line-height: 1.6; }
        .header { display: flex; justify-content: space-between; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .company-info h1 { margin: 0; font-size: 24px; }
        .payroll-info { text-align: right; }
        .section { margin-bottom: 30px; }
        .section h2 { font-size: 14px; font-weight: bold; border-bottom: 1px solid #ccc; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f5f5f5; font-weight: bold; }
        .total-row { background-color: #f5f5f5; font-weight: bold; }
        .align-right { text-align: right; }
        .footer { margin-top: 40px; padding-top: 20px; border-top: 1px solid #ccc; text-align: center; font-size: 12px; color: #666; }
        @media print { body { margin: 0; } .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-info">
            <h1>ASBL-ONG</h1>
            <p>Gestion de la Paie</p>
        </div>
        <div class="payroll-info">
            <h2>Fiche de Paie #' . htmlspecialchars($payrollData['id']) . '</h2>
            <p>Mois: ' . htmlspecialchars($payrollData['payroll_month']) . '/' . htmlspecialchars($payrollData['payroll_year']) . '</p>
        </div>
    </div>

    <div class="section">
        <h2>Informations Employé</h2>
        <table>
            <tr>
                <td><strong>Nom:</strong> ' . htmlspecialchars(($emp['first_name'] ?? '') . ' ' . ($emp['last_name'] ?? '')) . '</td>
                <td><strong>Email:</strong> ' . htmlspecialchars($emp['email'] ?? '') . '</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>Détail du Salaire</h2>
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="align-right">Montant (€)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Salaire Brut</td>
                    <td class="align-right">' . number_format($payrollData['salary_gross'] ?? 0, 2, ',', ' ') . '</td>
                </tr>
                <tr>
                    <td>Bonus</td>
                    <td class="align-right">' . number_format($payrollData['bonuses'] ?? 0, 2, ',', ' ') . '</td>
                </tr>
                <tr>
                    <td>Heures Supplémentaires</td>
                    <td class="align-right">' . number_format($payrollData['overtime_pay'] ?? 0, 2, ',', ' ') . '</td>
                </tr>
                <tr class="total-row">
                    <td>Total Brut</td>
                    <td class="align-right">' . number_format(($payrollData['salary_gross'] ?? 0) + ($payrollData['bonuses'] ?? 0) + ($payrollData['overtime_pay'] ?? 0), 2, ',', ' ') . '</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Retenues et Taxes</h2>
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="align-right">Montant (€)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Cotisations Sociales</td>
                    <td class="align-right">' . number_format($payrollData['social_contributions'] ?? 0, 2, ',', ' ') . '</td>
                </tr>
                <tr>
                    <td>Taxes</td>
                    <td class="align-right">' . number_format($payrollData['taxes'] ?? 0, 2, ',', ' ') . '</td>
                </tr>
                <tr>
                    <td>Autres Retenues</td>
                    <td class="align-right">' . number_format($payrollData['deductions'] ?? 0, 2, ',', ' ') . '</td>
                </tr>
                <tr class="total-row">
                    <td>Total Retenues</td>
                    <td class="align-right">' . number_format(($payrollData['social_contributions'] ?? 0) + ($payrollData['taxes'] ?? 0) + ($payrollData['deductions'] ?? 0), 2, ',', ' ') . '</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Résumé</h2>
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="align-right">Montant (€)</th>
                </tr>
            </thead>
            <tbody>
                <tr class="total-row">
                    <td><strong>SALAIRE NET À PAYER</strong></td>
                    <td class="align-right"><strong>' . number_format($payrollData['salary_net'] ?? 0, 2, ',', ' ') . '</strong></td>
                </tr>
                <tr>
                    <td>Statut</td>
                    <td class="align-right">';
        
        $statusLabels = ['draft' => 'Brouillon', 'validated' => 'Validé', 'paid' => 'Payé'];
        $status = $payrollData['status'] ?? 'draft';
        $html .= htmlspecialchars($statusLabels[$status] ?? $status);
        
        $html .= '</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <p><strong>Notes:</strong> ' . htmlspecialchars($payrollData['notes'] ?? '') . '</p>
    </div>

    <div class="footer">
        <p>Généré le ' . date('d/m/Y à H:i') . '</p>
        <p>Ceci est un document généré automatiquement.</p>
        <button class="no-print" onclick="window.print()" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">Imprimer / Sauvegarder en PDF</button>
    </div>
</body>
</html>';
        
        return $html;
    }

    /**
     * Display skills management page
     */
    public function skills()
    {
        try {
            $skill = new Skill();
            $employee = new Employee();

            $skills = $skill->findAll() ?? [];
            $categories = Skill::getCategories() ?? [];
            $allEmployees = $employee->findAll() ?? [];

            // Enrich skills with employee count
            foreach ($skills as &$s) {
                $empCount = 0;
                foreach ($allEmployees as $emp) {
                    // Count employees with this skill (would need join query in real scenario)
                }
                $s['employee_count'] = $empCount;
            }

            return $this->renderPage('hr/skills', [
                'skills' => $skills,
                'categories' => $categories,
                'totalSkills' => count($skills),
                'pageTitle' => 'Gestion des Compétences'
            ]);
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/hr');
        }
    }

    /**
     * Create or edit a skill
     */
    public function editSkill($id = null)
    {
        try {
            $skill = new Skill();
            $skillData = null;

            if ($id) {
                $skillData = $skill->findById($id);
                if (!$skillData) {
                    $this->setFlash('error', 'Compétence non trouvée');
                    return $this->redirect('/hr/skills');
                }
            }

            // Handle form submission
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'name' => $_POST['name'] ?? '',
                    'category' => $_POST['category'] ?? '',
                    'description' => $_POST['description'] ?? ''
                ];

                $errors = $skill->validate($data);
                if (!empty($errors)) {
                    return $this->renderPage('hr/skills-edit', [
                        'skill' => $skillData,
                        'errors' => $errors,
                        'pageTitle' => $id ? 'Éditer Compétence' : 'Nouvelle Compétence'
                    ]);
                }

                if ($id) {
                    $skill->update($id, $data);
                    $this->setFlash('success', 'Compétence mise à jour avec succès');
                } else {
                    $skill->insert($data);
                    $this->setFlash('success', 'Compétence créée avec succès');
                }

                return $this->redirect('/hr/skills');
            }

            return $this->renderPage('hr/skills-edit', [
                'skill' => $skillData,
                'pageTitle' => $id ? 'Éditer Compétence' : 'Nouvelle Compétence'
            ]);
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/hr/skills');
        }
    }

    /**
     * Delete a skill
     */
    public function deleteSkill($id)
    {
        try {
            $skill = new Skill();
            $skill->delete($id);
            $this->setFlash('success', 'Compétence supprimée avec succès');
            return $this->redirect('/hr/skills');
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erreur: ' . $e->getMessage());
            return $this->redirect('/hr/skills');
        }
    }}