<x-layouts.app :title="__('Admin Dashboard')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Dashboard') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage the modules data from here: ') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>
    @session("success")
        <p class=" text-green-600">{{ $value }}</p>
    @endsession

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="bg-white py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <dl class="grid grid-cols-1 gap-x-8 gap-y-16 text-center lg:grid-cols-3">
                    <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                        <dt class="text-base/7 text-gray-600">Transactions every 24 hours</dt>
                        <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">44
                            million</dd>
                    </div>
                    <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                        <dt class="text-base/7 text-gray-600">Assets under holding</dt>
                        <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">$119
                            trillion</dd>
                    </div>
                    <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                        <dt class="text-base/7 text-gray-600">New users annually</dt>
                        <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">46,000
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

    </div>
</x-layouts.app>