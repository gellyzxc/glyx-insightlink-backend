<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkRequest;
use App\Http\Resources\LinkResource;
use App\Models\Link;
use App\Models\RouteSetting;
use App\Services\LinkService;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    protected LinkService $linkService;

    public function __construct(LinkService $linkService)
    {
        $this->linkService = $linkService;
    }

    public function index()
    {
        $links = Link::all();

        return LinkResource::collection($links->load('settings.linkRouteSettings.routeSetting'));
    }

    public function handle($shortcut, Request $request)
    {
        $link = Link::where('shortcut', $shortcut)->firstOrFail();


        if (!$request->cookie('session_id')) {
            $sessionId = (string) \Str::uuid();
            cookie()->queue('session_id', $sessionId, 60 * 24 * 365);
        }

        $redirectUrl = $this->linkService->getRedirectLink($link);

        return redirect()->away($redirectUrl);
    }

    public function store(LinkRequest $request)
    {
        $link = $this->linkService->createLink($request->validated());

        return LinkResource::make($link->load('settings.linkRouteSettings'));
    }

    public function show(Link $link)
    {
        $link = cache()->remember("link:{$link->id}", 60 * 24 * 365, function () use ($link) {
            return $link->load('settings.linkRouteSettings.routeSetting');
        });

        return LinkResource::make($link);
    }

    public function update(LinkRequest $request, Link $link)
    {
        $link = $this->linkService->updateLink($link, $request->validated());

        return LinkResource::make($link->load('settings.linkRouteSettings'));
    }

    public function destroy(Link $link)
    {
        $link->delete();

        return response()->json();
    }
}
