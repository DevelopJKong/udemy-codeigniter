<?=$this->extend("layouts/default")?>

<?=$this->section("title")?>Home<?=$this->endSection()?>

<?=$this->section("content")?>

    <h1>Welcome</h1>


    <?php if (current_user()): ?>
        <p>Hello! <?= current_user()->name?></p>
        <a href="<?=site_url("/tasks")?>">See Tasks</a>
        <a href="<?=site_url("/logout")?>">Logout</a>
        <p>User is logged in</p>
    <?php else: ?>
        <a href="<?=site_url("/signup")?>">Sign up</a>
        <a href="<?=site_url("/login")?>">Login</a>
        <p>User is not logged in</p>
    <?php endif;?>


<?=$this->endSection()?>