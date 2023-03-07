<?php

namespace App\Contexts;

use App\Models\Track as TrackModel;
use App\Contexts\Block as BlockContext;

class Track
{
    private $blocked_user_list;

    public function __construct($user_id)
    {
        $this->blocked_user_list = BlockContext::getBlockedUserIdList($user_id);
    }

    public function getAll()
    {
        $tracks = TrackModel::whereNotIn('user_id', $this->blocked_user_list)
                            ->orderBy('created_at', 'desc')
                            ->paginate(30);

        $parsed_tracks = $tracks->transform(function ($track) {
            return [
                'id' => $track->id,
                'username' => $track->user->username,
                'avatar' => $track->user->avatar,
                'total_distance' => $track->total_distance,
                'total_time' => $track->total_time,
                'date' => $track->created_at,
                "last_likes" => $this->getRelatedLikes($track, 3)
            ];
        });

        return $this->paginateTracks($tracks, $parsed_tracks);
    }

    private function getRelatedLikes($track, $num_of_likes)
    {
        if ($track->likes->isEmpty()) {
            return [];
        } else {
            return $track->likes->reduce(function ($acc, $like) use ($num_of_likes) {
                if (count($acc) < $num_of_likes) {
                    if (!in_array($like->user->id, $this->blocked_user_list)) {
                        array_push($acc, [
                            'id' => $like->user->id,
                            'username' => $like->user->username,
                            'avatar' => $like->user->avatar
                        ]);
                    }
                }

                return $acc;
            }, []);
        }
    }

    private function paginateTracks($queryTracks, $parsed_tracks)
    {
        $pagination = $queryTracks->toArray();
        unset($pagination['data']);
        unset($pagination['links']);

        return [
            'tracks' => $parsed_tracks,
            'pagination' => $pagination
        ];
    }
}
