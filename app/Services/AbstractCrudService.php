<?php

namespace App\Services;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

abstract class AbstractCrudService
{
    protected const string MODEL = '';
    protected const string RESOURCE = '';

    public function index(Request $request, $userId): JsonResource
    {
        return $this->getResource()::collection($this->getRecordQuery(userId: $userId)->paginate(config('app.pagination.per_page')));
    }

    public function show(int $id, int $userId = null): JsonResource
    {
        $resource = $this->getResource();

        return new $resource($this->getModel()::findOrFail($id));
    }

    public function create(array $data, int $userId = null, array $meta = null): void
    {
        $this->getModel()::create($data);
    }

    public function update(array $data, $id, int $userId = null, array $meta = null): void
    {
        $data['updated_at'] = now();

        $this->getRecordQuery($id, $userId)->update($data);
    }

    public function delete(int $id, int $userId = null, array $meta = null): void
    {
        $this->getRecordQuery($id, $userId)->delete();
    }

    protected function getRecordQuery(int $id = null, int $userId = null): Builder
    {
        return DB::table($this->getModel()::TABLE)
            ->when($id, fn ($query) => $query->where('id', $id))
            ->when($userId, fn ($query) => $query->where('user_id', $userId));
    }

    protected function getModel(): string
    {
        return static::MODEL;
    }

    protected function getResource(): string
    {
        return static::RESOURCE;
    }
}
