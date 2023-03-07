<?php

namespace App\Contexts;

use App\Models\Block as BlockModel;

class Block
{
    public static function blockUser($user_id, $blocked_user_id)
    {
        try {
            return BlockModel::create([
                'user_id' => $user_id,
                'blocked_user_id' => $blocked_user_id
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function isUserBlocked($user_id, $blocked_user_id)
    {
        $blocked_users = BlockModel::where([
                ['user_id', '=', $user_id],
                ['blocked_user_id', '=', $blocked_user_id]
            ])->get();

        if ($blocked_users->isEmpty()) {
            return false;
        }

        return true;
    }

    public static function getBlockedUserIdList($user_id)
    {
        $blocked_list = self::getBlockedList($user_id);

        return $blocked_list->map(function ($blocked) {
            return $blocked->blocked_user_id;
        })->toArray();
    }

    public static function getBlockUserList($user_id)
    {
        $blocked_list = self::getBlockedList($user_id);
        return $blocked_list->map(function ($blocked) {
            return [
                'id' => $blocked->blocked->id,
                'username' => $blocked->blocked->username,
                'avatar' => $blocked->blocked->avatar,
            ];
        })->toArray();
    }

    private static function getBlockedList($user_id)
    {
        return BlockModel::where('user_id', '=', $user_id)->get();
    }
}
