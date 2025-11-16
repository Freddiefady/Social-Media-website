<?php

declare(strict_types=1);

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\PreviewUrlRequest;
use DOMDocument;
use Illuminate\Http\JsonResponse;

final class UrlPreviewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return array<string, string>|JsonResponse
     */
    public function __invoke(PreviewUrlRequest $request): array|JsonResponse
    {
        $url = $request->string('url')->toString();

        $html = file_get_contents($url);

        if ($html === false) {
            return response()->json([
                'error' => 'Failed to fetch URL content',
            ], 400);
        }

        $dom = new DOMDocument();

        // Suppress warnings for malformed HTML
        libxml_use_internal_errors(true);
        // Load HTML content into the DOMDocument
        $dom->loadHTML($html);
        // Restore handling to its previous state
        libxml_use_internal_errors(false);

        $metaTags = $dom->getElementsByTagName('meta');

        /** @var array<string, string> $ogTags */
        $ogTags = [];

        foreach ($metaTags as $metaTag) {
            $property = $metaTag->getAttribute('property');

            if (str_starts_with($property, 'og:')) {
                $ogTags[$property] = $metaTag->getAttribute('content');
            }
        }

        return $ogTags;
    }
}
