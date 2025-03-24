<span @class([
    'badge',
    App\Enums\Module\ModuleStatus::from($status)->badge(),
])>{{ \App\Enums\Module\ModuleStatus::getDescription($status) }}</span>
