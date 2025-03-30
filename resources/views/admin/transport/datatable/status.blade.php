<span
    @class([
        'badge',
        App\Enums\Transport\TransportStatus::from(
            $model->statuses->last()->status->value)->badge(),
    ])>{{ \App\Enums\Transport\TransportStatus::getDescription($model->statuses->last()->status->value) }}</span>
