<?php

global $errors;

?>

<html>
<head>
    <title>Ввод данных</title>
    <link rel="stylesheet" href="/public/css/site.css">
</head>

<body>
<div class="container">
    <?php if (count($errors)) { ?>
        <div class="errors">
            <?php foreach ($errors as $error) { ?>
                <div class="error">
                    <?= $error ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

    <form action="" method="post">
        <input type="text" name="group_number" placeholder="Номер группы"/>
        <input type="text" name="type" placeholder="Тип занятия"/>
        <input type="text" name="length" placeholder="Количество пар"/>
        <input type="text" name="subject" placeholder="Предмет"/>
        <input type="text" name="professor" placeholder="Имя преподавателя"/>

        <button type="submit" class="btn" name="send_data">Отправить данные</button>
    </form>
</div>
</body>
</html>
