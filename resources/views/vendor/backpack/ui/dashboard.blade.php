@extends(backpack_view('blank'))

@php
    use App\Models\User;

    $widgets['before_content'] = [];

    // Show Total Users Widget only to Admin
    if (backpack_user()->isAdmin()) {
        $userCount = User::count();
        $widgets['before_content'][] = [
            'type' => 'card',
            'class' => 'card text-white bg-success',
            'wrapper' => ['class' => 'col-md-4 mb-3'],
            'content' => [
                'header' => 'Total Registered Users',
                'body' => "<h3 class='text-white'>$userCount</h3>",
            ],
        ];
    }

    // PayPal Payment Widget
    $widgets['before_content'][] = [
        'type' => 'card',
        'class' => 'card bg-light border-primary',
        'wrapper' => ['class' => 'col-md-6 mb-3'],
        'content' => [
            'header' => 'PAYPAL PAYMENT',
            'body' => '
                <p>You can support the platform by making a quick PayPal donation.</p>
                <a href="https://www.paypal.me/btanemba?ref=' . auth()->id() . '" target="_blank" class="btn btn-primary">
                    Pay Now via PayPal
                </a>',
        ],
    ];

    // Bank Transfer Widget
    $widgets['before_content'][] = [
        'type' => 'card',
        'class' => 'card bg-light border-primary',
        'wrapper' => ['class' => 'col-md-6 mb-3'],
        'content' => [
            'header' => 'BANK PAYMENT',
            'body' => '
                <p><strong>Account Name:</strong> Benedict Torhile Anemba</p>
                <p><strong>Bank Name:</strong> [Actual Bank Name]</p>
                <p><strong>IBAN:</strong> [Valid IBAN]</p>
                <p><strong>BIC/SWIFT:</strong> [Valid BIC]</p>
                <p><strong>Reference:</strong> Your Email or User ID</p>',
        ],
    ];

    // Optional Getting Started Widget
    if (backpack_theme_config('show_getting_started')) {
        $widgets['before_content'][] = [
            'type' => 'view',
            'view' => backpack_view('inc.getting_started'),
            'wrapper' => ['class' => 'col-md-12 mb-3'],
        ];
    }

    // // Spacer Cards (optional aesthetic spacing)
    // $widgets['before_content'][] = [
    //     'type' => 'card',
    //     'wrapper' => ['class' => 'col-md-12 mb-3'],
    //     'content' => [
    //         'body' => '<div style="height: 10px;"></div>',
    //     ],
    // ];
@endphp
{{--
@section('content')
    <div class="container mt-4">
        <div class="row">
            @foreach ($widgets['before_content'] as $widget)
                @if (($widget['type'] ?? '') === 'view' && !empty($widget['view']) && view()->exists($widget['view']))
                    @include($widget['view'], ['widget' => $widget])
                @else
                    @widget($widget)
                @endif
            @endforeach
        </div>
    </div>
@endsection --}}
