<?php
declare(strict_types=1);
if (!function_exists('redirect')) {
    /**
     * Redirect the user to given path.
     *
     * @param string $path
     *
     * @return void
     */
    function redirect(string $path)
    {
        header("Location: ${path}");
        exit;
    }
}

if (!function_exists('getPosts')) {
    /**
     * Get posts by user ID
     *
     * @param int $userID
     * @param PDO $pdo
     * @return array
     */
    function getPostsByUser(int $userID, PDO $pdo): array
    {
        $statement = $pdo->prepare('SELECT * FROM posts WHERE user_id = :user_id ORDER BY datetime DESC');
        $statement->bindParam(':user_id', $userID, PDO::PARAM_INT);
        $statement->execute();
        $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
        if($posts===false) {
            $posts = [];
        }
        return $posts;
    }
}

if (!function_exists('getAllPosts')) {
    /**
     * Get all posts 
     * 
     * @param PDO $pdo
     * @return array
     */
    function getAllPosts(PDO $pdo): array
    {
        $statement = $pdo->prepare('SELECT * FROM posts ORDER BY datetime DESC');
        $statement->execute();
        $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
        if($posts===false) {
            $posts = [];
        }
        return $posts;
    }
}

if (!function_exists('getAvatar')) {
    /**
     * Get avatar by user ID
     *
     * @param int $userID
     * @param PDO $pdo
     * @return array
     */
    function getAvatar(int $userID, PDO $pdo): array
    {
        $statement = $pdo->prepare('SELECT * FROM avatars WHERE avatar_id = :avatar_id');
        $statement->bindParam(':avatar_id', $userID, PDO::PARAM_INT);
        $statement->execute();
        $avatar = $statement->fetch(PDO::FETCH_ASSOC);
        if($avatar===false) {
            $avatar = [];
        }
        return $avatar;
    }
}

if (!function_exists('getUserByID')) {
    /**
     * Get User by user ID
     *
     * @param int $userID
     * @param PDO $pdo
     * @return array
     */
    function getUserByID(int $userID, PDO $pdo): array
    {
        $statement = $pdo->prepare('SELECT * FROM users WHERE id = :id');
        $statement->bindParam(':id', $userID, PDO::PARAM_INT);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if($user===false) {
            $user = [];
        }
        return $user;
    }
}