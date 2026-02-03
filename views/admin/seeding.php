<?php
$pageTitle = $pageTitle ?? 'Générateur de Données Fictives';
?>

<div class="main-content">


    <!-- Main Content - Single Column for Better Flow -->
    <div style="max-width: 800px;">

        <!-- ÉTAPE 1: Instructions Claires -->
        <div class="chart-card" style="margin-bottom: var(--spacing-lg); border-left: 4px solid var(--primary-color);">
            <div class="chart-content" style="padding: var(--spacing-lg);">
                <h3 style="margin-top: 0; color: var(--primary-color); display: flex; align-items: center; gap: 8px;">
                    <span style="background-color: var(--primary-color); color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">1</span>
                    Qu'est-ce qui va être généré ?
                </h3>
                <p style="margin: 12px 0 0 0; color: var(--gray-700);">
                    Le système va créer automatiquement 227 enregistrements fictifs réalistes :
                </p>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 16px;">
                    <div style="padding: 10px; background-color: var(--gray-50); border-radius: 4px; text-align: center;">
                        <p style="margin: 0; font-size: 1.3rem; font-weight: bold; color: var(--primary-color);">15</p>
                        <p style="margin: 4px 0 0 0; font-size: 0.85rem; color: var(--gray-600);">Utilisateurs</p>
                    </div>
                    <div style="padding: 10px; background-color: var(--gray-50); border-radius: 4px; text-align: center;">
                        <p style="margin: 0; font-size: 1.3rem; font-weight: bold; color: #f5576c;">25</p>
                        <p style="margin: 4px 0 0 0; font-size: 0.85rem; color: var(--gray-600);">Employés</p>
                    </div>
                    <div style="padding: 10px; background-color: var(--gray-50); border-radius: 4px; text-align: center;">
                        <p style="margin: 0; font-size: 1.3rem; font-weight: bold; color: #00f2fe;">30</p>
                        <p style="margin: 4px 0 0 0; font-size: 0.85rem; color: var(--gray-600);">Contrats</p>
                    </div>
                    <div style="padding: 10px; background-color: var(--gray-50); border-radius: 4px; text-align: center;">
                        <p style="margin: 0; font-size: 1.3rem; font-weight: bold; color: #43e97b;">40</p>
                        <p style="margin: 4px 0 0 0; font-size: 0.85rem; color: var(--gray-600);">Absences</p>
                    </div>
                    <div style="padding: 10px; background-color: var(--gray-50); border-radius: 4px; text-align: center;">
                        <p style="margin: 0; font-size: 1.3rem; font-weight: bold; color: #f093fb;">50</p>
                        <p style="margin: 4px 0 0 0; font-size: 0.85rem; color: var(--gray-600);">Membres</p>
                    </div>
                    <div style="padding: 10px; background-color: var(--gray-50); border-radius: 4px; text-align: center;">
                        <p style="margin: 0; font-size: 1.3rem; font-weight: bold; color: #4facfe;">12</p>
                        <p style="margin: 4px 0 0 0; font-size: 0.85rem; color: var(--gray-600);">Projets</p>
                    </div>
                    <div style="padding: 10px; background-color: var(--gray-50); border-radius: 4px; text-align: center;">
                        <p style="margin: 0; font-size: 1.3rem; font-weight: bold; color: #FFD23F;">15</p>
                        <p style="margin: 4px 0 0 0; font-size: 0.85rem; color: var(--gray-600);">Événements</p>
                    </div>
                    <div style="padding: 10px; background-color: var(--gray-50); border-radius: 4px; text-align: center;">
                        <p style="margin: 0; font-size: 1.3rem; font-weight: bold; color: #FF6B9D;">60</p>
                        <p style="margin: 4px 0 0 0; font-size: 0.85rem; color: var(--gray-600);">Donations</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ÉTAPE 2: Avertissement -->
        <div class="chart-card" style="margin-bottom: var(--spacing-lg); border-left: 4px solid #FFD23F; background-color: rgba(255, 210, 63, 0.1);">
            <div class="chart-content" style="padding: var(--spacing-lg);">
                <h3 style="margin-top: 0; display: flex; align-items: center; gap: 8px;">
                    <span style="background-color: #FFD23F; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">2</span>
                    <span style="color: #FFD23F;">Important : Lisez ceci</span>
                </h3>
                <div style="margin-top: 12px; padding: 12px; background-color: white; border-radius: 4px;">
                    <ul style="margin: 0; padding-left: 20px; color: var(--gray-700);">
                        <li><strong>Développement uniquement</strong> - N'utilisez pas en production</li>
                        <li><strong>Données fictives</strong> - Tous les enregistrements sont générés automatiquement</li>
                        <li><strong>Non destructif</strong> - Ces données peuvent être supprimées à tout moment</li>
                        <li><strong>Durée</strong> - La génération prend 2-5 secondes</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- ÉTAPE 3: Action Principale -->
        <div class="chart-card" style="margin-bottom: var(--spacing-lg); border: 2px solid var(--primary-color); background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(102, 126, 234, 0.02) 100%);">
            <div class="chart-content" style="padding: var(--spacing-lg);">
                <h3 style="margin-top: 0; display: flex; align-items: center; gap: 8px;">
                    <span style="background-color: var(--primary-color); color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">3</span>
                    <span style="color: var(--primary-color);">Générer les données</span>
                </h3>

                <div id="seedingForm" style="margin-top: var(--spacing-lg);">

                    <!-- Configuration Options -->
                    <div style="margin-bottom: var(--spacing-lg); padding: 16px; background-color: var(--gray-50); border-radius: 6px;">
                        <h4 style="margin: 0 0 16px 0; color: var(--primary-color); display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-cog"></i> Personnaliser la génération
                        </h4>

                        <!-- Data Types Selection -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px;">
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 10px; background-color: white; border-radius: 4px; border: 1px solid var(--gray-200);">
                                <input type="checkbox" class="dataTypeCheckbox" value="users" checked style="width: 18px; height: 18px; cursor: pointer;">
                                <span style="font-weight: 500; color: var(--gray-700);">👤 Utilisateurs</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 10px; background-color: white; border-radius: 4px; border: 1px solid var(--gray-200);">
                                <input type="checkbox" class="dataTypeCheckbox" value="employees" checked style="width: 18px; height: 18px; cursor: pointer;">
                                <span style="font-weight: 500; color: var(--gray-700);">👥 Employés</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 10px; background-color: white; border-radius: 4px; border: 1px solid var(--gray-200);">
                                <input type="checkbox" class="dataTypeCheckbox" value="contracts" checked style="width: 18px; height: 18px; cursor: pointer;">
                                <span style="font-weight: 500; color: var(--gray-700);">📋 Contrats</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 10px; background-color: white; border-radius: 4px; border: 1px solid var(--gray-200);">
                                <input type="checkbox" class="dataTypeCheckbox" value="absences" checked style="width: 18px; height: 18px; cursor: pointer;">
                                <span style="font-weight: 500; color: var(--gray-700);">🚫 Absences</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 10px; background-color: white; border-radius: 4px; border: 1px solid var(--gray-200);">
                                <input type="checkbox" class="dataTypeCheckbox" value="members" checked style="width: 18px; height: 18px; cursor: pointer;">
                                <span style="font-weight: 500; color: var(--gray-700);">👫 Membres</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 10px; background-color: white; border-radius: 4px; border: 1px solid var(--gray-200);">
                                <input type="checkbox" class="dataTypeCheckbox" value="projects" checked style="width: 18px; height: 18px; cursor: pointer;">
                                <span style="font-weight: 500; color: var(--gray-700);">📊 Projets</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 10px; background-color: white; border-radius: 4px; border: 1px solid var(--gray-200);">
                                <input type="checkbox" class="dataTypeCheckbox" value="events" checked style="width: 18px; height: 18px; cursor: pointer;">
                                <span style="font-weight: 500; color: var(--gray-700);">🎉 Événements</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 10px; background-color: white; border-radius: 4px; border: 1px solid var(--gray-200);">
                                <input type="checkbox" class="dataTypeCheckbox" value="donations" checked style="width: 18px; height: 18px; cursor: pointer;">
                                <span style="font-weight: 500; color: var(--gray-700);">💰 Donations</span>
                            </label>
                        </div>

                        <!-- Quantities Configuration -->
                        <h5 style="margin: 0 0 12px 0; color: var(--gray-700);">Quantités :</h5>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            <div>
                                <label style="display: block; font-weight: 500; color: var(--gray-700); margin-bottom: 6px;">👤 Utilisateurs <small style="color: var(--gray-500); font-weight: normal;">(défaut: 15)</small></label>
                                <input type="number" id="userCount" value="15" min="1" max="100" style="width: 100%; padding: 8px; border: 1px solid var(--gray-300); border-radius: 4px; font-size: 0.9rem;">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 500; color: var(--gray-700); margin-bottom: 6px;">👥 Employés <small style="color: var(--gray-500); font-weight: normal;">(défaut: 25)</small></label>
                                <input type="number" id="employeeCount" value="25" min="1" max="100" style="width: 100%; padding: 8px; border: 1px solid var(--gray-300); border-radius: 4px; font-size: 0.9rem;">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 500; color: var(--gray-700); margin-bottom: 6px;">📋 Contrats <small style="color: var(--gray-500); font-weight: normal;">(défaut: 30)</small></label>
                                <input type="number" id="contractCount" value="30" min="1" max="100" style="width: 100%; padding: 8px; border: 1px solid var(--gray-300); border-radius: 4px; font-size: 0.9rem;">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 500; color: var(--gray-700); margin-bottom: 6px;">🚫 Absences <small style="color: var(--gray-500); font-weight: normal;">(défaut: 40)</small></label>
                                <input type="number" id="absenceCount" value="40" min="1" max="150" style="width: 100%; padding: 8px; border: 1px solid var(--gray-300); border-radius: 4px; font-size: 0.9rem;">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 500; color: var(--gray-700); margin-bottom: 6px;">👫 Membres <small style="color: var(--gray-500); font-weight: normal;">(défaut: 50)</small></label>
                                <input type="number" id="memberCount" value="50" min="1" max="200" style="width: 100%; padding: 8px; border: 1px solid var(--gray-300); border-radius: 4px; font-size: 0.9rem;">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 500; color: var(--gray-700); margin-bottom: 6px;">📊 Projets <small style="color: var(--gray-500); font-weight: normal;">(défaut: 12)</small></label>
                                <input type="number" id="projectCount" value="12" min="1" max="50" style="width: 100%; padding: 8px; border: 1px solid var(--gray-300); border-radius: 4px; font-size: 0.9rem;">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 500; color: var(--gray-700); margin-bottom: 6px;">🎉 Événements <small style="color: var(--gray-500); font-weight: normal;">(défaut: 15)</small></label>
                                <input type="number" id="eventCount" value="15" min="1" max="50" style="width: 100%; padding: 8px; border: 1px solid var(--gray-300); border-radius: 4px; font-size: 0.9rem;">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 500; color: var(--gray-700); margin-bottom: 6px;">💰 Donations <small style="color: var(--gray-500); font-weight: normal;">(défaut: 60)</small></label>
                                <input type="number" id="donationCount" value="60" min="1" max="200" style="width: 100%; padding: 8px; border: 1px solid var(--gray-300); border-radius: 4px; font-size: 0.9rem;">
                            </div>
                        </div>
                    </div>

                    <!-- Confirmation Checkbox -->
                    <label style="display: flex; align-items: flex-start; gap: 12px; cursor: pointer; padding: 14px; background-color: white; border-radius: 6px; margin-bottom: 16px; border: 1px solid var(--gray-200);">
                        <input type="checkbox" id="confirmClear" style="width: 20px; height: 20px; cursor: pointer; margin-top: 2px; flex-shrink: 0;">
                        <div>
                            <p style="margin: 0; font-weight: 600; color: var(--gray-700);">Je confirme la génération des données fictives</p>
                            <p style="margin: 4px 0 0 0; font-size: 0.85rem; color: var(--gray-600);">Cochez cette case pour activer le bouton de génération</p>
                        </div>
                    </label>

                    <!-- Main Action Button - LARGE AND PROMINENT -->
                    <button id="seedBtn" onclick="generateData()" disabled style="width: 100%; padding: 18px 24px; background-color: var(--primary-color); color: white; border: none; border-radius: 8px; font-weight: 700; font-size: 1.1rem; cursor: not-allowed; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px; opacity: 0.5; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <i class="fas fa-flask-vial" style="font-size: 1.3rem;"></i>
                        <span>🚀 GÉNÉRER LES DONNÉES FICTIVES</span>
                    </button>

                    <!-- Progress Output -->
                    <div id="outputContainer" style="display: none; margin-top: 20px;">
                        <h4 style="color: var(--primary-color); margin: 0 0 12px 0; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-spinner fa-spin"></i> Progression en cours...
                        </h4>
                        <div id="seedOutput" style="background-color: #1e1e1e; padding: 16px; border-radius: 6px; font-family: 'Courier New', monospace; font-size: 0.85rem; color: #00ff00; max-height: 400px; overflow-y: auto; white-space: pre-wrap; border-left: 4px solid var(--primary-color); line-height: 1.5;">
                            ⏳ Génération en cours...
                        </div>
                    </div>

                    <!-- Success Message -->
                    <div id="successMessage" style="display: none; margin-top: 16px; padding: 16px; background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); border-radius: 6px; border-left: 4px solid #43e97b;">
                        <p style="margin: 0; color: #155724; font-weight: 600; display: flex; align-items: center; gap: 10px; font-size: 1.05rem;">
                            <i class="fas fa-check-circle" style="font-size: 1.3rem;"></i>
                            ✅ Données fictives générées avec succès !
                        </p>
                        <p style="margin: 8px 0 0 0; color: #155724; font-size: 0.9rem;">Vous pouvez maintenant consulter les données dans les différentes pages de l'application.</p>
                    </div>

                    <!-- Error Message -->
                    <div id="errorMessage" style="display: none; margin-top: 16px; padding: 16px; background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); border-radius: 6px; border-left: 4px solid #FF6B9D;">
                        <p style="margin: 0; color: #721c24; font-weight: 600; display: flex; align-items: center; gap: 10px; font-size: 1.05rem;">
                            <i class="fas fa-exclamation-circle" style="font-size: 1.3rem;"></i>
                            ❌ Erreur : <span id="errorText">Une erreur est survenue</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ÉTAPE 4: Prochaines Étapes -->
        <div class="chart-card">
            <div class="chart-content" style="padding: var(--spacing-lg);">
                <h3 style="margin-top: 0; display: flex; align-items: center; gap: 8px;">
                    <span style="background-color: var(--primary-color); color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">4</span>
                    <span style="color: var(--primary-color);">Après la génération</span>
                </h3>
                <div style="margin-top: 12px; display: flex; flex-direction: column; gap: 10px;">
                    <div style="padding: 12px; background-color: var(--gray-50); border-radius: 4px; display: flex; align-items: flex-start; gap: 10px;">
                        <i class="fas fa-employees-team" style="color: var(--primary-color); margin-top: 2px;"></i>
                        <div>
                            <p style="margin: 0; font-weight: 600;">Consultez les Employés</p>
                            <p style="margin: 4px 0 0 0; font-size: 0.9rem; color: var(--gray-600);">Allez à Gestion RH → Employés pour voir les 25 employés générés</p>
                        </div>
                    </div>
                    <div style="padding: 12px; background-color: var(--gray-50); border-radius: 4px; display: flex; align-items: flex-start; gap: 10px;">
                        <i class="fas fa-file-contract" style="color: #00f2fe; margin-top: 2px;"></i>
                        <div>
                            <p style="margin: 0; font-weight: 600;">Consultez les Contrats</p>
                            <p style="margin: 4px 0 0 0; font-size: 0.9rem; color: var(--gray-600);">Allez à Gestion RH → Contrats pour voir les 30 contrats générés</p>
                        </div>
                    </div>
                    <div style="padding: 12px; background-color: var(--gray-50); border-radius: 4px; display: flex; align-items: flex-start; gap: 10px;">
                        <i class="fas fa-users" style="color: #f093fb; margin-top: 2px;"></i>
                        <div>
                            <p style="margin: 0; font-weight: 600;">Consultez les Membres</p>
                            <p style="margin: 4px 0 0 0; font-size: 0.9rem; color: var(--gray-600);">Allez à Gestion ASBL-ONG → Membres pour voir les 50 membres générés</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    #seedBtn {
        transition: all 0.3s ease;
    }

    #seedBtn:disabled {
        opacity: 0.5 !important;
        cursor: not-allowed !important;
        transform: none !important;
    }

    #seedBtn:not(:disabled) {
        opacity: 1;
        cursor: pointer;
    }

    #seedBtn:not(:disabled):hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(102, 126, 234, 0.5);
    }

    #seedBtn:not(:disabled):active {
        transform: translateY(-1px);
    }

    #seedOutput {
        line-height: 1.6;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .fa-spinner {
        animation: spin 1s linear infinite;
    }
</style>

<script>
    // Activer/désactiver le bouton selon la confirmation
    document.getElementById('confirmClear').addEventListener('change', function() {
        const btn = document.getElementById('seedBtn');
        if (this.checked) {
            btn.disabled = false;
            btn.style.opacity = '1';
            btn.style.cursor = 'pointer';
        } else {
            btn.disabled = true;
            btn.style.opacity = '0.5';
            btn.style.cursor = 'not-allowed';
        }
    });

    // Fonction pour générer les données
    async function generateData() {
        const btn = document.getElementById('seedBtn');
        const outputContainer = document.getElementById('outputContainer');
        const seedOutput = document.getElementById('seedOutput');
        const successMessage = document.getElementById('successMessage');
        const errorMessage = document.getElementById('errorMessage');
        const errorText = document.getElementById('errorText');

        // Réinitialiser les messages
        successMessage.style.display = 'none';
        errorMessage.style.display = 'none';
        outputContainer.style.display = 'block';
        seedOutput.textContent = '⏳ Génération en cours... Veuillez patienter...\n\n';

        // Scroll vers la sortie
        setTimeout(() => outputContainer.scrollIntoView({
            behavior: 'smooth'
        }), 100);

        // Désactiver le bouton pendant le traitement
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Génération en cours... Veuillez patienter...</span>';

        try {
            // Récupérer les types de données sélectionnés
            const selectedTypes = Array.from(document.querySelectorAll('.dataTypeCheckbox:checked')).map(el => el.value);

            if (selectedTypes.length === 0) {
                errorText.textContent = 'Veuillez sélectionner au moins un type de données';
                errorMessage.style.display = 'block';
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-flask-vial"></i> <span>🚀 GÉNÉRER LES DONNÉES FICTIVES</span>';
                return;
            }

            // Récupérer les quantités
            const quantities = {
                users: parseInt(document.getElementById('userCount').value) || 15,
                employees: parseInt(document.getElementById('employeeCount').value) || 25,
                contracts: parseInt(document.getElementById('contractCount').value) || 30,
                absences: parseInt(document.getElementById('absenceCount').value) || 40,
                members: parseInt(document.getElementById('memberCount').value) || 50,
                projects: parseInt(document.getElementById('projectCount').value) || 12,
                events: parseInt(document.getElementById('eventCount').value) || 15,
                donations: parseInt(document.getElementById('donationCount').value) || 60
            };

            const response = await fetch('/seed/generate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    confirm: 'yes',
                    types: selectedTypes,
                    quantities: quantities
                })
            });

            // Vérifier si la réponse est du JSON valide
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('Le serveur n\'a pas retourné de JSON. Code: ' + response.status);
            }

            const data = await response.json();

            if (data.success) {
                seedOutput.textContent = (data.output || '✅ Données fictives générées avec succès !\n') + '\n✅ Vous pouvez maintenant consulter les données dans l\'application.';
                successMessage.style.display = 'block';
                btn.innerHTML = '<i class="fas fa-check-circle"></i> <span>✅ Génération Réussie</span>';
                btn.style.backgroundColor = '#43e97b';
                btn.disabled = false;
            } else {
                errorText.textContent = data.message || 'Une erreur est survenue';
                errorMessage.style.display = 'block';
                seedOutput.textContent = '❌ Erreur : ' + (data.message || 'Erreur inconnue');
                btn.innerHTML = '<i class="fas fa-flask-vial"></i> <span>🚀 GÉNÉRER LES DONNÉES FICTIVES</span>';
                btn.style.backgroundColor = '';
                btn.disabled = false;
            }
        } catch (error) {
            console.error('Erreur complète:', error);
            errorText.textContent = error.message;
            errorMessage.style.display = 'block';

            let errorMsg = '❌ Erreur : ' + error.message;
            if (error.message.includes('Code: 401')) {
                errorMsg += '\n\n💡 Vous devez être connecté et avoir les permissions administrateur.';
            } else if (error.message.includes('Code: 403')) {
                errorMsg += '\n\n💡 Vous n\'avez pas les permissions pour générer les données. Seul un administrateur peut le faire.';
            }
            seedOutput.textContent = errorMsg;
            btn.innerHTML = '<i class="fas fa-flask-vial"></i> <span>🚀 GÉNÉRER LES DONNÉES FICTIVES</span>';
            btn.style.backgroundColor = '';
            btn.disabled = false;
        }
    }
</script>