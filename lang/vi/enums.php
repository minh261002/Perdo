<?php

use App\Enums\ActiveStatus;
use App\Enums\Discount\DiscountApplyFor;
use App\Enums\Discount\DiscountType;
use App\Enums\Module\ModuleStatus;
use App\Enums\Transaction\PaymentMethod;
use App\Enums\Transaction\PaymentStatus;
use App\Enums\User\UserLoginType;
use App\Enums\User\UserRole;
use App\Enums\Order\OrderStatus;

return [
    ActiveStatus::class => [
        ActiveStatus::Active->value => 'Đang hoạt động',
        ActiveStatus::InActive->value => 'Không hoạt động',
    ],
    ModuleStatus::class => [
        ModuleStatus::Completed->value => 'Hoàn thành',
        ModuleStatus::InProgress->value => 'Đang tiến hành',
    ],
    UserLoginType::class => [
        UserLoginType::Email->value => 'Email',
        UserLoginType::Google->value => 'Google',
        UserLoginType::Facebook->value => 'Facebook',
    ],
    UserRole::class => [
        UserRole::Guest->value => 'Khách hàng',
        UserRole::Host->value => 'Chủ nhà'
    ],
    DiscountApplyFor::class => [
        DiscountApplyFor::All->value => 'Áp dụng cho tất cả',
        DiscountApplyFor::One->value => 'Áp dụng cho khách hàng cụ thể',
    ],
    DiscountType::class => [
        DiscountType::Percentage->value => 'Phần trăm',
        DiscountType::Fixed->value => 'Cố định',
    ],
    PaymentMethod::class => [
        PaymentMethod::COD->value => 'Thanh toán khi nhận hàng',
        PaymentMethod::MOMO->value => 'Cổng thanh toán MOMO',
        PaymentMethod::VNPAY->value => 'Cổng thanh toán VNPay',
        PaymentMethod::QRCODE->value => 'Thanh toán qua mã QR',
    ],
    PaymentStatus::class => [
        PaymentStatus::Pending->value => 'Chờ thanh toán',
        PaymentStatus::Completed->value => 'Đã thanh toán',
        PaymentStatus::Cancelled->value => 'Đã hủy',
    ],
    OrderStatus::class => [
        OrderStatus::Pending->value => 'Chờ xác nhận',
        OrderStatus::Processing->value => 'Đã xác nhận',
        OrderStatus::Completed->value => 'Hoàn thành',
        OrderStatus::Cancelled->value => 'Đã hủy',
    ],
];
