<?php

/**
 * Donation Controller
 * Based on Phase 4: Backend Development - Step 4.3 Controllers and Business Logic
 * Handles donation CRUD operations
 */

class DonationController extends Controller
{
    private $donationModel;

    public function __construct()
    {
        parent::__construct();
        $this->donationModel = new Donation();
    }

    /**
     * List all donations
     */
    public function index()
    {
        $this->requireAuth();

        $project_id = $this->getQueryData()['project_id'] ?? '';
        $conditions = [];
        if (!empty($project_id)) {
            $conditions['project_id'] = $project_id;
        }

        $donations = $this->donationModel->getDonationsWithProjects($conditions, 'd.donation_date DESC');

        // Calculate totals using model methods
        $total_amount = $this->donationModel->getTotalAmount($conditions);
        $total_donations = $this->donationModel->getTotalCount($conditions);

        $flash = $this->getFlash();

        $this->renderPage('donations/index', [
            'donations' => $donations,
            'project_id' => $project_id,
            'total_amount' => $total_amount,
            'total_donations' => $total_donations,
            'flash' => $flash
        ]);
    }

    /**
     * Show create donation form
     */
    public function create()
    {
        $this->requireAuth();
        $flash = $this->getFlash();

        // Get all projects for project selection
        $projectModel = new Project();
        $projects = $projectModel->findAll([], 'name ASC');

        $this->renderPage('donations/create', [
            'flash' => $flash,
            'projects' => $projects
        ]);
    }

    /**
     * Store new donation
     */
    public function store()
    {
        $this->requireAuth();
        $data = $this->getPostData();

        try {
            $donationData = [
                'donor_name' => $this->sanitize($data['donor_name'] ?? ''),
                'donor_email' => $this->sanitize($data['donor_email'] ?? ''),
                'amount' => $data['amount'] ?? '',
                'donation_date' => $data['donation_date'] ?? date('Y-m-d'),
                'project_id' => $data['project_id'] ?? null,
                'payment_method' => $data['payment_method'] ?? 'cash',
                'notes' => $this->sanitize($data['notes'] ?? '')
            ];

            $this->donationModel->validate($donationData);
            $this->donationModel->save($donationData);

            $this->setFlash('success', 'Donation recorded successfully.');
            $this->redirect('/donations');
        } catch (Exception $e) {
            $this->handleValidationError($e);
        }
    }

    /**
     * Show donation details
     */
    public function show()
    {
        $this->requireAuth();
        $id = $this->getQueryData()['id'] ?? null;

        if (!$id) {
            $this->redirect('/donations');
        }

        $donation = $this->donationModel->findById($id);
        if (!$donation) {
            $this->setFlash('error', 'Donation not found.');
            $this->redirect('/donations');
        }

        $flash = $this->getFlash();

        $this->renderPage('donations/show', [
            'donation' => $donation,
            'flash' => $flash
        ]);
    }

    /**
     * Show edit donation form
     */
    public function edit()
    {
        $this->requireAuth();
        $id = $this->getQueryData()['id'] ?? null;

        if (!$id) {
            $this->redirect('/donations');
        }

        $donation = $this->donationModel->findById($id);
        if (!$donation) {
            $this->setFlash('error', 'Donation not found.');
            $this->redirect('/donations');
        }

        $flash = $this->getFlash();

        // Get all projects for project selection
        $projectModel = new Project();
        $projects = $projectModel->findAll([], 'name ASC');

        $this->renderPage('donations/edit', [
            'donation' => $donation,
            'flash' => $flash,
            'projects' => $projects
        ]);
    }

    /**
     * Update donation
     */
    public function update()
    {
        $this->requireAuth();
        $data = $this->getPostData();
        $id = $data['id'] ?? null;

        if (!$id) {
            $this->redirect('/donations');
        }

        try {
            $donationData = [
                'id' => $id,
                'donor_name' => $this->sanitize($data['donor_name'] ?? ''),
                'donor_email' => $this->sanitize($data['donor_email'] ?? ''),
                'amount' => $data['amount'] ?? '',
                'donation_date' => $data['donation_date'] ?? '',
                'project_id' => $data['project_id'] ?? null,
                'payment_method' => $data['payment_method'] ?? 'cash',
                'notes' => $this->sanitize($data['notes'] ?? '')
            ];

            $this->donationModel->validate($donationData);
            $this->donationModel->save($donationData);

            $this->setFlash('success', 'Donation updated successfully.');
            $this->redirect('/donations');
        } catch (Exception $e) {
            $this->handleValidationError($e);
        }
    }

    /**
     * Delete donation
     */
    public function delete()
    {
        $this->requireAuth();
        $id = $this->getQueryData()['id'] ?? null;

        if (!$id) {
            $this->redirect('/donations');
        }

        try {
            $this->donationModel->delete($id);
            $this->setFlash('success', 'Donation deleted successfully.');
        } catch (Exception $e) {
            $this->setFlash('error', 'Failed to delete donation: ' . $e->getMessage());
        }

        $this->redirect('/donations');
    }
}
