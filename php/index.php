<?php
/**
 * Created by PhpStorm.
 * User: RinesThaix
 * Date: 19.03.2018
 * Time: 15:48
 */
echo '<html>
<form action="index.php" method="get">
    <button name="create" value="" type="submit">Создать новый товар</button>
    <button name="remove" value="" type="submit">Удалить существующий</button>
    <input type="hidden" name="curpage" value="' . $selected_page . '"/>
    <button name="page" value="' . ($selected_page - 1) . '" type="submit">Предыдущая страница</button>
    <button name="page" value="' . ($selected_page + 1) . '" type="submit">Следующая страница</button>
    <input type="submit" class="button" name="refresh" value="Обновить страницу" />
</form>
</html>';

?>
