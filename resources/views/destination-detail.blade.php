@extends('layouts.app')

@section('title', 'Du Lịch ' . $destination->name . ' - Danh Sách Tour | Chestnut Travel')
@section('meta_description', Str::limit(strip_tags($destination->description), 160))

@section('content')
<section class="relative bg-gray-900 text-white py-16">
    <div class="absolute inset-0 z-0">
        <img src="{{ $destination->image_url }}" 
             alt="{{ $destination->name }}" 
             class="w-full h-full object-cover opacity-30">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-amber-400 font-bold text-xs uppercase tracking-widest block mb-2">Điểm đến nổi bật</span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-white mb-3">{{ $destination->name }}</h1>
        <p class="text-sm text-gray-300 max-w-2xl leading-relaxed">
            {!! $destination->description !!}
        </p>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-xl font-extrabold text-gray-900 mb-8">
            Các Tour Khám Phá {{ $destination->name }} ({{ $tours->count() }})
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($tours as $tour)
                <x-tour-card :tour="$tour" />
            @empty
                <div class="col-span-3 text-center py-12 text-gray-400">
                    <p>Hiện chưa có tour nào thuộc điểm đến này.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
