<div class="flex items-start max-md:flex-col">
    <div class="min-w-[220px] me-10">
        <flux:navlist heading="Pengaturan" expandable :expanded="true">
            <flux:navlist.item :href="route('settings.profile')" :active="request()->routeIs('settings.profile')">
                Profile
            </flux:navlist.item>

            <flux:navlist.item :href="route('settings.password')" :active="request()->routeIs('settings.password')">
                Password
            </flux:navlist.item>

            <flux:navlist.item :href="route('settings.appearance')" :active="request()->routeIs('settings.appearance')">
                Tampilan
            </flux:navlist.item>

            <flux:navlist.item :href="route('category')" :active="request()->routeIs('category')">
                Manajemen Kategori
            </flux:navlist.item>
        </flux:navlist>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <flux:heading>{{ $heading ?? '' }}</flux:heading>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

        <div class="mt-5 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>