<?php $__env->startSection('content'); ?>

<style>
    .container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

h1, h2 {
    color: #333;
}

hr {
    border: 1px solid #ddd;
}

.form-check-label strong {
    color: #007bff;
}

.form-choix-adresse .form-check {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-bottom: 10px;
    background-color: #fff;
}

.form-choix-adresse .form-check:hover {
    background-color: #f1f1f1;
}

.btn {
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 16px;
    font-weight: bold;
}

.btn-primary {
    background-color: #007bff;
    border: none;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-success {
    background-color: #28a745;
    border: none;
}

.btn-success:hover {
    background-color: #218838;
}

.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    color: #dc3545;
    font-size: 0.875em;
}

.form-group {
    margin-bottom: 20px;
}

label {
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
}

input.form-control {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

input.form-control:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 3px rgba(0, 123, 255, 0.25);
}

</style>
<div class="container">
    <h1 class="text-center mb-4">Choisissez une adresse</h1>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <h2 class="mb-3">Adresses existantes</h2>
    <?php if($adresses->isEmpty()): ?>
        <p class="text-muted">Aucune adresse enregistrée.</p>
    <?php else: ?>
        <form action="<?php echo e(route('enregistrement.commande')); ?>" method="POST" class="form-choix-adresse">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <?php $__currentLoopData = $adresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adresse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="form-check mb-2">
                        <input 
                            type="radio" 
                            name="adresse_id" 
                            value="<?php echo e($adresse->code_adresse_client); ?>" 
                            class="form-check-input" 
                            required
                        >
                        <label class="form-check-label">
                            <strong><?php echo e($adresse->nom_adresse_client); ?></strong><br>
                            <?php echo e($adresse->rue_client); ?>, <?php echo e($adresse->ville_client); ?> (<?php echo e($adresse->pays_client); ?>)
                        </label>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <button type="submit" class="btn btn-primary">Utiliser cette adresse</button>
        </form>
    <?php endif; ?>

    <hr class="my-5">

    <h2 class="mb-3">Ajouter une nouvelle adresse</h2>
    <form action="<?php echo e(route('commande.adresse')); ?>" method="POST" class="form-ajout-adresse">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label for="nom_adresse_client">Nom de l'adresse</label>
            <input 
                type="text" 
                id="nom_adresse_client" 
                name="nom_adresse_client" 
                class="form-control <?php $__errorArgs = ['nom_adresse_client'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                value="<?php echo e(old('nom_adresse_client')); ?>" 
                required
            >
            <?php $__errorArgs = ['nom_adresse_client'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="form-group">
            <label for="ligne1">Rue</label>
            <input 
                type="text" 
                id="ligne1" 
                name="ligne1" 
                class="form-control <?php $__errorArgs = ['ligne1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                value="<?php echo e(old('ligne1')); ?>" 
                required
            >
            <?php $__errorArgs = ['ligne1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="form-group">
            <label for="ville">Ville</label>
            <input 
                type="text" 
                id="ville" 
                name="ville" 
                class="form-control <?php $__errorArgs = ['ville'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                value="<?php echo e(old('ville')); ?>" 
                required
            >
            <?php $__errorArgs = ['ville'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="form-group">
            <label for="code_postal">Code postal</label>
            <input 
                type="text" 
                id="code_postal" 
                name="code_postal" 
                class="form-control <?php $__errorArgs = ['code_postal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                value="<?php echo e(old('code_postal')); ?>" 
                required
            >
            <?php $__errorArgs = ['code_postal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="form-group">
            <label for="pays">Pays</label>
            <input 
                type="text" 
                id="pays" 
                name="pays" 
                class="form-control <?php $__errorArgs = ['pays'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                value="<?php echo e(old('pays')); ?>" 
                required
            >
            <?php $__errorArgs = ['pays'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <button type="submit" class="btn btn-success">Ajouter l'adresse</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/s223/vinotrip/resources/views/commandes/choisir-adresse.blade.php ENDPATH**/ ?>