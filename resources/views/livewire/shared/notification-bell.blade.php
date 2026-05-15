<div class="relative" wire:poll.8s>

    {{-- Bell button --}}
    <button wire:click="toggle"
            class="relative flex items-center gap-1.5 px-3 py-2 rounded-xl text-gray-600 hover:bg-gray-100 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        <span class="text-xs font-medium">الإشعارات</span>

        {{-- Unread badge --}}
        @if($this->unreadCount > 0)
            <span class="absolute -top-1 -right-1 min-w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center px-1 animate-pulse">
                {{ $this->unreadCount > 9 ? '9+' : $this->unreadCount }}
            </span>
        @endif
    </button>

    {{-- Dropdown --}}
    @if($open)
    <div class="absolute right-0 top-full mt-2 w-96 bg-white rounded-2xl shadow-xl border border-gray-100 z-50 overflow-hidden"
         style="max-height: 480px; overflow-y: auto;">

        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 sticky top-0 bg-white">
            <div class="flex items-center gap-2">
                <h3 class="font-bold text-gray-800">الإشعارات</h3>
                @if($this->unreadCount > 0)
                    <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-0.5 rounded-full">
                        {{ $this->unreadCount }} جديد
                    </span>
                @endif
            </div>
            <div class="flex items-center gap-3">
                @if($this->unreadCount > 0)
                    <button wire:click="markAllRead"
                            class="text-xs text-[#1A6B3C] hover:underline font-medium">
                        تعليم الكل كمقروء
                    </button>
                @endif
                <button wire:click="toggle" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Notifications list --}}
        @forelse($this->notifications as $notification)
        @php
            $data      = $notification->data;
            $isUnread  = is_null($notification->read_at);
            $colorMap  = [
                'red'    => ['bg' => 'bg-red-100',    'text' => 'text-red-600',    'border' => 'border-red-200'],
                'green'  => ['bg' => 'bg-green-100',  'text' => 'text-[#1A6B3C]', 'border' => 'border-green-200'],
                'orange' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-600', 'border' => 'border-orange-200'],
            ];
            $c = $colorMap[$data['color']] ?? $colorMap['orange'];
        @endphp
        <div wire:click="markRead('{{ $notification->id }}')"
             class="flex gap-4 px-5 py-4 hover:bg-gray-50 cursor-pointer transition-colors border-b border-gray-50
                    {{ $isUnread ? 'bg-blue-50/30' : '' }}">

            {{-- Icon --}}
            <div class="w-10 h-10 {{ $c['bg'] }} rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                @if($data['icon'] === 'drop')
                    <svg class="w-5 h-5 {{ $c['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                    </svg>
                @elseif($data['icon'] === 'star')
                    <svg class="w-5 h-5 {{ $c['text'] }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                @else
                    <svg class="w-5 h-5 {{ $c['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                @endif
            </div>

            {{-- Content --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-2">
                    <p class="text-sm font-bold text-gray-800 leading-tight">{{ $data['title'] }}</p>
                    @if($isUnread)
                        <span class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0 mt-1.5"></span>
                    @endif
                </div>
                <p class="text-xs text-gray-600 mt-1 leading-relaxed">{{ $data['message'] }}</p>
                <p class="text-xs text-gray-400 mt-1.5">{{ $notification->created_at->diffForHumans() }}</p>
            </div>
        </div>
        @empty
        <div class="py-12 text-center">
            <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <p class="text-sm text-gray-400">لا توجد إشعارات</p>
        </div>
        @endforelse
    </div>

    {{-- Click outside overlay --}}
    <div class="fixed inset-0 z-40" wire:click="toggle"></div>
    @endif
</div>
