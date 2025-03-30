@if ($model->user_id)
    <a href="{{ route('admin.user.edit', $model->user->id) }}" class="text-decoration-none">
        {{ $model->user->name }}
    </a>
@else
    {{ $model->order->name }}
@endif
