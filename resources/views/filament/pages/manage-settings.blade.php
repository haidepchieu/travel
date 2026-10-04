<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6">
        {{ $this->form }}

        <div class="flex items-center gap-3 pt-4">
            <x-filament::button type="submit" size="lg" color="primary">
                Lưu toàn bộ cấu hình
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
