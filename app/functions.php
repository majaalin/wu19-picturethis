<?php
declare(strict_types=1);
if (!function_exists('redirect')) {
    /**
     * Redirect the user to given path.
     *
     * @param string $path
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

if (!function_exists('sortByPostID')) {
    /**
     * Sort by post ID
     * 
     * @param array $a
     * @param array $b
     * @return bool
     */
    function sortByPostID(array $a, array $b): bool
    {
    return $a['post_id']<$b['post_id'];
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

if (!function_exists('getLikesByPost')) {
    /**
     * Get User by user ID
     *
     * @param int $postID
     * @param PDO $pdo
     * @return array
     */
    function getLikesByPost(int $postID, PDO $pdo): array
    {
        $statement = $pdo->prepare("SELECT * FROM likes WHERE user_id = :user_id AND post_id = :post_id");
        $statement->execute([
            ":user_id" => $_SESSION["user"]["id"],
            ":post_id" => $postID
        ]);
        $liked = $statement->fetch(PDO::FETCH_ASSOC);
        if($liked===false) {
            $liked = [];
        }
        return $liked;
    }
}

if (!function_exists('getNumFollowers')) {
    /**
     * Get the number of followers by user ID
     *
     * @param int $userID
     * @param PDO $pdo
     * @return int
     */
    function getNumFollowers(int $userID, PDO $pdo): int
    {
        $statement = $pdo->prepare("SELECT * FROM follows WHERE id_following = :id_following");
        $statement->execute([
            ":id_following" => $userID
        ]);
        $followers = $statement->fetchAll(PDO::FETCH_ASSOC);
        if($followers===false) {
            return 0;
        } else {
            $numFollowers = 0;
            foreach ($followers as $following) {
                $numFollowers++;
            }
            return $numFollowers;
        }
    }
}

if (!function_exists('getNumFollowings')) {
    /**
     * Get the umber of followings by user ID
     *
     * @param int $userID
     * @param PDO $pdo
     * @return int
     */
    function getNumFollowings(int $userID, PDO $pdo): int
    {
        $statement = $pdo->prepare("SELECT * FROM follows WHERE user_id = :user_id");
        $statement->execute([
            ":user_id" => $userID
        ]);
        $followings = $statement->fetchAll(PDO::FETCH_ASSOC);
        if($followings===false) {
            return 0;
        } else {
            $numFollowings = 0;
            foreach ($followings as $following) {
                $numFollowings++;
            }
            return $numFollowings;
        }
    }
}

if (!function_exists('FollowByID')) {
    /**
     * Check whether logged-in user is following by profile ID
     *
     * @param int $profileID
     * @param int $userID
     * @param PDO $pdo
     * @return bool
     */
    function FollowByID(int $profileID, int $userID, PDO $pdo): bool
    {
        $statement = $pdo->prepare("SELECT * FROM follows WHERE user_id = :user_id AND id_following = :id_following");
        $statement->execute([
            ":user_id" => $userID,
            ":id_following" => $profileID
        ]);
        $following = $statement->fetch(PDO::FETCH_ASSOC);
        if($following!==false) {
            return true;
        }
        return $following;
    }
}

if (!function_exists('getPostsByFollowings')) {
    /**
     * Check whether logged-in user is following by profile ID
     *
     * @param int $userID
     * @param PDO $pdo
     * @return array
     */
    function getPostsByFollowings(int $userID, PDO $pdo): array
    {
        $statement = $pdo->prepare("SELECT * FROM follows WHERE user_id = :user_id");
        $statement->execute([
            ":user_id" => $userID
        ]);
        $followings = $statement->fetchAll(PDO::FETCH_ASSOC);
        if($followings===false) {
            return [];
        }
        $finalPosts = [];
        foreach($followings as $following) {
            $posts=getPostsByUser((int) $following['id_following'], $pdo);
            foreach($posts as $post) {
                $finalPosts[]=$post;
            }
        }
        usort($finalPosts,'sortByPostID');
        return $finalPosts;
    }
}


