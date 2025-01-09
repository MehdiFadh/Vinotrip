<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Confimation du séjour pour la commande <?php echo e($numcommande); ?></h2>

    <p>Ceci est un message automatique pour vous informer que le sejour à bien été valider.
        Date : <?php echo e($dateDebut); ?>

        La commande est au nom de <?php echo e($nomclient); ?>

    </p>
</body>
</html><?php /**PATH /home/s223/vinotrip/resources/views/emails/validationPartenaire.blade.php ENDPATH**/ ?>