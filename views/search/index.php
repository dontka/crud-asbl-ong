<?php
require_once 'views/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="hero-section">
                <h1 class="hero-title">Search Results</h1>
                <p class="hero-subtitle">Find what you're looking for across all our data</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="search-results-container">
                <?php if (!empty($query)): ?>
                    <div class="search-query-display">
                        <h3>Results for: "<?php echo htmlspecialchars($query); ?>"</h3>
                    </div>
                <?php endif; ?>

                <?php if (empty($results['members']) && empty($results['projects']) && empty($results['events']) && empty($results['donations'])): ?>
                    <div class="no-results">
                        <div class="no-results-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3>No results found</h3>
                        <p>Try adjusting your search terms or check your spelling.</p>
                    </div>
                <?php else: ?>
                    <!-- Members Results -->
                    <?php if (!empty($results['members'])): ?>
                        <div class="search-section">
                            <h4 class="search-section-title">
                                <i class="fas fa-users"></i> Members (<?php echo count($results['members']); ?>)
                            </h4>
                            <div class="search-results-grid">
                                <?php foreach ($results['members'] as $member): ?>
                                    <div class="search-result-card">
                                        <div class="result-icon">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="result-content">
                                            <h5><?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?></h5>
                                            <p><?php echo htmlspecialchars($member['email']); ?></p>
                                        </div>
                                        <div class="result-actions">
                                            <a href="/members/show?id=<?php echo $member['id']; ?>" class="btn btn-primary btn-sm">View</a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Projects Results -->
                    <?php if (!empty($results['projects'])): ?>
                        <div class="search-section">
                            <h4 class="search-section-title">
                                <i class="fas fa-project-diagram"></i> Projects (<?php echo count($results['projects']); ?>)
                            </h4>
                            <div class="search-results-grid">
                                <?php foreach ($results['projects'] as $project): ?>
                                    <div class="search-result-card">
                                        <div class="result-icon">
                                            <i class="fas fa-project-diagram"></i>
                                        </div>
                                        <div class="result-content">
                                            <h5><?php echo htmlspecialchars($project['name']); ?></h5>
                                            <p><?php echo htmlspecialchars(substr($project['description'], 0, 100)) . '...'; ?></p>
                                        </div>
                                        <div class="result-actions">
                                            <a href="/projects/show?id=<?php echo $project['id']; ?>" class="btn btn-primary btn-sm">View</a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Events Results -->
                    <?php if (!empty($results['events'])): ?>
                        <div class="search-section">
                            <h4 class="search-section-title">
                                <i class="fas fa-calendar-alt"></i> Events (<?php echo count($results['events']); ?>)
                            </h4>
                            <div class="search-results-grid">
                                <?php foreach ($results['events'] as $event): ?>
                                    <div class="search-result-card">
                                        <div class="result-icon">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                        <div class="result-content">
                                            <h5><?php echo htmlspecialchars($event['title']); ?></h5>
                                            <p><?php echo htmlspecialchars(substr($event['description'], 0, 100)) . '...'; ?></p>
                                        </div>
                                        <div class="result-actions">
                                            <a href="/events/show?id=<?php echo $event['id']; ?>" class="btn btn-primary btn-sm">View</a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Donations Results -->
                    <?php if (!empty($results['donations'])): ?>
                        <div class="search-section">
                            <h4 class="search-section-title">
                                <i class="fas fa-donate"></i> Donations (<?php echo count($results['donations']); ?>)
                            </h4>
                            <div class="search-results-grid">
                                <?php foreach ($results['donations'] as $donation): ?>
                                    <div class="search-result-card">
                                        <div class="result-icon">
                                            <i class="fas fa-donate"></i>
                                        </div>
                                        <div class="result-content">
                                            <h5>$<?php echo number_format($donation['amount'], 2); ?></h5>
                                            <p>By <?php echo htmlspecialchars($donation['first_name'] . ' ' . $donation['last_name']); ?> on <?php echo date('M j, Y', strtotime($donation['created_at'])); ?></p>
                                        </div>
                                        <div class="result-actions">
                                            <a href="/donations/show?id=<?php echo $donation['id']; ?>" class="btn btn-primary btn-sm">View</a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .search-results-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .search-query-display {
        margin-bottom: 2rem;
        padding: 1rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px;
        text-align: center;
    }

    .search-section {
        margin-bottom: 3rem;
    }

    .search-section-title {
        color: #333;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e9ecef;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .search-results-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
    }

    .search-result-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        border: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .search-result-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .result-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .result-content {
        flex: 1;
    }

    .result-content h5 {
        margin: 0 0 0.5rem 0;
        color: #333;
        font-size: 1.1rem;
    }

    .result-content p {
        margin: 0;
        color: #666;
        font-size: 0.9rem;
    }

    .result-actions {
        flex-shrink: 0;
    }

    .no-results {
        text-align: center;
        padding: 4rem 2rem;
        color: #666;
    }

    .no-results-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .no-results h3 {
        margin-bottom: 1rem;
        color: #333;
    }

    @media (max-width: 768px) {
        .search-results-container {
            padding: 1rem;
        }

        .search-results-grid {
            grid-template-columns: 1fr;
        }

        .search-result-card {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }

        .result-actions {
            width: 100%;
        }
    }
</style>

<?php
require_once 'views/footer.php';
?>