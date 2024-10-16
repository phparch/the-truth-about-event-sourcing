<form action="<?php echo e(route('contact.verb.store', $contact->id)); ?>" method="post">
    <?php echo csrf_field(); ?>
    First: <input type="text" name="first_name" value="<?php echo e($contact->getFirstName()); ?>"><br/>
    Last: <input type="text" name="last_name" value="<?php echo e($contact->getLastName()); ?>"><br/>
    Owner: <input type="text" name="owner_id" value="<?php echo e($contact->hasOwnerId() ? $contact->getOwnerId() : ''); ?>"><br/>
    Folder: <input type="text" name="folder" value="<?php echo e($contact->getFolder()); ?>"><br/>
    Add email address: <input type="text" name="email" value=""><br/>
    <button type="submit">Submit</button>
</form>
<br/>
Emails:<br/>
<?php $__currentLoopData = $contact->emails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $email): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php echo e($email); ?><form method="post" action="<?php echo e(route('contact.remove_email', $contact->id)); ?>"><input type="hidden" name="email" value="<?php echo e($email); ?>"><?php echo csrf_field(); ?><input type="submit" value="Remove"></form>
    <br/>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<br/>
<br/>

<h2>Events</h2>
<?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php #dump($event); ?><br/>
    <?php $class = preg_replace('#.*Events.#', "", get_class($event)); ?>
    <?php echo e($event->type); ?>

    <p style="padding-left:20px;">
        Who: <?php echo e($event->metadata['user']['name']); ?><br/>
        When: <?php echo e($event->metadata['when']); ?><br/>
        What: <?php echo e($event->metadata['when']); ?><br/>
        Where: <?php echo e($event->metadata['server']['IP'] ?? $event->metadata['server']['REMOTE_ADDR'] ?? ''); ?><br/>
        Why: <?php echo e($event->metadata['server']['METHOD'] ?? ''); ?> <?php echo e($event->metadata['server']['PATH'] ?? $event->metadata['server']['PATH_INFO'] ?? ''); ?><br/>
    </p>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /Users/jcongdon/repos/PHPArch/presentation/the-truth-about-event-sourcing/verbs/resources/views/verbs_contact.blade.php ENDPATH**/ ?>