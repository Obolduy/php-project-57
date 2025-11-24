<?php

namespace App\Label\Controllers;

use App\Framework\Controllers\Controller;
use App\Label\Actions\CreateLabelAction;
use App\Label\Actions\DeleteLabelAction;
use App\Label\Actions\UpdateLabelAction;
use App\Label\DTO\LabelDTO;
use App\Label\Factories\LabelFactory;
use App\Label\Repositories\LabelRepository;
use App\Label\Requests\StoreLabelRequest;
use App\Label\Requests\UpdateLabelRequest;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\RedirectResponse;

class LabelController extends Controller
{
    public function index(LabelRepository $labelRepository): ViewFactory|ViewContract
    {
        $labels = $labelRepository->getAll();

        return view('labels.index', compact('labels'));
    }

    public function create(): ViewFactory|ViewContract
    {
        return view('labels.create');
    }

    public function store(StoreLabelRequest $request, CreateLabelAction $createLabelAction): RedirectResponse
    {
        /** @var LabelDto $dto */
        $dto = LabelFactory::fromRequestValidated($request);

        $createLabelAction->execute($dto);

        return redirect()
            ->route('labels.index')
            ->with('success', __('labels.created'));
    }

    public function edit(int $id, LabelRepository $labelRepository): ViewFactory|ViewContract
    {
        $label = $labelRepository->findById($id);

        if ($label === null) {
            abort(404);
        }

        return view('labels.edit', compact('label'));
    }

    public function update(
        UpdateLabelRequest $request,
        int $id,
        LabelRepository $labelRepository,
        UpdateLabelAction $updateLabelAction
    ): RedirectResponse {
        $label = $labelRepository->findById($id);

        if ($label === null) {
            abort(404);
        }

        /** @var LabelDto $dto */
        $dto = LabelFactory::fromRequestValidated($request);

        $updateLabelAction->execute($label, $dto);

        return redirect()
            ->route('labels.index')
            ->with('success', __('labels.updated'));
    }

    public function destroy(
        int $id,
        LabelRepository $labelRepository,
        DeleteLabelAction $deleteLabelAction
    ): RedirectResponse {
        $label = $labelRepository->findById($id);

        if ($label === null) {
            abort(404);
        }

        $result = $deleteLabelAction->execute($label);

        if (!$result) {
            return redirect()
                ->route('labels.index')
                ->with('error', __('labels.cannot_delete'));
        }

        return redirect()
            ->route('labels.index')
            ->with('success', __('labels.deleted'));
    }
}
