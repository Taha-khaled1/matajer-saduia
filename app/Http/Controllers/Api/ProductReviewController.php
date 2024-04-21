<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use App\Models\UserReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductReviewController extends Controller
{

    public function createReview(Request $request)
    {
        try {
            $validator =  Validator::make($request->all(), [
                'rating' => 'required|integer|min:1|max:5',
                'product_id' => 'required|integer',
                'review' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => __('custom.validation_error'), 'errors' => $validator->errors(), 'status_code' => 400], 400);
            }
            $review = new ProductReview();
            $review->product_id = $request->input('product_id');
            $review->user_id = $request->user->id; // Assuming you are using authentication
            $review->rating = $request->input('rating');
            $review->review = $request->input('review');
            $review->save();
            return successmMssageResponse(
                __('custom.review_added'),
                data: $review
            );
        } catch (\Exception $e) {
            return errorResponse(__('custom.review_problem'));
        }
    }
    public function createUserReview(Request $request)
    {
        try {
            $validator =  Validator::make($request->all(), [
                'rating' => 'required|integer|min:1|max:5',
                'vendor_id' => 'required|integer',
                'review' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => __('custom.validation_error'), 'errors' => $validator->errors(), 'status_code' => 400], 400);
            }
            $review = new UserReview();
            $review->vendor_id = $request->input('vendor_id');
            $review->user_id = $request->user->id; // Assuming you are using authentication
            $review->rating = $request->input('rating');
            $review->review = $request->input('review');
            $review->save();
            return successmMssageResponse(
                __('custom.review_added'),
                data: $review
            );
        } catch (\Exception $e) {
            return errorResponse(__('custom.review_problem'));
        }
    }
}
