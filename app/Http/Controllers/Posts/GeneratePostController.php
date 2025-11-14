<?php

declare(strict_types=1);

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Services\GenerateAiService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class GeneratePostController extends Controller
{
    public function __construct(private readonly GenerateAiService $generate) {}

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): Response
    {
        return $this->generate->__invoke($request->string('prompt')->toString());
    }
}
