<h3><?= $this->ad->title ?></h3>
<?= $this->ad->desc ?>
<p>Разместил: <?= $this->ad->user->login ?></p>
<a href="<?= Application::getLink('Favourites', array('action' => 'add', 'id' => $this->ad->getId())) ?>">Добавить в избранное</a>