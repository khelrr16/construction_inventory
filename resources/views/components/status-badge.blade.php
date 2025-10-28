@props(['status'])

@php
    $colors = [
        'active' => 'primary',
        'completed' => 'success',
        'postponed' => 'warning',
        'occupied' => 'warning',
        'packing' => 'primary',
        'on delivery' => 'primary',
        'discontinued' => 'danger',
        'delivered' => 'success',
        'to be packed' => 'info',
        'draft' => 'secondary',
        'to be delivered' => 'info',
        'cancelled' => 'danger',
        'pending' => 'warning',
        'incomplete' => 'dark',
        'inactive' => 'dark',
        'declined' => 'danger',
        'received' => 'success',
    ];
    
    $color = $colors[$status] ?? 'secondary';
    $label = ucfirst($status);
@endphp

<span {{ $attributes->merge(['class' => "badge bg-{$color}"]) }}>
    {{ $label }}
</span>