<?php
require "registerBd.php";?>
    <div class="container mt-4" style="text-align: center">
        <div class="row">
            <div class="col">
                <h2>Форма авторизации</h2>
                <form style="text-align: center" action="login.php" method="post">
                    <input type="text" class="form-control" name="login" id="login" placeholder="Введите логин" required><br>
                    <input type="password" class="form-control" name="password" id="pass" placeholder="Введите пароль" required><br>
                    <button class="btn btn-success" name="do_login" type="submit">Авторизоваться</button>
                </form>
            </div>
        </div>
    </div>

<?php

$data = $_POST;
// Пользователь нажимает на кнопку "Авторизоваться" и код начинает выполняться
if(isset($data['do_login'])) {
    // Создаем массив для сбора ошибок
    $errors = array();
    // Проводим поиск пользователей в таблице users
    $user = R::findOne('users', 'login = ?', array($data['login']));
    if($user) {
        // Если логин существует, тогда проверяем пароль
        if(password_verify($data['password'], $user->password)) {
            // Все верно, пускаем пользователя
            $_SESSION['logged_user'] = $user;
            // Редирект на главную страницу
            header('Location: index.php');
        } else {
            $errors[] = 'Пароль неверно введен!';
        }
    } else {
        //Если пользователя не было найденно происходит регистрация
            if(empty($errors)) {
                // Создаем таблицу users
                $user = R::dispense('users');
                // добавляем в таблицу записи
                $user->login = $data['login'];
                // Хешируем пароль
                $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
                // Сохраняем таблицу
                R::store($user);
            } else {
                // array_shift() извлекает первое значение массива array и возвращает его, сокращая размер array на один элемент.
                echo '<div style="color: red; ">' . array_shift($errors). '</div><hr>';
            }
            $_SESSION['logged_user'] = $user;
            header('Location: index.php');

        }
    }
    if(!empty($errors)) {

        echo '<div style="color: red; ">' . array_shift($errors). '</div><hr>';

    }


