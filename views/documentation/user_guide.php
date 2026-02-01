<?php

/**
 * Vue du guide d'utilisation
 * Phase 7.3: Documentation et Maintenance - Intégration in situ
 */
?>

<div class="documentation-container">
    <div class="doc-header">
        <h1><i class="fas fa-user-friends"></i> Guide d'utilisation</h1>
        <p class="doc-subtitle">Apprenez à maîtriser toutes les fonctionnalités du système</p>
        <div class="doc-nav">
            <a href="/documentation" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à l'accueil
            </a>
        </div>
    </div>

    <div class="doc-content">
        <?php foreach ($content as $sectionKey => $section): ?>
            <section class="doc-section" id="<?php echo $sectionKey; ?>">
                <h2><i class="fas fa-bookmark"></i> <?php echo $section['title']; ?></h2>

                <?php if (isset($section['content'])): ?>
                    <div class="section-content">
                        <?php echo nl2br($section['content']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($section['sections'])): ?>
                    <?php foreach ($section['sections'] as $subSectionKey => $subSection): ?>
                        <div class="subsection">
                            <h3><?php echo $subSection['title']; ?></h3>

                            <?php if (isset($subSection['steps'])): ?>
                                <ol class="steps-list">
                                    <?php foreach ($subSection['steps'] as $step): ?>
                                        <li><?php echo $step; ?></li>
                                    <?php endforeach; ?>
                                </ol>
                            <?php endif; ?>

                            <?php if (isset($subSection['items'])): ?>
                                <ul class="items-list">
                                    <?php foreach ($subSection['items'] as $item): ?>
                                        <li><?php echo $item; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if (isset($section['tips'])): ?>
                    <div class="tips-box">
                        <h4><i class="fas fa-lightbulb"></i> Conseils pratiques</h4>
                        <ul>
                            <?php foreach ($section['tips'] as $tip): ?>
                                <li><?php echo $tip; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </section>
        <?php endforeach; ?>
    </div>

    <div class="doc-navigation">
        <h3><i class="fas fa-list"></i> Sommaire</h3>
        <ul class="toc">
            <?php foreach ($content as $sectionKey => $section): ?>
                <li><a href="#<?php echo $sectionKey; ?>"><?php echo $section['title']; ?></a></li>
            <?php endforeach; ?>
        </ul>
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        border-bottom: 2px solid #007bff;
    }

    .doc-section h2 i {
        color: #007bff;
        margin-right: 10px;
    }

    .section-content {
        margin-bottom: 20px;
        line-height: 1.6;
        color: #555;
    }

    .subsection {
        margin: 25px 0;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #007bff;
    }

    .subsection h3 {
        margin-top: 0;
        color: #333;
        font-size: 1.3em;
    }

    .steps-list,
    .items-list {
        margin: 15px 0;
        padding-left: 20px;
    }

    .steps-list li,
    .items-list li {
        margin-bottom: 8px;
        line-height: 1.5;
        color: #666;
    }

    .tips-box {
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        border-radius: 8px;
        padding: 20px;
        margin-top: 20px;
    }

    .tips-box h4 {
        margin-top: 0;
        color: #856404;
    }

    .tips-box ul {
        margin: 10px 0 0 0;
        padding-left: 20px;
    }

    .tips-box li {
        color: #856404;
        margin-bottom: 5px;
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
        border-bottom: 2px solid #007bff;
        padding-bottom: 10px;
    }

    .toc {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .toc li {
        margin-bottom: 8px;
    }

    .toc a {
        color: #007bff;
        text-decoration: none;
        padding: 5px 10px;
        border-radius: 4px;
        transition: all 0.3s ease;
        display: block;
    }

    .toc a:hover {
        background: #f8f9fa;
        color: #0056b3;
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

        .doc-header h1 {
            font-size: 2em;
        }
    }
</style>

<script>
    // Smooth scrolling for table of contents
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

    // Highlight active section in TOC
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

<style>
    .toc a.active {
        background: #007bff;
        color: white;
    }
</style>