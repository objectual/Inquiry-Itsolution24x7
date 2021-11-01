<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class UserCriteria.
 *
 * @package namespace App\Criteria;
 */
class UserCriteria extends BaseCriteria implements CriteriaInterface
{
    protected $role = null;
    protected $mine = null;

    /**
     * Apply criteria in query repository
     *
     * @param string $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if ($this->exists('role')) {
            $role = $this->role;
            $model = $model->whereHas('roles', function ($q) use ($role) {
                return $q->where('id', $role);
            });
        }

        if ($this->exists('mine') && (!\Entrust::hasRole(['super-admin', 'admin']))) {
            $model->whereHas('consultants', function ($q) {
                $q->where('id', \Auth::id());
            });
        }

        return $model;
    }
}
