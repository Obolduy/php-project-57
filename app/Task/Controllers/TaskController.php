<?php

namespace App\Task\Controllers;

use App\Framework\Controllers\Controller;
use App\Label\Repositories\LabelRepository;
use App\Task\Actions\CreateTaskAction;
use App\Task\Actions\DeleteTaskAction;
use App\Task\Actions\UpdateTaskAction;
use App\Task\DTO\TaskDTO;
use App\Task\Factories\TaskFactory;
use App\Task\Factories\TaskFilterFactory;
use App\Task\Repositories\TaskRepository;
use App\Task\Requests\StoreTaskRequest;
use App\Task\Requests\UpdateTaskRequest;
use App\TaskStatus\Repositories\TaskStatusRepository;
use App\User\Repositories\UserRepository;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(
        Request $request,
        TaskRepository $taskRepository,
        TaskStatusRepository $taskStatusRepository,
        UserRepository $userRepository
    ): ViewFactory|ViewContract {
        $filters = TaskFilterFactory::fromRequest($request);
        $tasks = $taskRepository->getAll($filters);
        $statuses = $taskStatusRepository->getAll();
        $users = $userRepository->getAll();

        return view('tasks.index', compact('tasks', 'statuses', 'users'));
    }

    public function create(
        TaskStatusRepository $taskStatusRepository,
        UserRepository $userRepository,
        LabelRepository $labelRepository
    ): ViewFactory|ViewContract {
        $statuses = $taskStatusRepository->getAll();
        $users = $userRepository->getAll();
        $labels = $labelRepository->getAll();

        return view('tasks.create', compact('statuses', 'users', 'labels'));
    }

    public function store(StoreTaskRequest $request, CreateTaskAction $createTaskAction): RedirectResponse
    {
        /** @var TaskDTO $dto */
        $dto = TaskFactory::fromRequestValidated($request);
        $userId = Auth::id();
        
        if (!is_int($userId)) {
            abort(401, 'User must be authenticated');
        }
        
        $createTaskAction->execute($dto, $userId);

        return redirect()
            ->route('tasks.index')
            ->with('success', __('tasks.created'));
    }

    public function show(int $id, TaskRepository $taskRepository): ViewFactory|ViewContract
    {
        $task = $taskRepository->findById($id);

        if (!$task) {
            abort(404);
        }

        return view('tasks.show', compact('task'));
    }

    public function edit(
        int $id,
        TaskRepository $taskRepository,
        TaskStatusRepository $taskStatusRepository,
        UserRepository $userRepository,
        LabelRepository $labelRepository
    ): ViewFactory|ViewContract {
        $task = $taskRepository->findById($id);

        if (!$task) {
            abort(404);
        }

        $statuses = $taskStatusRepository->getAll();
        $users = $userRepository->getAll();
        $labels = $labelRepository->getAll();

        return view('tasks.edit', compact('task', 'statuses', 'users', 'labels'));
    }

    public function update(
        UpdateTaskRequest $request,
        int $id,
        TaskRepository $taskRepository,
        UpdateTaskAction $updateTaskAction
    ): RedirectResponse {
        $task = $taskRepository->findById($id);

        if (!$task) {
            abort(404);
        }

        /** @var TaskDTO $dto */
        $dto = TaskFactory::fromRequestValidated($request);

        $updateTaskAction->execute($task, $dto);

        return redirect()
            ->route('tasks.index')
            ->with('success', __('tasks.updated'));
    }

    public function destroy(
        int $id,
        TaskRepository $taskRepository,
        DeleteTaskAction $deleteTaskAction
    ): RedirectResponse {
        $task = $taskRepository->findById($id);

        if (!$task) {
            abort(404);
        }

        $userId = Auth::id();
        
        if (!is_int($userId)) {
            abort(401, 'User must be authenticated');
        }

        $result = $deleteTaskAction->execute($task, $userId);

        if (!$result) {
            return redirect()
                ->route('tasks.index')
                ->with('error', __('tasks.cannot_delete'));
        }

        return redirect()
            ->route('tasks.index')
            ->with('success', __('tasks.deleted'));
    }
}
