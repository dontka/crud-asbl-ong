<?php

/**
 * Project Controller
 * Based on Phase 4: Backend Development - Step 4.3 Controllers and Business Logic
 * Handles project CRUD operations
 */

class ProjectController extends Controller
{
    private $projectModel;

    public function __construct()
    {
        parent::__construct();
        $this->projectModel = new Project();
    }

    /**
     * List all projects
     */
    public function index()
    {
        $this->requireAuth();

        $status = $this->getQueryData()['status'] ?? '';
        $conditions = [];
        if (!empty($status)) {
            $conditions['status'] = $status;
        }

        $projects = $this->projectModel->findAll($conditions, 'name ASC');
        $flash = $this->getFlash();

        $this->renderPage('projects/index', [
            'projects' => $projects,
            'status' => $status,
            'flash' => $flash
        ]);
    }

    /**
     * Show create project form
     */
    public function create()
    {
        $this->requireAuth();
        $flash = $this->getFlash();

        $this->renderPage('projects/create', [
            'flash' => $flash
        ]);
    }

    /**
     * Store new project
     */
    public function store()
    {
        $this->requireAuth();
        $data = $this->getPostData();

        try {
            $projectData = [
                'name' => $this->sanitize($data['name'] ?? ''),
                'description' => $this->sanitize($data['description'] ?? ''),
                'start_date' => $data['start_date'] ?? null,
                'end_date' => $data['end_date'] ?? null,
                'budget' => $data['budget'] ?? null,
                'status' => $data['status'] ?? 'planning',
                'manager_id' => $data['manager_id'] ?? null
            ];

            $this->projectModel->validate($projectData);
            $this->projectModel->save($projectData);

            $this->setFlash('success', 'Project created successfully.');
            $this->redirect('/projects');
        } catch (Exception $e) {
            $this->handleValidationError($e);
        }
    }

    /**
     * Show project details
     */
    public function show()
    {
        $this->requireAuth();
        $id = $this->getQueryData()['id'] ?? null;

        if (!$id) {
            $this->redirect('/projects');
        }

        $project = $this->projectModel->findById($id);
        if (!$project) {
            $this->setFlash('error', 'Project not found.');
            $this->redirect('/projects');
        }

        $flash = $this->getFlash();

        $this->renderPage('projects/show', [
            'project' => $project,
            'flash' => $flash
        ]);
    }

    /**
     * Show edit project form
     */
    public function edit()
    {
        $this->requireAuth();
        $id = $this->getQueryData()['id'] ?? null;

        if (!$id) {
            $this->redirect('/projects');
        }

        $project = $this->projectModel->findById($id);
        if (!$project) {
            $this->setFlash('error', 'Project not found.');
            $this->redirect('/projects');
        }

        $flash = $this->getFlash();

        $this->renderPage('projects/edit', [
            'project' => $project,
            'flash' => $flash
        ]);
    }

    /**
     * Update project
     */
    public function update()
    {
        $this->requireAuth();
        $data = $this->getPostData();
        $id = $data['id'] ?? null;

        if (!$id) {
            $this->redirect('/projects');
        }

        try {
            $projectData = [
                'id' => $id,
                'name' => $this->sanitize($data['name'] ?? ''),
                'description' => $this->sanitize($data['description'] ?? ''),
                'start_date' => $data['start_date'] ?? null,
                'end_date' => $data['end_date'] ?? null,
                'budget' => $data['budget'] ?? null,
                'status' => $data['status'] ?? 'planning',
                'manager_id' => $data['manager_id'] ?? null
            ];

            $this->projectModel->validate($projectData);
            $this->projectModel->save($projectData);

            $this->setFlash('success', 'Project updated successfully.');
            $this->redirect('/projects');
        } catch (Exception $e) {
            $this->handleValidationError($e);
        }
    }

    /**
     * Delete project
     */
    public function delete()
    {
        $this->requireAuth();
        $id = $this->getQueryData()['id'] ?? null;

        if (!$id) {
            $this->redirect('/projects');
        }

        try {
            $this->projectModel->delete($id);
            $this->setFlash('success', 'Project deleted successfully.');
        } catch (Exception $e) {
            $this->setFlash('error', 'Failed to delete project: ' . $e->getMessage());
        }

        $this->redirect('/projects');
    }
}
