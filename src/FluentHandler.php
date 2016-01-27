<?php

namespace Otobank\Monolog\Handler;

use Fluent\Logger\FluentLogger;
use Fluent\Logger\HttpLogger;
use Fluent\Logger\LoggerInterface;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

/**
 * Monolog handler for fluent.
 */
class FluentHandler extends AbstractProcessingHandler
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Constructor.
     *
     * @param string|LoggerInterface $fluentUri
     * @param int                    $level
     * @param bool                   $bubble
     */
    public function __construct($fluentUri = null, $level = Logger::DEBUG, $bubble = true)
    {
        parent::__construct($level, $bubble);

        if (is_null($fluentUri)) {
            $fluentUri = sprintf('fluent://%s:%d',
                FluentLogger::DEFAULT_ADDRESS, FluentLogger::DEFAULT_LISTEN_PORT);
        }

        if ($fluentUri instanceof LoggerInterface) {
            $this->logger = $fluentUri;
        } else {
            $this->parseUri($fluentUri);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function write(array $record)
    {
        $tag = $record['channel'];

        $this->logger->post($tag, array_merge($record['context'], [
            'level'   => Logger::getLevelName($record['level']),
            'message' => $record['message'],
        ]));
    }

    /**
     * @param string $fluentUri
     */
    protected function parseUri($fluentUri)
    {
        $parameters = parse_url($fluentUri);

        if (!$parameters) {
            throw new \InvalidArgumentException('Unsupported uri.'); // @codeCoverageIgnore
        }

        if (!isset($parameters['scheme'])) {
            $parameters['scheme'] = 'fluent';
        }

        switch (strtolower($parameters['scheme'])) {
            case 'http':
                $host = isset($parameters['host']) ? $parameters['host'] : '127.0.0.1';
                $port = isset($parameters['port']) ? $parameters['port'] : HttpLogger::DEFAULT_HTTP_PORT;
                $this->logger = new HttpLogger($host, $port);
                break;

            case 'tcp':
            case 'fluent':
                $host = isset($parameters['host']) ? $parameters['host'] : FluentLogger::DEFAULT_ADDRESS;
                $port = isset($parameters['port']) ? $parameters['port'] : FluentLogger::DEFAULT_LISTEN_PORT;
                if (isset($parameters['query'])) {
                    parse_str($parameters['query'], $options);
                }
                $this->logger = new FluentLogger($host, $port, isset($options) ? $options : []);
                break;

            default:
                throw new \InvalidArgumentException(sprintf('"%s" is not supported protocol.', $parameters['scheme']));
        }
    }
}
