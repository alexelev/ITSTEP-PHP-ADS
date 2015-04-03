<header style="margin-bottom:20px;">
<?php if ($this->user) { ?>

	<div style="float: right"> Вы вошли как  <a href="<?=Application::getLink('User')?>"><?=$this->user->login?></a></div>
	<nav>
		<ul>
			<li>
				<a href="<?=Application::getLink('Ads', array('action' => 'new'))  ?>">Создать объявление</a>
			</li>
			<li>
				<a href="<?=Application::getLink('User', array('action' => 'ads'))  ?>">Мои обьявления</a>
			</li>
			<li>
				<a href="<?=Application::getLink('Favourites') ?>">Избранные объявления</a>
			</li>
			<li>
				<a href="<?=Application::getLink('User', array('action' => 'logout')) ?>">Выход</a>
			</li>
		</ul>
	</nav>
	<div style="clear: both"></div>

<? } else { ?>

	<nav>
		<ul>
			<li>
				<a href="<?=Application::getLink('Favourites') ?>">Избранные объявления</a>
			</li>
		</ul>
	</nav>

	<form method="POST" action="<?= Application::getLink('User', array('action' => 'login')) ?>" style="float: right; width: 300px">
		<input type="hidden" name="back" value="<?= $this->back ?>">
		Логин: <br>
		<input type="text" name="login"> <br>
		Пароль: <br>
		<input type="password" name="password"> <br>
		<a href="<?=Application::getLink('User', array('action' => 'register'))?>">Регистрация</a>
		<input type="submit" value="Войти">
	</form>
	<div style="clear:both"></div>
<? } ?>
</header>
