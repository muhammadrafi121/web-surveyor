<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('feedback', [
            'title' => 'Bantuan',
            'script' => 'feedback',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'desc' => 'required',
        ];

        if ($request->has('title')) {
            $rules['title'] = 'required';
        }

        $request->validate($rules);

        $feedback = [
            'text' => $request->desc,
            'target' => $request->target,
            'user_id' => auth()->user()->id,
        ];

        if ($request->has('title')) {
            $feedback['title'] = $request->title;
        }

        if ($request->has('parent')) {
            $feedback['parent_id'] = $request->parent;
        }

        Feedback::create($feedback);

        if ($request->filled('url')) {
            return redirect($request->url)->with('message', 'Pesan Telah terkirim');
        }

        if ($request->target == 'admin') {
            return redirect('/feedback/admin')->with('message', 'Pesan Telah terkirim');
        }

        if ($request->target == 'all') {
            return redirect('/feedback/all')->with('message', 'Pesan Telah terkirim');
        }
    }

    public function showAdminMsg()
    {
        $messages = Feedback::where('target', 'admin')
            ->where('parent_id', null)
            ->orderBy('created_at', 'desc')
            ->get();

        if (auth()->user()->role != 'Administrator') {
            $messages = Feedback::where('target', 'admin')
                ->where('parent_id', null)
                ->where('user_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('listfeedback', [
            'title' => 'Entri Pesan',
            'messages' => $messages,
            'script' => 'message',
        ]);
    }

    public function showForum()
    {
        $messages = Feedback::where('target', 'all')
            ->where('parent_id', null)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('listfeedback', [
            'title' => 'Entri Pesan',
            'messages' => $messages,
            'script' => 'message',
        ]);

        return $messages;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show(Feedback $feedback)
    {
        return view('detailfeedback', [
            'title' => 'Entri Pesan',
            'feedback' => $feedback,
            'script' => 'message',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function edit(Feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feedback $feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feedback $feedback)
    {
        //
    }
}
