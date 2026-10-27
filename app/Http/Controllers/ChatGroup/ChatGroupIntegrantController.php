<?php

namespace App\Http\Controllers\ChatGroup;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChatGroup\DeleteChatGroupIntegrantRequest;
use App\Http\Requests\ChatGroup\StoreChatGroupIntegrantRequest;
use App\Http\Requests\ChatGroup\UpdateChatGroupIntegrantRequest;
use App\Services\ChatGroup\ChatGroupIntegrantService;
use App\Support\ReturnApi;

class ChatGroupIntegrantController extends Controller
{
    public function __construct(
        protected ChatGroupIntegrantService $chatGroupIntegrantService
    ) {}

    public function store(StoreChatGroupIntegrantRequest $request) 
    {
        try {

            $data = $this->chatGroupIntegrantService->store($request->validated());
            return ReturnApi::success(
                $data,
                'Chat group created successfully!',
                201
            ); 
        } catch(\Exception $e) {
            throw new ApiException('Error to create chat group: ' . $e->getMessage());
        }
    }

    public function update(UpdateChatGroupIntegrantRequest $request) 
    {
        try {

            $data = $this->chatGroupIntegrantService->update($request->validated());
            return ReturnApi::success(
                $data,
                'Integrant updated successfully!',
                200
            ); 
        } catch(\Exception $e) {
            throw new ApiException('Error to update integrant: ' . $e->getMessage());
        }
    }

    public function delete(DeleteChatGroupIntegrantRequest $request) 
    {
        try {

            $data = $this->chatGroupIntegrantService->delete($request->validated());
            return ReturnApi::success(
                $data,
                'Integrants removed successfully!',
                200
            ); 
        } catch(\Exception $e) {
            throw new ApiException('Error to remove integrants: ' . $e->getMessage());
        }
    }
}
