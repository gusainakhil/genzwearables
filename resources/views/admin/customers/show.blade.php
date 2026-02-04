@extends('admin.layout')

@section('title', 'Customer Details')
@section('page-title', 'Customer Details')

@section('content')
<div class="max-w-6xl">
    <div class="mb-6">
        <a href="{{ route('admin.customers.index') }}" class="text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-2"></i>Back to Customers
        </a>
    </div>

    <div class="grid grid-cols-3 gap-6 mb-6">
        <!-- Customer Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Customer Information</h3>
            <dl class="space-y-2">
                <div>
                    <dt class="text-sm text-gray-500">Name</dt>
                    <dd class="font-medium">{{ $customer->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Email</dt>
                    <dd>{{ $customer->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Phone</dt>
                    <dd>{{ $customer->phone ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Status</dt>
                    <dd>
                        <span class="px-2 py-1 text-xs rounded-full {{ $customer->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($customer->status) }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Joined</dt>
                    <dd>{{ $customer->created_at->format('M d, Y') }}</dd>
                </div>
            </dl>

            <form action="{{ route('admin.customers.status', $customer) }}" method="POST" class="mt-4">
                @csrf
                @method('PATCH')
                <label class="block text-gray-700 text-sm font-bold mb-2">Update Status</label>
                <div class="flex space-x-2">
                    <select name="status" class="flex-1 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                        <option value="active" {{ $customer->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $customer->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Update
                    </button>
                </div>
            </form>
        </div>

        <!-- Stats -->
        <div class="col-span-2 bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Statistics</h3>
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-blue-50 p-4 rounded">
                    <p class="text-sm text-gray-600">Total Orders</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $customer->orders->count() }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded">
                    <p class="text-sm text-gray-600">Total Spent</p>
                    <p class="text-2xl font-bold text-green-600">₹{{ number_format($customer->orders->where('payment_status', 'paid')->sum('total'), 2) }}</p>
                </div>
                <div class="bg-purple-50 p-4 rounded">
                    <p class="text-sm text-gray-600">Addresses</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $customer->addresses->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Addresses -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Addresses</h3>
        <div class="grid grid-cols-2 gap-4">
            @foreach($customer->addresses as $address)
                <div class="border rounded p-4 {{ $address->is_default ? 'border-blue-500 bg-blue-50' : '' }}">
                    @if($address->is_default)
                        <span class="inline-block bg-blue-600 text-white text-xs px-2 py-1 rounded mb-2">Default</span>
                    @endif
                    <p class="font-medium">{{ $address->name }}</p>
                    <p class="text-sm text-gray-600 mt-2">
                        {{ $address->address }}<br>
                        {{ $address->city }}, {{ $address->state }} {{ $address->pincode }}<br>
                        {{ $address->country }}<br>
                        Phone: {{ $address->phone }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Orders -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Order History</h3>
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Items</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($customer->orders as $order)
                <tr>
                    <td class="px-4 py-3">{{ $order->order_number }}</td>
                    <td class="px-4 py-3">{{ $order->created_at->format('M d, Y') }}</td>
                    <td class="px-4 py-3">{{ $order->items->count() }}</td>
                    <td class="px-4 py-3">₹{{ number_format($order->total, 2) }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($order->order_status == 'delivered') bg-green-100 text-green-800
                            @elseif($order->order_status == 'cancelled') bg-red-100 text-red-800
                            @else bg-blue-100 text-blue-800
                            @endif">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-800">
                            View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-3 text-center text-gray-500">No orders yet</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
