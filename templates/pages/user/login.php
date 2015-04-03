<?php
	// echo "<pre>"; var_dump($_SERVER); echo "</pre>";
 foreach ($this->errors as $error) { ?>
    <div style="color: red; font-weight: bold;"><?= $error ?></div>
<?php } ?>

<form action="<?= Application::getLink('User', array('action' => 'login')) ?>" method="post">
    <input type="hidden" name="back" value="<?= $this->back ?>">
    Логин: <input type="text" name="login" value="<?= $this->login ?>" /> <br/><br/>
    Пароль: <input type="password" name="password" value="" /> <br/><br/>
    <input type="submit" value="Войти" />
</form>