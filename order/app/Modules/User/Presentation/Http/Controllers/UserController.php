<?php

namespace App\Modules\User\Presentation\Http\Controllers;

use App\Modules\User\Application\Queries\GetUser\GetUserHandler;
use App\Modules\User\Application\Queries\GetUser\GetUserQuery;
use App\Modules\User\Application\Queries\GetUserPagination\GetUserListHandler;
use App\Modules\User\Application\Queries\GetUserPagination\GetUserListQuery;
use App\Modules\User\Application\Queries\GetUserPagination\PaginationRequest;
use App\Modules\User\Application\Queries\GetUserPagination\UserSearchRequest;
use App\Modules\User\Application\UseCase\DeleteUser\DeleteUserHandler;
use App\Modules\User\Application\UseCase\DeleteUser\DeleteUserQuery;
use App\Modules\User\Application\UseCase\UpdateUser\UpdateUserHandler;
use App\Modules\User\Application\UseCase\UpdateUser\UpdateUserQuery;
use App\Modules\User\Application\UseCase\UpdateUser\UpdateUserRequest;
use App\Modules\User\Presentation\Http\Requests\GetUserListRequest;
use App\Modules\User\Presentation\Http\Requests\UpdateUserFormRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController
{
    public function index(GetUserListRequest $request, GetUserListHandler $handler): JsonResponse
    {
        $limit =  $request->validated('limit', 20);

        $paginationRequest = new PaginationRequest(
            limit: $limit,
            offset: ((int)$request->validated('page', 1) - 1) * $limit
        );

        $userSearchRequest = new UserSearchRequest(
            name: $request->validated('name'),
        );

        $response = $handler->handle(
            new GetUserListQuery(
                $paginationRequest,
                $userSearchRequest
            )
        );

        return new JsonResponse($response);
    }

    public function show(int $id, GetUserHandler $handler): JsonResponse
    {
        $response = $handler->handle(
            new GetUserQuery($id)
        );

        if (!$response) {
            abort(404);
        }

        return new JsonResponse([
            'data' => $response
        ]);
    }

    public function update(UpdateUserFormRequest $formRequest, int $id, UpdateUserHandler $handler): JsonResponse
    {
        $response = $handler->handle(
            new UpdateUserQuery(
                $id,
                new UpdateUserRequest($formRequest->input('name'))
            )
        );

        if (!$response) {
            abort(404);
        }

        return new JsonResponse([
            'data' => $response
        ]);
    }

    public function destroy(int $id, DeleteUserHandler $handler): JsonResponse
    {
        $response = $handler->handle(
            new DeleteUserQuery($id)
        );

        if (!$response) {
            abort(404);
        }

        return new JsonResponse([
            'message' => 'User delete'
        ], 204);
    }
}
