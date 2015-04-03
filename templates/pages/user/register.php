<!-- <a href="<?= Application::getLink('User', array('action' => 'login'))?>">login</a> -->
<?php
	// echo "<pre>"; var_dump($_SERVER); echo "</pre>";
	 foreach ($this->errors as $error) { ?>
	    <div style="color: red; font-weight: bold;"><?= $error ?></div>
<?php } ?>

<form method="POST" action="<?= Application::getLink('User', array('action' => 'register')) ?>" style="width: 200px; margin: 0 auto">	
	Логин: <br>
	<input type="text" name="login"> <br>
	Email: <br>
	<input type="text" name="email"> <br>
	Пароль: <br>
	<input type="password" name="pass"> <br>
	Подтвердите пароль: <br>
	<input type="password" name="confirm"> <br>
	<input type="submit" value="REGISTEr" style="width: 100%; margin-top: 15px">
</form>