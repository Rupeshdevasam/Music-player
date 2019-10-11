<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Playlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
class PlaylistController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function store(Request $request)
    {

    	$this->validate($request, [
    		'name' => 'required|unique:files',
    		'public' => 'required',
    		'song'	=> 'required',
    		'place' => 'required',

    	]);
    	$model = new Playlist();

    	return $model::create([
    		'places' => $request['place'],
    		'name' => $request['name'],
    		'songs' => $request['song'],
    		'public' => $request['public'],
    		'user_id' => Auth::id()

    	]);
    }

    /**
     * Edit specific file
     * @param  integer  $id      File Id
     * @param  Request $request  Request with form data: filename
     * @return boolean           True if success, otherwise - false
     */
    public function edit(Request $request)
    {
    	$this->validate($request, [
    		'song' => 'required',
    		'place' => 'required',
    		'id' => 'required',
    	]);
    	$list = Playlist::where('id', $request['id'])->where('user_id', Auth::id())->first();
    	
    	$list->songs =$list->songs.'*'.$request['song'];
    	$list->places =$list->places.'*'.$request['place'];
    	return response()->json($list->save());

    }
    public function getPlaylistsMini()
    {
    	return Playlist::select('name','id')->where('user_id', Auth::id())->get();
    }
    public function getPlaylists()
    {
    	return Playlist::all()->where('user_id', Auth::id());
    }
}
