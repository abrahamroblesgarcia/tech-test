<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BlockRequest;
use App\Contexts\Block as BlockContext;

class BlockController extends Controller
{
    public function index(Request $request)
    {
        $current_user_id = $request->user()->id;
        $user_blocked_list = BlockContext::getBlockUserList($current_user_id);

        return response()->json($user_blocked_list);
    }

    public function blockUser(BlockRequest $request)
    {
        $current_user_id = $request->user()->id;
        $blocked_user_id = $request->blocked_user_id;

        try {
            BlockContext::blockUser($current_user_id, $blocked_user_id);
            $response_msg = "user id: {$blocked_user_id} blocked successfully.";
            $status = 200;
        } catch (\Exception $error) {
            $response_msg = "A problem has occurred on our server, please try again later.";
            $status = 500;
        }

        return response()->json(['message' =>$response_msg], $status);
    }
}
