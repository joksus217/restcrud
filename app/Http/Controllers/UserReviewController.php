<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\UserReview;

class UserReviewController extends Controller
{   
    public function __construct(Request $request){
        
    }

    public function getAll(){
        $review = UserReview::all();

        if($review){
            $res = [
                'status' => 'success',
                'data' => $review
            ];
        } else {
            $res = [
                'status' => 'failed'
            ];
        }

        return $res;
    }

    public function insert(Request $request){
        $review = New UserReview();

        $validate = $this->validateInput($request);
        if($validate){
            return $validate;
        }

        $review->order_id = $request->input('order_id');
        $review->product_id = $request->input('product_id');
        $review->user_id = $request->input('user_id');
        $review->rating = $request->input('rating');
        $review->review = $request->input('review');

        if($review->save()){
            $res = [
                'status' => 'success'
            ];
        } else {
            $res = [
                'status' => 'failed'
            ];
        }

        return $res;
    }

    public function update(Request $request, $id){
        $review = UserReview::find($id);

        if($review) {
            $validate = $this->validateInput($request);
            if($validate){
                return $validate;
            }

            $review->order_id = $request->input('order_id');
            $review->product_id = $request->input('product_id');
            $review->user_id = $request->input('user_id');
            $review->rating = $request->input('rating');
            $review->review = $request->input('review');

            if($review->save()){
                $res = [
                    'status' => 'success'
                ];
            } else {
                $res = [
                    'status' => 'failed'
                ];
            }
        } else {
            $res = [
                    'status' => 'failed',
                    'messege' => 'not found'
                ];
        }
        

        return $res;
    }

    public function delete($id){
        $review = UserReview::find($id);

        if($review && $review->delete()){
            $res = [
                'status' => 'success'
            ];
        } else {
            $res = [
                'status' => 'failed'
            ];
        }

        return $res;
    }

    private function validateInput($request) {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer',
            'product_id' => 'required|integer',
            'user_id' => 'required|integer',
            'rating' => 'required|integer|between:1,5',
            'review' => 'required'
        ]);

        if($validator->fails()){
            $errors = $validator->errors();

            $res = [
                'status' => 'failed',
                'messege' => $validator->messages()->first()
            ];

            return $res;
        } else {
            return false;
        }
    }
}
