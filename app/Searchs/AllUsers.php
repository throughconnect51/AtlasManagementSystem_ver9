<?php

namespace App\Searchs;

use App\Models\Users\User;

class AllUsers implements DisplayUsers {

    public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects) {
        $query = User::with('subjects');

        $updown = $updown ?: 'ASC';

        if (!is_null($subjects)) {
            $query->whereHas('subjects', function($q) use ($subjects) {
                $q->whereIn('subjects.id', $subjects);
            });
        }
        
        return $query->orderBy('id', $updown)->get();
    }

}