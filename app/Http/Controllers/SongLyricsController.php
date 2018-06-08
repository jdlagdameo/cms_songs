<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App;
use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\SongLyricsCreateRequest;
use App\Http\Requests\SongLyricsUpdateRequest;
use App\Repositories\SongLyricsRepository;
use App\Validators\SongLyricsValidator;
use App\Transformers\SongLyricsTransformer;
use DataTables;

/**
 * Class SongLyricsController
 * @package App\Http\Controllers
 */
class SongLyricsController extends Controller
{
    /**
     * @var SongLyricsRepository
     */
    protected $repository;

    /**
     * @var SongLyricsValidator
     */
    protected $validator;

    /**
     * SongLyricsController constructor.
     *
     * @param SongLyricsRepository $repository
     * @param SongLyricsValidator $validator
     */
    public function __construct(SongLyricsRepository $repository, SongLyricsValidator $validator, Request $request)
    {
        $this->repository = $repository;
        $this->validator = $validator;

        if ($request->is('api/*')) {
            $this->middleware('auth:api');
        } else {
            $this->middleware('auth');
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin/song_lyrics.index', compact('songLyrics'));
    }

    /**
     * Datatables Data
     * @param DataTables $datatable
     * @return mixed
     */
    public function TableData(DataTables $datatable)
    {
        $song_lyrics = App\Entities\SongLyrics::select('*');

        return DataTables::eloquent($song_lyrics)
            ->setTransformer(new SongLyricsTransformer())->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SongLyricsCreateRequest $request
     * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(SongLyricsCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $song_lyric = $this->repository->create($request->all());

            $response = [
                'success' => true,
                'message' => 'Song Lyrics successfully created.',
                'data' => $song_lyric->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function show($id)
    {
        $songLyric = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $songLyric,
            ]);
        }

        return view('songLyrics.show', compact('songLyric'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $songLyric = $this->repository->find($id);

        return view('songLyrics.edit', compact('songLyric'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SongLyricsUpdateRequest $request
     * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(SongLyricsUpdateRequest $request)
    {

        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $song_lyric = $this->repository->update($request->all(), $request->id);
            $response = [
                'success' => true,
                'message' => 'Song Lyrics successfully updated.',
                'data' => $song_lyric->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Song Lyrics successfully deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Year deleted.');
    }
}
