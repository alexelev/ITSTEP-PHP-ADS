<? //echo '<pre>'; var_dump($this->list); echo '</pre>';
	function getDesc($desc)
	{
		$desc = wordwrap($desc, 30, '_');
		// echo($desc).'<br>';
		$pos = strpos($desc, '_');
		// echo($pos).'<br>';
		if ($pos) {
			$desc = substr($desc, 0, $pos).'...';
		}
		// echo($desc).'<br>';
		return $desc;
		// return substr(wordwrap($desc, 300, '_'), 0, strpos(wordwrap($desc, 300, '_'), '_'));
	}

	foreach ($this->list as $ad) { ?>
	<div>
		<h3>
			<a href="<?= Application::getLink('Ads', array('id' => $ad['id'])) ?>">
				<?= $ad['title'] ?>
			</a>
		</h3>
		<br>
		<?= getDesc(str_replace("\r\n", ' ', strip_tags($ad['desc']))) ?>
		<br>
		<a href="<?= Application::getLink('Ads', array('id' => $ad['id'])) ?>">Подробнее</a> <br>
	</div>
<? } ?>