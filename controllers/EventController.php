<?php

/**
 * Event Controller
 * Based on Phase 4: Backend Development - Step 4.3 Controllers and Business Logic
 * Handles event CRUD operations
 */

class EventController extends Controller
{
    private $eventModel;

    public function __construct()
    {
        parent::__construct();
        $this->eventModel = new Event();
    }

    /**
     * List all events
     */
    public function index()
    {
        $this->requireAuth();

        $status = $this->getQueryData()['status'] ?? '';
        $conditions = [];
        if (!empty($status)) {
            $conditions['status'] = $status;
        }

        $events = $this->eventModel->findAll($conditions, 'event_date DESC');
        $flash = $this->getFlash();

        $this->render('events/index', [
            'events' => $events,
            'status' => $status,
            'flash' => $flash
        ]);
    }

    /**
     * Show create event form
     */
    public function create()
    {
        $this->requireAuth();
        $flash = $this->getFlash();

        $this->render('events/create', [
            'flash' => $flash
        ]);
    }

    /**
     * Store new event
     */
    public function store()
    {
        $this->requireAuth();
        $data = $this->getPostData();

        try {
            $eventData = [
                'title' => $this->sanitize($data['title'] ?? ''),
                'description' => $this->sanitize($data['description'] ?? ''),
                'event_date' => $data['event_date'] ?? '',
                'location' => $this->sanitize($data['location'] ?? ''),
                'organizer_id' => $data['organizer_id'] ?? null,
                'max_participants' => $data['max_participants'] ?? null,
                'status' => $data['status'] ?? 'planned'
            ];

            $this->eventModel->validate($eventData);
            $this->eventModel->save($eventData);

            $this->setFlash('success', 'Event created successfully.');
            $this->redirect('/events.php');
        } catch (Exception $e) {
            $this->handleValidationError($e);
        }
    }

    /**
     * Show event details
     */
    public function show()
    {
        $this->requireAuth();
        $id = $this->getQueryData()['id'] ?? null;

        if (!$id) {
            $this->redirect('/events.php');
        }

        $event = $this->eventModel->findById($id);
        if (!$event) {
            $this->setFlash('error', 'Event not found.');
            $this->redirect('/events.php');
        }

        $flash = $this->getFlash();

        $this->render('events/show', [
            'event' => $event,
            'flash' => $flash
        ]);
    }

    /**
     * Show edit event form
     */
    public function edit()
    {
        $this->requireAuth();
        $id = $this->getQueryData()['id'] ?? null;

        if (!$id) {
            $this->redirect('/events.php');
        }

        $event = $this->eventModel->findById($id);
        if (!$event) {
            $this->setFlash('error', 'Event not found.');
            $this->redirect('/events.php');
        }

        $flash = $this->getFlash();

        $this->render('events/edit', [
            'event' => $event,
            'flash' => $flash
        ]);
    }

    /**
     * Update event
     */
    public function update()
    {
        $this->requireAuth();
        $data = $this->getPostData();
        $id = $data['id'] ?? null;

        if (!$id) {
            $this->redirect('/events.php');
        }

        try {
            $eventData = [
                'id' => $id,
                'title' => $this->sanitize($data['title'] ?? ''),
                'description' => $this->sanitize($data['description'] ?? ''),
                'event_date' => $data['event_date'] ?? '',
                'location' => $this->sanitize($data['location'] ?? ''),
                'organizer_id' => $data['organizer_id'] ?? null,
                'max_participants' => $data['max_participants'] ?? null,
                'status' => $data['status'] ?? 'planned'
            ];

            $this->eventModel->validate($eventData);
            $this->eventModel->save($eventData);

            $this->setFlash('success', 'Event updated successfully.');
            $this->redirect('/events.php');
        } catch (Exception $e) {
            $this->handleValidationError($e);
        }
    }

    /**
     * Delete event
     */
    public function delete()
    {
        $this->requireAuth();
        $id = $this->getQueryData()['id'] ?? null;

        if (!$id) {
            $this->redirect('/events.php');
        }

        try {
            $this->eventModel->delete($id);
            $this->setFlash('success', 'Event deleted successfully.');
        } catch (Exception $e) {
            $this->setFlash('error', 'Failed to delete event: ' . $e->getMessage());
        }

        $this->redirect('/events.php');
    }
}
