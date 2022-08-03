<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Support\Stubs\Models;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Somnambulist\Components\Models\AggregateRoot;
use Somnambulist\Components\Models\Behaviours\AggregateEntityCollectionHelper;
use Somnambulist\Components\Models\Types\Auth\Password;
use Somnambulist\Components\Models\Types\Identity\EmailAddress;
use Somnambulist\Components\Tests\Support\Stubs\Events\UserAuthenticationDetailsUpdated;
use Somnambulist\Components\Tests\Support\Stubs\Events\UserCreated;
use Somnambulist\Components\Tests\Support\Stubs\Events\UserRegistrationComplete;

class User extends AggregateRoot
{

    use AggregateEntityCollectionHelper;

    private Name         $name;
    private EmailAddress $email;
    private Password     $password;
    private Collection   $groups;

    private function __construct(UserId $id, Name $name, EmailAddress $email, Password $password)
    {
        $this->id       = $id;
        $this->name     = $name;
        $this->email    = $email;
        $this->password = $password;

        $this->groups = new ArrayCollection();

        $this->initializeTimestamps();
    }

    public static function create(UserId $id, Name $name, EmailAddress $email, Password $password): self
    {
        $model = new self($id, $name, $email, $password);
        $model->raise(UserCreated::class, [
            'name'  => (string)$name,
            'email' => (string)$email,
        ]);

        return $model;
    }

    public function changeUserLoginTo(EmailAddress $email, Password $password): void
    {
        $this->email    = $email;
        $this->password = $password;

        $this->raise(UserAuthenticationDetailsUpdated::class);
    }

    public function completeRegistration(): void
    {
        $this->raise(UserRegistrationComplete::class);
    }

    public function groups(): UserGroups
    {
        return $this->collectionHelperFor($this->groups, UserGroups::class);
    }
}
