$(document).ready(() => {
	function changeButton(msg, status = true) {
		$('#reg_button').prop('disabled', status);
		$('#reg_button').text(msg);
	}
	
	changeButton('Введите логин и пароль.');

	//проверяем имя нового пользователя в б.д.
	$('#new_login').keyup(() => {
		if ($('#new_login').val() != '') {
			changeButton('Проверка...');

			$.post("./scripts/user_availability.php", { user_name: $('#new_login').val() }, (data) => {
				if (data == 'yes') {
					changeButton('Это имя уже занято.');
				} else if (data == 'no') {
					changeButton('Имя доступно для регистрации.');
					
					if ($('#new_pass').val() != $('#new_pass2').val()) {
						changeButton('Разные пароли!');
					} else {
						if ($('#new_login').val() != '' && $('#new_pass').val() != '') {
							changeButton('Зарегистрироваться!', false);
						}
					}
				} else {
					changeButton('Ошибка!');
				}
			});
		} else {
			changeButton('Введите логин и пароль.');
		}
	});

	//проверка паролей
	$('#new_pass2, #new_pass').keyup(() => {
		if ($('#new_pass').val() != $('#new_pass2').val()) {
			changeButton('Разные пароли!');
		} else {
			if ($('#new_login').val() != '' && $('#new_pass').val() != '') {
				changeButton('Зарегистрироваться!', false);
			}
		}
	});
});