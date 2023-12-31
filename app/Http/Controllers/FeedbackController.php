<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\feedbacks;

class FeedbackController extends Controller
{
    //
    function add(Request $req)
    {
        $feedback = new feedbacks;
        $feedback->name = $req->name;
        $feedback->title = $req->title;
        $feedback->body = $req->body;
        if($feedback)
        {
            $feedback->save();
            return ["success"=>"Feedback added successfully."];
        }
        else{
            return ["error"=>"Feedback add to failed!"];
        }
    }
    function all()
    {
        $feedbacks = feedbacks::all();
        $result = ['feedbacks' => $feedbacks];
        return $result;
    }
}
