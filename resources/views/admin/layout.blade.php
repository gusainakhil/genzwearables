<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - GenZ Wearables</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
    <style>
        .sidebar-link.active {
            background-color: #3b82f6;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white flex-shrink-0 overflow-y-auto">
            <div class="p-6">
                <h1 class="text-2xl font-bold">GenZ Wearables</h1>
                <p class="text-sm text-gray-400">Admin Panel</p>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home mr-3"></i>
                    Dashboard
                </a>
                
                <a href="{{ route('admin.categories.index') }}" class="sidebar-link flex items-center px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-folder mr-3"></i>
                    Categories
                </a>
                
                <a href="{{ route('admin.products.index') }}" class="sidebar-link flex items-center px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fas fa-box mr-3"></i>
                    Products
                </a>
                
                <a href="{{ route('admin.orders.index') }}" class="sidebar-link flex items-center px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart mr-3"></i>
                    Orders
                </a>
                
                <a href="{{ route('admin.customers.index') }}" class="sidebar-link flex items-center px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                    <i class="fas fa-users mr-3"></i>
                    Customers
                </a>
                
                <a href="{{ route('admin.coupons.index') }}" class="sidebar-link flex items-center px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                    <i class="fas fa-tag mr-3"></i>
                    Coupons
                </a>
                
                <a href="{{ route('admin.sizes.index') }}" class="sidebar-link flex items-center px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('admin.sizes.*') ? 'active' : '' }}">
                    <i class="fas fa-ruler mr-3"></i>
                    Sizes
                </a>
                
                <a href="{{ route('admin.colors.index') }}" class="sidebar-link flex items-center px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('admin.colors.*') ? 'active' : '' }}">
                    <i class="fas fa-palette mr-3"></i>
                    Colors
                </a>
                
                <a href="{{ route('admin.reviews.index') }}" class="sidebar-link flex items-center px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                    <i class="fas fa-star mr-3"></i>
                    Reviews
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm z-10">
                <div class="flex items-center justify-between px-6 py-4">
                    <h2 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">{{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
