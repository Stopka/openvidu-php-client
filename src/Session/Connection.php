<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Session;

use DateTime;
use Stopka\OpenviduPhpClient\InvalidDataException;
use Stopka\OpenviduPhpClient\OpenViduRoleEnum;

class Connection
{

    /** @var string */
    private string $connectionId;

    /** @var DateTime */
    private DateTime $createdAt;

    /** @var OpenViduRoleEnum */
    private OpenViduRoleEnum $role;

    /** @var string */
    private string $token;

    /** @var string */
    private string $location;

    /** @var string */
    private string $platform;

    /** @var string */
    private string $serverData;

    /** @var string */
    private string $clientData;

    /** @var Publisher[] */
    protected array $publishers = [];

    /** @var string[] */
    protected array $subscribers = [];

    /**
     * Connection constructor.
     * @param string $connectionId
     * @param DateTime $createdAt
     * @param OpenViduRoleEnum $role
     * @param string $token
     * @param string $location
     * @param string $platform
     * @param string $serverData
     * @param string $clientData
     * @param Publisher[] $publishers
     * @param string[] $subscribers
     */
    public function __construct(
        string $connectionId,
        DateTime $createdAt,
        OpenViduRoleEnum $role,
        string $token,
        string $location,
        string $platform,
        string $serverData,
        string $clientData,
        array $publishers,
        array $subscribers
    ) {
        $this->connectionId = $connectionId;
        $this->createdAt = $createdAt;
        $this->role = $role;
        $this->token = $token;
        $this->location = $location;
        $this->platform = $platform;
        $this->serverData = $serverData;
        $this->clientData = $clientData;
        $this->publishers = $publishers;
        $this->subscribers = $subscribers;
    }

    /**
     * @return string
     */
    public function getConnectionId(): string
    {
        return $this->connectionId;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return OpenViduRoleEnum
     */
    public function getRole(): OpenViduRoleEnum
    {
        return $this->role;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @return string
     */
    public function getPlatform(): string
    {
        return $this->platform;
    }

    /**
     * @return string
     */
    public function getServerData(): string
    {
        return $this->serverData;
    }

    /**
     * @return string
     */
    public function getClientData(): string
    {
        return $this->clientData;
    }

    /**
     * @return Publisher[]
     */
    public function getPublishers(): array
    {
        return $this->publishers;
    }

    /**
     * @return string[]
     */
    public function getSubscribers(): array
    {
        return $this->subscribers;
    }

    /**
     * @param string[] $subscribers
     */
    public function setSubscribers(array $subscribers): void
    {
        $this->subscribers = $subscribers;
    }

    /**
     * @param mixed[] $data
     * @return Connection
     * @throws InvalidDataException
     */
    public static function createFromDataArray(array $data): Connection
    {
        $publishers = [];
        foreach ($data['publishers'] as $arrayPublisher) {
            $publisher = Publisher::createFromDataArray($arrayPublisher);
            $publishers[$publisher->getStreamId()] = $publisher;
        }
        $subscribers = [];
        foreach ($data['subscribers'] as $arraySubscriber) {
            $subscribers[] = $arraySubscriber['streamId'];
        }

        return new Connection(
            $data['connectionId'],
            (new DateTime())->setTimestamp($data['createdAt']),
            new OpenViduRoleEnum($data['role']),
            $data['token'],
            $data['location'],
            $data['platform'],
            $data['serverData'],
            $data['clientData'],
            $publishers,
            $subscribers
        );
    }

    /**
     * @return mixed[]
     */
    public function getDataArray(): array
    {
        return [
            'connectionId' => $this->connectionId,
            'createdAt' => $this->createdAt->getTimestamp(),
            'role' => (string)$this->role,
            'token' => $this->token,
            'location' => $this->location,
            'platform' => $this->platform,
            'serverData' => $this->serverData,
            'clientData' => $this->clientData,
            'publishers' => array_map(
                static fn(Publisher $publisher) => $publisher->getDataArray(),
                $this->publishers
            ),
            'subscribers' => $this->subscribers,
        ];
    }
}
