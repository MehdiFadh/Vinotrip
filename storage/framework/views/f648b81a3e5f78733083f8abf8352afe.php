<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>


    <h4>Ceci est un mail automatique pour vous récapituler votre séjour.</h4>
    <p>Votre numéro de commande est le : <?php echo e($numcommande); ?></p>
    <p>Le sejour à été commander au nom de <?php echo e($nomclient); ?></p>


    <p>Vous allez être héberger à l'hotel : <?php echo e($hotel); ?></p>

    <p>Votre destination sera : <?php echo e($destination); ?></p>

</body>
</html><?php /**PATH /home/s223/vinotrip/resources/views/emails/carnetRoute.blade.php ENDPATH**/ ?>