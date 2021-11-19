<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Repositories\ServiceRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class ServiceController extends Controller
{
    private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function getAll(Request $request): Response
    {
        $filters = $request->get('filter') ?? null;

        try {
            $services = $this->serviceRepository->getAll($filters);
        } catch (\Exception $exception) {
            return response(['error' => $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR]);
        }

        return response(['success' => $services]);
    }

    public function get(int $id): Response
    {
        try {
            $foundService = $this->serviceRepository->get($id);
        } catch (ModelNotFoundException $exception) {
            return response(['error' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            return response(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response(['success' => $foundService]);
    }

    public function create(Request $request): Response
    {
        try {
            $request->validate([
                'title' => 'required:string',
                'summary' => 'string',
                'total_cost' => 'required:int'
            ]);
        } catch (ModelNotFoundException $exception) {
            return response(['error' => $exception->getMessage()], Response::HTTP_PRECONDITION_FAILED);
        }

        $newService = new Service([
            'title' => $request->get('title'),
            'summary' => $request->get('summary'),
            'total_cost' => $request->get('total_cost'),
        ]);

        try {
            $newService = $this->serviceRepository->create($newService);
        } catch (\Exception $exception) {
            return response(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response(['success' => $newService]);
    }

    public function update(Request $request): Response
    {
        //Validación datos recibidos
        try {
            $request->validate([
                'id' => 'required:int',
                'title' => 'required:string',
                'summary' => 'string',
                'total_cost' => 'required:int'
            ]);
        } catch (ModelNotFoundException $exception) {
            return response(['error' => $exception->getMessage()], Response::HTTP_PRECONDITION_FAILED);
        }

        //Obtener servicio existente
        try {
            $foundService = $this->serviceRepository->get($request->get('id'));
        } catch (ModelNotFoundException $exception) {
            return response(['error' => $exception->getMessage(), Response::HTTP_PRECONDITION_FAILED]);
        } catch (\Exception $exception) {
            return response(['error' => $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR]);
        }

        //Editar campos
        if ($title = $request->get('title')) {
            $foundService->title = $title;
        }

        if ($summary = $request->get('summary')) {
            $foundService->summary = $summary;
        }

        if ($total_cost = $request->get('total_cost')) {
            $foundService->total_cost = $total_cost;
        }

        //Guardar cambios en BD
        try {
            $foundService = $this->serviceRepository->update($foundService);
        } catch (\Exception $exception) {
            return response(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response(['success' => $foundService]);
    }

    public function delete(int $id): Response
    {

    }


}
