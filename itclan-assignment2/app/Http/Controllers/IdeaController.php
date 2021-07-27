<?php

namespace App\Http\Controllers;

use App\Http\Requests\IdeaRequest;
use App\Jobs\SendAddIdeaEmailJob;
use App\Models\Idea;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ideas = Idea::latest()->get();
        $players = Idea::where('is_win', 2)->get();
        return view('ideas.index', compact('ideas', 'players'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $idea = null;
        return view('ideas.create', compact('idea'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param IdeaRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(IdeaRequest $request)
    {
        $idea = Idea::create($request->all());

        $details['name'] = $idea->name;
        $details['email'] = $idea->email;
//        dispatch(new SendAddIdeaEmailJob($details));

        return redirect()->route('ideas.index')->with('message', 'A new Idea added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Idea $idea
     * @return \Illuminate\Http\Response
     */
    public function edit(Idea $idea)
    {
        return view('ideas.create', compact('idea'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param IdeaRequest $request
     * @param Idea $idea
     * @return \Illuminate\Http\Response
     */
    public function update(IdeaRequest $request, Idea $idea)
    {
        $idea->update($request->all());
        return redirect()->route('ideas.index')->with('message', 'Idea updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Idea $idea
     * @return \Illuminate\Http\Response
     */
    public function destroy(Idea $idea)
    {
        $idea->delete();
        return back()->with('message', 'Idea deleted successfully!');
    }
}
