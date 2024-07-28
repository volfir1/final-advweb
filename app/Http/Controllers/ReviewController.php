<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    public function history()
    {
        try {
            $user = Auth::user();
            // Fetch completed orders and their review status
            $orders = Order::with(['products'])
                ->where('customer_id', $user->id)
                ->where('status', 'completed')
                ->get();

            $reviews = $orders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'status' => 'not_reviewed', // Assuming 'not_reviewed' for simplicity
                    'product' => $order->products->map(function ($product) {
                        return [
                            'id' => $product->id, // Include product ID
                            'image_url' => $product->image_url,
                            'name' => $product->name,
                            'description' => $product->description
                        ];
                    })
                ];
            });

            return response()->json(['reviews' => $reviews]);
        } catch (\Exception $e) {
            Log::error('Error in ReviewController@history: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching your reviews.'], 500);
        }
    }
    public function showReviewForm($orderId)
    {
        $order = Order::findOrFail($orderId);
        $product = $order->product;

        return view('myreviews', compact('product', 'order'));
    }

    public function store(Request $request)
    {
        Log::info($request->all());
        $this->validate($request, [
            'rate' => 'required|integer|min:1|max:10',
            'comment' => 'required|string|min:3',
            'order_id' => 'required|integer|exists:orders,id',
            'product_id' => 'required|integer|exists:products,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $review = new Review();
            $review->rate = $request->input('rate');
            $review->comment = $request->input('comment');
            $review->order_id = $request->input('order_id');
            $review->product_id = $request->input('product_id');
            $review->customer_id = Auth::id();
            if ($request->hasFile('image')) {
                $review->image = $request->file('image')->store('images', 'public');
            }
            $review->save();

            // Update the review status
            $review->status = 'reviewed';
            $review->save();

            return response()->json(['message' => 'Review submitted successfully']);
        } catch (\Exception $e) {
            Log::error('Error in submitting review: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while submitting your review.'], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'review_id' => 'required|exists:reviews,id',
            'status' => 'required|in:not_reviewed,reviewed',
        ]);

        $review = Review::find($request->review_id);
        $review->status = $request->status;
        $review->save();

        return response()->json(['success' => true]);
    }
}