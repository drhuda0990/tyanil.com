@extends('layouts.app')

@section('title', 'الإشعارات')

@section('SCSS')
    <style>
        .customer-notifications {
            background: #FFF9EF;
        }

        .notification-list {
            display: grid;
            gap: 16px;
        }

        .notification-card {
            display: grid;
            gap: 8px;
            padding: 22px;
            border: 1px solid #E8DDCF;
            border-radius: 8px;
            background: #FFFCF6;
            box-shadow: 0 14px 36px rgba(62, 74, 63, 0.07);
        }

        .notification-card.unread {
            border-color: #8FAF8B;
        }

        .notification-card__top {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: center;
        }

        .notification-card h3 {
            color: #3E4A3F;
            font-size: 20px;
            margin: 0;
        }

        .notification-card p {
            color: #766C63;
            margin: 0;
        }

        .notification-badge {
            padding: 5px 10px;
            border-radius: 999px;
            background: #F4EBDD;
            color: #3E4A3F;
            font-size: 12px;
            white-space: nowrap;
        }

        .notification-action {
            width: fit-content;
            padding: 9px 16px;
            border-radius: 8px;
            background: #8FAF8B;
            color: #FFFCF6;
            font-weight: 700;
        }

        .notification-action:hover {
            color: #FFFCF6;
            background: #3E4A3F;
        }
    </style>
@endsection

@section('content')
    <section class="customer-notifications pt-120 pb-120">
        <div class="container">
            <div class="section-header mb-40">
                <h5><span class="tr-ar">إشعاراتي</span><span class="tr-en">My notifications</span></h5>
            </div>

            <div class="notification-list">
                @forelse ($notifications as $notification)
                    <article class="notification-card {{ $notification->read_at ? '' : 'unread' }}">
                        <div class="notification-card__top">
                            <h3>{{ $notification->title_ar }}</h3>
                            <span class="notification-badge">
                                {{ $notification->read_at ? 'مقروء' : 'جديد' }}
                            </span>
                        </div>
                        @if ($notification->body_ar)
                            <p>{{ $notification->body_ar }}</p>
                        @endif
                        <small>{{ $notification->created_at?->diffForHumans() }}</small>
                        <a class="notification-action"
                            href="{{ route('customer.notifications.read', ['id' => encrypt($notification->id)]) }}">
                            <span class="tr-ar">عرض التفاصيل</span><span class="tr-en">View details</span>
                        </a>
                    </article>
                @empty
                    <article class="notification-card">
                        <h3><span class="tr-ar">لا توجد إشعارات حالياً</span><span class="tr-en">No notifications yet</span></h3>
                        <p><span class="tr-ar">ستظهر هنا تحديثات الطلبات والتنبيهات المهمة.</span><span class="tr-en">Order updates and important alerts will appear here.</span></p>
                    </article>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        </div>
    </section>
@endsection
