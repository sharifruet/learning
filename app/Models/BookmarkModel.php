<?php

namespace App\Models;

use CodeIgniter\Model;

class BookmarkModel extends Model
{
    protected $table            = 'bookmarks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'lesson_id',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Check if lesson is bookmarked by user
     */
    public function isBookmarked(int $userId, int $lessonId): bool
    {
        return $this->where('user_id', $userId)
                   ->where('lesson_id', $lessonId)
                   ->first() !== null;
    }

    /**
     * Toggle bookmark status
     */
    public function toggleBookmark(int $userId, int $lessonId): bool
    {
        $existing = $this->where('user_id', $userId)
                        ->where('lesson_id', $lessonId)
                        ->first();

        if ($existing) {
            return $this->delete($existing['id']) !== false;
        } else {
            return $this->insert([
                'user_id' => $userId,
                'lesson_id' => $lessonId,
            ]) !== false;
        }
    }

    /**
     * Get user's bookmarked lessons
     */
    public function getUserBookmarks(int $userId)
    {
        return $this->where('user_id', $userId)
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }
}

