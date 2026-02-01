<?php

/**
 * Vue de la documentation technique
 * Phase 7.3: Documentation et Maintenance - Intégration in situ
 */
?>

<div class="documentation-container">
    <div class="doc-header">
        <h1><i class="fas fa-cogs"></i> Documentation technique</h1>
        <p class="doc-subtitle">Informations techniques pour développeurs et administrateurs</p>
        <div class="doc-nav">
            <a href="/documentation" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à l'accueil
            </a>
        </div>
    </div>

    <div class="doc-content">
        <?php foreach ($content as $sectionKey => $section): ?>
            <section class="doc-section" id="<?php echo $sectionKey; ?>">
                <h2><i class="fas fa-code"></i> <?php echo $section['title']; ?></h2>

                <?php if (isset($section['description'])): ?>
                    <div class="section-description">
                        <?php echo nl2br($section['description']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($section['components'])): ?>
                    <div class="components-grid">
                        <?php foreach ($section['components'] as $component): ?>
                            <div class="component-item">
                                <i class="fas fa-cube"></i>
                                <span><?php echo $component; ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($section['tables'])): ?>
                    <div class="tables-section">
                        <h3>Tables principales</h3>
                        <div class="tables-grid">
                            <?php foreach ($section['tables'] as $tableName => $description): ?>
                                <div class="table-item">
                                    <code><?php echo $tableName; ?></code>
                                    <span><?php echo $description; ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (isset($section['indexes'])): ?>
                    <div class="indexes-section">
                        <h3>Index de performance</h3>
                        <ul class="indexes-list">
                            <?php foreach ($section['indexes'] as $index): ?>
                                <li><i class="fas fa-search"></i> <?php echo $index; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (isset($section['features'])): ?>
                    <div class="features-section">
                        <h3>Fonctionnalités de sécurité</h3>
                        <div class="features-grid">
                            <?php foreach ($section['features'] as $feature): ?>
                                <div class="feature-item">
                                    <i class="fas fa-shield-alt"></i>
                                    <span><?php echo $feature; ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (isset($section['endpoints'])): ?>
                    <div class="api-section">
                        <h3>Points d'entrée API</h3>
                        <div class="endpoints-list">
                            <?php foreach ($section['endpoints'] as $endpoint): ?>
                                <div class="endpoint-item">
                                    <code><?php echo $endpoint; ?></code>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </section>
        <?php endforeach; ?>
    </div>

    <div class="doc-navigation">
        <h3><i class="fas fa-list"></i> Sommaire technique</h3>
        <ul class="toc">
            <?php foreach ($content as $sectionKey => $section): ?>
                <li><a href="#<?php echo $sectionKey; ?>"><?php echo $section['title']; ?></a></li>
            <?php endforeach; ?>
        </ul>

        <div class="tech-info">
            <h4><i class="fas fa-info-circle"></i> Informations système</h4>
            <ul>
                <li><strong>PHP Version:</strong> <?php echo PHP_VERSION; ?></li>
                <li><strong>Système:</strong> <?php echo PHP_OS; ?></li>
                <li><strong>Base de données:</strong> MySQL</li>
                <li><strong>Architecture:</strong> MVC-like</li>
            </ul>
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
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
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
        border-bottom: 2px solid #28a745;
    }

    .doc-section h2 i {
        color: #28a745;
        margin-right: 10px;
    }

    .section-description {
        margin-bottom: 25px;
        line-height: 1.6;
        color: #555;
        font-size: 1.1em;
    }

    .components-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
        margin: 20px 0;
    }

    .component-item {
        display: flex;
        align-items: center;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #28a745;
    }

    .component-item i {
        color: #28a745;
        margin-right: 10px;
        font-size: 1.2em;
    }

    .component-item span {
        color: #333;
        font-weight: 500;
    }

    .tables-section,
    .indexes-section,
    .features-section,
    .api-section {
        margin-top: 25px;
    }

    .tables-section h3,
    .indexes-section h3,
    .features-section h3,
    .api-section h3 {
        color: #333;
        margin-bottom: 15px;
        font-size: 1.2em;
    }

    .tables-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 15px;
    }

    .table-item {
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .table-item code {
        display: block;
        background: #e9ecef;
        padding: 5px 10px;
        border-radius: 4px;
        margin-bottom: 8px;
        font-family: 'Courier New', monospace;
        color: #495057;
    }

    .table-item span {
        color: #666;
        font-size: 0.9em;
    }

    .indexes-list {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin: 0;
    }

    .indexes-list li {
        margin-bottom: 10px;
        color: #555;
    }

    .indexes-list li i {
        color: #28a745;
        margin-right: 10px;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 15px;
    }

    .feature-item {
        display: flex;
        align-items: flex-start;
        padding: 15px;
        background: #fff3cd;
        border-radius: 8px;
        border-left: 4px solid #ffc107;
    }

    .feature-item i {
        color: #856404;
        margin-right: 10px;
        margin-top: 2px;
        font-size: 1.1em;
    }

    .feature-item span {
        color: #856404;
        line-height: 1.4;
    }

    .endpoints-list {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
    }

    .endpoint-item {
        margin-bottom: 10px;
    }

    .endpoint-item code {
        background: #e9ecef;
        padding: 5px 10px;
        border-radius: 4px;
        font-family: 'Courier New', monospace;
        color: #495057;
        display: block;
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
        border-bottom: 2px solid #28a745;
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
        color: #28a745;
        text-decoration: none;
        padding: 5px 10px;
        border-radius: 4px;
        transition: all 0.3s ease;
        display: block;
    }

    .toc a:hover,
    .toc a.active {
        background: #28a745;
        color: white;
    }

    .tech-info {
        border-top: 1px solid #dee2e6;
        padding-top: 20px;
    }

    .tech-info h4 {
        margin-top: 0;
        color: #333;
        font-size: 1.1em;
    }

    .tech-info ul {
        margin: 10px 0 0 0;
        padding-left: 20px;
    }

    .tech-info li {
        margin-bottom: 5px;
        color: #666;
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

        .components-grid,
        .tables-grid,
        .features-grid {
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
</script>