<?php

/**
 * Vue du plan de maintenance
 * Phase 7.3: Documentation et Maintenance - Intégration in situ
 */
?>

<div class="documentation-container">
    <div class="doc-header">
        <h1><i class="fas fa-tools"></i> Plan de maintenance</h1>
        <p class="doc-subtitle">Procédures de maintenance, sauvegarde et mise à jour</p>
        <div class="doc-nav">
            <a href="/documentation" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à l'accueil
            </a>
        </div>
    </div>

    <div class="doc-content">
        <?php foreach ($content as $sectionKey => $section): ?>
            <section class="doc-section" id="<?php echo $sectionKey; ?>">
                <h2><i class="fas fa-wrench"></i> <?php echo $section['title']; ?></h2>

                <?php if (isset($section['description'])): ?>
                    <div class="section-description">
                        <?php echo nl2br($section['description']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($section['schedule'])): ?>
                    <div class="schedule-section">
                        <h3>Planification</h3>
                        <div class="schedule-grid">
                            <?php foreach ($section['schedule'] as $task => $time): ?>
                                <div class="schedule-item">
                                    <div class="schedule-time"><?php echo $time; ?></div>
                                    <div class="schedule-task"><?php echo $task; ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (isset($section['retention'])): ?>
                    <div class="retention-section">
                        <h3>Période de rétention</h3>
                        <ul class="retention-list">
                            <?php foreach ($section['retention'] as $type => $period): ?>
                                <li><strong><?php echo $type; ?>:</strong> <?php echo $period; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (isset($section['checks'])): ?>
                    <div class="checks-section">
                        <h3>Vérifications effectuées</h3>
                        <div class="checks-grid">
                            <?php foreach ($section['checks'] as $check): ?>
                                <div class="check-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span><?php echo $check; ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (isset($section['alerts'])): ?>
                    <div class="alerts-section">
                        <h3>Système d'alertes</h3>
                        <ul class="alerts-list">
                            <?php foreach ($section['alerts'] as $alert): ?>
                                <li><i class="fas fa-bell"></i> <?php echo $alert; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (isset($section['procedure'])): ?>
                    <div class="procedure-section">
                        <h3>Procédure de mise à jour</h3>
                        <ol class="procedure-steps">
                            <?php foreach ($section['procedure'] as $step): ?>
                                <li><?php echo $step; ?></li>
                            <?php endforeach; ?>
                        </ol>
                    </div>
                <?php endif; ?>

                <?php if (isset($section['steps'])): ?>
                    <div class="emergency-section">
                        <h3>Étapes d'urgence</h3>
                        <ol class="emergency-steps">
                            <?php foreach ($section['steps'] as $step): ?>
                                <li><?php echo $step; ?></li>
                            <?php endforeach; ?>
                        </ol>
                    </div>
                <?php endif; ?>
            </section>
        <?php endforeach; ?>
    </div>

    <div class="doc-navigation">
        <h3><i class="fas fa-list"></i> Sommaire maintenance</h3>
        <ul class="toc">
            <?php foreach ($content as $sectionKey => $section): ?>
                <li><a href="#<?php echo $sectionKey; ?>"><?php echo $section['title']; ?></a></li>
            <?php endforeach; ?>
        </ul>

        <div class="maintenance-tools">
            <h4><i class="fas fa-terminal"></i> Outils disponibles</h4>
            <div class="tools-list">
                <a href="#" onclick="runBackup('database')" class="tool-btn">
                    <i class="fas fa-database"></i>
                    Sauvegarde DB
                </a>
                <a href="#" onclick="runBackup('files')" class="tool-btn">
                    <i class="fas fa-folder"></i>
                    Sauvegarde fichiers
                </a>
                <a href="#" onclick="runMonitor()" class="tool-btn">
                    <i class="fas fa-heartbeat"></i>
                    Monitoring
                </a>
                <a href="#" onclick="runMigrations()" class="tool-btn">
                    <i class="fas fa-code-branch"></i>
                    Migrations
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .documentation-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .doc-header {
        text-align: center;
        margin-bottom: 40px;
        padding: 30px;
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
        color: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .doc-header h1 {
        margin: 0 0 10px 0;
        font-size: 2.5em;
    }

    .doc-subtitle {
        margin: 0 0 20px 0;
        font-size: 1.2em;
        opacity: 0.9;
    }

    .doc-nav {
        text-align: center;
    }

    .doc-content {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 30px;
    }

    .doc-section {
        padding: 30px;
        border-bottom: 1px solid #f0f0f0;
    }

    .doc-section:last-child {
        border-bottom: none;
    }

    .doc-section h2 {
        color: #333;
        margin-top: 0;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #ffc107;
    }

    .doc-section h2 i {
        color: #ffc107;
        margin-right: 10px;
    }

    .section-description {
        margin-bottom: 25px;
        line-height: 1.6;
        color: #555;
        font-size: 1.1em;
    }

    .schedule-section,
    .retention-section,
    .checks-section,
    .alerts-section,
    .procedure-section,
    .emergency-section {
        margin-top: 25px;
    }

    .schedule-section h3,
    .retention-section h3,
    .checks-section h3,
    .alerts-section h3,
    .procedure-section h3,
    .emergency-section h3 {
        color: #333;
        margin-bottom: 15px;
        font-size: 1.2em;
    }

    .schedule-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 15px;
    }

    .schedule-item {
        padding: 15px;
        background: #fff3cd;
        border-radius: 8px;
        border-left: 4px solid #ffc107;
    }

    .schedule-time {
        font-weight: bold;
        color: #856404;
        margin-bottom: 5px;
    }

    .schedule-task {
        color: #856404;
    }

    .retention-list {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin: 0;
    }

    .retention-list li {
        margin-bottom: 10px;
        color: #555;
    }

    .checks-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
    }

    .check-item {
        display: flex;
        align-items: center;
        padding: 15px;
        background: #d4edda;
        border-radius: 8px;
        border-left: 4px solid #28a745;
    }

    .check-item i {
        color: #155724;
        margin-right: 10px;
        font-size: 1.2em;
    }

    .check-item span {
        color: #155724;
    }

    .alerts-list {
        background: #f8d7da;
        border-radius: 8px;
        padding: 20px;
        margin: 0;
    }

    .alerts-list li {
        margin-bottom: 10px;
        color: #721c24;
    }

    .alerts-list li i {
        color: #dc3545;
        margin-right: 10px;
    }

    .procedure-steps,
    .emergency-steps {
        background: #e9ecef;
        border-radius: 8px;
        padding: 20px;
        margin: 0;
        counter-reset: step-counter;
    }

    .procedure-steps li,
    .emergency-steps li {
        margin-bottom: 15px;
        color: #495057;
        line-height: 1.5;
        position: relative;
        padding-left: 30px;
    }

    .procedure-steps li:before,
    .emergency-steps li:before {
        content: counter(step-counter);
        counter-increment: step-counter;
        position: absolute;
        left: 0;
        top: 0;
        background: #007bff;
        color: white;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8em;
        font-weight: bold;
    }

    .doc-navigation {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 30px;
        position: sticky;
        top: 20px;
    }

    .doc-navigation h3 {
        margin-top: 0;
        color: #333;
        border-bottom: 2px solid #ffc107;
        padding-bottom: 10px;
    }

    .toc {
        list-style: none;
        padding: 0;
        margin: 0 0 30px 0;
    }

    .toc li {
        margin-bottom: 8px;
    }

    .toc a {
        color: #ffc107;
        text-decoration: none;
        padding: 5px 10px;
        border-radius: 4px;
        transition: all 0.3s ease;
        display: block;
    }

    .toc a:hover,
    .toc a.active {
        background: #ffc107;
        color: white;
    }

    .maintenance-tools {
        border-top: 1px solid #dee2e6;
        padding-top: 20px;
    }

    .maintenance-tools h4 {
        margin-top: 0;
        color: #333;
        font-size: 1.1em;
    }

    .tools-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        margin-top: 15px;
    }

    .tool-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 12px;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        text-decoration: none;
        color: #495057;
        font-size: 0.9em;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .tool-btn:hover {
        background: #ffc107;
        color: white;
        border-color: #ffc107;
    }

    .tool-btn i {
        margin-right: 8px;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #545b62;
    }

    @media (max-width: 768px) {
        .doc-navigation {
            position: static;
            margin-bottom: 30px;
        }

        .doc-section {
            padding: 20px;
        }

        .schedule-grid,
        .checks-grid {
            grid-template-columns: 1fr;
        }

        .tools-list {
            grid-template-columns: 1fr;
        }

        .doc-header h1 {
            font-size: 2em;
        }
    }
</style>

<script>
    // Smooth scrolling and active section highlighting
    document.querySelectorAll('.toc a').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    window.addEventListener('scroll', function() {
        const sections = document.querySelectorAll('.doc-section');
        const tocLinks = document.querySelectorAll('.toc a');

        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            if (pageYOffset >= sectionTop - 100) {
                current = section.getAttribute('id');
            }
        });

        tocLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === '#' + current) {
                link.classList.add('active');
            }
        });
    });

    // Maintenance tools functions
    function runBackup(type) {
        if (confirm(`Voulez-vous lancer une sauvegarde ${type === 'database' ? 'de base de données' : 'des fichiers'} ?`)) {
            // Here you would make an AJAX call to run the backup
            alert(`Sauvegarde ${type} lancée. Vous recevrez une notification une fois terminée.`);
        }
    }

    function runMonitor() {
        window.open('monitor.php', '_blank');
    }

    function runMigrations() {
        if (confirm('Voulez-vous appliquer les migrations de base de données ?')) {
            // Here you would make an AJAX call to run migrations
            alert('Migrations en cours. Vous recevrez une notification une fois terminées.');
        }
    }
</script>