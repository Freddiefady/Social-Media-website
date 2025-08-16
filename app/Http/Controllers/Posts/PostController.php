<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\StorePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function store(StorePostRequest $request): RedirectResponse
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
     * @throws \Exception
     */
    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $post->update($request->validated());
            $delete_ids = $request->input('deleted_file_ids', []);
            // If there are attachments to delete, fetch them
            if (!empty($delete_ids)) {
                $attachments = $post->attachments()
                    ->where('post_id', $post->id)
                    ->whereIn('id', $delete_ids)
                    ->get();
            }
            // Delete attachments
            foreach ($attachments as $attachment) {
                $attachment->delete();
            }
            // Handle attachments if any
            $this->handleAttachments($request, $post);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
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
    private function handleAttachments($request, $post = null): void
    {
        if ($request->hasFile('attachments')) {
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
