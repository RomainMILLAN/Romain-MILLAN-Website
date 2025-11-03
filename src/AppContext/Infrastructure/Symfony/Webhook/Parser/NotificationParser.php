<?php

namespace App\Infrastructure\Symfony\Webhook\Parser;

use App\Domain\Messenger\Command\Notification\Notify;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\ChainRequestMatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestMatcher\IpsRequestMatcher;
use Symfony\Component\HttpFoundation\RequestMatcher\IsJsonRequestMatcher;
use Symfony\Component\HttpFoundation\RequestMatcher\MethodRequestMatcher;
use Symfony\Component\HttpFoundation\RequestMatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\RemoteEvent\RemoteEvent;
use Symfony\Component\Webhook\Client\AbstractRequestParser;
use Symfony\Component\Webhook\Exception\RejectWebhookException;

class NotificationParser extends AbstractRequestParser
{
    /**
     * @var array<string>
     */
    private readonly array $allowedIps;

    public function __construct(
        #[Autowire(param: 'kernel.environment')]
        private readonly string $environment,
        #[Autowire(env: 'WEBHOOK_ALLOWED_IPS')]
        string $allowedIps,
    ) {
        $this->allowedIps = explode(';', $allowedIps);
    }

    #[\Override()]
    protected function doParse(Request $request, #[\SensitiveParameter] string $secret): ?RemoteEvent
    {
        /** @var array<string, mixed> $payload */
        $payload = $request->getPayload()
            ->all();

        if ($request->headers->get('Signature') !== $secret) {
            throw new RejectWebhookException(Response::HTTP_NOT_ACCEPTABLE, 'Missing or incorrect signature.');
        }

        if (isset($payload['message']) || $payload['message'] == null) {
            throw new RejectWebhookException(Response::HTTP_NOT_ACCEPTABLE, 'Missing or incorrect payload datas.');
        }

        return new Notify(
            id: uniqid(),
            payload: [
                'message' => $payload['message'],
            ]
        );
    }

    protected function getRequestMatcher(): RequestMatcherInterface
    {
        $matchers = [
            new MethodRequestMatcher([Request::METHOD_POST]),
            new IsJsonRequestMatcher(),
        ];

        if ($this->allowedIps !== []) {
            $matchers[] = new IpsRequestMatcher($this->allowedIps);
        }

        return new ChainRequestMatcher($matchers);
    }
}
