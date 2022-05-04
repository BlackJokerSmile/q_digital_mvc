<?php $head = '<link rel="stylesheet" href="public/css/auth.css">'; ?>

<?php ob_start() ?>
<div class="center-container">
    <?php echo (!empty($session_user)) ? '<p>You are currently logged in by <strong>'.$session_user.'</strong></p>' : '' ?>
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