<div class="space-y-6">
    <!-- Reviews Summary -->
    <div class="p-6 bg-dark-800 rounded-2xl border border-gray-700/50">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <!-- Average Rating -->
            <div class="text-center md:text-left">
                <div class="text-5xl font-black text-white mb-2">{{ number_format($averageRating, 1) }}</div>
                <div class="flex items-center justify-center md:justify-start gap-1 mb-2">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-6 h-6 {{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                </div>
                <p class="text-sm text-gray-400">{{ $totalReviews }} {{ $totalReviews === 1 ? 'review' : 'reviews' }}</p>
            </div>

            <!-- Rating Distribution -->
            <div class="flex-1 max-w-md space-y-2">
                @foreach([5, 4, 3, 2, 1] as $star)
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-400 w-12">{{ $star }} star</span>
                        <div class="flex-1 h-2 bg-gray-700 rounded-full overflow-hidden">
                            @php
                                $percentage = $totalReviews > 0 ? ($ratingDistribution[$star] / $totalReviews) * 100 : 0;
                            @endphp
                            <div class="h-full bg-yellow-400" style="width: {{ $percentage }}%"></div>
                        </div>
                        <span class="text-sm text-gray-400 w-8 text-right">{{ $ratingDistribution[$star] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Write Review Button -->
        @auth
            <div class="mt-6 pt-6 border-t border-gray-700/50">
                @if(auth()->user()->canReviewGame($game->id))
                    @if($editingReview)
                        <button wire:click="openReviewForm" class="px-6 py-3 text-sm font-bold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-all">
                            Edit Your Review
                        </button>
                        <button wire:click="deleteReview" wire:confirm="Are you sure you want to delete your review?" class="ml-3 px-6 py-3 text-sm font-bold text-red-400 bg-red-500/10 rounded-xl hover:bg-red-500/20 transition-all">
                            Delete Review
                        </button>
                    @else
                        <button wire:click="openReviewForm" class="px-6 py-3 text-sm font-bold text-black bg-brand-yellow rounded-xl hover:bg-yellow-400 transition-all">
                            Write a Review
                        </button>
                    @endif
                @else
                    <p class="text-sm text-gray-500">Purchase this game to write a review</p>
                @endif
            </div>
        @else
            <div class="mt-6 pt-6 border-t border-gray-700/50">
                <p class="text-sm text-gray-500">
                    <a href="{{ route('login') }}" class="text-brand-yellow hover:underline">Login</a> to write a review
                </p>
            </div>
        @endauth
    </div>

    <!-- Review Form Modal -->
    @if($showReviewForm)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/70" wire:click="closeReviewForm">
            <div class="w-full max-w-lg p-6 bg-dark-800 rounded-2xl border border-gray-700/50 mx-4" wire:click.stop>
                <h3 class="text-xl font-bold text-white mb-4">{{ $editingReview ? 'Edit Your Review' : 'Write a Review' }}</h3>
                
                <form wire:submit.prevent="submitReview" class="space-y-4">
                    <!-- Star Rating -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Rating *</label>
                        <div class="flex gap-2">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" wire:click="$set('rating', {{ $i }})" class="transition-transform hover:scale-110">
                                    <svg class="w-10 h-10 {{ $rating >= $i ? 'text-yellow-400' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </button>
                            @endfor
                        </div>
                        @error('rating') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Comment -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Comment (Optional)</label>
                        <textarea wire:model="comment" rows="4" maxlength="500" class="w-full px-4 py-2 text-white bg-dark-900 border border-gray-700 rounded-xl focus:outline-none focus:border-brand-yellow" placeholder="Share your experience with this game..."></textarea>
                        <div class="flex justify-between mt-1">
                            <span class="text-xs text-gray-500">{{ strlen($comment) }}/500 characters</span>
                            @error('comment') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" wire:click="closeReviewForm" class="px-6 py-2 text-gray-300 bg-gray-700 rounded-xl hover:bg-gray-600">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-2 font-bold text-black bg-brand-yellow rounded-xl hover:bg-yellow-400" wire:loading.attr="disabled">
                            <span wire:loading.remove>Submit Review</span>
                            <span wire:loading>Submitting...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Reviews List -->
    <div>
        <!-- Sort Options -->
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-white">Customer Reviews</h3>
            <select wire:model.live="sortBy" class="px-4 py-2 text-sm text-white bg-dark-800 border border-gray-700 rounded-xl focus:outline-none focus:border-brand-yellow">
                <option value="recent">Most Recent</option>
                <option value="highest">Highest Rating</option>
                <option value="lowest">Lowest Rating</option>
            </select>
        </div>

        <!-- Reviews -->
        <div class="space-y-4">
            @forelse($reviews as $review)
                <div class="p-6 bg-dark-800 rounded-2xl border border-gray-700/50">
                    <div class="flex items-start gap-4">
                        <!-- Avatar -->
                        <img src="{{ $review->user->avatar_url }}" alt="{{ $review->user->name }}" class="w-12 h-12 rounded-full border-2 border-gray-700">
                        
                        <div class="flex-1">
                            <!-- Header -->
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <h4 class="font-bold text-white">{{ $review->user->name }}</h4>
                                    <div class="flex items-center gap-1 mt-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                            </div>

                            <!-- Comment -->
                            @if($review->comment)
                                <p class="text-gray-300 mt-2">{{ $review->comment }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-12 text-center bg-dark-800/50 rounded-2xl border border-dashed border-gray-700">
                    <svg class="w-12 h-12 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                    <p class="text-gray-400 font-medium">No reviews yet</p>
                    <p class="text-gray-500 text-sm mt-1">Be the first to review this game!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
