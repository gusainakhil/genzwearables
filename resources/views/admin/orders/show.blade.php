@extends('admin.layout')

@section('title', 'Order Details')
@section('page-title', 'Order Details')

@section('content')
<div class="max-w-6xl">
    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-2"></i>Back to Orders
        </a>
    </div>

    <!-- Order Info -->
    <div class="grid grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Order Information</h3>
            <dl class="space-y-2">
                <div>
                    <dt class="text-sm text-gray-500">Order Number</dt>
                    <dd class="font-medium">{{ $order->order_number }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Order Date</dt>
                    <dd>{{ $order->created_at->format('M d, Y h:i A') }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Order Status</dt>
                    <dd>
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($order->order_status == 'delivered') bg-green-100 text-green-800
                            @elseif($order->order_status == 'cancelled') bg-red-100 text-red-800
                            @else bg-blue-100 text-blue-800
                            @endif">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </dd>
                </div>
            </dl>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Customer Information</h3>
            <dl class="space-y-2">
                <div>
                    <dt class="text-sm text-gray-500">Name</dt>
                    <dd class="font-medium">{{ $order->user->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Email</dt>
                    <dd>{{ $order->user->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Phone</dt>
                    <dd>{{ $order->user->phone ?? 'N/A' }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Payment Information</h3>
            <dl class="space-y-2">
                <div>
                    <dt class="text-sm text-gray-500">Payment Status</dt>
                    <dd>
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($order->payment_status == 'paid') bg-green-100 text-green-800
                            @elseif($order->payment_status == 'failed') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </dd>
                </div>
                @if($order->payment)
                <div>
                    <dt class="text-sm text-gray-500">Payment Method</dt>
                    <dd>{{ $order->payment->payment_method }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Transaction ID</dt>
                    <dd>{{ $order->payment->transaction_id ?? 'N/A' }}</dd>
                </div>
                @endif
            </dl>
        </div>
    </div>

    <!-- Shipping Address -->
    @if($order->address)
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Shipping Address</h3>
        <p class="text-gray-700">
            {{ $order->address->name }}<br>
            {{ $order->address->address }}<br>
            {{ $order->address->city }}, {{ $order->address->state }} {{ $order->address->pincode }}<br>
            {{ $order->address->country }}<br>
            Phone: {{ $order->address->phone }}
        </p>
    </div>
    @endif

    <!-- Order Items -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Order Items</h3>
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Size</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Color</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($order->items as $item)
                <tr>
                    <td class="px-4 py-3">{{ $item->product->name }}</td>
                    <td class="px-4 py-3">{{ $item->variant->size->name }}</td>
                    <td class="px-4 py-3">{{ $item->variant->color->name }}</td>
                    <td class="px-4 py-3">₹{{ number_format($item->price, 2) }}</td>
                    <td class="px-4 py-3">{{ $item->quantity }}</td>
                    <td class="px-4 py-3">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
                <tr class="font-medium">
                    <td colspan="5" class="px-4 py-3 text-right">Subtotal:</td>
                    <td class="px-4 py-3">₹{{ number_format($order->subtotal, 2) }}</td>
                </tr>
                @if($order->shipping)
                <tr>
                    <td colspan="5" class="px-4 py-3 text-right">Shipping:</td>
                    <td class="px-4 py-3">₹{{ number_format($order->shipping, 2) }}</td>
                </tr>
                @endif
                @if($order->discount)
                <tr>
                    <td colspan="5" class="px-4 py-3 text-right">Discount:</td>
                    <td class="px-4 py-3 text-red-600">-₹{{ number_format($order->discount, 2) }}</td>
                </tr>
                @endif
                <tr class="font-bold text-lg">
                    <td colspan="5" class="px-4 py-3 text-right">Total:</td>
                    <td class="px-4 py-3">₹{{ number_format($order->total, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Order Actions -->
    <div class="grid grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Update Order Status</h3>
            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="flex space-x-4">
                    <select name="order_status" class="flex-1 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                        <option value="placed" {{ $order->order_status == 'placed' ? 'selected' : '' }}>Placed</option>
                        <option value="packed" {{ $order->order_status == 'packed' ? 'selected' : '' }}>Packed</option>
                        <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="returned" {{ $order->order_status == 'returned' ? 'selected' : '' }}>Returned</option>
                    </select>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Update
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Update Payment Status</h3>
            <form action="{{ route('admin.orders.payment-status', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="flex space-x-4">
                    <select name="payment_status" class="flex-1 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                        <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Shipment Details -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Shipment Details</h3>
        
        @if($order->shipment)
            <dl class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <dt class="text-sm text-gray-500">Courier Name</dt>
                    <dd class="font-medium">{{ $order->shipment->courier_name }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Tracking Number</dt>
                    <dd class="font-medium">{{ $order->shipment->tracking_number }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Shipped Date</dt>
                    <dd>{{ $order->shipment->shipped_date ? $order->shipment->shipped_date->format('M d, Y') : 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Delivery Date</dt>
                    <dd>{{ $order->shipment->delivery_date ? $order->shipment->delivery_date->format('M d, Y') : 'N/A' }}</dd>
                </div>
            </dl>
        @endif

        <form action="{{ route('admin.orders.shipment', $order) }}" method="POST">
            @csrf
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Courier Name</label>
                    <input type="text" name="courier_name" value="{{ $order->shipment->courier_name ?? '' }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Tracking Number</label>
                    <input type="text" name="tracking_number" value="{{ $order->shipment->tracking_number ?? '' }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Shipped Date</label>
                    <input type="date" name="shipped_date" value="{{ $order->shipment?->shipped_date?->format('Y-m-d') ?? date('Y-m-d') }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                </div>
            </div>
            <button type="submit" class="mt-4 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                {{ $order->shipment ? 'Update' : 'Add' }} Shipment
            </button>
        </form>
    </div>
</div>
@endsection
