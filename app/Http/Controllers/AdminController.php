<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Models\Faq;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_conversations' => Conversation::count(),
            'total_messages' => Message::count(),
            'total_faqs' => Faq::count(),
        ];

        $recentConversations = Conversation::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.index', compact('stats', 'recentConversations'));
    }

    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function conversations()
    {
        $conversations = Conversation::with(['user', 'messages'])
            ->latest()
            ->paginate(20);
        return view('admin.conversations', compact('conversations'));
    }
}