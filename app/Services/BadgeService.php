<?php

namespace App\Services;

use App\Models\User;
use App\Models\Badge;
use App\Models\CommentCount;
use App\Models\UserBadge;
use League\Flysystem\Exception;
use App\Models\Board;

class BadgeService
{
    public function updateUserBadgeInBoard($boardId)
    {
        $sortedBadgeList = Badge::orderBy('priority', 'asc')->get();
        User::findListInBoard($boardId)
            ->each(function ($user, $i) use ($sortedBadgeList, $boardId) {
                $badge = $sortedBadgeList->first(function ($badge, $i) use ($user, $boardId) {
                    return $this->canAddSelectedBadgeId($user, $boardId, $badge->badge_id);
                });
                if ($user->badge_id != $badge->badge_id) {
                    UserBadge::where('user_id', '=', $user->id)
                        ->where('board_id', '=', $boardId)
                        ->update(['badge_id' => $badge->badge_id]);
                }
            });
    }

    private function canAddSelectedBadgeId($user, $boardId, $badgeId)
    {
        $userId = $user->id;
        
        switch ($badgeId) {
            case Badge::BADGE_ID['TOP_USER']:
                return $this->isTopUserInBoard($userId, $boardId);
            case Badge::BADGE_ID['ACTIVE_USER']:
                return $this->isActiveUserInBoard($userId, $boardId);
            case Badge::BADGE_ID['POPULAR_USER']:
                return $this->isPopularUserInBoard($userId, $boardId);
            case Badge::BADGE_ID['LONELY_USER']:
                return $this->isLonelyUserInBoard($userId, $boardId);
            case Badge::BADGE_ID['BEGINNER']:
                return $this->isBgennerInBoard($userId, $boardId);
            default:
                throw new Exception("invaild badgeId(${badgeId})");
        }
    }

    private function isTopUserInBoard($userId, $boardId)
    {
        return $userId == Board::findMostActiveUserInBoard($boardId);
    }

    private function isActiveUserInBoard($userId, $boardId)
    {
        $targetUserCommentCount = CommentCount::findUserCommentCountInBoard($boardId, $userId);
        $userCommentCountAvg = CommentCount::findUserCommentCountAvgInBoard($boardId);
        return  $targetUserCommentCount >= $userCommentCountAvg;
    }

    private function isPopularUserInBoard($userId, $boardId)
    {
        $targetUserReplyCountAvg = CommentCount::findUserReplyCountAvgInBoard($boardId, $userId);
        $userReplyCountAvg = CommentCount::findReplyCountAvgInBoard($boardId);
        return $targetUserReplyCountAvg >= $userReplyCountAvg;
    }

    private function isLonelyUserInBoard($userId, $boardId)
    {
        return CommentCount::findUserReplyCountInBoard($boardId, $userId) == 0;
    }

    private function isBgennerInBoard($userId, $boardId)
    {
        $targetUserCommentCount = CommentCount::findUserCommentCountInBoard($boardId, $userId);
        $userCommentCountAvg = CommentCount::findUserCommentCountAvgInBoard($boardId);
        return  $targetUserCommentCount <= ($userCommentCountAvg / 2.0);
    }
}
