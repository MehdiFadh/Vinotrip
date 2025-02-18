<?php $__env->startSection('content'); ?>
<div class="container-commande-historique">
    <h1 class="titre-commande-historique text-center mb-4">HISTORIQUE DE VOS COMMANDES</h1>
    <p class="description-commande-historique text-center">
        Vous trouverez ici vos commandes passées depuis la création de votre compte.
    </p>

    <table class="tableau-commande-historique table table-bordered text-center">
        <thead class="en-tete-tableau-commande">
            <tr>
                <th>RÉFÉRENCE DE COMMANDE</th>
                <th>DATE</th>
                <th>PRIX TOTAL</th>
                <th>PAIEMENT</th>
                <th>ÉTAT</th>
                <th>FACTURE</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $commandes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commande): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <a href="<?php echo e(route('commandes.details', $commande->numcommande)); ?>" class="lien-details-commande">
                            <?php echo e($commande->numcommande); ?>

                        </a>
                    </td>
                    <td><?php echo e(\Carbon\Carbon::parse($commande->date_commande)->format('d/m/Y')); ?></td>
                    <td><?php echo e($commande->montant_total); ?> €</td>
                    <td>Stripe</td>
                    <td>
                        <?php if(is_null($commande->etat_commande)): ?>
                            <form action="<?php echo e(route('checkout.session')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <!-- Champ caché pour transmettre le numéro de commande -->
                                <input type="hidden" name="numcommande" value="<?php echo e($commande->numcommande); ?>">
                                <button type="submit">Procéder au paiement</button>
                            </form>
                        <?php elseif($commande->etat_commande): ?>
                            <span class="badge badge-commande-acceptee">Paiement accepté</span>
                        <?php else: ?>
                            <span class="badge badge-commande-en-attente">Commande annulée</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($commande->etat_commande && $commande->num_facture): ?>  <!-- Vérifier si le paiement est effectué -->
                            <a href="<?php echo e(route('facture', $commande->numcommande)); ?>" class="bouton-facture-pdf" target="_blank">
                            <button id="generate-pdf">Générer Facture PDF</button>

                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

                            <script>
                                document.getElementById("generate-pdf").addEventListener("click", function () {

                                    // Récupérer les données de la commande (passées depuis Laravel Blade)
                                    var commande = {
                                        numcommande: "<?php echo e($commande->numcommande); ?>",
                                        date_facturation: "<?php echo e($commande->date_facturation); ?>",
                                        montant_total: "<?php echo e(number_format($commande->montant_total, 2, ',', ' ')); ?>", // Format du montant
                                        description_facture: "<?php echo e($commande->description_facture); ?>",
                                    };

                                    // Utiliser jsPDF pour créer un PDF
                                    const { jsPDF } = window.jspdf;
                                    const doc = new jsPDF();

                                    // Titre du document
                                    doc.setFontSize(18);
                                    doc.setFont("helvetica", "bold");
                                    doc.text("Facture N°" + commande.numcommande, 10, 20);

                                    let yOffset = 30; // Mise à jour de la position pour les informations suivantes

                                    // Informations sur la commande
                                    doc.setFontSize(12);
                                    doc.setFont("helvetica", "normal");

                                    // Date de facturation
                                    doc.text("Date de Facturation : " + commande.date_facturation, 10, yOffset);
                                    yOffset += 10;  // Espacement vertical

                                    // Description de la facture
                                    doc.text("Description : " + commande.description_facture, 10, yOffset);
                                    yOffset += 10;  // Espacement vertical

                                    // Ajouter une ligne de séparation
                                    doc.setLineWidth(0.5);
                                    doc.line(10, yOffset, 200, yOffset);
                                    yOffset += 10;

                                    // Montant Total (au lieu de "Montant à Payer")
                                    doc.setFontSize(14);
                                    doc.setFont("helvetica", "bold");
                                    doc.text("Montant Total : " + commande.montant_total + " €", 10, yOffset);

                                    // Ajouter le pied de page
                                    yOffset += 15; // Espacement
                                    doc.setFontSize(8);
                                    doc.text("Page 1", 180, yOffset);  // Page 1

                                    // Ouvrir le PDF dans un nouvel onglet
                                    window.open(doc.output('bloburl'), '_blank');
                                });
                            </script>
                            </a>
                        <?php else: ?>
                            <div class="container mt-5">
                                <span class="texte-commande-sans-facture">Pas de facture</span>
                                <div class="tooltip-container">
                                    <i class="informations-supplémentaires">ℹ</i>
                                    <div class="tooltip">
                                        La facture n'est pas disponible. Merci de procéder au paiement pour pouvoir la consulter.
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6">Aucune commande trouvée.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
    <df-messenger intent="WELCOME" chat-title="Vinotrip" agent-id="7b4ad48a-de71-45d7-b54f-bb72f83c4104" language-code="fr"></df-messenger> -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/s223/vinotrip/resources/views/commandes/historique.blade.php ENDPATH**/ ?>