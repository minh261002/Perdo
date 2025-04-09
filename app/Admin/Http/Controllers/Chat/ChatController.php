<?php

namespace App\Admin\Http\Controllers\Chat;

use App\Admin\Http\Requests\Message\SendMessageRequest;
use App\Admin\Services\Chat\ChatServiceInterface;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\Message\MessageRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController
{
    protected $messageRepository;
    protected $adminRepository;
    protected $chatService;

    public function __construct(
        MessageRepositoryInterface $messageRepository,
        AdminRepositoryInterface $adminRepository,
        ChatServiceInterface $chatService
    ) {
        $this->messageRepository = $messageRepository;
        $this->adminRepository = $adminRepository;
        $this->chatService = $chatService;
    }

    public function index()
    {
        $currentAdminId = Auth::guard('admin')->user()->id;

        $conversations = $this->messageRepository->getByQueryBuilder([
            'sender_id' => $currentAdminId,
        ])->pluck('receiver_id')
            ->merge(
                $this->messageRepository->getByQueryBuilder([
                    'receiver_id' => $currentAdminId,
                ])->pluck('sender_id')
            )
            ->unique()
            ->values();

        $admins = $this->adminRepository->getByQueryBuilder([
            'id' => $conversations,
        ])->get();

        return view('admin.chat.index', compact('admins'));
    }

    public function show($adminId)
    {
        $admin = auth()->guard('admin')->user();
        $chatAdmin = $this->adminRepository->findOrFail($adminId);
        $messages = $admin->sentMessages()
            ->where('receiver_id', $adminId)
            ->orWhere(function ($query) use ($adminId) {
                $query->where('sender_id', $adminId)
                    ->where('receiver_id', auth()->id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $messages->where('sender_id', $adminId)
            ->where('receiver_id', $admin->id)
            ->where('is_read', false)
            ->each(function ($message) {
                $message->update(['is_read' => true]);
            });
        return view('admin.chat.box-conversation', compact('chatAdmin', 'messages'));
    }

    public function send(SendMessageRequest $request)
    {
        $this->chatService->send($request);
        return response()->json(['status' => 'success', 'message' => 'Gửi tin nhắn thành công']);
    }
}
