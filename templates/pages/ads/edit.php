<?php
	

?>

<script>
	tinymce.init({selector: 'textarea'});
	$(function(){
		$('#add_phone').click(function(e){
			e.preventDefault();
			var $input = $('<input type="text" name="phone[]" class="phone">');
			var $lastInput = $('.phone:last');
			$lastInput.after($input);
			$lastInput.after($('<br />'));
		});

		// $('select[name=email').editableSelect();

		$('#update-capcha').click(function(e){
			e.preventDefault();
			$('img').attr('src', '/assets/img/capcha.php');
		})
	})	
</script>

<? $formAction = $this->id
	? 
	Application::getLink('Ads', array('action' => 'edit', 'id' => $this->id))
	: 
	Application::getLink('Ads', array('action' => 'new'))
?>

<form method="POST" action="<?= $formAction ?>">

	<select name="category" id="">

		<option value="">Выберите категорию</option>
		
		<? foreach ($this->categories as $category) { ?>
			<option value="<?= $category['id'] ?>" <?= ($category['id'] == $this->id_category) ? 'selected' : '' ?>><?= $category['title'] ?></option>
		<? } ?>

	</select>
	<br>
	<? 
	// echo '<pre>'; var_dump($this->errors); echo '</pre>';
	if (isset($this->errors['title'])) { ?>
		<div style="color: red; font-weight: bold"><?= $this->errors['title'] ?></div>
	<? } ?>

	<? if (isset($this->errors['desc'])) { ?>
		<div style="color: red; font-weight: bold"><?= $this->errors['desc'] ?></div>
	<? } ?>

	Заголовок: <br>
	<input type="text" name="title" value="<?= $this->title?>"> <br>
	Текст объявления: <br>
	<textarea name="desc" id="" cols="50" rows="7"><?= $this->desc ?></textarea> <br>
	
	<? if (isset($this->errors['email'])) { ?>
		<div style="color: red; font-weight: bold"><?= $this->errors['email'] ?></div>
	<? } ?>
	
	Email: <br>
	<? //echo '<pre>'; var_dump($this->emails); echo '</pre>';
	$emails = $this->emails;
	if (!empty($emails)) { ?>
		<select name="email" id="">
			<?foreach ($this->emails as $email) {?>
				<option><?= $email->contact ?></option>	
			<? } ?>
		</select> <br>
	<? } else { ?>
		<input type="text" name="email" value=""> <br>
	<? } ?>
	<br>
	<? if (!$validate) { ?>
	<form action="" method="post">
		<img src="/assets/img/capcha.php"> <br>
		<a id="update-capcha" href="#">update capcha</a> <br>
		<input type="text" name="capcha"> <br>
		<input type="submit" value="send">
	</form>
	<?}?>

	<? if (isset($this->errors['phone'])) { ?>
		<div style="color: red; font-weight: bold"><?= $this->errors['phone'] ?></div>
	<? } ?>

	Тел. номер: <br>
	<input type="text" name="phone[]" value="" class="phone"> <a href="" id="add_phone">Добавить номер</a><br>
	<input type="submit" value="Отправить">
</form>