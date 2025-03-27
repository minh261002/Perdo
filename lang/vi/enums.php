<?php

use App\Enums\ActiveStatus;
use App\Enums\Discount\DiscountApplyFor;
use App\Enums\Discount\DiscountType;
use App\Enums\Module\ModuleStatus;
use App\Enums\User\UserLoginType;
use App\Enums\User\UserRole;

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
    ]
];