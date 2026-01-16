<div>
    <!-- Header -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-black text-white tracking-tight">Order Management</h2>
                <p class="mt-1 text-sm text-gray-400">Track and manage customer orders</p>
            </div>
            <button wire:click="exportCSV" class="px-6 py-2.5 bg-green-600 hover:bg-green-500 text-white font-bold rounded-xl transition-all flex items-center gap-2 shadow-lg shadow-green-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export CSV
            </button>
        </div>
    </div>

    <!-- Content Card -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-dark-800 border border-gray-700/50 rounded-2xl overflow-hidden shadow-xl">
            <!-- Filters -->
            <div class="p-6 border-b border-gray-700/50 space-y-4 lg:space-y-0 lg:flex lg:items-center lg:justify-between gap-4">
                <div class="flex-1 max-w-md relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input 
                        wire:model.live.debounce.300ms="searchTerm" 
                        type="text" 
                        placeholder="Search by order number..." 
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-700 rounded-xl leading-5 bg-dark-900 text-gray-300 placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 sm:text-sm transition-colors duration-200"
                    >
                </div>
                
                <div class="flex flex-wrap items-center gap-4">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-gray-500 uppercase">Dari:</span>
                        <input type="date" wire:model.live="dateFrom" class="bg-dark-900 border border-gray-700 rounded-lg px-2 py-1.5 text-xs text-gray-300 focus:ring-1 focus:ring-indigo-500">
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-gray-500 uppercase">Sampai:</span>
                        <input type="date" wire:model.live="dateTo" class="bg-dark-900 border border-gray-700 rounded-lg px-2 py-1.5 text-xs text-gray-300 focus:ring-1 focus:ring-indigo-500">
                    </div>
                    <div class="w-40">
                        <select 
                            wire:model.live="statusFilter" 
                            class="block w-full pl-3 pr-10 py-2.5 text-sm border-gray-700 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-xl bg-dark-900 text-gray-300"
                        >
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="completed">Completed</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700/50 text-left">
                    <thead class="bg-dark-900/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Order #</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">User</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Game</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Total</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50 bg-dark-800">
                        @forelse($orders as $order)
                            <tr wire:key="{{ $order->id }}" class="hover:bg-dark-900/50 transition-colors duration-150 group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-mono text-indigo-400 font-bold bg-indigo-500/10 px-2 py-1 rounded inline-block">
                                        {{ $order->order_number }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-white">{{ $order->user->name ?? 'Guest' }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->user->email ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($order->game && $order->game->image)
                                            <img src="{{ Storage::url($order->game->image) }}" class="w-8 h-8 rounded-lg object-cover mr-3 border border-gray-700">
                                        @endif
                                        <div class="text-sm text-gray-300">{{ $order->game->name ?? 'N/A' }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-brand-yellow">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20',
                                            'processing' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                            'completed' => 'bg-green-500/10 text-green-400 border-green-500/20',
                                            'failed' => 'bg-red-500/10 text-red-400 border-red-500/20',
                                        ];
                                        $statusClass = $statusClasses[$order->status] ?? 'bg-gray-700 text-gray-400';
                                    @endphp
                                    <span class="px-2.5 py-1 text-xs font-bold border rounded-full {{ $statusClass }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-400">{{ $order->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-600">{{ $order->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <!-- View Button -->
                                        <!-- View Button -->
                                        <button 
                                            type="button"
                                            x-on:click="$wire.viewDetails('{{ $order->id }}')"
                                            wire:loading.attr="disabled"
                                            class="p-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg transition-all duration-200"
                                            title="View Details">
                                            <svg wire:loading.remove target="viewDetails('{{ $order->id }}')" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            <div wire:loading target="viewDetails({{ $order->id }})">
                                                <svg class="w-5 h-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </div>
                                        </button>

                                        @if($order->status === 'pending')
                                            <!-- Process Button -->
                                            <button 
                                                type="button"
                                                x-on:click="Swal.fire({
                                                    title: 'Confirm Processing?',
                                                    text: 'Mark this order as processing?',
                                                    icon: 'question',
                                                    background: '#1E293B',
                                                    color: '#fff',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#3B82F6',
                                                    cancelButtonColor: '#64748B',
                                                    confirmButtonText: 'Yes, Process it!'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        $wire.updateStatus('{{ $order->id }}', 'processing')
                                                    }
                                                })"
                                                wire:loading.attr="disabled"
                                                class="p-2 text-blue-400 hover:text-white hover:bg-blue-600 rounded-lg transition-all duration-200"
                                                title="Mark as Processing">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </button>
                                        @endif

                                        @if($order->status === 'processing')
                                            <!-- Complete Button -->
                                            <button 
                                                type="button"
                                                x-on:click="Swal.fire({
                                                    title: 'Complete Order?',
                                                    text: 'Confirm order completion?',
                                                    icon: 'warning',
                                                    background: '#1E293B',
                                                    color: '#fff',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#10B981',
                                                    cancelButtonColor: '#64748B',
                                                    confirmButtonText: 'Yes, Complete!'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        $wire.updateStatus('{{ $order->id }}', 'completed')
                                                    }
                                                })"
                                                wire:loading.attr="disabled"
                                                class="p-2 text-green-400 hover:text-white hover:bg-green-600 rounded-lg transition-all duration-200"
                                                title="Mark as Completed">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-24 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="p-4 bg-gray-800 rounded-full mb-4">
                                            <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                        </div>
                                        <p class="text-lg font-medium text-gray-300">No orders found</p>
                                        <p class="text-sm text-gray-500 mt-1">Try changing your filters</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-700/50 bg-dark-900/30">
                {{ $orders->links() }}
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    @if($selectedOrder)
        <div class="fixed inset-0 z-[60] flex items-center justify-center bg-black/80 backdrop-blur-sm" wire:click="closeModal">
            <div class="w-full max-w-3xl p-6 bg-gray-800 rounded-xl border border-gray-700 shadow-2xl" wire:click.stop>
                <h3 class="mb-4 text-xl font-bold text-white flex justify-between items-center">
                    <span>Order Details - <span class="text-brand-yellow font-mono">{{ $selectedOrder->order_number }}</span></span>
                    <button type="button" wire:click="closeModal" class="text-gray-400 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </h3>
                
                <div class="space-y-4 max-h-[70vh] overflow-y-auto pr-2 custom-scrollbar">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-3 rounded-lg bg-dark-900 border border-gray-700/50">
                            <p class="text-xs font-bold text-gray-500 uppercase">User</p>
                            <p class="text-white font-medium">{{ $selectedOrder->user->name ?? 'Guest' }}</p>
                            <p class="text-xs text-gray-400">{{ $selectedOrder->user->email ?? '-' }}</p>
                        </div>
                        <div class="p-3 rounded-lg bg-dark-900 border border-gray-700/50">
                            <p class="text-xs font-bold text-gray-500 uppercase">Game</p>
                            <p class="text-white font-medium">{{ $selectedOrder->game->name ?? 'Deleted Game' }}</p>
                        </div>
                        <div class="p-3 rounded-lg bg-dark-900 border border-gray-700/50">
                            <p class="text-xs font-bold text-gray-500 uppercase">Game Account ID</p>
                            <p class="text-white font-medium font-mono text-brand-yellow">{{ $selectedOrder->game_account_id }}</p>
                        </div>
                        <div class="p-3 rounded-lg bg-dark-900 border border-gray-700/50">
                            <p class="text-xs font-bold text-gray-500 uppercase">Payment Method</p>
                            <p class="text-white font-medium">{{ $selectedOrder->payment_method }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="mb-2 text-sm font-bold text-gray-400 uppercase">Order Items</p>
                        <div class="bg-dark-900 rounded-lg border border-gray-700/50 overflow-hidden">
                            @foreach($selectedOrder->items as $item)
                                <div class="flex justify-between p-4 border-b border-gray-700/50 last:border-0 hover:bg-white/5 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded bg-brand-yellow/10 flex items-center justify-center text-brand-yellow font-bold text-xs">
                                            x{{ $item->quantity }}
                                        </div>
                                        <span class="text-white font-medium">{{ $item->product_name }}</span>
                                    </div>
                                    <span class="text-white font-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                            <div class="p-4 bg-brand-yellow/10">
                                <div class="flex justify-between items-center">
                                    <span class="text-brand-yellow font-bold uppercase text-sm">Total Amount</span>
                                    <span class="text-xl font-black text-brand-yellow">Rp {{ number_format($selectedOrder->total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($selectedOrder->payment)
                        <div class="p-4 rounded-lg bg-green-500/10 border border-green-500/20">
                            <div class="flex items-center gap-3">
                                <div class="p-2 rounded-full bg-green-500/20 text-green-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">Payment Status</p>
                                    <p class="text-green-400 font-bold uppercase tracking-wider">{{ ucfirst($selectedOrder->payment->status) }}</p>
                                    @if($selectedOrder->payment->paid_at)
                                        <p class="text-xs text-green-500/60 mt-0.5">Paid at: {{ $selectedOrder->payment->paid_at->format('d M Y H:i') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-700">
                    <button type="button" wire:click="closeModal" class="px-5 py-2.5 text-sm font-bold text-gray-300 bg-gray-700 hover:bg-gray-600 rounded-xl transition-all">
                        Close
                    </button>
                    @if($selectedOrder->status === 'pending')
                    <button 
                        type="button"
                        x-on:click="Swal.fire({
                            title: 'Process Now?',
                            text: 'Mark as Processing?',
                            icon: 'question',
                            background: '#1E293B',
                            color: '#fff',
                            showCancelButton: true,
                            confirmButtonColor: '#3B82F6',
                            confirmButtonText: 'Yes'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $wire.updateStatus('{{ $selectedOrder->id }}', 'processing');
                                $wire.closeModal();
                            }
                         })" 
                        class="px-5 py-2.5 text-sm font-bold text-black bg-brand-yellow hover:bg-yellow-400 rounded-xl transition-all shadow-lg shadow-yellow-500/20">
                        Process Order
                    </button>
                    @endif
                </div>
            </div>
        </div>
    @endif


</div>
