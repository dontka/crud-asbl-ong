<?php

/**
 * Member Controller
 * Based on Phase 4: Backend Development - Step 4.3 Controllers and Business Logic
 * Handles member CRUD operations
 */

class MemberController extends Controller
{
    private $memberModel;

    public function __construct()
    {
        parent::__construct();
        $this->memberModel = new Member();
    }

    /**
     * List all members
     */
    public function index()
    {
        $this->requireAuth();

        $search = $this->getQueryData()['search'] ?? '';
        $status = $this->getQueryData()['status'] ?? '';

        $conditions = [];
        if (!empty($status)) {
            $conditions['status'] = $status;
        }

        if (!empty($search)) {
            $members = $this->memberModel->search($search, ['first_name', 'last_name', 'email'], $conditions, 'last_name ASC, first_name ASC');
        } else {
            $members = $this->memberModel->findAll($conditions, 'last_name ASC, first_name ASC');
        }

        $flash = $this->getFlash();

        $this->renderPage('members/index', [
            'members' => $members,
            'search' => $search,
            'status' => $status,
            'flash' => $flash,
            'pageTitle' => 'Gestion des Membres'
        ]);
    }

    /**
     * Show create member form
     */
    public function create()
    {
        $this->requireAuth();
        $flash = $this->getFlash();

        $this->renderPage('members/create', [
            'flash' => $flash
        ]);
    }

    /**
     * Store new member
     */
    public function store()
    {
        $this->requireAuth();
        $data = $this->getPostData();

        try {
            $memberData = [
                'first_name' => $this->sanitize($data['first_name'] ?? ''),
                'last_name' => $this->sanitize($data['last_name'] ?? ''),
                'email' => $this->sanitize($data['email'] ?? ''),
                'phone' => $this->sanitize($data['phone'] ?? ''),
                'address' => $this->sanitize($data['address'] ?? ''),
                'join_date' => $data['join_date'] ?? date('Y-m-d'),
                'status' => $data['status'] ?? 'active'
            ];

            $this->memberModel->validate($memberData);
            $this->memberModel->save($memberData);

            $this->setFlash('success', 'Member created successfully.');
            $this->redirect('/members');
        } catch (Exception $e) {
            $this->handleValidationError($e);
        }
    }

    /**
     * Show member details
     */
    public function show()
    {
        $this->requireAuth();
        $id = $this->getQueryData()['id'] ?? null;

        if (!$id) {
            $this->redirect('/members');
        }

        $member = $this->memberModel->findById($id);
        if (!$member) {
            $this->setFlash('error', 'Member not found.');
            $this->redirect('/members');
        }

        $flash = $this->getFlash();

        $this->renderPage('members/show', [
            'member' => $member,
            'flash' => $flash
        ]);
    }

    /**
     * Show edit member form
     */
    public function edit()
    {
        $this->requireAuth();
        $id = $this->getQueryData()['id'] ?? null;

        if (!$id) {
            $this->redirect('/members');
        }

        $member = $this->memberModel->findById($id);
        if (!$member) {
            $this->setFlash('error', 'Member not found.');
            $this->redirect('/members');
        }

        $flash = $this->getFlash();

        $this->renderPage('members/edit', [
            'member' => $member,
            'flash' => $flash
        ]);
    }

    /**
     * Update member
     */
    public function update()
    {
        $this->requireAuth();
        $data = $this->getPostData();
        $id = $data['id'] ?? null;

        if (!$id) {
            $this->redirect('/members');
        }

        try {
            $memberData = [
                'id' => $id,
                'first_name' => $this->sanitize($data['first_name'] ?? ''),
                'last_name' => $this->sanitize($data['last_name'] ?? ''),
                'email' => $this->sanitize($data['email'] ?? ''),
                'phone' => $this->sanitize($data['phone'] ?? ''),
                'address' => $this->sanitize($data['address'] ?? ''),
                'join_date' => $data['join_date'] ?? '',
                'status' => $data['status'] ?? 'active'
            ];

            $this->memberModel->validate($memberData);
            $this->memberModel->save($memberData);

            $this->setFlash('success', 'Member updated successfully.');
            $this->redirect('/members');
        } catch (Exception $e) {
            $this->handleValidationError($e);
        }
    }

    /**
     * Delete member
     */
    public function delete()
    {
        $this->requireAuth();
        $id = $this->getQueryData()['id'] ?? null;

        if (!$id) {
            $this->redirect('/members');
        }

        try {
            $this->memberModel->delete($id);
            $this->setFlash('success', 'Member deleted successfully.');
        } catch (Exception $e) {
            $this->setFlash('error', 'Failed to delete member: ' . $e->getMessage());
        }

        $this->redirect('/members');
    }

    /**
     * Search members
     */
    public function search()
    {
        $this->requireAuth();
        $query = $this->getQueryData()['q'] ?? '';

        if (empty($query)) {
            $this->redirect('/members');
        }

        $members = $this->memberModel->search($query);
        $flash = $this->getFlash();

        $this->renderPage('members/search', [
            'members' => $members,
            'query' => $query,
            'flash' => $flash
        ]);
    }

    /**
     * Export members to CSV
     */
    public function export()
    {
        $this->requireAuth();

        $search = $this->getQueryData()['search'] ?? '';
        $status = $this->getQueryData()['status'] ?? '';

        $conditions = [];
        if (!empty($status)) {
            $conditions['status'] = $status;
        }

        if (!empty($search)) {
            $members = $this->memberModel->search($search, ['first_name', 'last_name', 'email'], $conditions, 'last_name ASC, first_name ASC');
        } else {
            $members = $this->memberModel->findAll($conditions, 'last_name ASC, first_name ASC');
        }

        // Set headers for CSV download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=members_' . date('Y-m-d') . '.csv');

        // Create output stream
        $output = fopen('php://output', 'w');

        // Add BOM for UTF-8
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // CSV headers
        fputcsv($output, ['ID', 'First Name', 'Last Name', 'Email', 'Phone', 'Join Date', 'Status']);

        // CSV data
        foreach ($members as $member) {
            fputcsv($output, [
                $member['id'],
                $member['first_name'],
                $member['last_name'],
                $member['email'],
                $member['phone'] ?? '',
                $member['join_date'],
                $member['status']
            ]);
        }

        fclose($output);
        exit;
    }
}
