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
    } else {
        // Instruction Widget for Non-Admins
        $widgets['before_content'][] = [
            'type' => 'card',
            'class' => 'card border-warning',
            'wrapper' => ['class' => 'col-md-12 mb-3'],
            'content' => [
                'header' => '<strong class="text-danger text-uppercase">Setting Your Account</strong>',
                'body' => '
                    <ol>
                        <li><strong>Complete your Profile</strong></li>
                        <li><strong>In the Skill Tab, fill and upload relevant images</strong></li>
                        <li><strong>Choose a Payment Plan</strong> [This can be changed anytime] in your Profile</li>
                        <li><strong>Make payment to be searchable</strong>. When someone makes a search on the homepage, you will only be visible once payment is made.</li>
                    </ol>',
            ],
        ];
    }


    // // PayPal Payment Widget
    // $widgets['before_content'][] = [
    //     'type' => 'card',
    //     'class' => 'card bg-light border-primary',
    //     'wrapper' => ['class' => 'col-md-6 mb-3'],
    //     'content' => [
    //         'header' => 'PAYPAL PAYMENT',
    //         'body' => '
    //             <p>You can support the platform by making a quick PayPal donation.</p>
    //             <a href="https://www.paypal.me/btanemba?ref=' . auth()->id() . '" target="_blank" class="btn btn-primary">
    //                 Pay Now via PayPal
    //             </a>',
    //     ],
    // ];

//    $widgets['before_content'][] = [
//     'type' => 'card',
//     'class' => 'card bg-light border-primary',
//     'wrapper' => ['class' => 'col-md-6 mb-3'],
//     'content' => [
//         'header' => 'BANK PAYMENT',
//         'body' => '
//             <p>You can pay via bank transfer. Click the button below to see full details.</p>
//             <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bankPaymentModal">
//                 View Full Bank Details
//             </button>

//             <!-- Modal -->
//             <div class="modal fade" id="bankPaymentModal" tabindex="-1" aria-labelledby="bankPaymentModalLabel" aria-hidden="true">
//               <div class="modal-dialog modal-dialog-centered modal-lg">
//                 <div class="modal-content">
//                   <div class="modal-header">
//                     <h5 class="modal-title" id="bankPaymentModalLabel">Bank Transfer Details</h5>
//                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
//                   </div>
//                   <div class="modal-body">
//                     <p><strong>Account Name:</strong> Benedict Torhile Anemba</p>
//                     <p><strong>Bank Name:</strong> [Actual Bank Name]</p>
//                     <p><strong>IBAN:</strong> [Valid IBAN]</p>
//                     <p><strong>BIC/SWIFT:</strong> [Valid BIC]</p>
//                     <p><strong>Reference:</strong> Your Email or User ID</p>
//                   </div>
//                   <div class="modal-footer">
//                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
//                   </div>
//                 </div>
//               </div>
//             </div>
//         ',
//     ],
// ];
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
