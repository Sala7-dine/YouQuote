<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TagController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Tag::class);
        $tags = Tag::all();
        return response()->json($tags);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Tag::class);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags'
        ]);

        $tag = Tag::create($validated);
        return response()->json($tag, 201);
    }

    public function show(Tag $tag)
    {
        $this->authorize('view', $tag);
        return response()->json($tag);
    }

    public function update(Request $request, Tag $tag)
    {
        $this->authorize('update', $tag);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id
        ]);

        $tag->update($validated);
        return response()->json($tag);
    }

    public function destroy(Tag $tag)
    {
        $this->authorize('delete', $tag);
        $tag->delete();
        return response()->json(null, 204);
    }

    public function attachToQuote(Request $request, Tag $tag)
    {
        $this->authorize('update', $tag);
        $validated = $request->validate([
            'quote_id' => 'required|exists:quotes,id'
        ]);

        $tag->quotes()->attach($validated['quote_id']);
        return response()->json(['message' => 'Tag attached successfully']);
    }

    public function detachFromQuote(Request $request, Tag $tag)
    {
        $this->authorize('update', $tag);
        $validated = $request->validate([
            'quote_id' => 'required|exists:quotes,id'
        ]);

        $tag->quotes()->detach($validated['quote_id']);
        return response()->json(['message' => 'Tag detached successfully']);
    }
}
