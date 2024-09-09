<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;
use App\Helpers\ResponseCostum;
use App\Http\Resources\PaymentResource;
use Exception;

class PaymentController extends Controller
{
    public function getPaymentUser()
    {
        try {
            $user = auth()->user();
            $payments = Payment::whereHas('order', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
            return ResponseCostum::success(PaymentResource::collection($payments), 'Payment retrieved successfully', 200);
        } catch (Exception $e) {
            return ResponseCostum::error($e->getMessage(), 'Payment retrieval failed', 500);
        }
    }
    // get all payment
    public function index()
    {
        try {
            $payments = Payment::all();
            return ResponseCostum::success(PaymentResource::collection($payments), 'Payment retrieved successfully',200);
        } catch (Exception $e) {
            return ResponseCostum::error($e->getMessage(), 'Payment retrieval failed',500);
        }
    }
    //
    public function store(Request $request)
    {
        try {
            // Validate the request
            $validatedData = $request->validate([
                'order_id' => 'required|exists:orders,id',
                'payment_method' => 'required|string',
            ]);

            // Find the order
            $order = Order::findOrFail($validatedData['order_id']);

            // Create the payment
            $payment = new Payment($validatedData);
            $payment->amount = $order->total_amount; // Use the order's amount
            $payment->payment_date = now(); // Use current date and time
            $payment->status = 'pending'; // Set initial status as pending
            $payment->transaction_code = uniqid('PAY-');
            // Note: The payment is not saved to the database at this point

            // Process payment (this is a placeholder - implement actual payment processing logic)
            $paymentSuccessful = $this->processPayment($payment);

            if ($paymentSuccessful) {
                $payment->status = 'successful';
                $order->status = 'paid';
            } else {
                $payment->status = 'failed';
                $order->status = 'cancelled';
                
                // Add reason for failure
                $failureReason = $this->getPaymentFailureReason($payment);
                $payment->failure_reason = $failureReason;
            }

            $payment->save();
            $order->save();

            if ($paymentSuccessful) {
                return ResponseCostum::success($payment, 'Payment processed successfully for the order', 200);
            } else {
                return ResponseCostum::error($failureReason, 'Payment processing failed', 400);
            }
        } catch (Exception $e) {
            return ResponseCostum::error($e->getMessage(), 'Payment processing failed', 500);
        }
    }

    public function destroy($id)
    {
        try {
            $payment = Payment::findOrFail($id);
            $payment->delete();
            return ResponseCostum::success($payment, 'Payment deleted successfully', 200);
        } catch (Exception $e) {
            return ResponseCostum::error($e->getMessage(), 'Payment deletion failed', 500);
        }
    }
    private function processPayment(Payment $payment)
    {
        // Implement actual payment processing logic here
        // This is just a placeholder that randomly determines success or failure
        return rand(0, 1) === 1;
    }
}
