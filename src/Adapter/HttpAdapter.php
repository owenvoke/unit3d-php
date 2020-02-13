<?php

declare(strict_types=1);

namespace OwenVoke\Unit3d\Adapter;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use OwenVoke\Unit3d\Exception\HttpException;
use Psr\Http\Message\ResponseInterface;

class HttpAdapter
{
    protected Client $client;

    protected ResponseInterface $response;

    public function __construct(string $token, ?Client $client = null)
    {
        $this->client = $client ?: new Client(['headers' => ['Authorization' => sprintf('Bearer %s', $token)]]);
    }

    /**
     * @param  string  $url
     * @return string
     */
    public function get(string $url): string
    {
        try {
            $this->response = $this->client->get($url);
        } catch (RequestException $e) {
            $this->response = $e->getResponse();
            $this->handleError();
        }

        return (string) $this->response->getBody();
    }

    /**
     * @param  string  $url
     * @return string
     */
    public function delete(string $url): string
    {
        try {
            $this->response = $this->client->delete($url);
        } catch (RequestException $e) {
            $this->response = $e->getResponse();
            $this->handleError();
        }

        return (string) $this->response->getBody();
    }

    /**
     * @param  string  $url
     * @param  array|string  $content
     * @return string
     * @throws HttpException
     */
    public function put(string $url, $content = ''): string
    {
        $options = [];

        $options[is_array($content) ? 'json' : 'body'] = $content;

        try {
            $this->response = $this->client->put($url, $options);
        } catch (RequestException $e) {
            $this->response = $e->getResponse();
            $this->handleError();
        }

        return (string) $this->response->getBody();
    }

    /**
     * @param  string  $url
     * @param  array|string  $content
     * @return string
     * @throws HttpException
     */
    public function post(string $url, $content = ''): string
    {
        $options = [];

        $options[is_array($content) ? 'json' : 'body'] = $content;

        try {
            $this->response = $this->client->post($url, $options);
        } catch (RequestException $e) {
            $this->response = $e->getResponse();
            $this->handleError();
        }

        return (string) $this->response->getBody();
    }

    /** @throws HttpException */
    protected function handleError(): void
    {
        $body = (string) $this->response->getBody();
        $code = (int) $this->response->getStatusCode();

        $content = json_decode($body);

        throw new HttpException($content->message ?? 'Request not processed.', $code);
    }
}
