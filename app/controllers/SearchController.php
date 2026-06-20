<?php

class SearchController
{
    public static function search(): void
    {
        requireAuth();
        $user = currentUser();
        $query = trim($_GET['q'] ?? '');
        $results = [];

        if ($query !== '') {
            $results = Entry::search($user['id'], $query);
        }

        require __DIR__ . '/../views/search.php';
    }
}
