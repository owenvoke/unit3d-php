<?php

declare(strict_types=1);

namespace OwenVoke\UNIT3D;

use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin\AddHostPlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\Plugin\RedirectPlugin;
use Http\Discovery\Psr17FactoryDiscovery;
use OwenVoke\UNIT3D\Api\AbstractApi;
use OwenVoke\UNIT3D\Api\Torrent;
use OwenVoke\UNIT3D\Exception\BadMethodCallException;
use OwenVoke\UNIT3D\Exception\InvalidArgumentException;
use OwenVoke\UNIT3D\HttpClient\Builder;
use OwenVoke\UNIT3D\HttpClient\Plugin\Authentication;
use OwenVoke\UNIT3D\HttpClient\Plugin\PathPrepend;
use Psr\Http\Client\ClientInterface;

/**
 * @method Api\Torrent torrent()
 * @method Api\Torrent torrents()
 */
final class Client
{
    public const AUTH_ACCESS_TOKEN = 'access_token_header';

    private ?string $enterpriseUrl = null;
    private Builder $httpClientBuilder;

    public function __construct(Builder $httpClientBuilder = null, ?string $enterpriseUrl = null)
    {
        $this->httpClientBuilder = $builder = $httpClientBuilder ?? new Builder();

        $builder->addPlugin(new RedirectPlugin());
        $builder->addPlugin(new AddHostPlugin(Psr17FactoryDiscovery::findUriFactory()->createUri('https://blutopia.xyz')));
        $builder->addPlugin(new HeaderDefaultsPlugin([
            'User-Agent' => 'unit3d-php (https://github.com/owenvoke/unit3d-php)',
        ]));

        $builder->addHeaderValue('Accept', 'application/json');
        $builder->addPlugin(new PathPrepend('/api'));

        if ($enterpriseUrl) {
            $this->setEnterpriseUrl($enterpriseUrl);
        }
    }

    public static function createWithHttpClient(ClientInterface $httpClient): self
    {
        $builder = new Builder($httpClient);

        return new self($builder);
    }

    /** @throws InvalidArgumentException */
    public function api(string $name): AbstractApi
    {
        switch ($name) {
            case 'torrent':
            case 'torrents':
                return new Torrent($this);

            default:
                throw new InvalidArgumentException(sprintf('Undefined api instance called: "%s"', $name));
        }
    }

    public function authenticate(string $tokenOrLogin, ?string $password = null, ?string $authMethod = null): void
    {
        if (null === $password && null === $authMethod) {
            throw new InvalidArgumentException('You need to specify authentication method!');
        }

        $this->getHttpClientBuilder()->removePlugin(Authentication::class);
        $this->getHttpClientBuilder()->addPlugin(new Authentication($tokenOrLogin, $password, $authMethod));
    }

    private function setEnterpriseUrl(string $enterpriseUrl): void
    {
        $this->enterpriseUrl = $enterpriseUrl;

        $builder = $this->getHttpClientBuilder();
        $builder->removePlugin(AddHostPlugin::class);
        $builder->removePlugin(PathPrepend::class);

        $builder->addPlugin(new AddHostPlugin(Psr17FactoryDiscovery::findUriFactory()->createUri($this->getEnterpriseUrl())));
        $builder->addPlugin(new PathPrepend('/api'));
    }

    public function getEnterpriseUrl(): ?string
    {
        return $this->enterpriseUrl;
    }

    public function __call(string $name, array $args): AbstractApi
    {
        try {
            return $this->api($name);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException(sprintf('Undefined method called: "%s"', $name), $e->getCode(), $e);
        }
    }

    public function getHttpClient(): HttpMethodsClientInterface
    {
        return $this->getHttpClientBuilder()->getHttpClient();
    }

    protected function getHttpClientBuilder(): Builder
    {
        return $this->httpClientBuilder;
    }
}
