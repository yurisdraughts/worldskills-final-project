$(document).ready(() => {
    const onSubmit = (event) => {
        event.preventDefault();
        const value = Math.floor(Number($('#art_in_page').val()));

        if (!isNaN(value) && value !== 0) {
            $.post("./scripts/set_art_in_page.php",
                { art_in_page: value },
                data => {
                    $('#art_in_page').val('');
                    $(`<p id=php-response>${data}</p>`).insertAfter('#art_in_page');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                });
        } else {
            $('#art_in_page').val('');
            $(`<p id=php-response>Неверное значение. Попробуйте ещё раз!</p>`).insertAfter('#art_in_page');
            setTimeout(() => {
                $('#php-response').remove();
            }, 1000);
        }
    };

    const onClick = () => {
        $('#settings').replaceWith(`<form method=post id=settings>
            <label for=art_in_page>Число постов на странице:</label>
            <input id=art_in_page type=number>
            <p style="display: flex;"><input class=article_button id=art_in_page_button type=submit value='Обновить'>
            <input class="article_button" id=cancel_settings_button style="margin: 0 0 0 18px;" type="button" value="Отмена"></p>
        </form>`);

        $('#settings').submit(onSubmit);

        $('#cancel_settings_button').click(() => {
            $('#settings').replaceWith("<input id=settings class=article_button type=button value='Обновить число постов на странице'>");
            $('#settings').click(onClick);
        });
    };

    $('#settings').click(onClick);
});