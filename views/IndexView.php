<?php $head = '<link rel="stylesheet" href="public/css/index.css">'; ?>

<?php ob_start() ?>
<div class="center-container">
    <h3 class="task-header">Task list</h3>
    <div class="login-info">
        <p>You are logged in by <strong><?= $session_user ?></strong></p>
        <p>May you want 
            <a href="auth">login/register?</a>
        </p>
    </div>
    <div class="form-container">
        <form method="POST" action="new_task.php" class="form">
            <input name="description" type="text" placeholder="Enter text...">
            <input type="submit" name="" value="add task">
        </form>

        <form method="POST" action="all_tasks_action.php" class="form">
            <input type="submit" name="action" value="remove all">
            <input type="submit" name="action" value="ready all">
        </form>
    </div>

    <div class="tasks-list">
        <?php foreach($db_tasks as $task): ?>
        <div class="task">
            <div class="task__main">
                <form method="POST" action="one_task_action.php">
                    <p class="task-description">
                    <?= $task['description']; ?>
                    </p>
                    <input type="hidden" name="task_id" value="<?= $task['id']; ?>">
                    <input type="submit" name="task_action" value="<?= $task['status']==='ready' ? 'unready': 'ready'; ?>">
                    <input type="submit" name="task_action" value="delete">
                </form>
            </div>
            <div class="task__status 
            <?= ($task['status'] == 'ready') ? ' task__status_ready' : ' task__status_not-ready' ?>
            ">
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php $body = ob_get_clean() ?>

<?php include LAYOUT_PATH; ?>