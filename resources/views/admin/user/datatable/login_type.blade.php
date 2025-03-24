<span @class([
    'badge',
    App\Enums\User\UserLoginType::from($login_type)->badge(),
])>{{ \App\Enums\User\UserLoginType::getDescription($login_type) }}</span>
