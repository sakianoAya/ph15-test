<?php

function saveUser(array $user): array
{
    $handle = fopen(__DIR__ . '/../data/users.csv', 'a');

    $user['id'] = getNewId();

    fputcsv($handle, [
        $user['id'],
        $user['name'],//名字
        $user['email'],//mail
        $user['password'],//密碼
        $user['birthday'],//生日
        $user['residence'],//住所
    ]);

    fclose($handle);

    return $user;
}

function getUsers(): array
{
    $handle = fopen(__DIR__ . '/../data/users.csv', 'r');
    $users = [];

    while (!feof($handle)) {
        $row = fgetcsv($handle);

        // 空行対策
        if ($row === false || is_null($row[0])) {
            break;
        }

        $user = [
            'id' => $row[0],
            'name' => $row[1],
            'email' => $row[2],
            'password' => $row[3],
            'birthday' =>$row[4],
            'residence'=>$row[5],
        ];

        $users[] = $user;
    }

    fclose($handle);

    return $users;
}

function getNewId(): int
{
    $maxId = 0;
    $users = getUsers();

    foreach ($users as $user) {
        $id = intval($user['id']);
        if ($id > $maxId) {
            $maxId = $id;
        }
    }

    return $maxId + 1;
}

function login(string $email, string $password): ?array
{
    $users = getUsers();

    foreach ($users as $user) {
        if ($user['email'] === $email && $user['password'] === $password) {
            return $user;
        }
    }

    return null;
}

function getUser(string|int $id): ?array
{
    $users = getUsers();

    foreach ($users as $user) {
        if (intval($user['id']) === intval($id)) {
            return $user;
        }
    }

    return null;
}


function updateUser(array $user): array
{
    $users = getUsers();
    $updatedUsers = [];

    foreach ($users as $existingUser) {
        if ($existingUser['id'] === $user['id']) {
            $updatedUsers[] = $user; // 更新用戶數據
        } else {
            $updatedUsers[] = $existingUser; // 保留其他用戶數據
        }
    }

    $handle = fopen(__DIR__ . '/../data/users.csv', 'w');

    foreach ($updatedUsers as $updatedUser) {
        fputcsv($handle, [
            $updatedUser['id'],
            $updatedUser['name'],
            $updatedUser['email'],
            $updatedUser['password'],
            $updatedUser['birthday'],
            $updatedUser['residence'],
        ]);
    }

    fclose($handle);

    return $user;
}
