<span @class(['badge', App\Enums\User\UserRole::from($role)->badge()])>{{ \App\Enums\User\UserRole::getDescription($role) }}</span>
