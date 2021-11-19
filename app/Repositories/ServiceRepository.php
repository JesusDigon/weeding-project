<?php

namespace App\Repositories;

use App\Models\Service;

class ServiceRepository
{
    // Número de items por página
    private const PAGE_OFFSET = 15;

    public function getAll(?array $filters = []): array
    {
        $services = Service::paginate(self::PAGE_OFFSET);

        if (!empty($filters)) {
            $services = Service::where($filters)
                ->paginate(self::PAGE_OFFSET);
        }

        return $services
            ->toArray();
    }

    public function get(int $id): Service
    {
        return Service::findOrFail($id);
    }

    public function create(Service $service): Service
    {
        $service->save();
        return $service;
    }

    public function update(Service $service): Service
    {
        $service->save();
        return $service;
    }

    public function delete(int $id): void
    {
        $service = Service::findOrFail($id);
        $service->delete();
    }
}
