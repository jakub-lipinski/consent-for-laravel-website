<?php

namespace App\Http\Controllers;

use App\Documentation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DocumentationController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('docs.show', 'introduction');
    }

    public function show(string $page, Documentation $documentation): View
    {
        $metadata = $documentation->page($page);
        $rendered = $documentation->render($documentation->markdown($page));
        $pages = $documentation->pages();
        $position = array_search($page, array_column($pages, 'slug'), true);

        return view('docs.show', [
            ...$rendered,
            'page' => $metadata,
            'navigation' => $documentation->navigation(),
            'previous' => $pages[$position - 1] ?? null,
            'next' => $pages[$position + 1] ?? null,
        ]);
    }

    public function search(Documentation $documentation): JsonResponse
    {
        return response()->json($documentation->searchIndex());
    }
}
