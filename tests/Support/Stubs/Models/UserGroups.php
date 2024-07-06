<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Support\Stubs\Models;

use InvalidArgumentException;
use Somnambulist\Components\Models\AbstractEntityCollection;
use Somnambulist\Components\Models\Exceptions\EntityNotFoundException;
use Somnambulist\Components\Tests\Support\Stubs\Events\UserJoinedGroup;
use Somnambulist\Components\Tests\Support\Stubs\Events\UserLeftGroup;

final class UserGroups extends AbstractEntityCollection
{
    private function isMemberOf(Group $group): bool
    {
        return $this->entities->filter(fn (UserGroup $ug) => $ug->group()->equals($group))->count() > 0;
    }

    private function findByGroup(Group $group): ?UserGroup
    {
        return $this->entities->filter(fn (UserGroup $ug) => $ug->group()->equals($group))->first() ?: null;
    }

    public function get(int $id): UserGroup
    {
        if (null === $group = $this->findById($id)) {
            throw EntityNotFoundException::entityNotFound(UserGroup::class, $this->root->id()->toString(), $id);
        }

        return $group;
    }

    public function for(Group $group): UserGroup
    {
        if (null === $ug = $this->findByGroup($group)) {
            throw EntityNotFoundException::entityNotFound(UserGroup::class, $this->root->id()->toString(), $group->toString());
        }

        return $ug;
    }

    public function join(Group $group, Role $role): void
    {
        if ($this->isMemberOf($group)) {
            throw new InvalidArgumentException();
        }

        $this->entities->add(new UserGroup($i = $this->nextId(), $this->root, $group, $role));

        $this->raise(UserJoinedGroup::class, ['id' => $i, 'group' => (string)$group, 'role' => (string)$role]);
    }

    public function leave(Group $group): void
    {
        if (!$this->isMemberOf($group)) {
            return;
        }

        $this->entities->removeElement($this->for($group));

        $this->raise(UserLeftGroup::class, ['group' => (string)$group]);
    }
}
