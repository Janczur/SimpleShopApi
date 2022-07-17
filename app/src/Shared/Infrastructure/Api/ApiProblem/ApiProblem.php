<?php
declare(strict_types=1);

namespace App\Shared\Infrastructure\Api\ApiProblem;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class ApiProblem
{
    public const INVALID_BODY_FORMAT = 'invalid_body_format';
    public const REQUIRED_PARAMETER_MISSING = 'required_parameter_missing';
    public const INVALID_PARAMETER_TYPE = 'invalid_parameter_type';
    public const VALIDATION_FAILED = 'validation_failed';
    public const DOMAIN_ERROR = 'domain_error';

    private static array $titles = [
        self::INVALID_BODY_FORMAT => 'Invalid request body format',
        self::REQUIRED_PARAMETER_MISSING => 'Required parameter is missing',
        self::INVALID_PARAMETER_TYPE => 'Invalid parameter type',
        self::VALIDATION_FAILED => 'Validation failed',
        self::DOMAIN_ERROR => 'Domain error',
    ];

    private static array $statusCodes = [
        self::INVALID_BODY_FORMAT => 400,
        self::REQUIRED_PARAMETER_MISSING => 400,
        self::INVALID_PARAMETER_TYPE => 400,
        self::VALIDATION_FAILED => 422,
        self::DOMAIN_ERROR => 422,
    ];

    private int $statusCode;
    private string $type;
    private string $title;
    private array $extraData = [];

    protected function __construct(int $statusCode, string $type = null, $title = null)
    {
        $this->type = $type;
        $this->statusCode = $statusCode;
        $this->title = $title;
    }

    public static function withType(string $type): self
    {
        if (!isset(self::$titles[$type])) {
            throw new InvalidArgumentException(sprintf('Unknown type "%s"', $type));
        }
        if (!isset(self::$statusCodes[$type])) {
            throw new InvalidArgumentException(sprintf('Unknown status code for type "%s"', $type));
        }
        return new self(self::$statusCodes[$type], $type, self::$titles[$type]);
    }

    public static function withStatusCode(int $statusCode): ApiProblem
    {
        $title = Response::$statusTexts[$statusCode] ?? 'Unknown status code';
        $type = 'unknown';
        return new self($statusCode, $type, $title);
    }

    public function set(string|int $key, mixed $value): void
    {
        $this->extraData[$key] = $value;
    }

    public function toArray(): array
    {
        return array_merge(
            $this->extraData,
            [
                'status' => $this->statusCode,
                'type' => $this->type,
                'title' => $this->title,
            ]
        );
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getTitle(): mixed
    {
        return $this->title;
    }
}