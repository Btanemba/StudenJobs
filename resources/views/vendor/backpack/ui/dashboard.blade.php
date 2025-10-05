@extends(backpack_view('blank'))

@php
    use App\Models\User;
    use App\Models\Skill;
    use App\Models\Invoice;

    $widgets['before_content'] = [];

    if (backpack_user()->isAdmin()) {
        // Counts
        $userCount = User::count();
        $skillCount = Skill::count();
        $invoiceCount = Invoice::count();

        // Wrap them in same-row boxes
        $widgets['before_content'][] = [
            'type'    => 'div',
            'class'   => 'row',
            'content' => [ // 4 boxes on same line
                [
                    'type' => 'card',
                    'class' => 'card text-white bg-primary',
                    'wrapper' => ['class' => 'col-md-3 mb-3'],
                    'content' => [
                        'header' => 'Total Registered Users',
                        'body'   => "<h2 class='text-center text-white'>$userCount</h2>",
                    ],
                ],
                [
                    'type' => 'card',
                    'class' => 'card text-white bg-success',
                    'wrapper' => ['class' => 'col-md-3 mb-3'],
                    'content' => [
                        'header' => 'Total Registered Skills',
                        'body'   => "<h2 class='text-center text-white'>$skillCount</h2>",
                    ],
                ],
                [
                    'type' => 'card',
                    'class' => 'card text-white bg-warning',
                    'wrapper' => ['class' => 'col-md-3 mb-3'],
                    'content' => [
                        'header' => 'Total Invoices Generated',
                        'body'   => "<h2 class='text-center text-white'>$invoiceCount</h2>",
                    ],
                ],

            ]
        ];
    } else {
        // Instruction widget
        $widgets['before_content'][] = [
            'type' => 'card',
            'class' => 'card border-warning',
            'wrapper' => ['class' => 'col-md-12 mb-3'],
            'content' => [
                'header' => '<strong class="text-danger text-uppercase">Setting Your Account</strong>',
                'body' => '
                    <ol>
                        <li><h2 class="fw-bold text-danger">Complete your Profile</h2></li>
                        <li><strong>In the Skill Tab, fill and upload relevant images</strong></li>
                        <li><strong>Choose a Payment Plan</strong></li>
                        <li><strong>Make payment to be searchable</strong></li>
                    </ol>',
            ],
        ];
    }
@endphp
