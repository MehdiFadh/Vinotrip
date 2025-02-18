<link rel="stylesheet" href="<?php echo e(asset('css/nous_contacter.css')); ?>">
<?php $__env->startSection('content'); ?>

<?php if(session('success')): ?>
        <div class="alert-alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

        <div class="contact-form-container">
        <h1>Nous Contacter</h1>
        <form action="<?php echo e(route('contact.formulaire')); ?>" method="post" class="contact-form">
        <?php echo csrf_field(); ?>
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" required>
            
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" required>
            
            <label for="message">Message :</label>
            <textarea name="message" id="message" required></textarea>
            
            <button type="submit">Envoyer</button>
                </form>
            </div>


            <!-- <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
            <df-messenger intent="WELCOME" chat-title="Vinotrip" agent-id="7b4ad48a-de71-45d7-b54f-bb72f83c4104" language-code="fr"></df-messenger> -->
<?php $__env->stopSection(); ?>
    

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/s223/vinotrip/resources/views/nous_contacter.blade.php ENDPATH**/ ?>