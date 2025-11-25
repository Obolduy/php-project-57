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
use App\Task\Models\Task;
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
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

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

    public function show(Task $task): ViewFactory|ViewContract
    {
        $task->load(['status', 'creator', 'assignedTo', 'labels']);

        return view('tasks.show', compact('task'));
    }

    public function edit(
        Task $task,
        TaskStatusRepository $taskStatusRepository,
        UserRepository $userRepository,
        LabelRepository $labelRepository
    ): ViewFactory|ViewContract {
        $this->authorize('update', $task);

        $task->load(['status', 'creator', 'assignedTo', 'labels']);

        $statuses = $taskStatusRepository->getAll();
        $users = $userRepository->getAll();
        $labels = $labelRepository->getAll();

        return view('tasks.edit', compact('task', 'statuses', 'users', 'labels'));
    }

    public function update(
        UpdateTaskRequest $request,
        Task $task,
        UpdateTaskAction $updateTaskAction
    ): RedirectResponse {
        $this->authorize('update', $task);

        /** @var TaskDTO $dto */
        $dto = TaskFactory::fromRequestValidated($request);

        $updateTaskAction->execute($task, $dto);

        return redirect()
            ->route('tasks.index')
            ->with('success', __('tasks.updated'));
    }

    public function destroy(
        Task $task,
        DeleteTaskAction $deleteTaskAction
    ): RedirectResponse {
        $this->authorize('delete', $task);

        $deleteTaskAction->execute($task);

        return redirect()
            ->route('tasks.index')
            ->with('success', __('tasks.deleted'));
    }
}
