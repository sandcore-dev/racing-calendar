<?php

namespace App\Http\Controllers\Admin;

use App\Models\Template;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class TemplateController extends Controller
{
    public function index(): Response
    {
        return Inertia::render(
            'Admin/Template/Index',
            [
                'title' => Lang::get('Admin')
                    . ' - ' . Lang::get('Templates'),

                'labels' => [
                    'title' => Lang::get('Templates'),
                    'template' => Lang::get('Template'),
                ],

                'adminAddUrl' => route('admin.template.create'),

                'templates' => Template::paginate(),
            ]
        );
    }

    public function create(): Response
    {
        return Inertia::render(
            'Admin/Template/Form',
            [
                'title' => Lang::get('Admin')
                    . ' - ' . Lang::get('Add template'),

                'header' => Lang::get('Add template'),

                'url' => route('admin.template.store'),

                'labels' => [
                    'name' => Lang::get('Name'),
                    'submit' => Lang::get('Add'),
                ],
            ]
        );
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'name' => ['required', 'unique:templates,name'],
            ]
        );

        $template = Template::create($request->only('name'));

        return Redirect::route('admin.template.index')
            ->with('success', __('The template :name has been added.', ['name' => $template->name]));
    }

    public function edit(Template $template): Response
    {
        return Inertia::render(
            'Admin/Template/Form',
            [
                'title' => Lang::get('Admin')
                    . ' - ' . Lang::get('Edit template :template', ['template' => $template->name]),

                'header' => Lang::get('Edit template :template', ['template' => $template->name]),

                'edit' => true,
                'url' => route('admin.template.update', ['template' => $template]),

                'labels' => [
                    'name' => Lang::get('Name'),
                    'submit' => Lang::get('Edit'),
                ],

                'data' => $template->only(['name']),
            ]
        );
    }

    public function update(Request $request, Template $template): RedirectResponse
    {
        $request->validate(
            [
                'name' => ['required', 'unique:templates,name,' . $template->id],
            ]
        );

        $template->update($request->only('name'));

        return Redirect::route('admin.template.index')
            ->with('success', __('The template :name has been edited.', ['name' => $template->name]));
    }
}
