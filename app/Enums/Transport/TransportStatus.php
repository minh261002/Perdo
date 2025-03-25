<?php

namespace App\Enums\Transport;

use App\Supports\Enum;

enum TransportStatus: string
{
    use Enum;

    //chưa lên đơn
    case Pending = 'pending';

    //đã lên đơn
    case Processing = 'processing';

    //Tài xế đã nhận hàng
    case DriverReceived = 'driver_received';

    //Tài xế đang giao hàng
    case Delivering = 'delivering';

    //Giao hàng thành công, chưa đối soát
    case Delivered = 'delivered';

    //Giao hàng thành công, đã đối soát
    case Completed = 'completed';

    //Giao hàng thất bại
    case Failed = 'failed';

    //Đã hủy
    case Cancelled = 'cancelled';

    public function badge(): string
    {
        return match ($this) {
            TransportStatus::Pending => 'bg-blue text-blue-fg',
            TransportStatus::Processing => 'bg-orange text-orange-fg',
            TransportStatus::DriverReceived => 'bg-yellow text-yellow-fg',
            TransportStatus::Delivering => 'bg-purple text-purple-fg',
            TransportStatus::Delivered => 'bg-green text-green-fg',
            TransportStatus::Completed => 'bg-green text-green-fg',
            TransportStatus::Failed => 'bg-red text-red-fg',
            TransportStatus::Cancelled => 'bg-red text-red-fg',
        };
    }



}
