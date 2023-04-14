let newArticle = function() {
	document.getElementById("add_article").style.display = "block";
	document.getElementById("add_article").setAttribute("method", "post");
	document.getElementById("add_article_button").style.display = "none";
};

let closeForm = function() {
	document.getElementById("add_article").style.display = "none";
	document.getElementById("add_article_button").style.display = "block";
};

let cancelForm = function() {
	elements = document.getElementById("add_article").querySelectorAll("input:not(input[type='hidden']), textarea");
	elements.forEach(element => {
		element.value = "";
	});
	closeForm();
};

$(document).ready(() => {
	$('#login_form :required').keyup(() => {
		if ($('#login_form [name="login"]').val() !== '' && $('#login_form [name="pass"]').val() !== '') {
			$('#login_form [name="login_button"]').prop('disabled', false);
		} else {
			$('#login_form [name="login_button"]').prop('disabled', true);
		}
	});
});