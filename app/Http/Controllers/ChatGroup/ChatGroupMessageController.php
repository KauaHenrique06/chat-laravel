<?php

namespace App\Http\Controllers\ChatGroup;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChatGroup\DeleteChatGroupMessageRequest;
use App\Http\Requests\ChatGroup\IndexChatGroupMessageRequest;
use App\Http\Requests\ChatGroup\ReadChatGroupMessageRequest;
use App\Http\Requests\ChatGroup\StoreChatGroupMessageRequest;
use App\Http\Requests\ChatGroup\UpdateChatGroupMessageRequest;
use App\Services\ChatGroup\ChatGroupMessageService;
use App\Support\ReturnApi;

class ChatGroupMessageController extends Controller
{
    public function __construct(
        protected ChatGroupMessageService $chatGroupMessageService
    ) {}

    public function store(StoreChatGroupMessageRequest $request) 
    {
        try {

            $data = $this->chatGroupMessageService->store($request->validated());
            return ReturnApi::success(
                $data,
                'Message sended successfully!',
                201
            ); 
        } catch(\Exception $e) {
            throw new ApiException('Error to send message: ' . $e->getMessage());
        }
    }

    public function update(UpdateChatGroupMessageRequest $request) 
    {
        try {

            $data = $this->chatGroupMessageService->update($request->validated());
            return ReturnApi::success(
                $data,
                'Message updated successfully!',
                200
            ); 
        } catch(\Exception $e) {
            throw new ApiException('Error to update message: ' . $e->getMessage());
        }
    }

    public function delete(DeleteChatGroupMessageRequest $request) 
    {
        try {

            $this->chatGroupMessageService->delete($request->validated());
            return ReturnApi::success(
                null,
                'Message deleted successfully!',
                200
            ); 
        } catch(\Exception $e) {
            throw new ApiException('Error to delete message: ' . $e->getMessage());
        }
    }

    public function index(IndexChatGroupMessageRequest $request) 
    {
        try {

            $data = $this->chatGroupMessageService->index($request->validated());
            return ReturnApi::success(
                $data,
                'Message indexed successfully!',
                200
            ); 
        } catch(\Exception $e) {
            throw new ApiException('Error to index message: ' . $e->getMessage());
        }
    }

    public function read(ReadChatGroupMessageRequest $request) 
    {
        try {

            $this->chatGroupMessageService->read($request->validated());
            return ReturnApi::success(
                null,
                'Messages marked as read successfully!',
                200
            ); 
        } catch(\Exception $e) {
            throw new ApiException('Error to mark messages as read: ' . $e->getMessage());
        }
    }
}
