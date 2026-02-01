<?php

/**
 * Documentation Controller
 * Phase 7.3: Documentation et Maintenance - Intégration in situ
 * Permet d'accéder à la documentation directement depuis l'interface web
 */

class DocumentationController extends Controller
{
    public function index()
    {
        // Page d'accueil de la documentation
        $this->render('documentation/index', [
            'title' => 'Documentation du système',
            'sections' => [
                'user_guide' => 'Guide d\'utilisation',
                'technical_doc' => 'Documentation technique',
                'maintenance' => 'Plan de maintenance',
                'api' => 'Référence API'
            ]
        ]);
    }

    public function userGuide()
    {
        $this->render('documentation/user_guide', [
            'title' => 'Guide d\'utilisation',
            'content' => $this->getUserGuideContent()
        ]);
    }

    public function technicalDoc()
    {
        $this->render('documentation/technical_doc', [
            'title' => 'Documentation technique',
            'content' => $this->getTechnicalDocContent()
        ]);
    }

    public function maintenance()
    {
        $this->render('documentation/maintenance', [
            'title' => 'Plan de maintenance',
            'content' => $this->getMaintenanceContent()
        ]);
    }

    public function api()
    {
        $this->render('documentation/api', [
            'title' => 'Référence API',
            'content' => $this->getApiContent()
        ]);
    }

    private function getUserGuideContent()
    {
        return [
            'introduction' => [
                'title' => 'Introduction',
                'content' => 'Le système CRUD ASBL-ONG est une plateforme web complète pour la gestion des associations à but non lucratif et organisations non gouvernementales.'
            ],
            'getting_started' => [
                'title' => 'Premiers pas',
                'sections' => [
                    'login' => [
                        'title' => 'Connexion',
                        'steps' => [
                            'Accédez à l\'URL de votre plateforme',
                            'Cliquez sur "Connexion"',
                            'Entrez vos identifiants',
                            'Cliquez sur "Se connecter"'
                        ]
                    ],
                    'roles' => [
                        'title' => 'Rôles utilisateurs',
                        'items' => [
                            'Administrateur : Accès complet',
                            'Modérateur : Gestion des membres et événements',
                            'Membre : Accès limité',
                            'Visiteur : Lecture seule'
                        ]
                    ]
                ]
            ],
            'member_management' => [
                'title' => 'Gestion des membres',
                'sections' => [
                    'add_member' => [
                        'title' => 'Ajouter un membre',
                        'steps' => [
                            'Aller dans "Membres" > "Nouveau membre"',
                            'Remplir le formulaire (nom, email, téléphone, etc.)',
                            'Cliquer sur "Enregistrer"'
                        ]
                    ],
                    'edit_member' => [
                        'title' => 'Modifier un membre',
                        'steps' => [
                            'Aller dans "Membres"',
                            'Cliquer sur le membre à modifier',
                            'Modifier les informations',
                            'Cliquer sur "Enregistrer"'
                        ]
                    ]
                ]
            ],
            'project_management' => [
                'title' => 'Gestion des projets',
                'sections' => [
                    'create_project' => [
                        'title' => 'Créer un projet',
                        'steps' => [
                            'Aller dans "Projets" > "Nouveau projet"',
                            'Remplir les détails (nom, description, budget)',
                            'Cliquer sur "Enregistrer"'
                        ]
                    ]
                ]
            ],
            'donation_management' => [
                'title' => 'Gestion des dons',
                'sections' => [
                    'record_donation' => [
                        'title' => 'Enregistrer un don',
                        'steps' => [
                            'Aller dans "Dons" > "Nouveau don"',
                            'Sélectionner le membre donateur',
                            'Entrer le montant et la méthode de paiement',
                            'Cliquer sur "Enregistrer"'
                        ]
                    ]
                ]
            ],
            'event_management' => [
                'title' => 'Gestion des événements',
                'sections' => [
                    'create_event' => [
                        'title' => 'Créer un événement',
                        'steps' => [
                            'Aller dans "Événements" > "Nouvel événement"',
                            'Remplir les détails (titre, date, lieu)',
                            'Cliquer sur "Enregistrer"'
                        ]
                    ]
                ]
            ]
        ];
    }

    private function getTechnicalDocContent()
    {
        return [
            'architecture' => [
                'title' => 'Architecture du système',
                'description' => 'Le système suit une architecture MVC (Modèle-Vue-Contrôleur) avec séparation claire des responsabilités.',
                'components' => [
                    'Modèles : Gestion des données et logique métier',
                    'Vues : Interface utilisateur et présentation',
                    'Contrôleurs : Traitement des requêtes et coordination',
                    'Base de données : MySQL avec PDO pour l\'accès sécurisé'
                ]
            ],
            'security' => [
                'title' => 'Sécurité',
                'features' => [
                    'Protection CSRF sur tous les formulaires',
                    'Validation et échappement des entrées utilisateur',
                    'Authentification et autorisation par rôles',
                    'Headers de sécurité HTTP',
                    'Logs d\'audit des actions sensibles'
                ]
            ],
            'database' => [
                'title' => 'Structure de la base de données',
                'tables' => [
                    'users : Comptes utilisateurs et rôles',
                    'members : Informations des membres',
                    'projects : Projets de l\'association',
                    'donations : Historique des dons',
                    'events : Événements organisés'
                ]
            ],
            'api' => [
                'title' => 'API REST',
                'description' => 'Interface de programmation pour l\'intégration avec d\'autres systèmes.',
                'endpoints' => [
                    'GET /api/users - Liste des utilisateurs',
                    'POST /api/users - Créer un utilisateur',
                    'GET /api/members - Liste des membres',
                    'POST /api/members - Ajouter un membre',
                    'GET /api/projects - Liste des projets',
                    'POST /api/projects - Créer un projet'
                ]
            ]
        ];
    }

    private function getMaintenanceContent()
    {
        return [
            'backup' => [
                'title' => 'Sauvegarde automatique',
                'description' => 'Le système effectue des sauvegardes régulières de la base de données et des fichiers pour garantir la sécurité des données.',
                'schedule' => [
                    'Base de données' => 'Toutes les 6 heures',
                    'Fichiers' => 'Toutes les 24 heures',
                    'Sauvegarde complète' => 'Hebdomadaire (dimanche 02h00)',
                    'Vérification des sauvegardes' => 'Quotidienne (06h00)'
                ],
                'retention' => [
                    'Sauvegardes horaires' => '7 jours',
                    'Sauvegardes quotidiennes' => '30 jours',
                    'Sauvegardes hebdomadaires' => '1 an',
                    'Sauvegardes mensuelles' => '5 ans'
                ],
                'checks' => [
                    'Vérification de l\'intégrité des fichiers',
                    'Test de restauration des sauvegardes',
                    'Contrôle de l\'espace disque disponible',
                    'Notification en cas d\'échec'
                ],
                'alerts' => [
                    'Alerte par email en cas d\'échec de sauvegarde',
                    'Notification SMS pour les sauvegardes critiques',
                    'Rapport hebdomadaire des sauvegardes effectuées'
                ]
            ],
            'monitoring' => [
                'title' => 'Monitoring système',
                'description' => 'Surveillance continue des performances et de la disponibilité du système.',
                'schedule' => [
                    'Vérification des services' => 'Toutes les 5 minutes',
                    'Contrôle des performances' => 'Toutes les heures',
                    'Analyse des logs' => 'Toutes les 4 heures',
                    'Rapport de santé' => 'Quotidien (08h00)'
                ],
                'checks' => [
                    'Disponibilité des services web',
                    'Utilisation CPU et mémoire',
                    'Espace disque disponible',
                    'Connexions à la base de données',
                    'Temps de réponse des API'
                ],
                'alerts' => [
                    'Alerte si indisponibilité > 5 minutes',
                    'Notification si utilisation CPU > 80%',
                    'Alerte si espace disque < 10%',
                    'Notification en cas d\'erreur critique'
                ]
            ],
            'updates' => [
                'title' => 'Mises à jour système',
                'description' => 'Procédures automatisées pour maintenir le système à jour et sécurisé.',
                'schedule' => [
                    'Vérification des mises à jour' => 'Quotidienne (03h00)',
                    'Installation des correctifs de sécurité' => 'Hebdomadaire (lundi 01h00)',
                    'Mise à jour des dépendances' => 'Mensuelle (1er du mois)',
                    'Sauvegarde avant mise à jour' => 'Automatique'
                ],
                'procedure' => [
                    'Création d\'une sauvegarde complète du système',
                    'Vérification des prérequis de mise à jour',
                    'Installation des mises à jour en environnement de test',
                    'Validation des fonctionnalités après mise à jour',
                    'Déploiement en production avec rollback automatique'
                ]
            ],
            'emergency' => [
                'title' => 'Procédures d\'urgence',
                'description' => 'Plan d\'action en cas d\'incident critique ou de panne majeure.',
                'steps' => [
                    'Évaluation immédiate de l\'impact et de la criticité',
                    'Activation du plan de continuité d\'activité',
                    'Notification des équipes techniques et direction',
                    'Mise en place de la solution de secours',
                    'Communication avec les utilisateurs affectés',
                    'Analyse post-incident et mise à jour des procédures'
                ]
            ]
        ];
    }

    private function getApiContent()
    {
        return [
            'authentication' => [
                'title' => 'Authentification',
                'description' => 'Toutes les requêtes API nécessitent une authentification via un token JWT.',
                'auth' => [
                    'type' => 'Bearer Token',
                    'header' => 'Authorization: Bearer {token}',
                    'description' => 'Le token doit être obtenu via le endpoint /auth/login et inclus dans toutes les requêtes suivantes.'
                ],
                'rate_limit' => [
                    'limit' => '1000 requêtes',
                    'window' => 'heure',
                    'description' => 'Limite appliquée par adresse IP. Les dépassements sont automatiquement bloqués.'
                ]
            ],
            'users' => [
                'title' => 'Gestion des utilisateurs',
                'description' => 'Endpoints pour la gestion des comptes utilisateurs et des rôles.',
                'endpoints' => [
                    [
                        'method' => 'GET',
                        'url' => '/api/v1/users',
                        'description' => 'Récupère la liste des utilisateurs',
                        'parameters' => [
                            [
                                'name' => 'page',
                                'type' => 'integer',
                                'required' => false,
                                'description' => 'Numéro de page (défaut: 1)'
                            ],
                            [
                                'name' => 'limit',
                                'type' => 'integer',
                                'required' => false,
                                'description' => 'Nombre d\'éléments par page (défaut: 20)'
                            ],
                            [
                                'name' => 'role',
                                'type' => 'string',
                                'required' => false,
                                'description' => 'Filtrer par rôle (admin, moderator, member)'
                            ]
                        ],
                        'responses' => [
                            '200' => [
                                'description' => 'Liste des utilisateurs récupérée avec succès',
                                'example' => '{
  "success": true,
  "data": {
    "users": [...],
    "pagination": {
      "page": 1,
      "limit": 20,
      "total": 150
    }
  }
}'
                            ],
                            '401' => [
                                'description' => 'Token d\'authentification manquant ou invalide'
                            ],
                            '403' => [
                                'description' => 'Permissions insuffisantes'
                            ]
                        ],
                        'example' => [
                            'curl' => 'curl -X GET "https://api.crud-asbl-ong.com/v1/users?page=1&limit=10" \\
  -H "Authorization: Bearer YOUR_TOKEN"',
                            'php' => '$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.crud-asbl-ong.com/v1/users?page=1&limit=10");
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer YOUR_TOKEN"]);
$result = curl_exec($ch);',
                            'js' => 'fetch(\'https://api.crud-asbl-ong.com/v1/users?page=1&limit=10\', {
  headers: {
    \'Authorization\': \'Bearer YOUR_TOKEN\'
  }
})
.then(response => response.json())
.then(data => console.log(data));'
                        ]
                    ],
                    [
                        'method' => 'POST',
                        'url' => '/api/v1/users',
                        'description' => 'Crée un nouvel utilisateur',
                        'parameters' => [
                            [
                                'name' => 'username',
                                'type' => 'string',
                                'required' => true,
                                'description' => 'Nom d\'utilisateur unique'
                            ],
                            [
                                'name' => 'email',
                                'type' => 'string',
                                'required' => true,
                                'description' => 'Adresse email valide'
                            ],
                            [
                                'name' => 'password',
                                'type' => 'string',
                                'required' => true,
                                'description' => 'Mot de passe (min 8 caractères)'
                            ],
                            [
                                'name' => 'role',
                                'type' => 'string',
                                'required' => false,
                                'description' => 'Rôle de l\'utilisateur (défaut: member)'
                            ]
                        ],
                        'responses' => [
                            '201' => [
                                'description' => 'Utilisateur créé avec succès',
                                'example' => '{
  "success": true,
  "data": {
    "user": {
      "id": 123,
      "username": "john_doe",
      "email": "john@example.com",
      "role": "member",
      "created_at": "2024-01-15T10:30:00Z"
    }
  }
}'
                            ],
                            '400' => [
                                'description' => 'Données invalides ou manquantes'
                            ],
                            '409' => [
                                'description' => 'Nom d\'utilisateur ou email déjà existant'
                            ]
                        ],
                        'example' => [
                            'curl' => 'curl -X POST "https://api.crud-asbl-ong.com/v1/users" \\
  -H "Content-Type: application/json" \\
  -H "Authorization: Bearer YOUR_TOKEN" \\
  -d \'{
    "username": "john_doe",
    "email": "john@example.com",
    "password": "securepassword123",
    "role": "member"
  }\'',
                            'php' => '$data = [
  "username" => "john_doe",
  "email" => "john@example.com",
  "password" => "securepassword123",
  "role" => "member"
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.crud-asbl-ong.com/v1/users");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  "Content-Type: application/json",
  "Authorization: Bearer YOUR_TOKEN"
]);
$result = curl_exec($ch);',
                            'js' => 'const userData = {
  username: "john_doe",
  email: "john@example.com",
  password: "securepassword123",
  role: "member"
};

fetch(\'https://api.crud-asbl-ong.com/v1/users\', {
  method: \'POST\',
  headers: {
    \'Content-Type\': \'application/json\',
    \'Authorization\': \'Bearer YOUR_TOKEN\'
  },
  body: JSON.stringify(userData)
})
.then(response => response.json())
.then(data => console.log(data));'
                        ]
                    ]
                ]
            ],
            'members' => [
                'title' => 'Gestion des membres',
                'description' => 'Endpoints pour la gestion des membres de l\'association.',
                'endpoints' => [
                    [
                        'method' => 'GET',
                        'url' => '/api/v1/members',
                        'description' => 'Récupère la liste des membres',
                        'parameters' => [
                            [
                                'name' => 'status',
                                'type' => 'string',
                                'required' => false,
                                'description' => 'Filtrer par statut (active, inactive, suspended)'
                            ],
                            [
                                'name' => 'search',
                                'type' => 'string',
                                'required' => false,
                                'description' => 'Recherche par nom ou email'
                            ]
                        ],
                        'responses' => [
                            '200' => [
                                'description' => 'Liste des membres récupérée avec succès'
                            ]
                        ]
                    ],
                    [
                        'method' => 'POST',
                        'url' => '/api/v1/members',
                        'description' => 'Ajoute un nouveau membre',
                        'parameters' => [
                            [
                                'name' => 'first_name',
                                'type' => 'string',
                                'required' => true,
                                'description' => 'Prénom du membre'
                            ],
                            [
                                'name' => 'last_name',
                                'type' => 'string',
                                'required' => true,
                                'description' => 'Nom du membre'
                            ],
                            [
                                'name' => 'email',
                                'type' => 'string',
                                'required' => true,
                                'description' => 'Adresse email'
                            ]
                        ],
                        'responses' => [
                            '201' => [
                                'description' => 'Membre créé avec succès'
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}