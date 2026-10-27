<?php

namespace App\Http\Controllers\ChatGroup;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChatGroup\DeleteChatGroupRequest;
use App\Http\Requests\ChatGroup\StoreChatGroupRequest;
use App\Http\Requests\ChatGroup\UpdateChatGroupRequest;
use App\Services\ChatGroup\ChatGroupService;
use App\Support\ReturnApi;

class ChatGroupController extends Controller
{
    public function __construct(
        protected ChatGroupService $chatGroupService
    ) {}

    public function store(StoreChatGroupRequest $request) 
    {
        try {

            $data = $this->chatGroupService->store($request->validated());
            return ReturnApi::success(
                $data,
                'Chat group created successfully!',
                201
            ); 
        } catch(\Exception $e) {
            throw new ApiException('Error to create chat group: ' . $e->getMessage());
        }
    }

    public function update(UpdateChatGroupRequest $request) 
    {
        try {

            $data = $this->chatGroupService->update($request->validated());
            return ReturnApi::success(
                $data,
                'Chat group updated successfully!',
                200
            ); 
        } catch(\Exception $e) {
            throw new ApiException('Error to update chat group: ' . $e->getMessage());
        }
    }

    public function delete(DeleteChatGroupRequest $request) 
    {
        try {

            $this->chatGroupService->delete($request->validated());
            return ReturnApi::success(
                null,
                'Chat group deleted successfully!',
                200
            ); 
        } catch(\Exception $e) {
            throw new ApiException('Error to delete chat group: ' . $e->getMessage());
        }
    }
}
