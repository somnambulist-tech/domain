## Command Query Responsibility Separation (CQRS)

This library provides implementations of:

 * query bus
 * command bus
 * job queue
 * domain event bus

Each is intended to action specific types of messages that have particular properties. Symfony Messenger
is used as the default implementation, however you can implement your own bus using whatever system you prefer.

### Domain Event Bus

The domain event bus is used to broadcast any events generated from the aggregate roots. More details
are available in the main [domain events](domain-events.md) documentation. It is worth reading about
generating events in [aggregate root](aggregate-root.md) docs for additional context.

Domain events are inherently asynchronous. When configuring this bus (by default via Symfony Messenger),
the bus should use a queuing mechanism and not be dispatched synchronously.

### Job Queue

The job queue is for scheduling heavy processing tasks in the background. Similar to the domain event bus
this should be configured to run asynchronously. Any processing task that requires a large amount of processing
or can take a long time to complete (e.g. reports, querying external APIs, processing media data etc.)
are candidates for the job queue.

__Important:__ even in development and testing environments it is important that this bus is never synchronous.
Using the `sync` method could incur timeouts and out of memory issues.

### Command Bus

The command bus is for dispatching change requests to the domain. Commands should have a 1:1 mapping with a single
command handler. The command itself will correspond to a specific domain action and will always be named following
the business terminology. For example: if you "register a customer" then the command will be `RegisterCustomer`.
If the business terminology changes, you should update the name of the class to reflect this.

It is suggested that the commands themselves live with your domain classes, however you can place them where you
like. Some people prefer grouping them in the same namespace as the handler under an `Application`.

Commands should be immutable and include all the information required by the change. This means commands should be
validated before dispatching - at least to ensure required parameters are included. The domain layer will handle
any specific domain validation requirements, but there may need to be application level restraints applied before
dispatching.

There are a couple of approaches that can be used to generate commands:

 * output from a form request
 * output from Symfony form handling
 * build from request object

#### Form Requests

A separate package [somnambulist/form-request-bundle](https://github.com/somnambulist-tech/form-request-bundle) is
available that provides an implementation of form requests, based on the same that are available in Laravel.

A form request provides a way of ensuring that a controller action can only be invoked if the request object is
valid. Validation is provided by [somnambulist/validation](https://github.com/somnambulist-tech/validation). The
resulting array data can be extracted from the validated data and a command returned directly from the custom
request object.

For example:

```php
use Somnambulist\Bundles\ApiBundle\Request\FormRequest

class CreateAccountFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id'   => 'required|uuid',
            'name' => 'required|max:255',
        ];
    }
    
    public function command(): CreateAccount
    {
        return new CreateAccount(
            $this->data()->get('id'),
            $this->data()->get('name'),
        );
    }
}
```

Then the controller would look something like:

```php
use Somnambulist\Components\Commands\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreateAccountController extends AbstractController
{
    public function __construct(private readonly CommandBus $command) {}
    
    public function __invoke(CreateAccountFormRequest $request): JsonResponse
    {
        $this->command->dispatch($request->command());
        
        return new JsonResponse(['ok']);
    }
}
```

The command action will only ever be called if the form request was successfully validated. This is a recommended
approach when creating APIs. There is [somnambulist/api-bundle](https://github.com/somnambulist-tech/api-bundle)
that provides additional infrastructure for building APIs including form requests and automatic documentation
generation.

#### Symfony Forms

For none-API applications where you need to display forms, Symfony Forms can be used to bind the command and provide
this on valid handling. This allows you to use the various SF form components for rendering widgets and using the
SF validator for constraints.

When using this approach your commands should strictly adhere to the business process you are trying to accomplish.
Typically: if following the Symfony cookbook or quick start, it will use an entity directly, but when following a
domain driven approach, this should not be done as our domain code should not allow arbitrary changes.

Instead, we will bind the command and require an initial state for the command itself. This state can be obtained by
querying the domain for the current state as needed in this context and either the raw data, or a command can be
returned (see later for query bus). The most important part of this process is that our form handler will make use
of custom data-mapping.

Using the same example as the earlier form request a form may be structured as:

```php
use Ramsey\Uuid\Uuid as UuidFactory;
use Somnambulist\Components\Domain\Entities\Types\Identity\Uuid;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function iterator_to_array;
use function ksort;

class CreateAccountFormType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setDataMapper($this)
            ->add('name', NameType::class)
            ->add('save', Type\SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CreateAccount::class,
            'empty_data' => null,
            'mapped'     => true,
        ]);
    }

    public function mapDataToForms($viewData, \Traversable $forms)
    {
        if (null === $viewData) {
            return;
        }
        if (!$viewData instanceof CreateAccount) {
            return;
        }

        $forms = iterator_to_array($forms);
        $forms['name']->setData($viewData->getName());
    }

    public function mapFormsToData(\Traversable $forms, &$viewData)
    {
        $forms = iterator_to_array($forms);

        $viewData = new CreateAccount(
            UuidFactory::uuid4()->toString(),
            $forms['name']->getData(),
        );
    }
}
```

The controller code may then look something like:

```php
use Somnambulist\Components\Commands\CommandBus;

class CreateAccountController extends AbstractController
{
    public function __construct(private readonly CommandBus $command) {}

    public function __invoke(Request $request): Response
    {
        $form = $this->createForm(CreateAccountFormType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->command()->dispatch($command = $form->getData());

                return $this->redirectToRoute();
            } catch (HandlerFailedException $e) {
                // do something with the error
            }
        }

        return $this->render('accounts/create_account.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
```

You can use any number of custom form types to make it easier to build complex forms, but always keep in mind
that they should reflect a _single_ business process. Never attempt to combine multiple changes in a single
command, instead proceed step wise; otherwise you will have to handle the cases of failures that interrupt the
application.

#### Build From Request

The last example is building the command directly from the request. This requires that you implement all
validation yourself, including any form handling.

A controller may then look like:

```php
use Ramsey\Uuid\Uuid;
use Somnambulist\Components\Commands\CommandBus;

class CreateAccountController extends AbstractController
{
    public function __construct(private readonly CommandBus $command) {}

    public function __invoke(Request $request): Response
    {
        try {
            // do some input validation before...
        
            $this->command()->dispatch(new CreateAccount(
                Uuid::uuidv4()->toString(),
                $request->get('name'),
            ));

            return $this->redirectToRoute();
        } catch (HandlerFailedException $e) {
            // do something with the error
        }

        return $this->render('accounts/create_account.html.twig');
    }
}
```

There are other means and libraries you can leverage. Generally you should follow your frameworks controller
and request handling for managing data in your controller.

### Query Bus

The last part is the query bus. This is another synchronous component that returns answers to questions about
the current state of the domain. These responses may be of any type (scalar, array, object) and should be specific
to a given question. Several default query types are included, however you should implement whatever logic you
need in your own queries. Any time you need data about the domain you should use the query bus - this includes in 
command handlers when you need data from another context.

Generally the query object should be immutable, however you may wish to add contextual information as you build
the query before dispatching, or maybe your query bus implementation adds additional context e.g. the current user
or execution times, or server information etc.

Various default behaviours are including for common tasks:

 * including additional resources in a response
 * adding meta data / context
 * pagination
 * sorting / ordering

These are general solutions to make it faster to build query objects, however it is recommended that you implement
your own specific needs.

The same as commands, queries should only have a single query handler. The query handler can implement whatever
logic is necessary to complete the query. This can be API calls, database calls, file lookups etc etc. How this is
done and what libraries (if any) is entirely up to you. The one consideration to keep in mind: responses should be
immutable and _never_ be the domain objects themselves. The aggregate roots should only ever be used in the write
context - queries should use a separate representation that makes sense for the given content.

For example: if you need a list of user data, for privacy purposes you may want to limit what is visible. This can be
done at the query level so that the names are returned as `<initial>, <lastname>` or the email address is `**` out.
Maybe this user data should include the last order date (if any) or most recent support request. It is a good idea to
have multiple queries that provide specific information instead of generalising to a single non-specific class.

From v5.0 query objects support the notion of a `response class`. This changes the execution slightly in that any
errors from handling the query are trapped and a status object is returned with the exception object. This allows
re-running the query or other handling based on the status, while providing a highly typed response object instead
of `mixed`. This is entirely optional and will not be a requirement. It is included to help with cases where a
query may need to run against local data first that can fail, but then allow control to call an external resource.

A query object can be as simple as:

```php
use Somnambulist\Components\Queries\AbstractQuery;

class GetAccountById extends AbstractQuery
{
    public function __construct(
        public readonly string $id,
    );
}
```

Or maybe there are specific considerations:

```php
use Somnambulist\Components\Queries\AbstractQuery;

class GetActiveAccountsInGoodStanding extends AbstractQuery
{
}
```

The query handler can implement the necessary logic for each query type and allow for including additional data
with a response. [somnambulist/read-models](https://github.com/somnambulist-tech/read-models) provides a means
to query for read-only data from databases using Doctrine DBAL under-the-hood in a pseudo active-record way.
For examples of this type of querying see the [somnambulist/accounts-service-skeleton](https://github.com/somnambulist-tech/accounts-service-skeleton)
project that makes use of this library, form requests, api-bundle, and read-models.
