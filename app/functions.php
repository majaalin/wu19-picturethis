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
    function getPosts(int $userID, PDO $pdo): array
    {
        $statement = $pdo->prepare('SELECT * FROM posts WHERE user_id = :user_id ORDER BY datetime DESC');
        $statement->bindParam(':user_id', $userID, PDO::PARAM_INT);
        $statement->execute();
        $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
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