<?php $head = '<link rel="stylesheet" href="public/css/auth.css">'; ?>

<?php ob_start() ?>
<div class="center-container">
    <?php echo (!empty(SESSION_USER)) ? '<p>You are currently logged in by <strong>'.SESSION_USER.'</strong></p>' : '' ?>
    <form method="post" class="auth-form">
        <?php echo !empty($message) ? '<p>'.$message.'</p>' : '' ?>
        <input type="text" name="login" id="login" placeholder="Login">
        <input type="password" name="password" id="password" placeholder="Password">
        <?php echo !empty($error_message) ? '<p>'.$error_message.'</p>' : '' ?>    
        <input type="submit" value="Login\Register">
    </form>
</div>
<?php $body = ob_get_clean() ?>

<?php include LAYOUT_PATH; ?>