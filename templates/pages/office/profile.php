<script>
	$(function(){
		$('a.name').click(function(event){
			event.preventDefault();

			$('span.name').hide();
			$('input.name').show();
			$(this).hide();
			$('input.name').focus();
		});
		$('a.email').click(function(event){
			event.preventDefault();

			$('span.email').hide();
			$('input.email').show();
			$(this).hide();
			$('input.email').focus();
		});

		$('input.name').blur(function(){
			$('span.loader-name').show();
			$.ajax({
				url: '/index.php?controller=office&action=saveName',
				type: 'post',
				data: {
					value: $(this).val(),
				},
				dataType: 'json',
				success: function(response){
					$('span.loader-name').hide();
					$('input.name').hide();
					$('span.name').show();
					$('a.name').show();
					if(response.error){						
						var curName = $('span.name').text();
						$('input.name').val(curName);
						alert(response.message);
					} else {
						var curName = $('input.name').val();
						$('span.name').text(curName);
					}
				}
			});
		});

		$('input.email').blur(function(){
			$('span.loader-email').show();
			$.ajax({
				url: '/index.php?controller=office&action=saveEmail',
				type: 'post',
				data: {
					value: $(this).val(),
				},
				dataType: 'json',
				success: function(response){
					$('span.loader-email').hide();
					$('input.email').hide();
					$('span.email').show();
					$('a.email').show();
					if(response.error){						
						var curEmail = $('span.email').text();
						$('input.email').val(curEmail);
						alert(response.message);
					} else {
						var curEmail = $('input.email').val();
						$('span.email').text(curEmail);
					}
				}
			});
		});

		$('input.name').keyup(function(event){
			if (event.keyCode == 13) {
				$('input.name').blur();
			};			
		});

		$('input.email').keyup(function(event){
			if (event.keyCode == 13) {
				$('input.email').blur();
			};			
		});

		$('td.phone span').click(function(){
			$(this).hide();
			$(this).next().show();			
		});

		$('td.phone input').keyup(function(event){
			if (event.keyCode == 13) {
				$(this).blur();
			};
		});

		$('td.phone input').blur(function(){
			$('span.loader-phone').show();
			var $input = $(this);
			$.ajax({
				url: '/index.php?controller=office&action=savePhone',
				type: 'post',
				data: {
					id: $(this).data('phone-id'),
					value: $(this).val(),
				},
				dataType: 'json',
				success: function(response){
					$('span.loader-phone').hide();
					$input.hide();
					$input.prev().show();
					
					if(response.error){						
						var curPhone = $input.prev().text();
						$input.val(curPhone);
						alert(response.message);
					} else {
						var curPhone = $input.val();
						$input.prev().text(curPhone);
					}
				}
			});
		});
	});
</script>

<br>
<div>
	<!-- <form action="<?= Application::getLink('Office', array('action' => 'saveProfile')) ?>" method="POST">
		Name: <input type="text" name="name" style="color:green; font-weight:bold; background:white;" value="<?= $this->user->name ?>">
		<a href="#" style="display:none;">Save</a> <br>
		Email: <input type="text" name="email" style="color:red; font-weight:bold; background:white;" value="<?= $this->user->email ?>">
		<!-- <a href="#" style="display:none;">Save</a> --> <br>
		<!-- <input type="submit" value="Save"> -->
	<!-- </form> --> 
	Name: <span class="name"><?=$this->user->name?></span>
	<input type="text" class="name" value="<?=$this->user->name?>" style="display: none;"> <a href="#" class="name">edit</a> <br>
	<span class="loader-name" style="display:none;">updating name</span> <br>
	Email: <span class="email"><?=$this->user->email?></span>
	<input type="text" class="email" value="<?=$this->user->email?>" style="display: none;"> <a href="#" class="email">edit</a> <br><br>
	<span class="loader-email" style="display:none;">updating email</span> <br>
	Telephones: <span class="loader-phone" style="display: none;">sending</span> <br>
	<table>
		<? foreach ($this->user->phones as $phone) { ?>
			<tr>
				<td class="phone" style="color:magenta"> 
					<span><?= $phone->phone ?></span>
					<input data-phone-id="<?= $phone->getId() ?>" type="text" value="<?=$phone->phone?>" style="display: none;">
				</td>
				<td class="phone"><a href="#">Higher</a></td>
				<td class="phone"><a href="#">Lower</a></td>
				<td class="phone"><a href="#">Delete</a></td>
			</tr>
		<? } ?>
	</table>
</div>