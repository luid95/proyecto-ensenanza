<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;


class CommentController extends Controller
{
    public function toggleApproval($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->approved = !$comment->approved;
        $comment->save();

        return response()->json(['message' => 'Estado de aprobación actualizado correctamente']);
        
    }

}
