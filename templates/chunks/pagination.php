<?
	$this->pages_count = ($this->count / $this->limit);

	if ($this->pages_count > 1) {
?>

<div>
	<ul>
		<li>
			<a href="<?= Application::getLink($this->controller, array('page' => ($this->page == 1) ? $this->page : $this->page - 1, 'action' => $this->action)) ?>">
				&lt;&lt;&nbsp;
			</a>
		</li>

		<? if ($this->page > 2) { ?>
			<li>
				<a href="<?= Application::getLink($this->controller, array('page' => $this->page - 2, 'action' => $this->action)) ?>">
					&nbsp;<?= $this->page - 2 ?>&nbsp;
				</a>
			</li>
		<? } ?>
		
		<? if ($this->page > 1) { ?>
			<li>
				<a href="<?= Application::getLink($this->controller, array('page' => $this->page - 1, 'action' => $this->action)) ?>">
					&nbsp;<?= $this->page - 1 ?>&nbsp;
				</a>
			</li>
		<? } ?>

		<li>
			<span style="color: red"><?= $this->page ?>&nbsp;</span>
		</li>

		<? if ($this->page < $this->pages_count) { ?>
			<li>
				<a href="<?= Application::getLink($this->controller, array('page' => $this->page + 1, 'action' => $this->action)) ?>">
					&nbsp;<?= $this->page + 1 ?>&nbsp;
				</a>
			</li>
		<? } ?>

		<? if ($this->page < $this->pages_count - 1) { ?>
			<li>
				<a href="<?= Application::getLink($this->controller, array('page' => $this->page + 2, 'action' => $this->action)) ?>">
					&nbsp;<?= $this->page + 2 ?>&nbsp;
				</a>
			</li>
		<? } ?>

		<? if ($this->page == $this->pages_count) { ?>
			<li>
				<a href="<?= Application::getLink($this->controller, array('page' => $this->page, 'action' => $this->action )) ?>">
					&nbsp;&gt;&gt;&nbsp;
				</a>
			</li>
		<? } else {?>
			<li>
				<a href="<?= Application::getLink($this->controller, array('page' => $this->page + 1, 'action' => $this->action)) ?>">
					&nbsp;&gt;&gt;&nbsp;
				</a>
			</li>
		<? } ?>
	</ul>
</div>

<? } ?>