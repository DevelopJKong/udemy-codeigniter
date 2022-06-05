
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?=$this->renderSection("title")?></title>
</head>
<body>

    <a href="<?=site_url("/")?>">Home</a>

    <?php if (current_user()): ?>
        <p>Hello! <?=current_user()->name?></p>
        <a href="<?=site_url("/tasks")?>">See Tasks</a>
        <a href="<?=site_url("/logout")?>">Logout</a>
    <?php else: ?>
        <a href="<?=site_url("/signup")?>">Sign up</a>
        <a href="<?=site_url("/login")?>">Login</a>
    <?php endif;?>


    <?php if (session()->has('warning')): ?>
        <div class="warning">
            <?=session('warning')?>
        </div>
    <?php endif;?>
    <?php if (session()->has('info')): ?>
        <div class="info">
            <?=session('info')?>
        </div>
    <?php endif;?>
    <?php if (session()->has('error')): ?>
        <div class="error">
            <?=session('error')?>
        </div>
    <?php endif;?>

    <?=$this->renderSection("content")?>

</body>
</html>