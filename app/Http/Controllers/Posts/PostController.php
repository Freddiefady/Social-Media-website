<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\CreatePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function store(CreatePostRequest $request)
    {
        DB::beginTransaction();
        try {
            $post = auth()->user()->posts()->create($request->validated());
            // Handle attachments if any
            $this->handleAttachments($request, $post);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->validated());

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (auth()->user()->id !== $post->user_id) {
            return response("You don't have permission to delete this post.", 403);
        }

        $post->delete();
        return back();
    }

    /**
     * @param $post
     * @return void
     * @Exception \Exception
     */
    public function handleAttachments($request, $post = null): void
    {
        if ($request->has('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filePath = $file->store('attachments/' . $post->id, 'public');
                $post->attachments()->create([
                    'path' => $filePath,
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                    'created_by' => auth()->id(),
                ]);
            }
        }
        DB::commit();
    }
}
