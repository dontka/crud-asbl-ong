<?php
// Définition des rôles et permissions (exemple de structure)
return [
    'admin' => ['*'],
    'responsable_rh' => ['hr.*', 'members.view', 'users.view'],
    'comptable' => ['finance.*', 'donations.view', 'projects.view'],
    'chef_projet' => ['projects.*', 'tasks.*', 'members.view'],
    'charge_relation' => ['crm.*', 'members.view', 'donations.view'],
    'membre' => ['dashboard.view', 'events.view', 'projects.view', 'profile.edit'],
    'invite' => ['public.*'],
    'moderateur' => ['moderation.*', 'comments.*'],
    'superviseur' => ['governance.*', 'reporting.*'],
    'auditeur' => ['audit.view', 'logs.view', 'reports.view'],
    'responsable_securite' => ['security.*', 'logs.view'],
    'it' => ['infrastructure.*', 'monitoring.*'],
    'communication' => ['communication.*', 'newsletters.*'],
    'conformite' => ['compliance.*', 'rgpd.*'],
    'marketplace' => ['plugins.*', 'marketplace.*'],
    'support' => ['support.*', 'tickets.*'],
    'formation' => ['training.*', 'users.view'],
    'qualite' => ['quality.*', 'feedback.*'],
    'volontaire' => ['missions.view', 'missions.submit', 'events.view'],
];
