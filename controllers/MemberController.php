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

        $members = $this->memberModel->findAll($conditions, 'last_name ASC, first_name ASC');
        $flash = $this->getFlash();

        $this->render('members/index', [
            'members' => $members,
            'search' => $search,
            'status' => $status,
            'flash' => $flash
        ]);
    }

    /**
     * Show create member form
     */
    public function create()
    {
        $this->requireAuth();
        $flash = $this->getFlash();

        $this->render('members/create', [
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
            $this->redirect('/members.php');
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
            $this->redirect('/members.php');
        }

        $member = $this->memberModel->findById($id);
        if (!$member) {
            $this->setFlash('error', 'Member not found.');
            $this->redirect('/members.php');
        }

        $flash = $this->getFlash();

        $this->render('members/show', [
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
            $this->redirect('/members.php');
        }

        $member = $this->memberModel->findById($id);
        if (!$member) {
            $this->setFlash('error', 'Member not found.');
            $this->redirect('/members.php');
        }

        $flash = $this->getFlash();

        $this->render('members/edit', [
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
            $this->redirect('/members.php');
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
            $this->redirect('/members.php');
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
            $this->redirect('/members.php');
        }

        try {
            $this->memberModel->delete($id);
            $this->setFlash('success', 'Member deleted successfully.');
        } catch (Exception $e) {
            $this->setFlash('error', 'Failed to delete member: ' . $e->getMessage());
        }

        $this->redirect('/members.php');
    }

    /**
     * Search members
     */
    public function search()
    {
        $this->requireAuth();
        $query = $this->getQueryData()['q'] ?? '';

        if (empty($query)) {
            $this->redirect('/members.php');
        }

        $members = $this->memberModel->search($query);
        $flash = $this->getFlash();

        $this->render('members/search', [
            'members' => $members,
            'query' => $query,
            'flash' => $flash
        ]);
    }
}
