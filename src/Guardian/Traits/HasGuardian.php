<?php

namespace App\Guardian\Traits;

trait HasGuardian
{
    /**
     * Get all of roles.
     */
    public function roles()
    {
        return $this->morphMany('App\Models\Role', 'roleable');
    }

    /**
     * Join Group
     *
     * @param mixed $groupId
     *
     * @return void
     */
    public function joinGroup($groupId)
    {
        return $this->roles()->create(['group_id' => $groupId]);
    }

    /**
     * Join multi groups
     *
     * @param array $groups
     *
     * @return void
     */
    public function joinMultiGroups($groups)
    {
        $roleable = [
            'roleable_type' => get_class($this),
            'roleable_id' => $this->id
        ];
        $groups = array_map(function($item) use ($roleable) {
            return array_merge($item, $roleable);
        },$groups);
        return $this->roles()->insert($groups);
    }

    /**
     * Has permissions
     *
     * @return \Collection
     */
    public function hasPermissions(array $where = [], string $action = null, array $select = [])
    {   
        $condition = [
            ['roleable_type', '=', get_class($this)],
            ['roleable_id', '=', $this->id]
        ];
        if (empty($select)) {
            $select = [
                'g.id AS group_id', 'g.name AS group_name', 'g.alias AS group_alias',
                'pa.id AS page_id', 'pa.name AS page_name', 'pa.alias AS page_alias',
                'p.id AS permission_id','p.actions AS permissions'
            ];
        }
        $where = empty($where) ? $condition : array_merge($condition, $where);

        $query = $this->join('roles AS r', 'r.roleable_id', '=', "{$this->getTable()}.{$this->getKeyName()}")
                    ->join('permissions AS p', 'p.group_id', '=', 'r.group_id')
                    ->join('pages AS pa', 'p.page_id', '=', 'pa.id')
                    ->join('groups AS g', 'g.id', '=', 'p.group_id')
                    ->select($select)
                    ->where($where);
        if ($action) {
            $query = $query->whereJsonContains('actions', $action);
        }

        $data = $query->get();

        return $data;
    }

    /**
     * Check user has the permission to access
     *
     * @param string $page
     * @param string $action
     *
     * @return boolean
     */
    public function rightAccess(string $page = null, string $action =  null)
    {
        if (is_null($page) && is_null($action)) {
            list($page, $action) = getPageAndAction();
        }
        $action = \App\Models\Action::findByAlias($action);
        $where = [
            ['pa.alias', '=', $page],
        ];
        return $this->hasPermissions($where, $action->id)->isNotEmpty();
    }
}
