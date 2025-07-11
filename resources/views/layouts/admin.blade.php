<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') | SELLEASE LIMITED</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/favicon.png">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            300: '#c4b5fd',
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95',
                        }
                    }
                }
            }
        }
    </script>
    
    @stack('styles')
</head>
<body class="h-full bg-gray-50 font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Top Navigation -->
        <header class="bg-white shadow-sm z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <!-- Mobile menu button -->
                    <div class="flex md:hidden">
                        <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-900 hover:bg-gray-100 focus:outline-none" id="mobile-menu-button">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                    
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <div class="text-xl font-bold bg-gradient-to-r from-primary-600 to-primary-800 bg-clip-text text-transparent">
                            SellEase
                        </div>
                    </div>
                    
                    <!-- Right side controls -->
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <!-- <button class="p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none relative">
                            <span class="sr-only">View notifications</span>
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button> -->
                        
                        <!-- User Profile -->
                        <div class="relative ml-3">
                            <button class="flex items-center text-sm rounded-full focus:outline-none" id="user-menu-button">
                                <span class="sr-only">Open user menu</span>
                                <div class="flex items-center">
                                    <span class="hidden md:inline mr-2 text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                                    <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-800">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                </div>
                            </button>
                            
                            <!-- User Dropdown -->
                            <div class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" id="user-menu">
<!--                                 <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your Profile</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a> -->
                                <a href="{{ route('admin.logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Sign out
                                </a>
                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area with Sidebar -->
        <div class="flex flex-1 overflow-hidden">
            <!-- Mobile sidebar (hidden on desktop) -->
            <div class="md:hidden fixed inset-0 z-40" id="mobile-sidebar-backdrop" style="display: none;">
                <div class="fixed inset-0 bg-gray-600 bg-opacity-75" id="mobile-sidebar-overlay"></div>
                <div class="fixed inset-y-0 left-0 max-w-xs w-full bg-white shadow transform transition ease-in-out duration-300 -translate-x-full" id="mobile-sidebar">
                    <div class="flex flex-col h-full py-4">
                        <div class="flex items-center justify-between px-4 mb-4">
                            <div class="text-lg font-semibold text-primary-800">Menu</div>
                            <button class="p-2 rounded-md text-gray-500 hover:text-gray-900 hover:bg-gray-100 focus:outline-none" id="close-mobile-sidebar">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="flex-1 overflow-y-auto">
                            <nav class="px-2 space-y-1">
                                <ul class="space-y-2">
                                    <li>
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-white bg-purple-700/50 hover:bg-purple-700/70 transition-all duration-200">
                                            <i class="fas fa-tachometer-alt w-5 text-center"></i>
                                            <span>Dashboard</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.products.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-purple-200 hover:text-white hover:bg-purple-700/30 transition-all duration-200">
                                            <i class="fas fa-box w-5 text-center"></i>
                                            <span>Products</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.orders.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-purple-200 hover:text-white hover:bg-purple-700/30 transition-all duration-200">
                                            <!-- <i class="fas fa-shopping-cart w-5 text-center"></i> -->
                                            <span>Orders</span>
                                         
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.categories.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-purple-200 hover:text-white hover:bg-purple-700/30 transition-all duration-200">
                                            <i class="fas fa-tags w-5 text-center"></i>
                                            <span>Categories</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.contact.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-purple-200 hover:text-white hover:bg-purple-700/30 transition-all duration-200">
                                            <i class="fas fa-tags w-5 text-center"></i>
                                            <span>Contacts</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Desktop Sidebar -->
            <div class="hidden md:flex md:flex-shrink-0">
                <div class="flex flex-col w-64 border-r border-gray-200 bg-white">
                    <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                        <!-- Logo -->
                        <div class="flex items-center justify-center px-4 mb-6">
                            <div class="text-xl font-bold bg-gradient-to-r from-primary-600 to-primary-800 bg-clip-text text-transparent">
                                Sellease LIMITED
                            </div>
                        </div>
                        
                        <!-- Navigation -->
                        <nav class="px-2 space-y-1">
                            <!-- Dashboard Link -->
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-white bg-purple-700/50 hover:bg-purple-700/70 transition-all duration-200">
                                        <i class="fas fa-tachometer-alt w-5 text-center"></i>
                                        <span>Dashboard</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.products.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-purple-200 hover:text-white hover:bg-purple-700/30 transition-all duration-200">
                                        <i class="fas fa-box w-5 text-center"></i>
                                        <span>Products</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.orders.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-purple-200 hover:text-white hover:bg-purple-700/30 transition-all duration-200">
                                        <i class="fas fa-shopping-cart w-5 text-center"></i>
                                        <span>Orders</span>
                                        <!-- <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">5 new</span> -->
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.categories.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-purple-200 hover:text-white hover:bg-purple-700/30 transition-all duration-200">
                                        <i class="fas fa-tags w-5 text-center"></i>
                                        <span>Categories</span>
                                    </a>
                                </li>
                                 <li>
                                        <a href="{{ route('admin.contact.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-purple-200 hover:text-white hover:bg-purple-700/30 transition-all duration-200">
                                            <i class="fas fa-tags w-5 text-center"></i>
                                            <span>Contacts</span>
                                        </a>
                                    </li>
                            </ul>
                        </nav>
                    </div>
                    
                    <!-- Sidebar footer -->
                    <div class="flex-shrink-0 flex border-t border-gray-200 p-4">
                        <div class="flex items-center">
                            <div class="h-9 w-9 rounded-full bg-primary-100 flex items-center justify-center text-primary-800 mr-3">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</div>
                                <a href="{{ route('admin.logout') }}" class="text-xs font-medium text-gray-500 hover:text-primary-600"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Sign out
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto focus:outline-none bg-gray-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                        <p>{{ session('error') }}</p>
                    </div>
                    @endif
                    @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                        <p>{{ session('success') }}</p>
                    </div>
                    @endif
                    <!-- Page heading -->
                    <div class="mb-6 flex justify-between items-center">
                        <h1 class="text-2xl font-bold text-gray-900">@yield('heading', 'Dashboard')</h1>
                        <div class="flex items-center space-x-2 text-sm text-gray-500">
                            <i class="fas fa-clock"></i>
                            <span id="current-time">{{ now()->format('l, F j, Y g:i A') }}</span>
                        </div>
                    </div>
                    
                    <!-- Page content -->
                    @yield('content')
                </div>
            </main>
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-sm text-gray-500 mb-2 md:mb-0">
                        &copy; {{ date('Y') }} SELLEASE. All rights reserved.
                    </div>
                    <!-- <div class="flex space-x-4">
                        <a href="#" class="text-sm text-gray-500 hover:text-primary-600">Privacy Policy</a>
                        <a href="#" class="text-sm text-gray-500 hover:text-primary-600">Terms of Service</a>
                        <a href="#" class="text-sm text-gray-500 hover:text-primary-600">Contact Us</a>
                    </div> -->
                </div>
            </div>
        </footer>
    </div>

    <!-- JavaScript -->
    <script>
        // Update time every second
        function updateTime() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            document.getElementById('current-time').textContent = now.toLocaleString('en-US', options);
        }
        setInterval(updateTime, 1000);
        
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const backdrop = document.getElementById('mobile-sidebar-backdrop');
            const sidebar = document.getElementById('mobile-sidebar');
            backdrop.style.display = 'block';
            setTimeout(() => {
                sidebar.classList.remove('-translate-x-full');
            }, 10);
        });
        
        document.getElementById('close-mobile-sidebar').addEventListener('click', function() {
            closeMobileSidebar();
        });
        
        document.getElementById('mobile-sidebar-overlay').addEventListener('click', function() {
            closeMobileSidebar();
        });
        
        function closeMobileSidebar() {
            const backdrop = document.getElementById('mobile-sidebar-backdrop');
            const sidebar = document.getElementById('mobile-sidebar');
            sidebar.classList.add('-translate-x-full');
            setTimeout(() => {
                backdrop.style.display = 'none';
            }, 300);
        }
        
        // Dropdown menus
        document.getElementById('user-menu-button').addEventListener('click', function() {
            document.getElementById('user-menu').classList.toggle('hidden');
        });
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('user-menu');
            const userMenuButton = document.getElementById('user-menu-button');
            
            if (userMenu && userMenuButton && !userMenu.contains(event.target)) {
                if (!userMenuButton.contains(event.target)) {
                    userMenu.classList.add('hidden');
                }
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
