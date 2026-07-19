<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LandingPageController extends Controller
{
    /**
     * Path where the landing page HTML is stored (relative to storage/app).
     */
    protected string $storagePath = 'landing-page/index.html';

    /**
     * Show a full preview of the landing page.
     */
    public function view()
    {
        $html = $this->getHtml();
        return view('admin.landing-page.view', compact('html'));
    }

    /**
     * Show the landing page editor.
     */
    public function edit()
    {
        $html = $this->getHtml();
        return view('admin.landing-page.edit', compact('html'));
    }

    /**
     * Save the updated landing page HTML.
     */
    public function update(Request $request)
    {
        $request->validate([
            'html' => ['required', 'string'],
        ]);

        Storage::put($this->storagePath, $request->input('html'));

        return response()->json(['success' => true, 'message' => 'Landing page saved successfully!']);
    }

    /**
     * Serve the raw landing page HTML (used by the preview iframe).
     */
    public function serve()
    {
        $html = $this->getHtml();
        return response($html, 200)->header('Content-Type', 'text/html; charset=UTF-8');
    }

    /**
     * Read HTML from storage, falling back to the default file.
     */
    protected function getHtml(): string
    {
        if (Storage::exists($this->storagePath)) {
            return Storage::get($this->storagePath);
        }

        // Fall back to the project-root mystery-box.html
        $fallback = base_path('mystery-box.html');
        if (file_exists($fallback)) {
            return file_get_contents($fallback);
        }

        return '<!DOCTYPE html><html><body><p>No landing page found.</p></body></html>';
    }
}
