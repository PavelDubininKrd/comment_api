<?php

namespace App\Traits;

use App\Http\Resources\ServerErrorResource;
use App\Http\Resources\SuccessResource;
use App\Log\Logging;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

trait CrudTrait
{
    public function index(Request $request, int $userId)
    {
        try {
            return app()->make($this->getService())->index($request, $userId);
        } catch (Exception $e) {
            Logging::logError($e);

            return new ServerErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Request $request, int $userId, int $id)
    {
        try {
            return app()->make($this->getService())->show($id, $userId);
        } catch (ModelNotFoundException $e) {
            abort(Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            Logging::logError($e);

            return new ServerErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(FormRequest $request, $userId): JsonResource
    {
        try {
            app()->make($this->getService())->create($request->all(), $userId);

            return new SuccessResource(Response::HTTP_CREATED);
        } catch (ModelNotFoundException $e) {
            abort(Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            Logging::logError($e);

            return new ServerErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(FormRequest $request, int $userId, int $id): JsonResource
    {
        try {
            app()->make($this->getService())->update($request->all(), $id, $userId);

            return new SuccessResource(Response::HTTP_OK);
        } catch (Exception $e) {
            Logging::logError($e);

            return new ServerErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(int $userId, int $id): JsonResource
    {
        try {
            app()->make($this->getService())->delete($id, $userId);

            return new SuccessResource(Response::HTTP_OK);
        } catch (Exception $e) {
            Logging::logError($e);

            return new ServerErrorResource(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getService(): string
    {
        return self::SERVICE;
    }
}
