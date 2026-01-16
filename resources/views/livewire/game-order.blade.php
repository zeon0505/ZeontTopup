<div class="min-h-screen pb-12 bg-dark-900">
    <!-- Hero Banner -->
    <div class="relative h-[280px] md:h-[320px] overflow-hidden">
        {{-- Background Image with Overlay --}}
        <div class="absolute inset-0">
            @if($game->image)
                <img src="{{ Storage::url($game->image) }}" alt="{{ $game->name }}" class="w-full h-full object-cover blur-sm opacity-50">
            @else
                <div class="w-full h-full bg-gradient-to-r from-gray-900 to-indigo-900"></div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-dark-900 via-dark-900/60 to-transparent"></div>
        </div>

        {{-- Content --}}
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-end pb-8">
            <div class="flex items-center gap-6">
                {{-- Game Icon --}}
                <div class="relative flex-shrink-0">
                    <div class="w-24 h-24 md:w-32 md:h-32 rounded-3xl overflow-hidden shadow-2xl ring-4 ring-dark-800">
                        @if($game->image)
                            <img src="{{ Storage::url($game->image) }}" alt="{{ $game->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-indigo-600 flex items-center justify-center">
                                <span class="text-3xl font-bold text-white">{{ substr($game->name, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Game Info --}}
                <div>
                    <h1 class="text-2xl md:text-4xl font-black text-white uppercase tracking-tight">{{ $game->name }}</h1>
                    <p class="text-indigo-400 font-medium">{{ $game->publisher ?? 'Official Publisher' }}</p>
                    <div class="flex items-center gap-4 mt-3 text-sm text-gray-400">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Instant Process
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                            </svg>
                            24/7 Support
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Column: Order Steps -->
            <div class="lg:col-span-8 space-y-8">
                <!-- Step 1: Account Validator -->
                <livewire:account-id-validator :gameId="$game->id" />
                
                <!-- Step 2: Product Selector -->
                <livewire:product-selector :gameId="$game->id" :preselectedProductId="request()->query('product')" />
                
                <!-- Step 3: Payment Method -->
                <livewire:payment-form />
            </div>

            <!-- Right Column: Info & Reviews & Cart -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Cart Summary (Sticky) -->
                <livewire:cart-summary :gameId="$game->id" />

                <!-- Reviews Card -->
                <div class="bg-dark-800 rounded-2xl p-6 border border-gray-700/50">
                    <h3 class="text-white font-bold text-lg mb-1">Reviews & Rating</h3>
                    <div class="flex items-end gap-3 mb-4">
                        <span class="text-5xl font-black text-white">{{ number_format($game->average_rating, 1) }}</span>
                        <div class="mb-2">
                            <div class="flex text-brand-yellow space-x-1">
                                @for($i=1; $i<=5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= round($game->average_rating) ? 'fill-current' : 'text-gray-600 fill-current opacity-20' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Based on {{ $game->reviews_count }} reviews</p>
                        </div>
                    </div>
                </div>

                <!-- Write a Review -->
                <div class="bg-dark-800 rounded-2xl p-6 border border-gray-700/50">
                    <h3 class="text-white font-bold text-lg mb-4">Write a Review</h3>
                    
                    @if(session()->has('message'))
                        <div class="p-3 mb-4 text-sm text-green-400 bg-green-500/10 rounded-xl border border-green-500/20">
                            {{ session('message') }}
                        </div>
                    @endif

                    <form wire:submit.prevent="submitReview">
                        <!-- Star Input -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-400 mb-2">Rating</label>
                            <div class="flex gap-2">
                                @for($i=1; $i<=5; $i++)
                                    <button type="button" wire:click="setRating({{ $i }})" class="focus:outline-none transition-transform hover:scale-110">
                                        <svg class="w-8 h-8 {{ $i <= $userRating ? 'text-brand-yellow fill-current' : 'text-gray-600 fill-current' }}" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </button>
                                @endfor
                            </div>
                        </div>

                        <!-- Comment Input -->
                        <div class="mb-4">
                            <textarea 
                                wire:model="reviewComment"
                                rows="3" 
                                class="w-full bg-dark-900 border border-gray-700 rounded-xl text-white placeholder-gray-500 text-sm p-3 focus:ring-1 focus:ring-brand-yellow focus:border-brand-yellow"
                                placeholder="Share your experience..."></textarea>
                            @error('reviewComment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="w-full py-2 bg-slate-700 hover:bg-brand-yellow hover:text-black text-white font-bold rounded-xl transition-all">
                            Submit Review
                        </button>
                    </form>
                </div>

                <!-- Recent Reviews List -->
                <div class="bg-dark-800 rounded-2xl p-6 border border-gray-700/50 max-h-[400px] overflow-y-auto">
                    <h3 class="text-white font-bold text-lg mb-4">Recent Reviews</h3>
                    <div class="space-y-4">
                        @forelse($reviews as $review)
                            <div class="border-b border-gray-700/50 pb-4 last:border-0 last:pb-0">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-bold text-white">{{ $review->user->name ?? 'User' }}</span>
                                    <span class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="flex text-brand-yellow w-3 h-3 gap-0.5 mb-2">
                                    @for($i=1; $i<=5; $i++)
                                        <svg class="{{ $i <= $review->rating ? 'fill-current' : 'text-gray-700 fill-current' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                                <p class="text-sm text-gray-400">{{ $review->comment }}</p>
                            </div>
                        @empty
                            <div class="text-center text-gray-500">No reviews yet.</div>
                        @endforelse
                    </div>

                <!-- Customer Service -->
                <div class="bg-dark-800 rounded-2xl p-6 border border-gray-700/50">
                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-dark-900 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-bold">Need Help?</h4>
                            <p class="text-sm text-gray-400 mt-1">Contact our admin support for any issues.</p>
                            <a href="https://wa.me/6281234567890" target="_blank" class="mt-3 block w-full py-2 bg-brand-yellow text-black font-bold rounded-xl text-sm hover:bg-yellow-400 transition-colors text-center">
                                Contact Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification -->
    <livewire:notification-toast />

    @push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            console.log("Payment System Initialized");
            
            Livewire.on('payment-initiated', (event) => {
                console.log('Payment Initiated Event Received:', event);
                
                // Extract data from event (Livewire 3 passes array of args)
                const data = event[0] || event;
                const snapToken = data.snap_token;

                if (typeof snap === 'undefined') {
                    alert('Error: Sistem pembayaran belum siap. Mohon refresh halaman.');
                    return;
                }

                if (snapToken) {
                    snap.pay(snapToken, {
                        onSuccess: function(result){
                            window.location.href = `/order/status/${data.order_number}`;
                        },
                        onPending: function(result){
                            window.location.href = `/order/status/${data.order_number}`;
                        },
                        onError: function(result){
                            console.error('Payment Error:', result);
                            Livewire.dispatch('show-notification', { message: 'Pembayaran Gagal!', type: 'error' });
                        },
                        onClose: function(){
                            console.log('Customer closed the popup without finishing the payment');
                            window.location.href = `/order/status/${data.order_number}`;
                        }
                    });
                } else {
                    console.error('Snap Token is missing!', data);
                    alert('Error: Gagal membuat token pembayaran.');
                }
            });
            
            // Fallback for window event if Livewire event fails
            window.addEventListener('payment-initiated', (event) => {
                console.log('Window Payment Event:', event.detail);
                const data = event.detail;
                const snapToken = data.snap_token;

                if (typeof snap === 'undefined') {
                    alert('Error: Sistem pembayaran belum siap. Mohon refresh halaman.');
                    return;
                }

                if(snapToken){
                     snap.pay(snapToken, {
                        onSuccess: function(result){
                            window.location.href = `/order/status/${data.order_number}`;
                        },
                        onPending: function(result){
                            window.location.href = `/order/status/${data.order_number}`;
                        },
                        onError: function(result){
                            console.error('Payment Error:', result);
                            Livewire.dispatch('show-notification', { message: 'Pembayaran Gagal!', type: 'error' });
                        }
                    });
                }
            });
        });
    </script>
    @endpush
</div>
