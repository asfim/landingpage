<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    protected $fillable = ['name', 'content'];

    /**
     * Get the default landing page record, or create one from the fallback HTML file.
     */
    public static function getDefault(): self
    {
        return static::firstOrCreate(
            ['name' => 'default'],
            ['content' => static::fallbackHtml()]
        );
    }

    /**
     * Update or create the default landing page record.
     */
    public static function saveDefault(string $html): self
    {
        return static::updateOrCreate(
            ['name' => 'default'],
            ['content' => $html]
        );
    }

    /**
     * Load the fallback HTML from the project-root mystery-box.html.
     */
    protected static function fallbackHtml(): string
    {
        $path = resource_path('views/landing-page.blade.php');

        return file_exists($path)
            ? file_get_contents($path)
            : '<!DOCTYPE html><html><body><p>No landing page content found.</p></body></html>';
    }
}
