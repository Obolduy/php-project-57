<?php

namespace App\TaskStatus\Controllers;

use App\Framework\Controllers\Controller;
use App\TaskStatus\Actions\CreateTaskStatusAction;
use App\TaskStatus\Actions\DeleteTaskStatusAction;
use App\TaskStatus\Actions\UpdateTaskStatusAction;
use App\TaskStatus\DTO\TaskStatusDTO;
use App\TaskStatus\Factories\TaskStatusFactory;
use App\TaskStatus\Repositories\TaskStatusRepository;
use App\TaskStatus\Requests\StoreTaskStatusRequest;
use App\TaskStatus\Requests\UpdateTaskStatusRequest;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\RedirectResponse;

class TaskStatusController extends Controller
{
    public function index(TaskStatusRepository $taskStatusRepository): ViewFactory|ViewContract
    {
        $taskStatuses = $taskStatusRepository->getAll();

        return view('task_statuses.index', compact('taskStatuses'));
    }

    public function create(): ViewFactory|ViewContract
    {
        return view('task_statuses.create');
    }

    public function store(
        StoreTaskStatusRequest $request,
        CreateTaskStatusAction $createTaskStatusAction
    ): RedirectResponse {
        /** @var TaskStatusDTO $dto */
        $dto = TaskStatusFactory::fromRequestValidated($request);
        $createTaskStatusAction->execute($dto);

        return redirect()
            ->route('task_statuses.index')
            ->with('success', __('task_statuses.created'));
    }

    public function edit(int $id, TaskStatusRepository $taskStatusRepository): ViewFactory|ViewContract
    {
        $taskStatus = $taskStatusRepository->findById($id);

        if (!$taskStatus) {
            abort(404);
        }

        return view('task_statuses.edit', compact('taskStatus'));
    }

    public function update(
        UpdateTaskStatusRequest $request,
        int $id,
        TaskStatusRepository $taskStatusRepository,
        UpdateTaskStatusAction $updateTaskStatusAction
    ): RedirectResponse {
        $taskStatus = $taskStatusRepository->findById($id);

        if (!$taskStatus) {
            abort(404);
        }

        /** @var TaskStatusDTO $dto */
        $dto = TaskStatusFactory::fromRequestValidated($request);

        $updateTaskStatusAction->execute($taskStatus, $dto);

        return redirect()
            ->route('task_statuses.index')
            ->with('success', __('task_statuses.updated'));
    }

    public function destroy(
        int $id,
        TaskStatusRepository $taskStatusRepository,
        DeleteTaskStatusAction $deleteTaskStatusAction
    ): RedirectResponse {
        $taskStatus = $taskStatusRepository->findById($id);

        if (!$taskStatus) {
            abort(404);
        }

        $result = $deleteTaskStatusAction->execute($taskStatus);

        if (!$result) {
            return redirect()
                ->route('task_statuses.index')
                ->with('error', __('task_statuses.cannot_delete'));
        }

        return redirect()
            ->route('task_statuses.index')
            ->with('success', __('task_statuses.deleted'));
    }
}
