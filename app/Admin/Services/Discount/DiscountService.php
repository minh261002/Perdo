<?php

namespace App\Admin\Services\Discount;

use App\Enums\Discount\DiscountApplyFor;
use App\Enums\Discount\DiscountType;
use App\Repositories\Discount\DiscountRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class DiscountService implements DiscountServiceInterface
{
    protected $repository;
    protected $userRepository;

    public function __construct(DiscountRepositoryInterface $repository, UserRepositoryInterface $userRepository)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    public function store(Request $request)
    {
        $data = $request->validated();

        if ($data['type'] == DiscountType::Percentage->value) {
            $data['discount_value'] = null;
        } else {
            $data['percent_value'] = null;
        }

        $apply_for = $data['apply_for'];
        if ($apply_for == DiscountApplyFor::All->value) {
            $users = $this->userRepository->getOrderBy('id', 'asc');
            $data['user_id'] = $users->pluck('id')->toArray();
        } else if ($apply_for == DiscountApplyFor::One->value) {
            $data['user_id'] = $data['user_id'] ?? [];
        }

        $userIds = $data['user_id'] ?? [];
        unset($data['user_id']);

        $discount = $this->repository->create($data);

        $discount->users()->sync($userIds);

        return $discount;
    }

    public function update(Request $request)
    {
        $data = $request->validated();

        if ($data['type'] == DiscountType::Percentage->value) {
            $data['discount_value'] = null;
        } else {
            $data['percent_value'] = null;
        }

        $apply_for = $data['apply_for'];
        if ($apply_for == DiscountApplyFor::All->value) {
            $users = $this->userRepository->getOrderBy('id', 'asc');
            $data['user_id'] = $users->pluck('id')->toArray();
        } else if ($apply_for == DiscountApplyFor::One->value) {
            $data['user_id'] = $data['user_id'] ?? [];
        }

        $userIds = $data['user_id'] ?? [];
        unset($data['user_id']);

        $discount = $this->repository->update($data['id'], $data);

        $discount->users()->sync($userIds);

        return $discount;
    }
}