<?php

/**
 * Vue de référence API
 * Phase 7.3: Documentation et Maintenance - Intégration in situ
 */
?>

<div class="api-container">
    <div class="api-header">
        <h1><i class="fas fa-code"></i> Référence API</h1>
        <p class="api-subtitle">Documentation complète des endpoints API REST</p>
        <div class="api-nav">
            <a href="/documentation?action=index" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à l'accueil
            </a>
        </div>
    </div>

    <div class="api-content">
        <?php foreach ($content as $sectionKey => $section): ?>
            <section class="api-section" id="<?php echo $sectionKey; ?>">
                <h2><i class="fas fa-plug"></i> <?php echo $section['title']; ?></h2>

                <?php if (isset($section['description'])): ?>
                    <div class="section-description">
                        <?php echo nl2br($section['description']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($section['endpoints'])): ?>
                    <div class="endpoints-section">
                        <?php foreach ($section['endpoints'] as $endpoint): ?>
                            <div class="endpoint-card">
                                <div class="endpoint-header">
                                    <span class="method method-<?php echo strtolower($endpoint['method']); ?>">
                                        <?php echo $endpoint['method']; ?>
                                    </span>
                                    <code class="endpoint-url"><?php echo $endpoint['url']; ?></code>
                                </div>

                                <div class="endpoint-description">
                                    <p><?php echo $endpoint['description']; ?></p>
                                </div>

                                <?php if (isset($endpoint['parameters'])): ?>
                                    <div class="endpoint-parameters">
                                        <h4>Paramètres</h4>
                                        <div class="parameters-table">
                                            <div class="param-header">
                                                <span>Nom</span>
                                                <span>Type</span>
                                                <span>Obligatoire</span>
                                                <span>Description</span>
                                            </div>
                                            <?php foreach ($endpoint['parameters'] as $param): ?>
                                                <div class="param-row">
                                                    <span class="param-name"><?php echo $param['name']; ?></span>
                                                    <span class="param-type"><?php echo $param['type']; ?></span>
                                                    <span class="param-required <?php echo $param['required'] ? 'yes' : 'no'; ?>">
                                                        <?php echo $param['required'] ? 'Oui' : 'Non'; ?>
                                                    </span>
                                                    <span class="param-desc"><?php echo $param['description']; ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if (isset($endpoint['responses'])): ?>
                                    <div class="endpoint-responses">
                                        <h4>Réponses</h4>
                                        <?php foreach ($endpoint['responses'] as $code => $response): ?>
                                            <div class="response-item">
                                                <div class="response-code code-<?php echo substr($code, 0, 1); ?>">
                                                    <?php echo $code; ?>
                                                </div>
                                                <div class="response-desc">
                                                    <strong><?php echo $response['description']; ?></strong>
                                                    <?php if (isset($response['example'])): ?>
                                                        <div class="response-example">
                                                            <pre><code><?php echo htmlspecialchars($response['example']); ?></code></pre>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (isset($endpoint['example'])): ?>
                                    <div class="endpoint-example">
                                        <h4>Exemple d'utilisation</h4>
                                        <div class="code-tabs">
                                            <div class="tab-buttons">
                                                <button class="tab-btn active" onclick="showTab(this, 'curl')">cURL</button>
                                                <button class="tab-btn" onclick="showTab(this, 'php')">PHP</button>
                                                <button class="tab-btn" onclick="showTab(this, 'js')">JavaScript</button>
                                            </div>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="curl">
                                                    <pre><code class="language-bash"><?php echo htmlspecialchars($endpoint['example']['curl']); ?></code></pre>
                                                </div>
                                                <div class="tab-pane" id="php">
                                                    <pre><code class="language-php"><?php echo htmlspecialchars($endpoint['example']['php']); ?></code></pre>
                                                </div>
                                                <div class="tab-pane" id="js">
                                                    <pre><code class="language-javascript"><?php echo htmlspecialchars($endpoint['example']['js']); ?></code></pre>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($section['auth'])): ?>
                    <div class="auth-section">
                        <h3>Authentification</h3>
                        <div class="auth-info">
                            <p><strong>Type:</strong> <?php echo $section['auth']['type']; ?></p>
                            <p><strong>Header:</strong> <code><?php echo $section['auth']['header']; ?></code></p>
                            <p><?php echo $section['auth']['description']; ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (isset($section['rate_limit'])): ?>
                    <div class="rate-limit-section">
                        <h3>Limitation de taux</h3>
                        <div class="rate-limit-info">
                            <p><strong>Limite:</strong> <?php echo $section['rate_limit']['limit']; ?> requêtes par <?php echo $section['rate_limit']['window']; ?></p>
                            <p><?php echo $section['rate_limit']['description']; ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </section>
        <?php endforeach; ?>
    </div>

    <div class="api-navigation">
        <h3><i class="fas fa-list"></i> Sommaire API</h3>
        <ul class="api-toc">
            <?php foreach ($content as $sectionKey => $section): ?>
                <li><a href="#<?php echo $sectionKey; ?>"><?php echo $section['title']; ?></a></li>
            <?php endforeach; ?>
        </ul>

        <div class="api-tools">
            <h4><i class="fas fa-flask"></i> Outils de test</h4>
            <div class="tools-list">
                <a href="#" onclick="openApiTester()" class="tool-btn">
                    <i class="fas fa-play"></i>
                    Testeur API
                </a>
                <a href="#" onclick="downloadPostman()" class="tool-btn">
                    <i class="fas fa-download"></i>
                    Collection Postman
                </a>
                <a href="#" onclick="viewSwagger()" class="tool-btn">
                    <i class="fas fa-eye"></i>
                    Documentation Swagger
                </a>
            </div>
        </div>

        <div class="api-info">
            <h4><i class="fas fa-info-circle"></i> Informations générales</h4>
            <ul class="info-list">
                <li><strong>Base URL:</strong> <code>https://api.crud-asbl-ong.com/v1</code></li>
                <li><strong>Format:</strong> JSON</li>
                <li><strong>Encoding:</strong> UTF-8</li>
                <li><strong>Version:</strong> v1.0.0</li>
            </ul>
        </div>
    </div>
</div>

<style>
    .api-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    .api-header {
        text-align: center;
        margin-bottom: 40px;
        padding: 30px;
        background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
        color: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .api-header h1 {
        margin: 0 0 10px 0;
        font-size: 2.5em;
    }

    .api-subtitle {
        margin: 0 0 20px 0;
        font-size: 1.2em;
        opacity: 0.9;
    }

    .api-nav {
        text-align: center;
    }

    .api-content {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 30px;
    }

    .api-section {
        padding: 30px;
        border-bottom: 1px solid #f0f0f0;
    }

    .api-section:last-child {
        border-bottom: none;
    }

    .api-section h2 {
        color: #333;
        margin-top: 0;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #17a2b8;
    }

    .api-section h2 i {
        color: #17a2b8;
        margin-right: 10px;
    }

    .section-description {
        margin-bottom: 25px;
        line-height: 1.6;
        color: #555;
        font-size: 1.1em;
    }

    .endpoint-card {
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 30px;
        border-left: 4px solid #17a2b8;
        overflow: hidden;
    }

    .endpoint-header {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        background: white;
        border-bottom: 1px solid #dee2e6;
    }

    .method {
        padding: 4px 8px;
        border-radius: 4px;
        color: white;
        font-weight: bold;
        font-size: 0.8em;
        margin-right: 15px;
        min-width: 60px;
        text-align: center;
    }

    .method-get {
        background: #28a745;
    }

    .method-post {
        background: #007bff;
    }

    .method-put {
        background: #ffc107;
        color: #212529;
    }

    .method-delete {
        background: #dc3545;
    }

    .method-patch {
        background: #6f42c1;
    }

    .endpoint-url {
        font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
        font-size: 1.1em;
        color: #333;
        background: #f8f9fa;
        padding: 2px 6px;
        border-radius: 4px;
    }

    .endpoint-description {
        padding: 15px 20px;
        background: white;
    }

    .endpoint-description p {
        margin: 0;
        color: #555;
        line-height: 1.5;
    }

    .endpoint-parameters,
    .endpoint-responses,
    .endpoint-example {
        padding: 20px;
        background: #f8f9fa;
        border-top: 1px solid #dee2e6;
    }

    .endpoint-parameters h4,
    .endpoint-responses h4,
    .endpoint-example h4 {
        margin-top: 0;
        margin-bottom: 15px;
        color: #333;
        font-size: 1.1em;
    }

    .parameters-table {
        background: white;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .param-header {
        display: grid;
        grid-template-columns: 1fr 100px 100px 2fr;
        background: #17a2b8;
        color: white;
        padding: 12px 15px;
        font-weight: bold;
    }

    .param-row {
        display: grid;
        grid-template-columns: 1fr 100px 100px 2fr;
        padding: 12px 15px;
        border-bottom: 1px solid #dee2e6;
    }

    .param-row:last-child {
        border-bottom: none;
    }

    .param-name {
        font-weight: 500;
        color: #333;
    }

    .param-type {
        font-family: monospace;
        background: #e9ecef;
        padding: 2px 6px;
        border-radius: 3px;
        text-align: center;
    }

    .param-required.yes {
        color: #dc3545;
        font-weight: bold;
    }

    .param-required.no {
        color: #28a745;
    }

    .response-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
        padding: 15px;
        background: white;
        border-radius: 6px;
        border-left: 4px solid #28a745;
    }

    .response-code {
        min-width: 80px;
        font-weight: bold;
        margin-right: 15px;
        text-align: center;
    }

    .code-2 {
        color: #28a745;
    }

    .code-4 {
        color: #ffc107;
    }

    .code-5 {
        color: #dc3545;
    }

    .response-desc {
        flex: 1;
    }

    .response-example {
        margin-top: 10px;
    }

    .response-example pre {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 10px;
        margin: 0;
        font-size: 0.9em;
        overflow-x: auto;
    }

    .code-tabs {
        border: 1px solid #dee2e6;
        border-radius: 6px;
        overflow: hidden;
    }

    .tab-buttons {
        display: flex;
        background: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }

    .tab-btn {
        flex: 1;
        padding: 10px 15px;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 0.9em;
        transition: all 0.3s ease;
    }

    .tab-btn.active {
        background: #17a2b8;
        color: white;
    }

    .tab-content {
        background: white;
    }

    .tab-pane {
        display: none;
        padding: 0;
    }

    .tab-pane.active {
        display: block;
    }

    .tab-pane pre {
        margin: 0;
        border-radius: 0;
        border: none;
    }

    .auth-section,
    .rate-limit-section {
        margin-top: 25px;
        padding: 20px;
        background: #e9ecef;
        border-radius: 8px;
    }

    .auth-section h3,
    .rate-limit-section h3 {
        margin-top: 0;
        color: #333;
        font-size: 1.2em;
    }

    .auth-info,
    .rate-limit-info {
        line-height: 1.6;
    }

    .auth-info code,
    .rate-limit-info code {
        background: #f8f9fa;
        padding: 2px 6px;
        border-radius: 3px;
        font-family: monospace;
    }

    .api-navigation {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 30px;
        position: sticky;
        top: 20px;
    }

    .api-navigation h3 {
        margin-top: 0;
        color: #333;
        border-bottom: 2px solid #17a2b8;
        padding-bottom: 10px;
    }

    .api-toc {
        list-style: none;
        padding: 0;
        margin: 0 0 30px 0;
    }

    .api-toc li {
        margin-bottom: 8px;
    }

    .api-toc a {
        color: #17a2b8;
        text-decoration: none;
        padding: 5px 10px;
        border-radius: 4px;
        transition: all 0.3s ease;
        display: block;
    }

    .api-toc a:hover,
    .api-toc a.active {
        background: #17a2b8;
        color: white;
    }

    .api-tools,
    .api-info {
        border-top: 1px solid #dee2e6;
        padding-top: 20px;
        margin-top: 20px;
    }

    .api-tools h4,
    .api-info h4 {
        margin-top: 0;
        color: #333;
        font-size: 1.1em;
    }

    .tools-list {
        display: grid;
        grid-template-columns: 1fr;
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
        background: #17a2b8;
        color: white;
        border-color: #17a2b8;
    }

    .tool-btn i {
        margin-right: 8px;
    }

    .info-list {
        background: #f8f9fa;
        border-radius: 6px;
        padding: 15px;
        margin: 15px 0 0 0;
    }

    .info-list li {
        margin-bottom: 8px;
        color: #555;
    }

    .info-list code {
        background: white;
        padding: 2px 6px;
        border-radius: 3px;
        font-family: monospace;
        color: #333;
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
        .api-navigation {
            position: static;
            margin-bottom: 30px;
        }

        .api-section {
            padding: 20px;
        }

        .endpoint-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .param-header,
        .param-row {
            grid-template-columns: 1fr;
            gap: 5px;
        }

        .response-item {
            flex-direction: column;
            gap: 10px;
        }

        .tab-buttons {
            flex-direction: column;
        }

        .api-header h1 {
            font-size: 2em;
        }
    }
</style>

<script>
    // Smooth scrolling and active section highlighting
    document.querySelectorAll('.api-toc a').forEach(anchor => {
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
        const sections = document.querySelectorAll('.api-section');
        const tocLinks = document.querySelectorAll('.api-toc a');

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

    // Tab functionality
    function showTab(button, tabId) {
        const tabContainer = button.closest('.code-tabs');
        const tabButtons = tabContainer.querySelectorAll('.tab-btn');
        const tabPanes = tabContainer.querySelectorAll('.tab-pane');

        tabButtons.forEach(btn => btn.classList.remove('active'));
        tabPanes.forEach(pane => pane.classList.remove('active'));

        button.classList.add('active');
        tabContainer.querySelector('#' + tabId).classList.add('active');
    }

    // API tools functions
    function openApiTester() {
        window.open('api-tester.php', '_blank');
    }

    function downloadPostman() {
        // Trigger download of Postman collection
        const link = document.createElement('a');
        link.href = 'api/postman_collection.json';
        link.download = 'crud-asbl-ong-api-v1.postman_collection.json';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function viewSwagger() {
        window.open('api/docs', '_blank');
    }
</script>