<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class OrderController extends Controller
{
    //
    public function index()
    {
        //
        // $order = order::all();
        // $detail = orderDetail::all();
        // return response()->json(['order_id'=>$order->order_id, 'user_id'=>$order->user_id, 'detail'=>$detail]);
        $order = DB::table('orders')
                        ->leftJoin('order_details', 'orders.order_id', '=', 'order_details.order_id')
                        ->select('orders.order_id', 'orders.total', 'order_details.product_id','order_details.amount')
                        ->get();
        return $order;
    }

    public function createOrder(Request $request)
    {
        $order = new Order;
        $order->order_id = $request->order_id;
        $order->user_id = $request->user_id;
        $order->total = $request->total;
        // return $request;
        if($order->save()){
            foreach($request->detail as $d) {
                $detail = new OrderDetail;
                $detail->order_id = $order->order_id;
                $detail->product_id = $d['product_id'];
                $detail->amount = $d['amount'];
                $detail->total = $d['total'];
                $detail->save();
            }
            return 'Success';
        }else{
            return 'error';
        }     
    }

    public function deleteOrder(Request $request)
    {
        $data = Order::select('*')->where('order_id', $request->order_id)->latest('created_at')->first();
        // return response()->json($data);
        if($data){
            $data->delete(); 
            $detail = OrderDetail::select('*')->where('order_id', $request->order_id);
            $detail->delete();
        }else{
            return response()->json(['Status' => 'error']);
        }
        return response()->json(['Status' => 'Success', 'Data' => null]); 

    }

    public function updateOrder(Request $request)
    {
        $order= Order::select('*')->where('order_id', $request->order_id)->latest('created_at')->first();
        // return $order;
        if($order->update($request->all())){
            $detail = OrderDetail::select('*')->where('order_id', $request->order_id);
            $detail->delete();
            foreach($request->detail as $d) {
                $detail = new OrderDetail;
                $detail->order_id = $order->order_id;
                $detail->product_id = $d['product_id'];
                $detail->amount = $d['amount'];
                $detail->total = $d['total'];
                $detail->save();
            }
            return 'Success';
        }else{
            return 'Error';
        }
      
    }
}
