<?php

namespace App\Http\Controllers;
use JWTAuth;
use App\Models\Topic;
use App\Models\Tselect;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function index()
    {
        $topics = $this->user->topics()->get(["id", "topic_name", "user_id"])->toArray();

        return $topics;
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            "topic_name" => "required",
        ]);

        $topic = new Topic();
        $topic->topic_name = $request->topic_name;

        if ($this->user->topics()->save($topic)) {
            return response()->json([
                "status" => true,
                "topic" => $topic
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Ops, Topic could not be saved."
            ], 500);
        }
    }


    public function show($id)
    {
        //
        $topic = Topic::find($id);
    
        if ($topic) {
            return response()->json([
                "status" => true,
                "topic" => $topic
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Ops, topic id = $id not found."
            ]);
        }
    }

    public function selectedTopic(Request $request)
    {
        $this->validate($request, [
            "u_id" => "required",
            "topic_id" => "required",
        ]);

        foreach($request->topic_id as $tpc){
            $tselect = new Tselect();
            $tselect->user_id = $request->u_id;
            $tselect->topic_id =  $tpc;
            $tselectSave = $tselect->save();
        }
        if ($tselectSave){
            return response()->json([
                "status" => true,
                "message" => "your selected topic is saved."
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Ops, select topic could not be saved."
            ], 500);
        }
    }
}
